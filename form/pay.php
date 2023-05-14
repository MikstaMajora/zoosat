<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; minimum-scale=1.0;" />

<?php
if( !preg_match('/iPhone|iPad|iPod/i', $_SERVER ['HTTP_USER_AGENT']) ) {
	echo '<iframe id="myframe" src="https://qr.nspk.ru/BD10006LQ6LNI7R88AJBQP5AE5GEBSNT?type=02&bank=100000000015&sum=10000&cur=RUB&crc=B4F7" frameborder="0" scrolling="yes" height="100%" width="100%"></iframe>';
} else {
	echo 'У вас iphone';
}
?>

