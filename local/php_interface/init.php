<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/vendor/autoload.php';

AddEventHandler('main', 'OnProlog', function() {
    if (!defined('ADMIN_SECTION')) {
        \Otus\Diag\CustomLogger::logPageVisit();
    }
});
