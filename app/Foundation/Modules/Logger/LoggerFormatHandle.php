<?php


namespace App\Foundation\Modules\Logger;


use Monolog\Formatter\LogstashFormatter;

class LoggerFormatHandle
{
    public function __invoke($logger){
        $formatter = new LogstashFormatter(config('app.name'));
        foreach ($logger->getHandlers() as $handler){
            $handler->setFormatter($formatter);
        }
    }
}