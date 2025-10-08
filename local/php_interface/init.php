<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/vendor/autoload.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/local/app/autoload.php';

AddEventHandler('main', 'OnProlog', function() {
    if (!defined('ADMIN_SECTION')) {
        \Otus\Diag\CustomLogger::logPageVisit();
    }
});
