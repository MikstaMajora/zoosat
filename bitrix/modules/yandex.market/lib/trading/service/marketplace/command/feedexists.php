<?php

namespace Yandex\Market\Trading\Service\Marketplace\Command;

use Yandex\Market;
use Yandex\Market\Trading\Service as TradingService;
use Yandex\Market\Trading\Entity as TradingEntity;

class FeedExists
{
	protected $provider;
	protected $environment;

	public function __construct(
		TradingService\Marketplace\Provider $provider,
		TradingEntity\Reference\Environment $environment
	)
	{
		$this->provider = $provider;
		$this->environment = $environment;
	}

	public function filterProducts(array $productIds)
	{
		$feeds = $this->provider->getOptions()->getProductFeeds();

		if (empty($feeds)) { return $productIds; }

		return $this->queryExists($feeds, $productIds);
	}

	protected function queryExists(array $feeds, array $productIds, $field = 'ELEMENT_ID')
	{
		$result = [];

		foreach (array_chunk($productIds, 500) as $productChunk)
		{
			$query = Market\Export\Run\Storage\OfferTable::getList([
				'filter' => [
					'=SETUP_ID' => $feeds,
					'=' . $field => $productChunk,
					'=STATUS' => Market\Export\Run\Steps\Base::STORAGE_STATUS_SUCCESS,
				],
				'select' => [ $field ],
				'group' => [ $field ],
			]);

			while ($row = $query->fetch())
			{
				$result[] = $row[$field];
			}
		}

		return $result;
	}
}