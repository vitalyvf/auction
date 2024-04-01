<?php
if (is_file('config.php')) {
	require_once('config.php');
} else {
	die('Config file not found');
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <title>Installation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
    <div class="install">
        <h2>Для установки аукциона требуется:</h2>
        <ol>
            <li>Создать базу данных и залить в нее данные из файла <b>install/demo.sql</b></li>
            <br>
            <li>В файле <b>config.php</b> прописать данные для доступа к этой базе данных</li>
            <br>
            <li>Установить права на запись для папки c картинками: <b>chmod -R 777 images/</b></li>
        </ol>
        <h2>Для запуска аукциона понадобится:</h2>
        <ol>
            <li>Скрипт, который отслеживает время проведения аукционов - <b>update.php</b>. Запуск скрипта ограничен get параметром <b>cron</b>, который должен быть равен константе, прописаной в config.php. Можно поставить его выполнение на cron с частотой раз в минуту, но можно просто <a href="update.php?cron=<?= CRON_PASSWORD; ?>" target="_blank">запустить его в отдельном окне браузера</a>.
            </li>
            <br>
            <li>Обмен данными о ставках между участниками торгов проходит в реальном времени - для этого используется WebSocket. Необходмио открыть терминал и выполнить в нем команду <b>php server.php</b>.
            </li>
        </ol>
        <h2>Доступы:</h2>
        <ol>
            <li>Панель администратора <a href="admin/" target="_blank">находится в папке admin</a>. Логин/пароль для базового админа: <b>admin/admin</b>
            </li>
            <br>
            <li>Также создано несколько учетных записей покупателей: <b>111/111</b> <b>222/222</b> <b>333/333</b> и т.д. Вход для покупателей <a href="./" target="_blank">находится в корневом каталоге</a>
            </li>
        </ol>
    </div>
</body>
</html>
