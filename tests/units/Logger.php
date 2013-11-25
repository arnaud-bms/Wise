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
    
    private function getLogger()
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
        $logger = $this->getLogger();
        
        $logger->addProcessor(function($record) { echo "process "; return $record; });
        
        $this->assert->output($logger->debug('debug'))
                     ->isEqualTo('process debug');
    }
    
    public function testLog()
    {
        $logger = $this->getLogger();
        
        $this->assert->output($logger->debug('debug'))
                     ->isEqualTo('debug');
        
        $this->assert->output($logger->info('info'))
                     ->isEqualTo('info');
        
        $this->assert->output($logger->notice('notice'))
                     ->isEqualTo('notice');
        
        $this->assert->output($logger->warning('warning'))
                     ->isEqualTo('warning');
        
        $this->assert->output($logger->critical('critical'))
                     ->isEqualTo('critical');
        
        $this->assert->output($logger->alert('alert'))
                     ->isEqualTo('alert');
        
        $this->assert->output($logger->emergency('emergency'))
                     ->isEqualTo('emergency');
    }
}