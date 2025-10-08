<?php

namespace Otus\Diag\Orm;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

class SchoolRelationTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'class_relations';
    }

    public static function getMap(): array
    {
        return [
            (new IntegerField('ID'))
                ->configurePrimary()
                ->configureAutocomplete(),

            (new IntegerField('CLASS_ID'))
                ->configureRequired(),

            (new IntegerField('TEACHER_ID')), // ID учителя из инфоблока

            (new IntegerField('STUDENT_ID')), // ID ученика из инфоблока

            (new StringField('ROLE'))
                ->configureRequired()
                ->configureSize(50), // 'teacher' или 'student'

            // Связь с таблицей классов
            (new Reference(
                'CLASS_ENTITY',
                ClassTable::class,
                Join::on('this.CLASS_ID', 'ref.ID')
            )),

            // Связь с элементами инфоблока учителей 
            (new Reference(
                'TEACHER',
                \Bitrix\Iblock\ElementTable::class,
                Join::on('this.TEACHER_ID', 'ref.ID')
                    ->where('ref.IBLOCK_ID', 20)
            )),

            // Связь с элементами инфоблока учеников 
            (new Reference(
                'STUDENT',
                \Bitrix\Iblock\ElementTable::class,
                Join::on('this.STUDENT_ID', 'ref.ID')
                    ->where('ref.IBLOCK_ID', 19)
            )),
        ];
    }
}