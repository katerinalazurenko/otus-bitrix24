<?php
namespace Otus\Diag\Orm;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class StudentsTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'b_iblock_element';
    }
    
    public static function getMap()
    {
        return [
            new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true
            ]),
            new Entity\StringField('NAME'),
            new Entity\IntegerField('IBLOCK_ID', [
                'required' => true,
                'default_value' => 19 // ID вашего инфоблока учеников
            ]),
            // Добавьте нужные свойства учеников
        ];
    }
}