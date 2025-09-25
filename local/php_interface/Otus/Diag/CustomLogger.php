<?php

namespace Otus\Diag;

class CustomLogger
{
    public static function logPageVisit()
    {
        // Игнорируем битриксовые AJAX
        if (self::isBitrixAjax()) {
            return;
        }
        
        $logFile = $_SERVER['DOCUMENT_ROOT'] . '/local/logs/log_custom.log';
        $currentDate = date('Y-m-d H:i:s');
        $pageUrl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    
        $logMessage = "[$currentDate] Открыта страница: $pageUrl\n";
        
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }
    
    private static function isBitrixAjax()
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        
        // Игнорируем битриксовые AJAX-запросы
        $ajaxPaths = [
            '/bitrix/tools/public_session.php',
            '/bitrix/services/main/ajax.php',
            '/bitrix/components/bitrix/',
            'action=intranet.searchentity.getall' // 
        ];
        
        foreach ($ajaxPaths as $path) {
            if (strpos($uri, $path) !== false) {
                return true;
            }
        }
        
        return false;
    }
}