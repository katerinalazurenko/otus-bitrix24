<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/** @global $APPLICATION */
$APPLICATION->SetTitle('Врачи');
$APPLICATION->SetAdditionalCSS('/doctors/style.css');

// получение одной записи из инфоблока Страна в виде объекта

$countryId = 70; // Element{Country}Table
$country = \Bitrix\Iblock\Elements\ElementCountryTable::getByPrimary(
    $countryId, 
    array(
        'select' => [
            '*',
            'CURRENCY', 
            'CITIES.ELEMENT.NAME', 
            'CITIES.ELEMENT.ENGLISH',
            'CAPITAL.ELEMENT.NAME',
            'CAPITAL.ELEMENT.ENGLISH',
        ] 
    )
)->fetchObject();

pr($country->getId()); // ID элемента
pr($country->getName()); // имя элемента

pr($country->getCurrency()->getValue()); // свойство элемента Валюта  

// свойство элемента Столица  
pr($country->getCapital()->getElement()->getId()); 
pr($country->getCapital()->getElement()->getName()); 
pr($country->getCapital()->getElement()->getEnglish()->getValue()); 

// свойство элемента Города  
foreach($country->getCities()->getAll() as $prItem) {
    pr($prItem->getElement()->getEnglish()->getValue().' '.$prItem->getElement()->getName());
    // pr($prItem->getElement()->get('ID').' '.$prItem->getElement()->get('ENGLISH')->getValue().' '.$prItem->getElement()->getName());
}



// получение одной записи из инфоблока Страна в виде массива
/*$countryId = 70; 
$res = \Bitrix\Iblock\Elements\ElementCountryTable::getByPrimary($countryId, 
    array('select' => [
            '*', 
            'CITIES.ELEMENT.NAME', 
            'CITIES.ELEMENT.ENGLISH',
            // 'CAPITAL.ELEMENT.NAME',
            // 'CAPITAL.ELEMENT.ENGLISH',
        ]
    )
)->fetch();

// pr($res['NAME']); // имя элемента
pr($res); */


// получение одной записи из инфоблока Доктора в виде объекта
/*$docId = 69; 

$doctors = \Bitrix\Iblock\Elements\ElementDoctorsTable::getList([ // получение списка процедур у врачей
    'select' => [
        'ID', 
        'NAME', 
        'DETAIL_PICTURE',
        'PROC_IDS_MULTI.ELEMENT.NAME',
        'PROC_IDS_MULTI.ELEMENT.DESCRIPTION', // PROC_IDS_MULTI - множественное поле Процедуры у элемента инфоблока Доктора 
        'PROC_IDS_MULTI.ELEMENT.COLORS'
    ], 
    'filter' => [
        'ID' => $docId,
        'ACTIVE' => 'Y',
    ],
])
->fetchCollection(); 

foreach ($doctors as $doctor) {
    pr($doctor->getId().' '.$doctor->getName().' - - -');
    pr(CFile::GetPath($doctor->getDetailPicture()));

    foreach($doctor->getProcIdsMulti()->getAll() as $prItem) {
        // получаем значение свойства Описание у процедуры 
        if($prItem->getElement()->getDescription()!== null){
            pr($prItem->getId().' - '.$prItem->getElement()->getName().' - '.$prItem->getElement()->getDescription()->getValue());
        }
        // получаем значение свойства Цвет у процедуры 
        // foreach($prItem->getElement()->getColors()->getAll() as $color) {
        //     pr($color->getValue());
        // }
    }

}*/



// получение списка Процедур у записей инфоблока Врачи с использованием метода query()

/*$doctors = \Bitrix\Iblock\Elements\ElementDoctorsTable::query() 
->setSelect([  
    'NAME',
    'PROC_IDS_MULTI.ELEMENT.NAME',
    'PROC_IDS_MULTI.ELEMENT.DESCRIPTION' // PROC_IDS_MULTI - множественное поле инфоблока Доктора 
])
->setFilter(array('ACTIVE' => 'Y','ID' => $docId,))
->fetchCollection();

// затем обходим коллекцию и получаем процедуры
$procedures = []; 
foreach ($doctors as $doctor){
    foreach($doctor->getProcIdsMulti()->getAll() as $prItem) {
        $procedures[] = [
            'name'=> $prItem->getElement()->getName(),                
            'id' => $prItem->getElement()->getId()
        ];
    }
}
pr($procedures); */


// получение одной записи из инфоблока Процедуры
/*
$procedureId = 48; 
$procedures = \Bitrix\Iblock\Elements\ElementProceduresTable::getList([ // получение списка значений свойства цвет у  элемента Процедура
    'select' => [
        'ID', 
        'NAME', 
        'DESCRIPTION',
        'COLORS',
    ],
    'filter' => [
        'ID' => $procedureId,
        'ACTIVE' => 'Y'
    ],
])->fetchCollection();
foreach ($procedures as $procedure) {
    foreach($procedure->getColors()->getAll() as $color) {
            pr($color->getValue());
    }
}
*/





?>

