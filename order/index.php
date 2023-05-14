<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оформление заказа");
?>

<?$APPLICATION->IncludeComponent("bitrix:sale.order.ajax", "zoosat_default", Array(
	"PAY_FROM_ACCOUNT" => "N",	// Разрешить оплату с внутреннего счета
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",	// Разрешить оплату с внутреннего счета только в полном объеме
		"COUNT_DELIVERY_TAX" => "Y",	// Рассчитывать налог для доставки
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"ALLOW_AUTO_REGISTER" => "Y",	// Оформлять заказ с автоматической регистрацией пользователя
		"SEND_NEW_USER_NOTIFY" => "Y",	// Отправлять пользователю письмо, что он зарегистрирован на сайте
		"DELIVERY_NO_AJAX" => "Y",	// Когда рассчитывать доставки с внешними системами расчета
		"DELIVERY_NO_SESSION" => "N",	// Проверять сессию при оформлении заказа
		"TEMPLATE_LOCATION" => "popup",	// Визуальный вид контрола выбора местоположений
		"DELIVERY_TO_PAYSYSTEM" => "d2p",	// Последовательность оформления
		"USE_PREPAYMENT" => "N",	// Использовать предавторизацию для оформления заказа (PayPal Express Checkout)
		"PROP_1" => "",
		"PROP_3" => "",
		"PROP_2" => "",
		"PROP_4" => "",
		"SHOW_STORES_IMAGES" => "Y",	// Показывать изображения складов в окне выбора пункта выдачи
		"PATH_TO_BASKET" => SITE_DIR."basket/",	// Путь к странице корзины
		"PATH_TO_PERSONAL" => SITE_DIR."personal/",	// Путь к странице персонального раздела
		"PATH_TO_PAYMENT" => SITE_DIR."order/payment/",	// Страница подключения платежной системы
		"PATH_TO_AUTH" => SITE_DIR."auth/",	// Путь к странице авторизации
		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
		"PRODUCT_COLUMNS" => "",
		"DISABLE_BASKET_REDIRECT" => "N",	// Оставаться на странице оформления заказа, если список товаров пуст
		"DISPLAY_IMG_WIDTH" => "90",
		"DISPLAY_IMG_HEIGHT" => "90",
		"COMPONENT_TEMPLATE" => ".default",
		"ALLOW_NEW_PROFILE" => "Y",	// Разрешить множество профилей покупателей
		"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
		"COMPATIBLE_MODE" => "Y",	// Режим совместимости для предыдущего шаблона
		"BASKET_IMAGES_SCALING" => "adaptive",	// Режим отображения изображений товаров
		"ALLOW_USER_PROFILES" => "Y",	// Разрешить использование профилей покупателей
		"TEMPLATE_THEME" => "blue",	// Цветовая тема
		"SHOW_TOTAL_ORDER_BUTTON" => "Y",	// Отображать дополнительную кнопку оформления заказа
		"SHOW_PAY_SYSTEM_LIST_NAMES" => "Y",	// Отображать названия в списке платежных систем
		"SHOW_PAY_SYSTEM_INFO_NAME" => "Y",	// Отображать название в блоке информации по платежной системе
		"SHOW_DELIVERY_LIST_NAMES" => "Y",	// Отображать названия в списке доставок
		"SHOW_DELIVERY_INFO_NAME" => "Y",	// Отображать название в блоке информации по доставке
		"SHOW_DELIVERY_PARENT_NAMES" => "Y",	// Показывать название родительской доставки
		"BASKET_POSITION" => "after",	// Расположение списка товаров
		"SHOW_BASKET_HEADERS" => "Y",	// Показывать заголовки колонок списка товаров
		"DELIVERY_FADE_EXTRA_SERVICES" => "Y",	// Дополнительные услуги, которые будут показаны в пройденном (свернутом) блоке
		"SHOW_COUPONS_BASKET" => "Y",
		"SHOW_COUPONS_DELIVERY" => "Y",
		"SHOW_COUPONS_PAY_SYSTEM" => "Y",
		"SHOW_NEAREST_PICKUP" => "Y",	// Показывать ближайшие пункты самовывоза
		"DELIVERIES_PER_PAGE" => "8",	// Количество доставок на странице
		"PAY_SYSTEMS_PER_PAGE" => "8",	// Количество платежных систем на странице
		"PICKUPS_PER_PAGE" => "5",	// Количество пунктов самовывоза на странице
		"SHOW_MAP_IN_PROPS" => "N",	// Показывать карту в блоке свойств заказа
		"SHOW_MAP_FOR_DELIVERIES" => array(
			0 => "1",
			1 => "2",
		),
		"PROPS_FADE_LIST_1" => array(	// Свойства заказа, которые будут показаны в пройденном (свернутом) блоке (Физическое лицо)[s1]
			0 => "1",
			1 => "2",
			2 => "3",
			3 => "4",
			4 => "7",
		),
		"PROPS_FADE_LIST_2" => "",
		"PRODUCT_COLUMNS_VISIBLE" => array(	// Выбранные колонки таблицы списка товаров
			0 => "PREVIEW_PICTURE",
			1 => "PROPS",
			2 => "NOTES",
			3 => "DISCOUNT_PRICE_PERCENT_FORMATED",
			4 => "PRICE_FORMATED",
			5 => "WEIGHT_FORMATED",
		),
		"ADDITIONAL_PICT_PROP_13" => "-",
		"ADDITIONAL_PICT_PROP_14" => "-",
		"PRODUCT_COLUMNS_HIDDEN" => array(	// Свойства товаров отображаемые в свернутом виде в списке товаров
			0 => "PREVIEW_PICTURE",
			1 => "DETAIL_PICTURE",
			2 => "PREVIEW_TEXT",
			3 => "PROPS",
			4 => "NOTES",
			5 => "DISCOUNT_PRICE_PERCENT_FORMATED",
			6 => "PRICE_FORMATED",
			7 => "WEIGHT_FORMATED",
			8 => "PROPERTY_MINIMUM_PRICE",
			9 => "PROPERTY_MAXIMUM_PRICE",
			10 => "PROPERTY_HIT",
			11 => "PROPERTY_BRAND",
			12 => "PROPERTY_PROP_2033",
			13 => "PROPERTY_IN_STOCK",
		),
		"USE_YM_GOALS" => "N",	// Использовать цели счетчика Яндекс.Метрики
		"USE_CUSTOM_MAIN_MESSAGES" => "N",	// Заменить стандартные фразы на свои
		"USE_CUSTOM_ADDITIONAL_MESSAGES" => "N",	// Заменить стандартные фразы на свои
		"USE_CUSTOM_ERROR_MESSAGES" => "N",	// Заменить стандартные фразы на свои
		"SHOW_ORDER_BUTTON" => "final_step",	// Отображать кнопку оформления заказа (для неавторизованных пользователей)
		"SKIP_USELESS_BLOCK" => "Y",	// Пропускать шаги, в которых один элемент для выбора
		"SERVICES_IMAGES_SCALING" => "standard",	// Режим отображения вспомагательных изображений
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"ALLOW_APPEND_ORDER" => "Y",	// Разрешить оформлять заказ на существующего пользователя
		"SHOW_NOT_CALCULATED_DELIVERIES" => "L",	// Отображение доставок с ошибками расчета
		"SPOT_LOCATION_BY_GEOIP" => "Y",	// Определять местоположение покупателя по IP-адресу
		"SHOW_VAT_PRICE" => "Y",	// Отображать значение НДС
		"USE_PRELOAD" => "Y",	// Автозаполнение оплаты и доставки по предыдущему заказу
		"SHOW_PICKUP_MAP" => "N",	// Показывать карту для доставок с самовывозом
		"PICKUP_MAP_TYPE" => "yandex",	// Тип используемых карт
		"SHOW_COUPONS" => "N",	// Отображать поля ввода купонов
		"USER_CONSENT" => "Y",	// Запрашивать согласие
		"USER_CONSENT_ID" => "0",	// Соглашение
		"USER_CONSENT_IS_CHECKED" => "Y",	// Галка по умолчанию проставлена
		"USER_CONSENT_IS_LOADED" => "N",	// Загружать текст сразу
		"ACTION_VARIABLE" => "soa-action",	// Название переменной, в которой передается действие
		"EMPTY_BASKET_HINT_PATH" => "/",	// Путь к странице для продолжения покупок
		"USE_PHONE_NORMALIZATION" => "Y",	// Использовать нормализацию номера телефона
		"ADDITIONAL_PICT_PROP_18" => "-",	// Дополнительная картинка [Каталог товаров]
		"ADDITIONAL_PICT_PROP_21" => "-",	// Дополнительная картинка [Торговые предложения]
		"ADDITIONAL_PICT_PROP_28" => "-",	// Дополнительная картинка [Основной каталог товаров]
		"HIDE_ORDER_DESCRIPTION" => "N",	// Скрыть поле комментариев к заказу
		"USE_ENHANCED_ECOMMERCE" => "Y",	// Отправлять данные электронной торговли в Google и Яндекс
		"DATA_LAYER_NAME" => "dataLayer",	// Имя контейнера данных
		"BRAND_PROPERTY" => "",	// Свойство, в котором указан бренд товара
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>