<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

define('HTML_FOR_DOWNLOAD', 'html');


if(isset($_GET)  && !empty($_GET)){

	$dir = $_SERVER['DOCUMENT_ROOT'].'/bitrix/download/html/'. HTML_FOR_DOWNLOAD .'/';

	$fileList = [];

	foreach (new DirectoryIterator($dir) as $dirInfo) {

		if ( $dirInfo->isDot() ) continue;
		$dirKod = $dir.$dirInfo->getFilename();
		foreach(new DirectoryIterator($dirKod) as $fileInfo ){
			if ( $fileInfo->isDot() ) continue;
			//debug($fileInfo->getPathname());

			if( str_contains($fileInfo->getPathname(), '1Описание.htm') ){
				$fileList[$dirInfo->getFilename()] =  $fileInfo->getPathname();
			}

		}
	}

//debug($fileList);
	$dom = new DomDocument('1.0', 'utf-8');

	$products = $dom->appendChild($dom->createElement('PRODUCTS'));

	foreach($fileList as $key => $dirItem) {

		$product = $products->appendChild($dom->createElement('PRODUCT'));


		$code = $product->appendChild($dom->createElement('CODED'));
		$code->appendChild($dom->createTextNode($key));

		$vkDesc = $product->appendChild($dom->createElement('VK_DESC'));
		$vkDesc->appendChild($dom->createTextNode($dirItem));

//		$img = $product->appendChild($dom->createElement('FILES'));
//
//		foreach ($dirItem as $item){
//			$option = $img->appendChild($dom->createElement('OPTION', $item));
//		}

	}


	//генерация xml
	$dom->formatOutput = true; // установка атрибута formatOutput
	// domDocument в значение true
	// save XML as string or file
	//$test1 = $dom->saveXML(); // передача строки в test1

	//debug($dom);

	//$dom->save("files.xml");

	if( $dom->save("files.xml") or die("error") ){
		echo '<div class="alert alert-success" role="alert"> Документ <a target = "_blank" href = "/local/dev/update_vk/files.xml"> files.xml </a> успешно создан! </div>';
	}

}
