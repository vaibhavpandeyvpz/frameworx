<?php

namespace App\Services;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger as Monolog;
use Slim\Log;

class Logger
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var array
     */
    private $options;

    protected static $levels = [
        Log::ALERT => Monolog::ALERT,
        Log::CRITICAL => Monolog::CRITICAL,
        Log::DEBUG => Monolog::DEBUG,
        Log::EMERGENCY => Monolog::EMERGENCY,
        Log::ERROR => Monolog::ERROR,
        Log::INFO => Monolog::INFO,
        Log::NOTICE => Monolog::NOTICE,
        Log::WARN => Monolog::WARNING,
    ];

    /**
     * Logger constructor.
     * @param string $file
     * @param array $options
     */
    public function __construct($file, array $options = array())
    {
        $this->options = array_merge(array(
            'handlers' => array(new RotatingFileHandler($file, 7)),
            'name' => 'Frameworx',
            'processors' => array()
        ), $options);
    }

    public function write($object, $level)
    {
        if (!$this->logger instanceof Monolog) {
            $this->logger = new Monolog($this->options['name']);
            foreach ($this->options['handlers'] as $handler) {
                $this->logger->pushHandler($handler);
            }
            foreach ($this->options['processors'] as $processor) {
                $this->logger->pushProcessor($processor);
            }
        }
        $level = isset(static::$levels[$level]) ? static::$levels[$level] : Monolog::DEBUG;
        $this->logger->addRecord($level, $object);
    }
}
