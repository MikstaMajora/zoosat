<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$paramID = $request->get('id');

$server_paykeeper="https://5410773243.server.paykeeper.ru"; # указывается адрес вашего сервера PayKeeper

$queryParams = [
	'id' => $paramID
];

$uri="/info/payments/byid/?" . http_build_query($queryParams);                       # Запрос 1.1 JSON API

$user="admin";                                     # Логин в личном кабинете PayKeeper
$password="1896502f8ce3";                                 # Соответствующий логину пароль
$base64=base64_encode("$user:$password");         # Формируем base64 хэш

$curl=curl_init();                                # curl должен быть установлен
$headers=Array();
array_push($headers,'Authorization: Basic '.$base64);
# Подготавливаем заголовок для авторизации
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_URL,$server_paykeeper.$uri);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
curl_setopt($curl,CURLOPT_HEADER,false);

$payKeeperDataByUser=json_decode(curl_exec($curl));                            # Инициируем запрос к API

//debug( $payKeeperDataByUser);
$payAmount = $payKeeperDataByUser[0]->pay_amount;
$orderid = $payKeeperDataByUser[0]->orderid;
$uniqueID = $payKeeperDataByUser[0]->unique_id;


$data = file_get_contents("https://qr.nspk.ru/proxyapp/c2bmembers.json");
$jsonData = json_decode($data);
$dictionary = $jsonData->dictionary;

$is_mobile_device = check_mobile_device();

    if($is_mobile_device){
        if(file_exists( $_SERVER['DOCUMENT_ROOT'] . '/pay/mobile.php' )){
            require_once( $_SERVER['DOCUMENT_ROOT'] . '/pay/mobile.php' );
        }
    }else{
	    if(file_exists( $_SERVER['DOCUMENT_ROOT'] . '/pay/pc.php' )){
		    require_once( $_SERVER['DOCUMENT_ROOT'] . '/pay/pc.php' );
	    }
    }

?>

