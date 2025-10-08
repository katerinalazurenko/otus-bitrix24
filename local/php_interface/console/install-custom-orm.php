<?php
if (php_sapi_name() != 'cli')
{
    die();
}

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define("BX_NO_ACCELERATOR_RESET", true);
define("BX_CRONTAB", true);
define("STOP_STATISTICS", true);
define("NO_AGENT_STATISTIC", "Y");
define("DisableEventsCheck", true);
define("NO_AGENT_CHECK", true);

$_SERVER['DOCUMENT_ROOT'] = realpath('/home/c/cd30036/public_html');
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Entity\Base;
use Bitrix\Main\Application;
use Otus\Diag\Orm\ClassTable;
use Otus\Diag\Orm\TeachersTable;
use Otus\Diag\Orm\StudentsTable;
use Otus\Diag\Orm\SchoolRelationTable;

$entities = [
    ClassTable::class,
    TeachersTable::class,
    StudentsTable::class,
    SchoolRelationTable::class,
];

foreach ($entities as $entity) {
    if (!Application::getConnection($entity::getConnectionName())->isTableExists($entity::getTableName())) {
        Base::getInstance($entity)->createDbTable();
    }
}


