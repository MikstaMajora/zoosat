<!-- Подключение ядра без визуальной части -->
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

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

    $urlRoot = $_SERVER['DOCUMENT_ROOT'].'/local/dev/update_pics/images.xml';

    $xmlObj = simplexml_load_file($urlRoot);

    $elemObj = new CIBlockElement;
    $elemPreview = new CIBlockElement;

    $notUploadedItems = [];

    foreach($xmlObj->PRODUCT  as $key => $product) {

        $product = xml2array($product);

        $arImg = [];

        foreach($product['IMAGES']['OPTION'] as $img){
            $arImg[] = array("VALUE" => CFile::MakeFileArray($img),"DESCRIPTION"=>"");
        }



        $res = CIBlockElement::GetList(
            ['SORT' => 'NAME'],
            ['ACTIVE' => 'Y', "PROPERTY_KOD" => strval($product['CODED']."      ")],
            false,
            false,
            ['IBLOCK_ID', 'ID',  'PROPERTY_*' ]
        );

        $arPics = [];


        if( $elemObj = $res->Fetch() ){

            //debug($elemObj);

            // Раскидываем превью и картинки по разным пассивам
            foreach ($arImg as $arItem) {

                if ($arItem['VALUE']['name'] == 'preview.jpg') {

                    $elemPreview->Update($elemObj['ID'], array(
                        'PREVIEW_PICTURE' => CFile::makeFileArray($arItem['VALUE']['tmp_name']),
                        // 'DETAIL_PICTURE' => array('del' => 'Y') // Позже можно удалить этот код
                    ));

                } else {
                    $arPics[] = $arItem;
                }
            }

            sort($arPics);
            CIBlockElement::SetPropertyValuesEx($elemObj['ID'], IBLOCKID, array("MORE_PHOTO" => $arPics));

        } else {
            $notUploadedItems[] = $product['CODED'];
        }

    }

    sort($notUploadedItems);
    $comma_separated = implode(", <br>", $notUploadedItems);

    echo '<div class="alert alert-success" role="alert"> Картинки успешно загружены за ' . (microtime(true) - $start) . '</div>';
    echo '<div class="alert alert-warning" role="alert"> Не загруженные позиции: ' . "<br>" . $comma_separated . '</div>';

}