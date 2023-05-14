<?
$MESS["ARTURGOLUBEV_GMERCHANT_SELECT_IBLOCK"] = "Выберите инфоблок для выгрузки:";
$MESS["ARTURGOLUBEV_GMERCHANT_SELECT_GROUP"] = "Выберите выгружаемые разделы:";

$MESS["ARTURGOLUBEV_GMERCHANT_EXPORT_TYPE"] = "Тип выгрузки:";
$MESS["ARTURGOLUBEV_GMERCHANT_EXPORT_TYPE_NONE"] = "Общий (все возможные поля)";
$MESS["ARTURGOLUBEV_GMERCHANT_EXPORT_TYPE_TIKTOK"] = "TikTok";
$MESS["ARTURGOLUBEV_GMERCHANT_EXPORT_TYPE_FACEBOOK"] = "Facebook";
$MESS["ARTURGOLUBEV_GMERCHANT_EXPORT_TYPE_GOOGLE_MERCHANT"] = "Google Merchant";
$MESS["ARTURGOLUBEV_GMERCHANT_EXPORT_TYPE_GOOGLE_MERCHANT_DYNAMIC"] = "Google Merchant + поля ремакетинга";

$MESS["ARTURGOLUBEV_GMERCHANT_CHECK_PERMISSIONS"] = "<span data-hint='Включить проверку прав доступа для группы 2 (все пользователи)'></span>Не выгружать недоступные для неавторизованных пользователей товары:";
$MESS["ARTURGOLUBEV_GMERCHANT_FILTER_AVAILABLE"] = "<span data-hint='Товары не доступные к покупке по правилам битрикса будут исключены из выгрузки'></span>Не выгружать недоступные к покупке товары:";
$MESS["ARTURGOLUBEV_GMERCHANT_HIDE_WITHOT_PICTURES"] = "Не выгружать товары без картинок:";
$MESS["ARTURGOLUBEV_GMERCHANT_HIDE_WITHOT_DESCRIPTION"] = "Не выгружать товары без описаний:";
$MESS["ARTURGOLUBEV_GMERCHANT_HIDE_QUANTITY_NULL"] = "<span data-hint='Товары с нулевым и отрицательным доступным количеством не попадут в выгрузку'></span>Не выгружать товары с нулевым доступным количеством:";

/* dop params */
$MESS["ARTURGOLUBEV_GMERCHANT_LOCK_CUPON_CHECK"] = "<span data-hint='Помогает при проблемах с выгрузкой скидок (если скидки не появляются в фиде) и ошибоках о нехватке оперативной памяти при генерации прайса'></span>Отключить кеширование скидок:";

$MESS["ARTURGOLUBEV_GMERCHANT_LOCK_CUPON_CHECK_NOTE"] = "С помощью данной настройки можно отключить ресурсоёмкую проверку купонов, при использовании модуля на слабых хостингах";
$MESS["ARTURGOLUBEV_GMERCHANT_NO_CLEAR_DESCRIPTION_TAGS"] = "Список тегов, которые не нужно удалять из описания<br>(В формате: &lt;b&gt;&lt;p&gt;&lt;i&gt;&lt;br&gt;):";
$MESS["ARTURGOLUBEV_GMERCHANT_ONLY_STANDART_PRICE"] = "<span data-hint='При включенной опции тег sale_price использоваться не будет, финальная цена со скидкой (при её наличии) будет записана в price'></span>Записывать цену со скидкой в параметр &lt;price&gt;:";
$MESS["ARTURGOLUBEV_GMERCHANT_ONLY_STANDART_PRICE_NOTE"] = "Данная настройка полезна при выгрузке в Facebook, который в отличии от Google не умеет обрабатывать параметр &lt;sale_price&gt;";
$MESS["ARTURGOLUBEV_GMERCHANT_NO_USE_STANDART_PICTURES"] = "<span data-hint='В качестве основого фото товара будет использована первая картинка поля additional_image_link'></span>Не использовать<br>Картинку для анонса и Детальную картинку:";
$MESS["ARTURGOLUBEV_GMERCHANT_NO_USE_STANDART_PICTURES_NOTE"] = "В качестве основого фото товара будет использована первая картинка поля additional_image_link";

