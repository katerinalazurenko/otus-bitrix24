<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

use Otus\Diag\Orm\ClassTable;
use Otus\Diag\Orm\SchoolRelationTable;

// Получаем данные
$classes = ClassTable::getList()->fetchAll();
$teachers = Bitrix\Iblock\ElementTable::getList(['filter'=>['IBLOCK_ID'=>20]])->fetchAll();
$students = Bitrix\Iblock\ElementTable::getList(['filter'=>['IBLOCK_ID'=>19]])->fetchAll();

foreach($classes as $i => $class){
    // Связь учителя с классом
    if(isset($teachers[$i])){
        SchoolRelationTable::add([
            'CLASS_ID' => $class['ID'],
            'TEACHER_ID' => $teachers[$i]['ID'],
            'ROLE' => 'TEACHER'
        ]);
        echo "Класс {$class['NAME']} → Учитель {$teachers[$i]['NAME']}<br>";
    }
    
    // Связь ученика с классом
    if(isset($students[$i])){
        SchoolRelationTable::add([
            'CLASS_ID' => $class['ID'],
            'STUDENT_ID' => $students[$i]['ID'], 
            'ROLE' => 'STUDENT'
        ]);
        echo "Класс {$class['NAME']} → Ученик {$students[$i]['NAME']}<br>";
    }
}

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');