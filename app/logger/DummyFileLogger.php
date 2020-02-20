<?php
/**
 * Created by PhpStorm.
 * User: t.matskovich
 * Date: 19.02.2020
 * Time: 17:42
 */

namespace houseapp\app\logger;


use Psr\Log\LoggerInterface;

/**
 * Class DummyFileLogger
 * @package houseapp\app\logger
 */
class DummyFileLogger implements LoggerInterface
{

    /**
     * @var string
     */
    private $filename;

    /**
     * DummyFileLogger constructor.
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function emergency($message, array $context = array())
    {
        file_put_contents($this->filename, 'EMERGENCY: '. json_encode($context) . ' - ' . $message . "\r\n", FILE_APPEND);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function alert($message, array $context = array())
    {
        file_put_contents($this->filename, 'ALERT: '. json_encode($context) . ' - ' . $message . "\r\n", FILE_APPEND);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function critical($message, array $context = array())
    {
        file_put_contents($this->filename, 'CRITICAL: '. json_encode($context) . ' - ' . $message . "\r\n", FILE_APPEND);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function error($message, array $context = array())
    {
        file_put_contents($this->filename, 'ERROR: '. json_encode($context) . ' - ' . $message . "\r\n", FILE_APPEND);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function warning($message, array $context = array())
    {
        file_put_contents($this->filename, 'WARNING: '. json_encode($context) . ' - ' . $message . "\r\n", FILE_APPEND);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function notice($message, array $context = array())
    {
        file_put_contents($this->filename, 'NOTICE: '. json_encode($context) . ' - ' . $message . "\r\n", FILE_APPEND);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function info($message, array $context = array())
    {
        file_put_contents($this->filename, 'INFO: '. json_encode($context) . ' - ' . $message . "\r\n", FILE_APPEND);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function debug($message, array $context = array())
    {
        file_put_contents($this->filename, 'DEBUG: '. json_encode($context) . ' - ' . $message . "\r\n", FILE_APPEND);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return void
     *
     * @throws \Psr\Log\InvalidArgumentException
     */
    public function log($level, $message, array $context = array())
    {
        file_put_contents($this->filename, 'LOG: '. json_encode($context) . ' - ' . $message . "\r\n", FILE_APPEND);
    }
}