$MESS["ARTURGOLUBEV_GMERCHANT_SECTION_INNER_SELECTED"] = "Есть отмеченные вложеные разделы";





/* event notes */
$MESS["ARTURGOLUBEV_GMERCHANT_DEMO_IS_EXPIRED"] = "Демонстрационный период работы решения закончился. Для дальнейшего использования необходимо приобрести полую версию решения в <a href=\"http://marketplace.1c-bitrix.ru/solutions/arturgolubev.gmerchant/\" target=\"_blank\">marketplace.1c-bitrix.ru</a>";

$MESS["ARTURGOLUBEV_GMERCHANT_ERR_SKU_SETTINGS_ABSENT"] = "Отсутствуют настройки экспорта торговых предложений (Детальные настройки -> Цены и отбор товаров)";

/* callbacks */
$MESS["ARTURGOLUBEV_GMERCHANT_CALLBACKS_TITLE"] = "Настроены пользовательские обработчики:";

/* information */
$MESS["ARTURGOLUBEV_GMERCHANT_INFORMATION_TITLE"] = "Полезная информация";
$MESS["ARTURGOLUBEV_GMERCHANT_INFORMATION"] = "
<div style='line-height:24px; font-size:14px; color:#333;'>
Карточка решения на Marketplace - <a href='https://marketplace.1c-bitrix.ru/solutions/arturgolubev.gmerchant/#tab-about-link' target='_blank'>ссылка</a><br>
Видео-инструкции по установке и загрузке в Facebook/Merchant - <a href='https://arturgolubev.ru/knowledge/course2/' target='_blank'>ссылка</a><br>
Часто задаваемые вопросы по данному модулю - <a href='https://arturgolubev.ru/knowledge/course2/' target='_blank'>ссылка</a><br>
Вопросы по покупке, оплате, активации модуля и т.п. - <a href='https://arturgolubev.ru/knowledge/course1/' target='_blank'>ссылка</a>
</div>
";







/* standart */
$MESS["BX_CATALOG_EXPORT_IBLOCK_SELECT"] = "Выгружаемые данные";
$MESS["BX_CATALOG_EXPORT_FILE_PROPS"] = "Настройки фида";
$MESS["BX_CATALOG_EXPORT_PERFOMANCE"] = "Параметры производительности";
$MESS["BX_CATALOG_EXPORT_DATASETTING"] = "Настройка выгружаемых данных";

$MESS["BX_CATALOG_GOOGLE_EXPORT_UTM"] = "UTM Метки";
$MESS["BX_CATALOG_GOOGLE_EXPORT_UTM_EXAMPLE"] = "
Пример заполнения:<br>
utm_source=google&utm_medium=cpc&utm_campaign=campaignid";


$MESS["BX_CATALOG_EXPORT_YANDEX_COMPANY_NAME"] = "Название фида данных:";
$MESS["BX_CATALOG_EXPORT_YANDEX_COMPANY_DESCRIPTION"] = "Описание содержимого фида:";

