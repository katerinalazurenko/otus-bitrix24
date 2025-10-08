<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Врачи");
$APPLICATION->SetAdditionalCss("/doctors/style.css");

use Models\Lists\DoctorsPropertyValuesTable as DoctorsTable;
use Models\Lists\ProcedPropertyValuesTable as ProceduresTable;

$doctors = [];
$doctor;
$procedures = [];

$path = trim($_GET['path'],'/');
$action = '';
$doctor_name = '';

if(!empty($path)) {    
    if(str_contains($path, 'edit')) {
        $action = 'edit';
        $doctor_name = substr(strstr($path, '/', false), 1);
    } elseif(in_array($path, ['new','newproc'])) {
        $action = $path;
    } else $doctor_name = $path;
}

if(!empty($doctor_name)) {
    $doctor = DoctorsTable::query()
    ->setSelect([
        '*',
        'NAME' => 'ELEMENT.NAME',
        'PROCEDURES',
        // 'ID' => 'ELEMENT.ID'
    ])
    ->setFilter(array('NAME' => $doctor_name))
    ->fetch();

    if(is_array($doctor)) {
        if($doctor['PROCEDURES']) {
            foreach($doctor['PROCEDURES'] as $procedure) {
                $procedures[] = ProceduresTable::getByPrimary(
                    $procedure,
                    ['select' => ['NAME' => 'ELEMENT.NAME']]
                ) -> fetch();
            }         
        }
    } else {
        header("Location: /doctors");
        exit();
    }
}

if(empty($path)) {
    $doctors = DoctorsTable::query()
        ->setSelect([
            '*',
            'NAME' => 'ELEMENT.NAME'
            ])
        ->fetchAll();
}

if($action == 'newproc') {
    if(isset($_POST['proc-submit'])) {
        unset($_POST['proc-submit']);
        if(ProceduresTable::add($_POST)){
            header("Location: /doctors");
            exit();
        } else echo "Произошла ошибка";
    }
}

if($action == 'new' || $action == 'edit') {
    if(isset($_POST['doctor-submit'])) {
        unset($_POST['doctor-submit']);
       if($action == 'edit'&& !empty($_POST['ID'])){
            $ID = $_POST['ID'];
            unset($_POST['ID']);
            $_POST['IBLOCK_ELEMENT_ID'] = $ID;

            $procedures = $_POST['PROCEDURES'];
            unset($_POST['PROCEDURES']);
            CIBlockElement::SetPropertyValues($ID, DoctorsTable::IBLOCK_ID, $procedures, 'PROCEDURES');
            
            if(DoctorsTable::update($_POST['ID'],$_POST)){
                header("Location: /doctors");
                exit();
            } else echo "Произошла ошибка 1";
        } 
        if($action == 'new' && DoctorsTable::add($_POST)){
            header("Location: /doctors");
            exit();
        } else echo "Произошла ошибка 2";
    }

    $proc_options = ProceduresTable::query()
        ->setSelect(['ID' => 'ELEMENT.ID','NAME' => 'ELEMENT.NAME'])
        ->fetchAll();
        if(!empty($doctor_name)){
            $data = $doctor;
        }
}
?>
<section class="doctors">
    <h1><a href="/doctors">Врачи</a></h1>
    <? if(empty($action)):?>
        <div class="add-buttons">
            <? if(empty($doctor_name)):?>
                <a href="/doctors/new"><button>Добавить врача</button></a>
                <a href="/doctors/newproc"><button>Добавить процедуру</button></a>
            <? else: ?>
                <a href="/doctors/edit/<?=$doctor_name?>"><button>Изменить данные врача</button></a>
            <? endif;?>
        </div>
    <? endif;?>
    <div class="cards-list">
        <? foreach($doctors as $doc) { ?>
            <a class="card" href="/doctors/<?=$doc["NAME"]?>">
                <div class="fio">
                    <?=$doc["LASTNAME"]?>
                    <?=$doc["FIRSTNAME"]?>
                    <?=$doc["SURNAME"]?>
                </div>
            </a>
        <? } ?>
    </div>
        <? if(is_array($doctor)):?> 
        <div class="doctor-page">
            <h2><?=$doctor['LASTNAME']." ".$doctor['FIRSTNAME']." ".$doctor['SURNAME']?></h2>
            <h3>Процедуры:</h3>
            <ul>
                <?foreach($procedures as $proc):?>
                    <li><?=$proc['NAME']?></li>
                <?endforeach;?>
            </ul>
        </div>
    <?endif?>
    <?if($action == 'new' || $action == 'edit'): ?>
        <form method="POST">
            <h2>Данные врача</h2>
            <div class="doctor-add-form">
                <?if(isset($data['IBLOCK_ELEMENT_ID'])):?>
                    <input type="hidden" name="ID" value=<?=$data['IBLOCK_ELEMENT_ID']?> />
                <?endif?>

                <input type="text" name="NAME" placeholder="Название страницы врача(фамилия латиницей)" value="<?=$data['NAME']??' '?>">
                <input type="text" name="LASTNAME" placeholder="Фамилия врача" value="<?=$data['LASTNAME']??' '?>">
                <input type="text" name="FIRSTNAME" placeholder="Имя врача" value="<?=$data['FIRSTNAME']??' '?>">
                <input type="text" name="SURNAME" placeholder="Отчество врача" value="<?=$data['SURNAME']??' '?>">

                <select multiple name="PROCEDURES[]">
                    <option value="" selected disabled>Процедуры</option>
                        <?foreach($proc_options as $proc):?>
                            <option value="<?=$proc["ID"]?>"
                            <?if(isset($data['PROCEDURES']) && in_array($proc["ID"], $data['PROCEDURES'])):?>
                                selected
                            <?endif;?>>
                            <?=$proc['NAME'];?> 
                            </option>
                        <? endforeach;?>
                </select>

                <input type="submit" name="doctor-submit" value="Сохранить"/>
            </div>
        </form>
    <?endif?>

    <?if($action == 'newproc'): ?>
        <form method="POST">
            <h2>Добавить процедуру</h2>
            <div class="doctor-add-form">
                
                <input type="text" name="NAME" placeholder="Название процедуры)" value="<?=$data['NAME']??' '?>">

                <input type="submit" name="proc-submit" value="Сохранить"/> 
            </div>
        </form>
    <?endif?>

</section>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>