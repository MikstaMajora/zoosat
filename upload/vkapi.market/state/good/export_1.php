<? $arData = array (
  'complete' => true,
  'percent' => 100.0,
  'step' => 10,
  'steps' => 
  array (
    1 => 
    array (
      'name' => 'Проверка подключения',
      'percent' => 100,
      'error' => false,
    ),
    2 => 
    array (
      'name' => 'Формирование списка товаров (без торговых предложений) для экспорта. Обработано 7023 из 7023 элементов. 
В списке для экспорта товаров - 6339 (товары + торговые предложения - 6339)',
      'percent' => 100,
      'error' => false,
    ),
    3 => 
    array (
      'name' => 'Проверка ранее выгруженных товаров. Отсутствует 0. Обработано 5739 из 5739 элементов',
      'percent' => 100,
      'error' => false,
    ),
    4 => 
    array (
      'name' => 'Обновление ранее выгруженных товаров. Обработано: 5358 из 5358. Обновлено: 4989. Пропущено (нет изменений, несоответствие, ошибка): 369.',
      'percent' => 100,
      'error' => false,
    ),
    5 => 
    array (
      'name' => 'Удаление лишних товаров. Обработано: 381 из 381. Удалено: 381.',
      'percent' => 100.0,
      'error' => false,
    ),
    6 => 
    array (
      'name' => 'Удаление локальных дубликатов. Обработано: 0 из 0. Удалено: 0.',
      'percent' => 100,
      'error' => false,
    ),
    7 => 
    array (
      'name' => 'Выгрузка новых товаров, обработано: 981 из 981. Добавлено: 511. Пропущено из-за несоответствий: 470 (Чтобы узнать причины несоответствий, в настройках включите - Заполнять журнал операций = Все вместе. Повторите экспорт. Посмотрите причины пропуска среди ошибок журнала операций )',
      'percent' => 100,
      'error' => false,
    ),
    8 => 
    array (
      'name' => 'Удаление неизвестных товаров в ВК.  Обработано: 0 из 0. Удалено: 0.',
      'percent' => 100,
      'error' => false,
    ),
    9 => 
    array (
      'name' => 'Группировка, разгруппировка товаров в ВК. Обработано: 0 из 0. Сгруппировано: 0. ',
      'percent' => 100,
      'error' => false,
    ),
  ),
  'run' => false,
  'timeStart' => 1668157535,
  'exportRunPrepareList' => 
  array (
    'complete' => true,
    'percent' => 100.0,
    'count' => 7023,
    'offset' => 7023,
    'limit' => 10,
    'validProduct' => '6339',
    'valid' => 6339,
  ),
  'exportRunCheckExistsInVk' => 
  array (
    'complete' => true,
    'percent' => 100.0,
    'count' => 5739,
    'offset' => 5739,
    'limit' => 250,
    'losted' => 0,
  ),
  'exportRunUpdateInVk' => 
  array (
    'complete' => true,
    'percent' => 100.0,
    'count' => '5358',
    'offset' => 5358,
    'limit' => 25,
    'updated' => 4989,
    'skipped' => 369,
  ),
  'exportRunDeleteOldFromVK' => 
  array (
    'complete' => true,
    'percent' => 100.0,
    'count' => 381,
    'offset' => 381,
    'limit' => 25,
    'deleted' => 381,
  ),
  'exportRunDeleteLocalDoublesFormVK' => 
  array (
    'complete' => true,
    'percent' => 100,
    'count' => 0,
    'offset' => 0,
    'limit' => 20,
    'deleted' => 0,
    'arId' => 
    array (
    ),
  ),
  'exportRunAddToVk' => 
  array (
    'complete' => true,
    'percent' => 100.0,
    'count' => 981,
    'offset' => 981,
    'limit' => 25,
    'added' => 511,
    'skipped' => 470,
    'arId' => 
    array (
    ),
  ),
  'exportRunDeleteUnknownInVK' => 
  array (
    'complete' => true,
    'percent' => 100,
    'count' => 0,
    'offset' => 0,
    'limit' => 20,
    'deleted' => 0,
  ),
  'exportRunGroupUngroupItem' => 
  array (
    'complete' => true,
    'percent' => 100,
    'count' => 0,
    'offset' => 0,
    'limit' => 25,
    'grouped' => 0,
  ),
); ?>