<!-- Подключение ядра без визуальной части -->
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");

if(isset($_GET)  && !empty($_GET)){



	$start = microtime(true);

	define('IBLOCKID', 28);

	if(!function_exists('xml2array')){

		function xml2array($xmlObject, $out = []){
			foreach( (array)$xmlObject as $index => $node){
				$out[$index] = (is_object($node)) ? xml2array($node) : $node;
			}
			return $out;
		}

	}

	$urlRoot = $_SERVER['DOCUMENT_ROOT'].'/local/dev/update_vk/files.xml';

	$xmlObj = simplexml_load_file($urlRoot);

	$elemObj = new CIBlockElement;

	foreach($xmlObj->PRODUCT as $key => $product) {

		$product = xml2array($product);

		$homepage = file_get_contents( $product['VK_DESC']);


		$html = new \voku\Html2Text\Html2Text( $homepage,
			array(
				'width'    => 5000,
				'elements' => array(
					'h1' => array(
						'case' => \voku\Html2Text\Html2Text::OPTION_UPPERCASE,
					),
					'p' => array(
						'case' => \voku\Html2Text\Html2Text::OPTION_UPPERCASE,
						'append' => "\r\n",
					),
				),
			)
		);

		$value= $html->getText();

		//$homepage = file_get_contents( $product['VK_DESC'] );

		$res = CIBlockElement::GetList(
			['SORT' => 'ASC'],
			//['ACTIVE' => 'Y', "PROPERTY_KOD" => strval("33606" . "      ")],
			['ACTIVE' => 'Y', "PROPERTY_KOD" => strval($product['CODED']."      ")],
			false,
			false,
			['IBLOCK_ID', 'ID', "NAME",  'PROPERTY_*' ]
		);

        while($obj = $res->GetNextElement()){

                $arItem = $obj->GetFields();

                CIBlockElement::SetPropertyValues(
                $arItem['ID'],
                28,
                $value,
                "VK_DESC"
            );
		}


		/*

		$html = new \voku\Html2Text\Html2Text( $homepage,
			array(
				'width'    => 5000,
				'elements' => array(
					'h1' => array(
						'case' => \voku\Html2Text\Html2Text::OPTION_UPPERCASE,

					),
					'p' => array(
						'case' => \voku\Html2Text\Html2Text::OPTION_UPPERCASE,
						'append' => "\r\n",
					),
                    'table' => array(
                            'case' => \voku\Html2Text\Html2Text::OPTION_NONE,
                    )
				),
			)
		);

		$value= $html->getText();

		echo "КОД " . $product['CODED'];

		debug( $value );
*/




	}



	  echo '<div class="alert alert-success" role="alert"> Картинки успешно загружены за ' . (microtime(true) - $start) . '</div>';

}