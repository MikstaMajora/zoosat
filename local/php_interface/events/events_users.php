<?php
use Bitrix\Main\Application,
    Bitrix\Main\Context,
    Bitrix\Main\Request,
    Bitrix\Main\Server;

AddEventHandler("main", "OnAfterUserRegister", Array("ClassUser", "OnAfterUserRegisterHandler" ) );

class ClassUser
{
    function OnAfterUserRegisterHandler(&$arFields)
    {
        $mobile = $arFields['PERSONAL_PHONE'];

        $user = new CUser;
        $fields = Array(
            "PERSONAL_MOBILE"              => $mobile,
        );

        $user->Update( $arFields['USER_ID'], $fields);
        $strError .= $user->LAST_ERROR;

	    $coupon = \Bitrix\Sale\Internals\DiscountCouponTable::generateCoupon(true);


	    $addDb = \Bitrix\Sale\Internals\DiscountCouponTable::add(array(
		    'DISCOUNT_ID' => 7,
		    'COUPON'      => $coupon,
		    'TYPE'        => \Bitrix\Sale\Internals\DiscountCouponTable::TYPE_ONE_ORDER, //или TYPE_MULTI_ORDER
		    'MAX_USE'     => 1,
		    'USER_ID'     => $arFields['USER_ID'],
		    'DESCRIPTION' => 'Купон для рассылки',
	    ));

	    if ($addDb->isSuccess()) {

		    \Bitrix\Main\Mail\Event::sendImmediate(array(
			    //"EVENT_NAME" => "USER_INFO",
			    "EVENT_NAME" => "REGISTER_USER_COUPON",
			    "LID" => "s1",
			    "C_FIELDS" => array(
				    "EMAIL" => $arFields['EMAIL'],
				    "NAME" => $arFields["NAME"],
				    "LAST_NAME" => $arFields["LAST_NAME"],
				    "USER_ID" => $arFields['USER_ID'],
				    "TEXT" => "lorem 3 ",
				    //"COUPON_NUMBER" => $coupon,
				    "COUPON_GIFT" => $coupon
			    ),
			    "Y", //можно не указывать
			    2 //можно не указывать
		    ));

	    }

    //file_put_contents($_SERVER["DOCUMENT_ROOT"]."/logs/users.log", var_export( $arFields, true)."\r", FILE_APPEND | LOCK_EX);

    }
}

