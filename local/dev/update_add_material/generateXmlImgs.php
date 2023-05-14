<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


if(isset($_GET)  && !empty($_GET)){

	$dir = $_SERVER['DOCUMENT_ROOT'].'/bitrix/download/images_zoosat/images_postav_new/';

	$fileList = [];
// Перебираем папки и заносим файлы в $fileList
	foreach (new DirectoryIterator($dir) as $dirInfo) {

		if ( $dirInfo->isDot() ) continue;
		$dirKod = $dir.$dirInfo->getFilename();
		foreach(new DirectoryIterator($dirKod) as $fileInfo ){
			if ( $fileInfo->isDot() ) continue;
			$fileList[$dirInfo->getFilename()][] =  $fileInfo->getPathname();
		}
	}

//debug($fileList);

//Создает XML-строку и XML-документ при помощи DOM
	$dom = new DomDocument('1.0', 'utf-8');

	$products = $dom->appendChild($dom->createElement('PRODUCTS'));


	foreach($fileList as $key => $dirItem) {

		$product = $products->appendChild($dom->createElement('PRODUCT'));


		$code = $product->appendChild($dom->createElement('CODED'));
		$code->appendChild($dom->createTextNode($key));

		$img = $product->appendChild($dom->createElement('IMAGES'));

		foreach ($dirItem as $item){
			$option = $img->appendChild($dom->createElement('OPTION', $item));
		}


	}
//генерация xml
	$dom->formatOutput = true; // установка атрибута formatOutput
// domDocument в значение true
// save XML as string or file
//$test1 = $dom->saveXML(); // передача строки в test1

//debug($dom);

	if( $dom->save("images.xml") or die("error") ){
		echo '<div class="alert alert-success" role="alert"> Документ <a target = "_blank" href = "/local/dev/update_add_material/images.xml"> images.xml </a> успешно создан! </div>';
	}

}
