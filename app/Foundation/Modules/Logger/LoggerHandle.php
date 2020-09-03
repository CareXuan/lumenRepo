<?php


namespace App\Foundation\Modules\Logger;


use Doctrine\DBAL\Exception\ServerException;
use Illuminate\Support\Facades\Log;

class LoggerHandle
{
    protected $logType = 'general';
    protected $methods = ['notice', 'emergency', 'alert', 'critical', 'error', 'warning', 'info', 'debug'];

    const LOG_TYPE = 'log_type';

    public function setLogType($name)
    {
        $this->logType = $name;

        return $this;
    }

    public function getLogType()
    {
        return $this->logType;
    }

    public function __call($method, $args)
    {
        if (!in_array($method, $this->methods)) {
            throw new ServerException(sprintf("Method %s not exists", $method));
        }
        $context = [self::LOG_TYPE => $this->getLogType()];
        Log::channel('stack')->$method($args[0], isset($args[1]) ? array_merge($context, $args[1]) : $context);
    }
}