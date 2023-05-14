<?php

namespace Yandex\Market\Export\Xml\Tag\Concerns;

trait HasPackUnitDependency
{
	protected function copyPricePackUnitSetting(&$tagDescriptionList)
	{
		$packRatio = null;

		// find price ratio

		foreach ($tagDescriptionList as $tagDescription)
		{
			if ($tagDescription['TAG'] !== 'price') { continue; }

			if (isset($tagDescription['SETTINGS']['PACK_RATIO']))
			{
				$packRatio = $tagDescription['SETTINGS']['PACK_RATIO'];
			}

			break;
		}

		// write to self settings

		foreach ($tagDescriptionList as &$tagDescription)
		{
			if ($tagDescription['TAG'] !== $this->id) { continue; }

			$tagDescription['SETTINGS']['PACK_RATIO'] = $packRatio;
		}
		unset($tagDescription);
	}
}