$MESS["CET_ERROR_NO_NAME"] = "Введите название профиля выгрузки.";
$MESS["CET_STEP1"] = "Шаг";
$MESS["CET_STEP2"] = "из";
$MESS["CET_SAVE"] = "Сохранить";
$MESS["CET_ERROR_NO_IBLOCK1"] = "Информационный блок";
$MESS["CET_ERROR_NO_IBLOCK2"] = "не найден.";
$MESS["CET_ERROR_NO_FILENAME"] = "Не указано имя файла для экспорта.";
$MESS["CET_ERROR_NO_GROUPS"] = "Не указаны выгружаемые группы.";
$MESS["CET_ERROR_NO_PROFILE_NAME"] = "Введите название профиля выгрузки.";
$MESS["CET_SELECT_IBLOCK"] = "Выберите инфоблок";
$MESS["CET_SELECT_IBLOCK_EXT"] = "Выберите инфоблок для экспорта:";
$MESS["CET_SELECT_GROUP"] = "Выберите группы:";
$MESS["CET_FIRST_SELECT_IBLOCK"] = "Сначала выберите информационный блок";
$MESS["CET_ALL_GROUPS"] = "Все группы";
$MESS["CET_SERVER_NAME"] = "Доменное имя:";
$MESS["CET_SERVER_NAME_SET_CURRENT"] = "текущее";
$MESS["CET_SAVE_FILENAME"] = "Сохранить в файл:";
$MESS["CET_PROFILE_NAME"] = "Имя профиля:";
$MESS["CET_EXPORT"] = "Экспортировать";
$MESS["CET_ERROR_NO_IBLOCKS"] = "Не указаны выгружаемые информационные блоки.";
$MESS["CET_EXPORT_CATALOGS"] = "Каталоги для экспорта:";
$MESS["CET_CATALOG"] = "Каталог";
$MESS["CET_EXPORT2YANDEX"] = "Экспортировать в Яндекс.Товары";
$MESS["CATI_DATA_EXPORT"] = "Экспорт данных";
$MESS["CATI_NO_IBLOCK"] = "Информационный блок не выбран. Выгрузка невозможна.";
$MESS["CATI_NO_FORMAT"] = "Укажите формат файла данных и его свойства.";
$MESS["CATI_NO_DELIMITER"] = "Укажите символ-разделитель полей.";
$MESS["CATI_NO_SAVE_FILE"] = "Укажите файл для сохранения результата.";
$MESS["CATI_CANNOT_CREATE_FILE"] = "Ошибка создания файла данных.";
$MESS["CATI_NO_FIELDS"] = "Не заданы поля для экспорта.";
$MESS["CATI_SCHEME_EXISTS"] = "Схема с таким именем уже существует.";
$MESS["CATI_PAGE_TITLE"] = "Выгрузка каталога: шаг";
$MESS["CATI_NEXT_STEP"] = "Далее";
$MESS["CATI_INFOBLOCK"] = "Информационный блок для экспорта:";
$MESS["CATI_SCHEME_NAME"] = "Схема выгрузки:";
$MESS["CATI_NOT"] = "Нет";
$MESS["CATI_DELETE"] = "удалить";
$MESS["CATI_FIELDS"] = "Задайте соответствие полей в файле полям в базе";
$MESS["CATI_FI_ID"] = "Идентификатор";
$MESS["CATI_FI_NAME"] = "Название";
$MESS["CATI_FI_ACTIV"] = "Активность";
$MESS["CATI_FI_ACTIVFROM"] = "Активность с";
$MESS["CATI_FI_ACTIVTO"] = "Активность до";
$MESS["CATI_FI_CATIMG"] = "Картинка для списка";
$MESS["CATI_FI_CATDESCR"] = "Описание для списка";
$MESS["CATI_FI_DETIMG"] = "Картинка";
$MESS["CATI_FI_DETDESCR"] = "Описание";
$MESS["CATI_FI_UNIXML"] = "Уникальный идентификатор";
$MESS["CATI_FI_QUANT"] = "Количество";
$MESS["CATI_FI_WEIGHT"] = "Вес";
$MESS["CATI_FI_PROPS"] = "Свойство";
$MESS["CATI_FI_GROUP_LEV"] = "Группа уровня";
$MESS["CATI_FI_PRICE_TYPE"] = "Цена типа";
$MESS["CATI_FIELD"] = "поле";
$MESS["CATI_FORMAT_PROPS"] = "Задайте свойства формата файла";
$MESS["CATI_DELIMITERS"] = "С разделителями";
$MESS["CATI_DELIMITER_TYPE"] = "Разделитель полей";
$MESS["CATI_TAB"] = "табуляция";
$MESS["CATI_TZP"] = "точка с запятой";
$MESS["CATI_ZPT"] = "запятая";
$MESS["CATI_SPS"] = "пробел";
$MESS["CATI_OTR"] = "другой";
$MESS["CATI_SAVE_SCHEME"] = "Сохранить настройки как схему";
$MESS["CATI_SSCHEME_NAME"] = "Имя схемы";
$MESS["CATI_DATA_FILE_NAME"] = "Сохранить файл данных как...";
$MESS["CATI_DATA_FILE_NAME1"] = "Имя файла данных";
$MESS["CATI_SUCCESS"] = "Выгрузка завершена";
$MESS["CATI_SU_ALL"] = "Всего выгружено строк:";
$MESS["CATI_BACK"] = "Назад";
$MESS["CATI_FIRST_LINE_NAMES"] = "Первая строка содержит имена полей";
$MESS["CATI_SU_ALL1"] = "Скачать файл %DATA_URL% на свой компьютер";
$MESS["CATI_FIELDS_NEEDED"] = "Выгружать";
$MESS["CATI_FIELDS_NAMES"] = "Название поля";
$MESS["CATI_FIELDS_SORTING"] = "Порядок";
$MESS["CATI_NEXT_STEP_F"] = "Начать выгрузку";
$MESS["CATI_DATA_FILE_NAME1_DESC"] = "Если такой файл существует, то он будет перезаписан";
$MESS["CATI_TOO_MANY_TABLES"] = "Слишком большое объединение таблиц. Уменьшите количество экспортируемых свойств или типов цен.";
$MESS["EST_QUANTITY_FROM"] = "Покупаемое количество от";
$MESS["EST_QUANTITY_TO"] = "Покупаемое количество до";
$MESS["EST_PRICE_TYPE"] = "Тип цен \"#TYPE#\"";
$MESS["EST_PRICE_TYPE2"] = "Тип цен \"#NAME#\" (#TYPE#)";
$MESS["CAT_DETAIL_PROPS"] = "Детальные настройки";
$MESS["CAT_DETAIL_PROPS_RUN"] = "настроить";
$MESS["CET_IS_SKU"] = "Выбран инфоблок торговых предложений.";
$MESS["CET_USE_PARENT_SECT"] = "Использовать группы инфоблока товаров";
$MESS["CET_YAND_RUN_ERR_IBLOCK_ABSENT"] = "Инфоблок ##IBLOCK_ID# не существует";
$MESS["CET_YAND_RUN_ERR_PRODUCT_IBLOCK_ABSENT"] = "Инфоблок товаров ##IBLOCK_ID# не существует";
$MESS["CET_YAND_RUN_ERR_SECTION_SET_EMPTY"] = "Список групп не задан";
$MESS["CET_YAND_RUN_ERR_SETUP_FILE_ACCESS_DENIED"] = "Недостаточно прав для перезаписи файла #FILE#";
$MESS["CET_YAND_RUN_ERR_SETUP_FILE_OPEN_WRITING"] = "Невозможно открыть файл #FILE# для записи";
$MESS["CET_YAND_RUN_ERR_SETUP_FILE_WRITE"] = "Запись в файл #FILE# невозможна";
$MESS["CET_YAND_SELECT_IBLOCK"] = "Инфоблок для экспорта";
$MESS["CET_SELECT_IBLOCK_TYPE"] = "Выберите тип инфоблока";
$MESS["CET_YAND_GROUP_AND_OFFERS"] = "Группы и товары для импорта";
$MESS["CET_YAND_USE_IBLOCK_SITE"] = "Брать доменное имя из инфоблока";
$MESS["CET_ERROR_IBLOCK_PERM"] = "Недостаточно прав для работы с инфоблоком ##IBLOCK_ID#";
$MESS["YANDEX_ERR_SKU_SETTINGS_ABSENT"] = "Отсутствуют настройки экспорта торговых предложений";
$MESS["CES_ERROR_BAD_EXPORT_FILENAME"] = "Имя файла экспорта содержит запрещенные символы";
$MESS["CES_ERROR_BAD_EXPORT_FILENAME_EXTENTIONS"] = "Имя файла экспорта содержит запрещенное расширение";
$MESS["CES_ERROR_FORBIDDEN_EXPORT_FILENAME"] = "Запрещенное имя файла экспорта";
$MESS["CES_ERROR_PATH_WITHOUT_DEFAUT"] = "Экспорт может быть осуществлён только в папку, указанную в поле <b>Путь по умолчанию для экспортируемых файлов</b> настроек модуля.";
$MESS["CAT_ADM_CSV_EXP_TAB1"] = "Инфоблок";
$MESS["CAT_ADM_CSV_EXP_TAB1_TITLE"] = "Выбор информационного блока для экспорта";
$MESS["CAT_ADM_CSV_EXP_TAB2"] = "Параметры экспорта";
$MESS["CAT_ADM_CSV_EXP_TAB2_TITLE"] = "Настройка параметров экспорта";
$MESS["CAT_ADM_CSV_EXP_TAB3"] = "Результат";
$MESS["CAT_ADM_CSV_EXP_TAB3_TITLE"] = "Результат экспорта";
$MESS["CAT_ADM_CSV_EXP_IBLOCK_ID"] = "Инфоблок";
$MESS["CAT_ADM_CSV_EXP_ADD_SETTINGS"] = "Дополнительные настройки";
$MESS["CAT_ADM_CSV_EXP_EXPORT_FILES"] = "Выгружать файлы";
$MESS["CAT_ADM_CSV_EXP_EXPORT_FROM_CLOUDS"] = "Копировать файлы из облачных хранилищ";
$MESS["CAT_ADM_CSV_EXP_TIME_STEP"] = "Время выполнения шага";
$MESS["CAT_ADM_CSV_EXP_TIME_STEP_COMMENT"] = "0 - загрузить все сразу<br>положительное значение - число секунд на выполнение одного шага";
$MESS["CAT_ADM_CSV_EXP_SEP_ELEMENTS"] = "Поля и свойства элементов";
$MESS["CAT_ADM_CSV_EXP_SEP_SECTIONS"] = "Поля разделов";
$MESS["CAT_ADM_CSV_EXP_SEP_SECTIONS_EXT"] = "Поля и пользовательские свойства разделов";
$MESS["CAT_ADM_CSV_EXP_SEP_PRODUCT"] = "Свойства товара";
$MESS["CAT_ADM_CSV_EXP_SEP_PRICES"] = "Цены";
$MESS["CAT_ADM_CSV_EXP_SEP_SKU"] = "Поля и свойства торговых предложений";
$MESS["CAT_ADM_CSV_EXP_DESCR_SECT_PROP"] = "Пользовательское свойство";
$MESS["CAT_ADM_CSV_EXP_SECTION_LEVEL"] = "Раздел уровня #LEVEL#";
$MESS["YANDEX_ROOT_DIRECTORY_EXT"] = "Основной раздел каталога #NAME#";
$MESS["CATI_FI_PRICE_TYPE2"] = "Цена типа \"#TYPE#\"";
$MESS["CATI_FI_PRICE_TYPE3"] = "Цена типа \"#NAME#\" (#TYPE#)";
$MESS["CATI_FI_PRICE_CURRENCY"] = "в валюте #CURRENCY#";
$MESS["CATI_ADM_RETURN_TO_LIST"] = "Вернуться в список";
$MESS["CATI_ADM_RETURN_TO_LIST_TITLE"] = "Вернуться в список профилей экспорта";
$MESS["CAT_ADM_MISC_EXP_TAB1"] = "Параметры";
$MESS["CAT_ADM_MISC_EXP_TAB1_TITLE"] = "Настройка параметров экспорта";
$MESS["CAT_ADM_MISC_EXP_TAB2"] = "Результат";
$MESS["CAT_ADM_MISC_EXP_TAB2_TITLE"] = "Результат экспорта";
$MESS["CAT_ADM_CSV_EXP_CML2_LINK_IS_XML"] = "Выгружать в свойство привязки торговых предложений к товарам внешний код товара (XML_ID)";
$MESS["CAT_YANDEX_XML_CURRENCY"] = "Валюта, в которую конвертировать цены товаров:";
$MESS["CAT_YANDEX_USE_HTTPS"] = "Использовать в выгрузке протокол https:";
$MESS["CAT_YANDEX_DISABLE_REFERERS"] = "Не добавлять к ссылкам на товары реферер:";
$MESS["CAT_MAX_EXECUTION_TIME"] = "Время выполнения шага:";
$MESS["CAT_MAX_EXECUTION_TIME_NOTE"] = "0 - выгрузить все сразу<br> положительное значение - число секунд на выполнение одного шага";
$MESS["CATI_NO_RIGHTS_FILE"] = "У вас недостаточно прав для перезаписи файла #FILE#";
?>