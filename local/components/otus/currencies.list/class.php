<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Currency\CurrencyTable;

Loader::includeModule('currency');

class CurrencyListComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $arParams['CURRENCY'] = $arParams['CURRENCY'] ?? 'USD';
        return $arParams;
    }
    
    public function executeComponent()
    {
        try {
            $currency = CurrencyTable::getList([
                'select' => ['CURRENCY', 'AMOUNT', 'AMOUNT_CNT'],
                'filter' => ['=CURRENCY' => $this->arParams['CURRENCY']],
                'limit' => 1
            ])->fetch();
            
            if ($currency) {
                $this->arResult = [
                    'CURRENCY' => $currency['CURRENCY'],
                    'AMOUNT' => $currency['AMOUNT'],
                    'AMOUNT_CNT' => $currency['AMOUNT_CNT'],
                    'FORMATTED_RATE' => $currency['AMOUNT_CNT'] . ' RUB = ' . number_format($currency['AMOUNT'], 4) . ' ' . $currency['CURRENCY']
                ];
            } else {
                $this->arResult = false;
            }
            
            $this->includeComponentTemplate();
            
        } catch (Exception $e) {
            $this->arResult = false;
            $this->includeComponentTemplate();
        }
    }
}
?>