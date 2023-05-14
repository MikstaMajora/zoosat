
<html lang="ru-RU"><head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex, nofollow">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="true" name="HandheldFriendly">
	<meta content="width" name="MobileOptimized">
	<meta content="yes" name="apple-mobile-web-app-capable">

	<title>Система быстрых платежей - Оплата по QR коду</title>

	<link rel="stylesheet" type="text/css" href="https://qr.nspk.ru/css/style.css?v1">

	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

</head>
<body class="loading is-mobile loaded">
<div class="preloader"></div>

<div class="main main--no-summ">
	<header class="page-header" style="top: -103px;">
		<div class="logo-sbp">
			<img src="https://zoosat.ru/upload/CNext/3b4/6s01zctlc2wf4tx13m3wn9v48yvp2fyl.png" alt="СБП Системы Быстрых Платежей">
		</div>
		<div class="link">
			<a href="https://www.zoosat.ru/">zoosat.ru</a>
		</div>
	</header>

	<div class="content">

		<div>
			<div class="info-sum__text-sum">Номер заказа: <?=$orderid;?> </div>
			<div >Сумма заказа:  <?=$payAmount;?> <span class="info-sum__rub">&nbsp;₽</span></div>
		</div>

		<div class="content__mobile">
			<section class="info-sum">
				<div class="info-sum__text-sum">Сумма</div>
				<div class="info-sum__sum"><?=$payAmount;?></div><span class="info-sum__rub">&nbsp;₽</span><!--&nbsp;₽&#8381; или &#x20bd;-->
				<div class="anistripe">
					<div class="i1"></div>
					<div class="i2"></div>
					<div class="i3"></div>
					<div class="i4"></div>
					<div class="i5"></div>
					<div class="i6"></div>
					<div class="i7"></div>
					<div class="i8"></div>
					<div class="i1"></div>
				</div>
				<div class="info-sum__text">Выберите банковское приложение и&nbsp;подтвердите&nbsp;оплату</div>
			</section>

			<section class="info-sum info-sum--no-sum">
				<div class="info-sum__title">Выберите</div>
				<div class="info-sum__text">банковское приложение и&nbsp;подтвердите&nbsp;оплату</div>
			</section>

			<section class="banks">
				<div class="banks__search">
					<input type="text" placeholder="Поиск" id="bank-search">
				</div>

				<div class="banks__title">Все банки</div>

				<div class="banks__list-wrap" style="top: 628px;">
					<div class="banks__list banks__list--square">
						<div class="banks__list-inner" id="banks-list">


							<?php foreach($dictionary as $item): ?>
								<a href="<?=$item->schema;?>://qr.nspk.ru/<?=$uniqueID;?>">
									<div class="banks__list-item-img"><img src="<?=$item->logoURL;?>"></div>
									<span><?=$item->bankName;?></span>
								</a>
							<?php endforeach; ?>


						</div>
					</div>
				</div>

			</section>
		</div>

		<div class="content__desktop" style="top: 100px;">
			<section class="qr">
				<div class="qr__wrap"></div>
				<div class="qr__sum">
					<div class="qr__sum-row">
						<div class="qr__sum-text-sum">Сумма</div>
						<div class="qr__sum-sum">0</div><span class="qr__sum-rub">&nbsp;₽</span>
					</div>
					<div class="qr__sum-text">
						Для оплаты отсканируйте QR-код в&nbsp;мобильном приложении банка или штатной камерой телефона
					</div>
				</div>

				<div class="qr__sum qr__sum--no-sum">
					<div class="font90">Для оплаты</div>
					<div class="qr__sum-text">отсканируйте QR-код в&nbsp;мобильном приложении банка или штатной камерой телефона</div>
				</div>
			</section>

			<section class="faq" style="display:none;">
				<input type="checkbox" id="faq-tab-main">
				<label for="faq-tab-main" class="tab-label">Появились вопросы загляни сюда</label>
				<div class="tab-container">
					<input type="checkbox" name="faq-tab" id="faq-tab__tab-1" class="tab">
					<label for="faq-tab__tab-1">Как удалить настройки по&nbsp;умолчанию на&nbsp;ОС&nbsp;Android?</label>
					<div>
						<div>
							<p>Если вы&nbsp;установили мобильное приложение банка или браузер для открытия ссылок СБП по&nbsp;умолчанию
								и&nbsp;хотите сбросить выбор, то&nbsp;выполните следующие шаги:
							</p>
							<ol>
								<li>Зайдите в&nbsp;меню «Настройки» на&nbsp;телефоне;</li>
								<li>Выберите пункт «Приложения и&nbsp;уведомления»;</li>
								<li>Выберите мобильное приложение банка или браузер;</li>
								<li>Выберите пункт «Открывать по&nbsp;умолчанию»;</li>
								<li>Нажмите на&nbsp;кнопку «Удалить настройки по&nbsp;умолчанию»;</li>
							</ol>
							<p>После выполнения этих шагов, при попытке открыть ссылку СБП на&nbsp;оплату вам будет
								предложен список мобильных приложений банков, установленных на&nbsp;телефоне и&nbsp;браузер.</p>
						</div>
					</div>

					<input type="checkbox" name="faq-tab" id="faq-tab__tab-2">
					<label for="faq-tab__tab-2">А&nbsp;если у&nbsp;меня Xiaomi?</label>
					<div>
						<div>
							<p>Чтобы ссылки снова открывались в&nbsp;установленных на&nbsp;вашем Xiaomi приложениях,
								нужно вручную выставить данную функциональность в&nbsp;настройках.</p>
							<p>Для этого нам необходимо зайти в&nbsp;общие Настройки устройства и&nbsp;прокрутить
								список
								разделов до&nbsp;пункта «Приложения».
							</p><p>Нажимаем по&nbsp;нему и&nbsp;попадаем в&nbsp;меню глубоких настроек&nbsp;—
								здесь
								нам нужно выбрать пункт «Все приложения».</p>
							<p>Открывается список всех установленных на&nbsp;смартфоне приложений. </p>
							<p>В&nbsp;правом верхнем углу мы&nbsp;видим иконку в&nbsp;виде трех точек&nbsp;—
								нажимаем на&nbsp;нее и&nbsp;наблюдаем появление нового окошка, в&nbsp;котором нам
								необходимо выбрать пункт «Приложения по&nbsp;умолчанию»</p>
							<p>Выбираем настройки Браузера. Нам необходимо нажать на&nbsp;вариант «Не&nbsp;выбрано»&nbsp;—
								таким образом, смартфон не&nbsp;будет сразу направлять все открываемые ссылки именно
								на&nbsp;браузер.
								Это означает, что при открытии новой ссылки смартфон будет предлагать возможность
								выбора
								поддерживаемого приложения.</p>
						</div>
					</div>

					<input type="checkbox" name="faq-tab" id="faq-tab__tab-3">
					<label for="faq-tab__tab-3">А&nbsp;что делать если у&nbsp;меня iOS?</label>
					<div class="">
						<div>
							<p>Специально для владельцев iPhone разных версий мы&nbsp;разработали приложение <a href="https://apps.apple.com/ru/app/sbp-varia/id1541828520">SBPvaria</a></p>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>

	<footer class="footer">
		<div class="footer__anistripe">
			<div class="anistripe">
				<div class="i1"></div>
				<div class="i2"></div>
				<div class="i3"></div>
				<div class="i4"></div>
				<div class="i5"></div>
				<div class="i6"></div>
				<div class="i7"></div>
				<div class="i8"></div>
				<div class="i1"></div>
			</div>
		</div>
		<div>
			Все платежи проводятся Системой Быстрых Платежей.
			<br>
			© 2022 Система Быстрых Платежей. Все права защищены.
		</div>
	</footer>

	<section class="cookies">
		<div>Для улучшения качества нашего сервиса мы&nbsp;используем на&nbsp;сайте технологию cookies.</div>
		<a href="javascript:void(0);">Согласен</a>
	</section>
</div>

<script type="text/javascript" src="https://qr.nspk.ru/js/scripts.min.js?v1"></script>

</body></html>