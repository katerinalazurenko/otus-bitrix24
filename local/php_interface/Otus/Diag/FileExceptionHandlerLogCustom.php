<?php

namespace Otus\Diag;

use Bitrix\Main\Diag\FileExceptionHandlerLog;

class FileExceptionHandlerLogCustom extends FileExceptionHandlerLog
{

    protected $level;

    public function write($exception, $logType) 
    
    {

        $formatter = new \Bitrix\Main\Diag\ExceptionHandlerFormatter();
        $text = $formatter::format($exception, false, $this->level);

		$context = [
			'type' => static::logTypeToString($logType),
		];

		$logLevel = static::logTypeToLevel($logType);

		$message = "Otus - {date} - Host: {host} - {type} - {$text}\n";

		$this->logger->log($logLevel, $message, $context);
    }
}
