<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

use Bitrix\Main\Entity\Query;
use Otus\Diag\Orm\ClassTable;
use Otus\Diag\Orm\SchoolRelationTable;

$APPLICATION->SetTitle("Школьная система");

$classesQuery = new Query(ClassTable::class);
$classes = $classesQuery->setSelect(['*'])->exec();

?>
<div>
    <h1>Школьные классы</h1>
    
    <?php while ($class = $classes->fetch()): ?>
    <div>
        <h2>Класс: <?= htmlspecialchars($class['NAME']) ?></h2>
        <p>Количество учеников: <?= $class['QUANTITY'] ?></p>
        
        <?php
        $teachersQuery = new Query(SchoolRelationTable::class);
        $teachersQuery->setSelect([
            'TEACHER_ID',
            'TEACHER_NAME' => 'TEACHER.NAME',
        ]);
        $teachersQuery->setFilter([
            '=CLASS_ID' => $class['ID'],
            '=ROLE' => 'teacher'
        ]);
        $teachers = $teachersQuery->exec();
        ?>
        
        <h3>Учителя:</h3>
        <?php if ($teachers->getSelectedRowsCount() > 0): ?>
            <ul>
            <?php while ($teacher = $teachers->fetch()): 
                $properties = Bitrix\Iblock\ElementPropertyTable::getList([
                    'filter' => ['=IBLOCK_ELEMENT_ID' => $teacher['TEACHER_ID']],
                    'select' => ['IBLOCK_PROPERTY_ID', 'VALUE']
                ])->fetchAll();
                
                $experience = '';
                foreach($properties as $prop){
                    if($prop['IBLOCK_PROPERTY_ID'] == 71){ 
                        $experience = $prop['VALUE'];
                        break;
                    }
                }
            ?>
                <li>
                    <strong><?= htmlspecialchars($teacher['TEACHER_NAME']) ?></strong>
                    <?php if ($experience): ?>
                        - стаж <?= $experience ?> лет
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Учителя не назначены</p>
        <?php endif; ?>
        
        <?php
        $studentsQuery = new Query(SchoolRelationTable::class);
        $studentsQuery->setSelect([
            'STUDENT_ID',
            'STUDENT_NAME' => 'STUDENT.NAME',
        ]);
        $studentsQuery->setFilter([
            '=CLASS_ID' => $class['ID'],
            '=ROLE' => 'student'
        ]);
        $students = $studentsQuery->exec();
        ?>
        
        <h3>Ученики (<?= $students->getSelectedRowsCount() ?>):</h3>
        <?php if ($students->getSelectedRowsCount() > 0): ?>
            <ul>
            <?php while ($student = $students->fetch()): 
                $properties = Bitrix\Iblock\ElementPropertyTable::getList([
                    'filter' => ['=IBLOCK_ELEMENT_ID' => $student['STUDENT_ID']],
                    'select' => ['IBLOCK_PROPERTY_ID', 'VALUE']
                ])->fetchAll();
                
                $age = '';
                foreach($properties as $prop){
                    if($prop['IBLOCK_PROPERTY_ID'] == 70){ 
                        $age = $prop['VALUE'];
                        break;
                    }
                }
            ?>
                <li>
                    <?= htmlspecialchars($student['STUDENT_NAME']) ?>
                    <?php if ($age): ?>
                        - возраст <?= $age ?> лет
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Ученики не добавлены</p>
        <?php endif; ?>
    </div>
    <?php endwhile; ?>
</div>

<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');