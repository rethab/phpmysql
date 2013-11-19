<?php

/**
 * Composite Pattern
 */
interface Logger {
    public function log($message);
}

class LoggerComposite implements Logger {

    private $loggers = array();

    public function addLogger(Logger $logger) {
        $this->loggers[] = $logger;
    }

    public function log($message) {
        foreach ($this->loggers as $logger) {
            $logger->log($message);
        }
    }
}

class EchoLogger implements Logger {
    public function log($message) {
        echo "Logger: $message<br>";
    }   
}
