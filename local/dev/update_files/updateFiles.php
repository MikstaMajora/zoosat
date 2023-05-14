<!-- Подключение ядра без визуальной части -->
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if(isset($_GET)  && !empty($_GET)) {

    $start = microtime(true);

    define('IBLOCKID', 28);

    if (!function_exists('xml2array')) {

        function xml2array($xmlObject, $out = [])
        {
            foreach ((array)$xmlObject as $index => $node) {
                $out[$index] = (is_object($node)) ? xml2array($node) : $node;
            }
            return $out;
        }

    }


    $urlRoot = $_SERVER['DOCUMENT_ROOT'] . '/local/dev/update_files/files.xml';

    $xmlObj = simplexml_load_file($urlRoot);

    $elemObj = new CIBlockElement;

    $notDownloaded  = '';

    foreach ($xmlObj->PRODUCT as $key => $product) {

        $product = xml2array($product);

        $res = CIBlockElement::GetList(
            ['SORT' => 'ASC'],
            ['ACTIVE' => 'Y', "PROPERTY_KOD" => strval($product['CODED'] . "      ")],
            false,
            false,
            ['IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_*']
        );

        while ($elemObj = $res->Fetch()) {


                if (!is_array($product['FILES']['OPTION'])) {
                    $product['FILES']['OPTION'] = (array)$product['FILES']['OPTION'];
                }

                $arFiles = [];

                foreach ($product['FILES']['OPTION'] as $files) {

                    $cutDocumentRoot = substr($files, 77);
                    $pos = strpos($cutDocumentRoot, '.htm');
                    $fileDesc =   substr($cutDocumentRoot , 0, $pos);

                    //file_put_contents($_SERVER["DOCUMENT_ROOT"]."/logs/files.log", var_export($cutDocumentRoot, true)."\n\r", FILE_APPEND | LOCK_EX);


                    $arFiles[] = array("VALUE" => CFile::MakeFileArray($files), "DESCRIPTION" => $fileDesc);
                }

                CIBlockElement::SetPropertyValuesEx($elemObj['ID'], IBLOCKID, array("FILES" => $arFiles));



        }

    }

    echo '<div class="alert alert-success" role="alert"> HTML успешно загружены за ' . (microtime(true) - $start) . '</div>';


}