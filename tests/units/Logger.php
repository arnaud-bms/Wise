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
    
    public function getLogger()
    {
        $controller = new \atoum\mock\controller();
        $controller->write = function($record) { echo $record['message']; };
        
        $this->mockGenerator->generate('\Monolog\Handler\AbstractProcessingHandler', '\Monolog\Handler', 'MockHandler');
        
        $config = array(
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
        
        return new \Wise\Logger\Logger($config);
    }
    
    public function testProcessor()
    {
        $this
            ->if($logger = $this->getLogger())
            ->and($logger->addProcessor(function($record) { echo "process "; return $record; }))
            ->then
                ->output(function() use ($logger) { $logger->debug('debug'); })->isEqualTo('process debug')
        ;
    }
    
    public function testLog()
    {
        $this
            ->if($logger = $this->getLogger())
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