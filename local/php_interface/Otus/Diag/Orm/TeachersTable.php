<?php
namespace Otus\Diag\Orm;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class TeachersTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'b_iblock_element'; // Используем стандартную таблицу элементов
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
                'default_value' => 20 // ID вашего инфоблока учителей
            ]),
            // Добавьте нужные свойства учителей
        ];
    }
}
