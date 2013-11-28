<?php
namespace Wise\Logger\tests\units;

use atoum;

/**
 * Class \Wise\Logger\tests\units\Logger
 * 
 * This class tests the Logger component
 *
 * @author Guillaume Dievart <dievartg@gmail.com>
 */
class Logger extends atoum
{
    
    public function beforeTestMethod($testMethod)
    {
        $controller = new \atoum\mock\controller();
        $controller->write = function($record) { echo $record['message']; };
        
        $this->mockGenerator->generate('\Monolog\Handler\AbstractProcessingHandler', '\Monolog\Handler', 'MockHandler');
    }
    
    private function getLoggerConfig()
    {
        return array(
            'name'        => 'test',
            'date_format' => 'Y-m-d H:i:s',
            'format'      => "[%datetime%] [%channel%] [%level_name%] %message% %context% %extra%\n",
            'handler'     => array(
                array(
                    'type'      => 'mock',
                    'log_level' => 'debug'
                )
            )
        );
    }
    
    public function testProcessor()
    {
        $this
            ->if($config = $this->getLoggerConfig())
            ->and($logger = new \Wise\Logger\Logger($config))
            ->and($logger->addProcessor(function($record) { echo "process "; return $record; }))
            ->then
                ->output(function() use ($logger) { $logger->debug('debug'); })->isEqualTo('process debug')
        ;
    }
    
    public function testLog()
    {
        $this
            ->if($config = $this->getLoggerConfig())
            ->and($logger = new \Wise\Logger\Logger($config))
            ->then
                ->output(function() use ($logger) { $logger->debug('debug'); })->isEqualTo('debug')
                ->output(function() use ($logger) { $logger->info('info'); })->isEqualTo('info')
                ->output(function() use ($logger) { $logger->notice('notice'); })->isEqualTo('notice')
                ->output(function() use ($logger) { $logger->warning('warning'); })->isEqualTo('warning')
                ->output(function() use ($logger) { $logger->critical('critical'); })->isEqualTo('critical')
                ->output(function() use ($logger) { $logger->alert('alert'); })->isEqualTo('alert')
                ->output(function() use ($logger) { $logger->emergency('emergency'); })->isEqualTo('emergency')
        ;
    }
}