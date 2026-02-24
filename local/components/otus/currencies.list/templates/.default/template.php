<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
?>

<?php if ($arResult): ?>
    <div class="currency-rate">
        <?= $arResult['FORMATTED_RATE'] ?>
    </div>
<?php else: ?>
    <div class="currency-rate-error">
        Курс валюты не найден
    </div>
<?php endif; ?>