<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Проверочная страница")?>

<?php

// Путь к лог-файлу для ссылки
$logFile = '/local/logs/log_custom.log';
?>

<!-- Ваш HTML -->
<!DOCTYPE html>
<html>
<body>
    
    <!-- Ссылка на лог-файл -->
    <div>
        <strong>Лог-файл:</strong> 
        <a href="<?= $logFile ?>" target="_blank">Файл лога</a>
    </div>
</body>
</html>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>


