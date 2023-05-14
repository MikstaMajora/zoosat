<?php

namespace Yandex\Market\Trading\State;

use Bitrix\Main;
use Yandex\Market;

class PushAgent extends Internals\AgentSkeleton
{
	use Market\Reference\Concerns\HasMessage;

	const PERIOD_STEP_DEFAULT = 5;
	const NOTIFY_DISABLED = 'PUSH_AGENT_DISABLED';
	const NOTIFY_NOT_ALLOWED = 'PUSH_AGENT_NOT_ALLOWED';

	public static function getDefaultParams()
	{
		return [
			'interval' => static::getPeriod('restart', 300),
			'sort' => 300, // more priority
		];
	}

	public static function change($setupId, $path)
	{
		$date = static::committedDate($setupId, $path) ?: static::startDate($setupId, $path);
		$limit = static::limitDate();
		$agentParameters = [
			'method' => 'process',
			'interval' => static::getPeriod('step', static::PERIOD_STEP_DEFAULT),
			'search' => Market\Reference\Agent\Controller::SEARCH_RULE_SOFT,
		];

		if (Market\Data\DateTime::compare($date, $limit) === -1)
		{
			static::unregister($agentParameters + [
				'arguments' => [ $setupId, $path ],
			]);

			$date = static::expireDate();
			static::commitDate($setupId, $path, $date);
		}

		static::resetRestartPeriod();
		static::register($agentParameters + [
			'arguments' => [ $setupId, $path, static::formatDate($date) ],
		]);
	}

	protected static function resetRestartPeriod()
	{
		global $pPERIOD;

		$periodOption = static::getPeriod('restart', null);

		if ($periodOption !== null)
		{
			$pPERIOD = $periodOption;
		}
	}

	public static function process($setupId, $path, $date = null, $offset = null, $errorCount = 0)
	{
		return static::wrapAction(
			[static::class, 'processBody'],
			[ $setupId, $path, $date, $offset ],
			$errorCount
		);
	}

	protected static function processBody($setupId, $path, $date, $offset)
	{
		global $pPERIOD;

		try
		{
			$setup = static::getSetup($setupId);
			$dateTyped = $date !== null ? static::parseDate($date) : null;

			Market\Utils\ServerStamp\Facade::check();

			do
			{
				$runner = new Market\Trading\Procedure\Runner(
					Market\Trading\Entity\Registry::ENTITY_TYPE_NONE,
					null
				);

				$response = $runner->run($setup, $path, [
					'timestamp' => $dateTyped,
					'limit' => static::getPageSize(),
					'offset' => $offset,
				]);

				if ($response->getField('hasNext') !== true) { break; }

				$offset = $response->getField('offset');

				Market\Reference\Assert::notNull($offset, 'offset');

				if (static::isTimeExpired())
				{
					return [$setupId, $path, $date, $offset];
				}
			}
			while (true);
		}
		catch (Market\Exceptions\Api\Request $exception)
		{
			if (in_array($exception->getErrorCode(), ['METHOD_FAILURE', 'LIMIT_EXCEEDED'], true))
			{
				$pPERIOD = static::getPeriod('pause', 60);

				return [$setupId, $path, $date, $offset];
			}

			throw $exception;
		}

		static::commitDate($setupId, $path);

		return false;
	}

	protected static function canRepeat($exception, $errorCount)
	{
		if (static::isMethodNotAllowed($exception) || static::isRequestInvalid($exception))
		{
			return $errorCount < 1; // only first error skipped
		}

		return parent::canRepeat($errorCount, $errorCount);
	}

	protected static function logError(Market\Trading\Setup\Model $setup, $message)
	{
		parent::logError($setup, $message);

		if ($message instanceof Market\Utils\ServerStamp\ChangedException)
		{
			static::switchOff();
			static::notifyDisabled($setup, $message);
		}
		else if (static::isMethodNotAllowed($message))
		{
			static::switchOff([ $setup->getId() ]);
			static::notifyNotAllowed($setup);
		}
	}

	protected static function isMethodNotAllowed($exception)
	{
		return (
			$exception instanceof Market\Exceptions\Api\Request
			&& $exception->getErrorCode() === 'METHOD_NOT_ALLOWED'
		);
	}

	protected static function isRequestInvalid($exception)
	{
		return (
			$exception instanceof Market\Exceptions\Api\Request
			&& Market\Data\TextString::getPosition((string)$exception->getErrorCode(), 'INVALID') !== false
		);
	}

