<?php

namespace Otus\Diag\Orm;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

class ClassTable extends DataManager
{

    public static function getTableName(): string
    {
        return 'class';
    }

    public static function getMap(): array
    {
        return [
            (new IntegerField('ID'))
                ->configurePrimary()
                ->configureAutocomplete(),

            (new StringField('NAME'))
                ->configureRequired()
                ->configureSize(100),

            (new IntegerField('QUANTITY')),

            
            // (new Reference(
            //     'TEACHERS',
            //     TeachersTable::class,
            //     Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID')
            // )),

            // (new Reference(
            //     'STUDENTS',
            //     StudentsTable::class,
            //     Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID')
            // )),
        ];
    }
}