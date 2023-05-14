<?php

namespace Yandex\Market\Export\Xml\Format\Marketplace;

use Yandex\Market\Export\Xml;

class Catalog extends Xml\Format\YandexMarket\Simple
{
	use Concerns\TagRules;

	public function getDocumentationLink()
	{
		return 'https://yandex.ru/support/marketplace/assortment/files/yml-fby-fbs.html';
	}

	public function getRoot()
	{
		$result = parent::getRoot();

		$this->sanitizeRoot($result);

		return $result;
	}

	public function getOffer()
	{
		$result = parent::getOffer();

		$this->extendOffer($result);
		$this->sanitizeOffer($result);
		$this->overrideTags($result->getChildren(), [
			'vendor' => [ 'required' => true ],
			'description' => [ 'value_tags' => '<p><br>' ],
		]);

		return $result;
	}
}
