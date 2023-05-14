<?php

namespace Yandex\Market\Trading\State;

use Bitrix\Main;

class PushStore
{
	protected $setupId;
	protected $entityType;
	protected $primaryRule;
	protected $signRule;
	protected $existsCache = [];

	public function __construct($setupId, $entityType, $primaryRule, $signRule)
	{
		$this->setupId = $setupId;
		$this->entityType = $entityType;
		$this->primaryRule = $primaryRule;
		$this->signRule = $signRule;
	}

	public function filterChanged($dataList)
	{
		$values = $this->collectValues($dataList);

		if (empty($values)) { return []; }

		$exists = $this->fetchExists(array_keys($values));
		$changed = array_diff_assoc($values, $exists);

		return $this->onlyChanged($dataList, $changed);
	}

	public function commit($dataList)
	{
		$values = $this->collectValues($dataList);

		if (empty($values)) { return; }

		$rows = $this->valuesToRows($values);

		Internals\PushTable::addBatch($rows, [
			'VALUE',
			'TIMESTAMP_X',
		]);
	}

	protected function collectValues($dataList)
	{
		$result = [];

		foreach ($dataList as $data)
		{
			$primary = $this->getPrimary($data);

			if ($primary === null) { continue; }

			$sign = $this->getSign($data);

			if ($sign === '') { continue;}

			$result[$primary] = $sign;
		}

		return $result;
	}

	protected function valuesToRows($values)
	{
		$timestamp = new Main\Type\DateTime();
		$result = [];

		foreach ($values as $primary => $sign)
		{
			$result[] = [
				'SETUP_ID' => $this->setupId,
				'ENTITY_TYPE' => $this->entityType,
				'ENTITY_ID' => $primary,
				'VALUE' => $sign,
				'TIMESTAMP_X' => $timestamp,
			];
		}

		return $result;
	}

	protected function fetchExists($primaries)
	{
		if (empty($primaries)) { return []; }

		$primariesMap = array_flip($primaries);
		$needQuery = array_diff_key($primariesMap, $this->existsCache);

		if (!empty($needQuery))
		{
			$this->existsCache += $this->queryExists(array_keys($needQuery));
		}

		return array_intersect_key($this->existsCache, $primariesMap);
	}

	protected function queryExists($primaries)
	{
		$result = [];

		foreach (array_chunk($primaries, 500) as $primariesChunk)
		{
			$query = Internals\PushTable::getList([
				'filter' => [
					'=SETUP_ID' => $this->setupId,
					'=ENTITY_TYPE' => $this->entityType,
					'=ENTITY_ID' => $primariesChunk,
				],
				'select' => [
					'ENTITY_ID',
					'VALUE',
				],
			]);

			while ($row = $query->fetch())
			{
				$result[$row['ENTITY_ID']] = (string)$row['VALUE'];
			}
		}

		return $result;
	}

	protected function onlyChanged($dataList, $map)
	{
		$result = [];

		foreach ($dataList as $data)
		{
			$primary = $this->getPrimary($data);

			if ($primary === null || !isset($map[$primary])) { continue; }

			$result[] = $data;
		}

		return $result;
	}

	protected function getPrimary($data)
	{
		return $this->stringifyRule($data, $this->primaryRule);
	}

	protected function getSign($data)
	{
		return $this->stringifyRule($data, $this->signRule);
	}

	protected function stringifyRule($data, $rule)
	{
		if (is_callable($rule))
		{
			$result = (string)$rule($data);
		}
		else if (is_array($rule))
		{
			$values = [];

			foreach ($rule as $key)
			{
				$values[] = isset($data[$key]) ? (string)$data[$key] : '';
			}

			$result = implode(':', $values);
		}
		else
		{
			$result = isset($data[$rule]) ? (string)$data[$rule] : '';
		}

		return $result;
	}
}