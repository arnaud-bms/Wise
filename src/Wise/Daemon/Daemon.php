<?php
namespace Wise\Daemon;

use Wise\Component\Component;
use Wise\Daemon\Exception;

declare(ticks = 1);

abstract class Daemon extends Component
{
    /**
     * Path of the PID file
     * 
     * @var string
     */
    protected $pidfile;
    
    /**
     * This flag is set when the daemon receive a sigterm
     *
     * @var boolean 
     */
    protected $stopped = false;
    
    /**
     * This flag is set when the daemon receive a sigcont
     *
     * @var boolean 
     */
    protected $pause = false;
    
    /**
     * {@inherit}
     */
    final public function init($config)
    {
        $this->initDaemon($config);
        $this->sigHandle();
    }
    
    /**
     * This method is called on constructor
     */
    abstract protected function initDaemon($config);
    
    /**
     * This method is called on each cycle
     */
    abstract public function process();
    
    /**
     * Run the daemon
     */
    public function run()
    {
        $this->createPIDFile();
        while(true) {
            $this->process();
            
            while($this->pause && !$this->stopped) {
                usleep(200000);
            }
            
            if($this->stopped) {
                break;
            }
        }
    }
    
    /**
     * Create a pid file
     * 
     * @throws Exception If the create file failed
     */
    private function createPIDFile()
    {
        if ($this->pidfile === null) {
            $filename = strtolower(get_called_class());
            $this->pidfile = '/var/run/'.$filename.'.pid';
        }
        
        if (!@file_put_contents($this->pidfile, $this->getPID())) {
            throw new Exception('Cannot write to the file '.$this->pidfile, 0);
        }
    }
    
    /**
     * Set sig handles
     */
    private function sigHandle()
    {
        pcntl_signal(SIGCHLD, array($this, "sigChld"));
        pcntl_signal(SIGTERM, array($this, "sigTerm"));
        pcntl_signal(SIGCONT, array($this, "sigCont"));
    }
    
    /**
     * Method call on sigChld
     * 
     * @param int Sig receive from the child
     * @param int $pid Pid of the child process
     * @param int $status status of the child
     */
    protected function sigChld($signo, $pid = null, $status = null)
    {
        return;
    }
    
    /**
     * Method call on sigTerm
     */
    protected function sigTerm()
    {
        $this->stopped = true;
        
        return;
    }
    
    /**
     * Method call on sigCont
     */
    protected function sigCont()
    {
        $this->pause = !$this->pause;
        
        return;
    }
    
    /**
     * Return the current pid
     * 
     * @return int
     */
    protected function getPID()
    {
        return getmypid();
    }
    
    /**
     * Delete the pid file
     */
    private function deletePIDFile()
    {
        if (file_exists($this->pidfile)) {
            unlink($this->pidfile);
        }
    }
    
    /**
     * Close the daemon
     */
    final public function __destruct() 
    {
        $this->deletePIDFile();
    }
}
