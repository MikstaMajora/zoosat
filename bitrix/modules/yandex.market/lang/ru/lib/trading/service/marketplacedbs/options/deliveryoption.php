<?php

$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_ID'] = 'Служба доставки';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_NAME'] = 'Название';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_TYPE'] = 'Способ доставки';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_TYPE_HELP'] = '
<p><strong>Самовывоз</strong>&nbsp;&mdash; покупатель сможет забрать заказ из&nbsp;Точки продаж, которая добавлена в&nbsp;личном кабинете маркетплейса;</p>
<p><strong>Почта</strong>&nbsp;&mdash; доставка в&nbsp;отделение почтовой службы;</p>
<p><strong>Курьерская доставка</strong>&nbsp;&mdash; заказ доставит курьер магазина или службы доставки.</p>
';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_DAYS'] = 'Срок доставки по&nbsp;умолчанию';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_DAYS_HELP'] = 'Срок доставки является обязательным. Заполните значения по&nbsp;умолчанию, если служба доставки не&nbsp;поддерживает или может не&nbsp;передавать интервал доставки.';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_DAYS_NOTE'] = 'Срок доставки по&nbsp;умолчанию используется, если служба доставки не&nbsp;поддерживает или может не&nbsp;передавать интервал доставки.';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_DAYS_UNIT_1'] = 'день';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_DAYS_UNIT_2'] = 'дня';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_DAYS_UNIT_5'] = 'дней';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_SUMMARY'] = '#TYPE# &laquo;#ID#&raquo;, за #DAYS# (#HOLIDAY.CALENDAR#)';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_OUTLET'] = 'Пункты выдачи';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_SHIPMENT_DATE_BEHAVIOR'] = 'Плановая дата отгрузки';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_SHIPMENT_DATE_BEHAVIOR_HELP'] = 'Укажите, за сколько дней до получения заказа покупателем вы отдаёте его в службу доставки.';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_SHIPMENT_DATE_BEHAVIOR_OPTION_DELIVERY_DAY'] = 'В день доставки';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_SHIPMENT_DATE_BEHAVIOR_OPTION_ORDER_DAY'] = 'В день заказа';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_SHIPMENT_DATE_BEHAVIOR_OPTION_DELIVERY_OFFSET'] = 'Несколько дней до доставки';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_SHIPMENT_DATE_BEHAVIOR_OPTION_ORDER_OFFSET'] = 'Несколько дней после заказа';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_SHIPMENT_DATE_OFFSET'] = 'Количество дней для&nbsp;отгрузки';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_SHIPMENT_DATE_OFFSET_HELP'] = 'Необходимое количество рабочий дней для отгрузки заказа. В&nbsp;качестве режима работы используется График отгрузки.';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_SCHEDULE_GROUP'] = 'График доставки';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_AUTOMATION'] = 'Автоматизация';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_AUTO_FINISH'] = 'Завершать заказ после отправки';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_AUTO_FINISH_HELP'] = 'При уведомлении от&nbsp;маркетплейса устанавливать статусы заказа <nobr>1С-Битрикс</nobr>, указанные на&nbsp;вкладке &laquo;Статусы заказов&raquo; для статусов маркетплейса DELIVERY и&nbsp;DELIVERED.';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_SCHEDULE'] = 'Расписание';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_SCHEDULE_HELP'] = '
<p>На&nbsp;основе расписания будет сформирован список возможных дат доставки и&nbsp;временных интервалов, доступных покупателю для выбора.</p>
<p>На&nbsp;каждый день можно создать до&nbsp;5&nbsp;интервалов.</p>
<p>Формат времени: <nobr>24-часовой</nobr>, ЧЧ: ММ. В&nbsp;качестве минут всегда должно быть указано 00 (исключение&nbsp;&mdash; 23:59). Максимальное значение: 23:59.</p>
<p>Если интервалы не&nbsp;соответствуют требованиям, будет выполнено автоматическое округление. Например: интервал от&nbsp;9:15 до&nbsp;11:30 будет преобразован к&nbsp;9:00 до&nbsp;12:00.</p>
';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_SHIPMENT_DELAY'] = 'Задержка отгрузки';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_SHIPMENT_DELAY_HELP'] = 'Время необходимое магазину для передачи заказа в&nbsp;службу доставки';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_PERIOD_WEEKEND_RULE'] = 'Учет выходных';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_PERIOD_WEEKEND_RULE_HELP'] = '
<p>Как будет изменена первая дата доставки, если срок доставки от&nbsp;2 до&nbsp;4 дней:</p>
<ul>
<li><strong>Срок доставки указан в&nbsp;рабочих днях</strong>&nbsp;&mdash; второй рабочий день ^1;</li>
<li><strong>Выдача в&nbsp;ближайший рабочий день</strong>&nbsp;&mdash; первый рабочий день после двух дней ^1;</li>
<li><strong>Служба доставки учитывает выходные</strong>&nbsp;&mdash; второй день.</li>
</ul>
<p>^1 если заказ выполняется в&nbsp;нерабочее время с&nbsp;учетом задержки отгрузки, отсчет начнется со&nbsp;следующего рабочего дня.</p>
';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_PERIOD_WEEKEND_RULE_FULL'] = 'Срок доставки указан в рабочих днях';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_PERIOD_WEEKEND_RULE_EDGE'] = 'Выдача в ближайший рабочий день';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_PERIOD_WEEKEND_RULE_NONE'] = 'Служба доставки учитывает выходные';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_INTERVAL_FORMAT'] = 'Формат интервала';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_INTERVAL_FORMAT_TIME'] = 'Выбор даты и времени';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_INTERVAL_FORMAT_PERIOD'] = 'Интервал &laquo;ОТ-ДО&raquo;';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_INTERVAL_FORMAT_HELP'] = '
<p>Какой выбор даты доставки предлагать покупателю при оформлении заказа. Например, если срок доставки от&nbsp;2&nbsp;до&nbsp;3&nbsp;дней, то:</p>
<ul>
<li>Выбор даты и&nbsp;времени&nbsp;&mdash; пользователю будет предложено два варианта: доставка на&nbsp;2-ой день или на&nbsp;3-ий день;</li>
<li>Интервал &laquo;ОТ-ДО&raquo;&nbsp;&mdash; один вариант: 2-3&nbsp;дня.</li>
</ul>
';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_OPTIONS_DELIVERYOPTION_HOLIDAY_GROUP'] = 'Праздничные дни';
