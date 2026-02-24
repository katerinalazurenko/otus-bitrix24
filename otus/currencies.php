<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle("");
?><?$APPLICATION->IncludeComponent(
    "otus:currencies.list",
    ".default",
    Array(
        "CURRENCY" => "USD",
    )
);?><?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
?>