	protected static function switchOff(array $arguments = null)
	{
		$methods = [
			'change',
		];

		foreach ($methods as $method)
		{
			static::unregister([
				'method' => $method,
				'arguments' => $arguments,
				'search' => Market\Reference\Agent\Controller::SEARCH_RULE_SOFT,
			]);
		}
	}

	protected static function notifyDisabled(Market\Trading\Setup\Model $setup, Market\Utils\ServerStamp\ChangedException $exception)
	{
		$uiCode =  Market\Ui\Service\Facade::codeByTradingService($setup->getServiceCode());
		$resetUrl = Market\Ui\Admin\Path::getModuleUrl('trading_list', [
			'lang' => LANGUAGE_ID,
			'service' => $uiCode,
			'postAction' => 'reinstall',
		]);
		$logUrl = Market\Ui\Admin\Path::getModuleUrl('trading_log', [
			'lang' => LANGUAGE_ID,
			'service' => $uiCode,
			'find_level' => Market\Logger\Level::ERROR,
			'set_filter' => 'Y',
			'apply_filter' => 'Y',
		]);

		\CAdminNotify::Add([
			'NOTIFY_TYPE' => \CAdminNotify::TYPE_ERROR,
			'MODULE_ID' => Market\Config::getModuleName(),
			'TAG' => static::NOTIFY_DISABLED,
			'MESSAGE' => self::getMessage(
				'DISABLED',
				[
					'#MESSAGE#' => $exception->getMessage(),
					'#RESET_URL#' => $resetUrl,
					'#LOG_URL#' => $logUrl,
				],
				$exception->getMessage()
			),
		]);
	}

	protected static function notifyNotAllowed(Market\Trading\Setup\Model $setup)
	{
		$uiCode =  Market\Ui\Service\Facade::codeByTradingService($setup->getServiceCode());
		$setupUrl = Market\Ui\Admin\Path::getModuleUrl('trading_edit', [
			'lang' => LANGUAGE_ID,
			'service' => $uiCode,
			'id' => $setup->getId(),
			'YANDEX_MARKET_ADMIN_TRADING_EDIT_active_tab' => 'tab1',
		]);
		$logUrl = Market\Ui\Admin\Path::getModuleUrl('trading_log', [
			'lang' => LANGUAGE_ID,
			'service' => $uiCode,
			'find_level' => Market\Logger\Level::ERROR,
			'find_setup' => $setup->getId(),
			'set_filter' => 'Y',
			'apply_filter' => 'Y',
		]);

		\CAdminNotify::Add([
			'NOTIFY_TYPE' => \CAdminNotify::TYPE_ERROR,
			'MODULE_ID' => Market\Config::getModuleName(),
			'TAG' => static::NOTIFY_NOT_ALLOWED,
			'MESSAGE' => self::getMessage('NOT_ALLOWED', [
				'#SETUP_URL#' => $setupUrl,
				'#LOG_URL#' => $logUrl,
			]),
		]);
	}

	protected static function getPageSize()
	{
		$name = static::optionName('page_size');
		$option = (int)Market\Config::getOption($name, 500);

		return max(1, min(2000, $option));
	}

	protected static function committedDate($setupId, $path)
	{
		$name = static::getStateDateName($setupId, $path);
		$stored = (string)Market\State::get($name);

		return ($stored !== '' ? static::parseDate($stored) : null);
	}

	protected static function startDate($setupId, $path)
	{
		$result = new Main\Type\DateTime();
		$result->add('-PT1H');

		return static::commitDate($setupId, $path, $result);
	}

	protected static function limitDate()
	{
		$result = static::expireDate();
		$result->add('-PT3H'); // 3 hours for process

		return $result;
	}

	protected static function expireDate()
	{
		$result = new Main\Type\DateTime();
		$result->add('-P1D');

		return $result;
	}

	protected static function commitDate($setupId, $path, Main\Type\DateTime $date = null)
	{
		$result = $date !== null ? $date : new Main\Type\DateTime();
		$name = static::getStateDateName($setupId, $path);

		Market\State::set($name, static::formatDate($result));

		return $result;
	}

	protected static function parseDate($dateString)
	{
		return new Main\Type\DateTime($dateString, \DateTime::ATOM);
	}

	protected static function formatDate(Main\Type\DateTime $date)
	{
		return $date->format(\DateTime::ATOM);
	}

	protected static function getStateDateName($setupId, $path)
	{
		return implode('_', [
			static::getOptionPrefix(),
			$setupId,
			str_replace('/', '_', $path)
		]);
	}

	protected static function getOptionPrefix()
	{
		return 'trading_push';
	}
}