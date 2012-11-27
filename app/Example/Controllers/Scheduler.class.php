<?php
declare(ticks=1);
namespace Example\Controllers;

use Example\ExampleController;

/**
 * Description of Scheduler
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Scheduler extends ExampleController {

    protected $_maxProcesses = 10;
    protected $_jobsStarted = 0;
    protected $_currentJobs = array();
    protected $_signalQueue = array();

    /**
     * Run the Daemon
     */
    public function run()
    {
        pcntl_signal(SIGCHLD, array($this, "childSignalHandler"));
        while(true) {
            $fifo = new \Example\Controllers\Fifo;
            do {
                $stmt = $fifo->select('*', array('status' => 0), 100);
                $jobs = $stmt->fetchAll(\Telelab\DB\Driver\Statement::FETCH_ASSOC);
                echo count($jobs)." ".count($this->_currentJobs)."\n";
                if(empty($jobs)) {
                    usleep(5000000);
                }
            } while(empty($jobs));
            $fifo->closeConnection();

            foreach($jobs as $job) {
                while(count($this->_currentJobs) >= $this->_maxProcesses) {
                   sleep(1);
                }

                $this->launchJob($job);
            }
        }
    }


    /**
     * Launch a job from the job queue
     */
    protected function launchJob($job)
    {
        $pid = pcntl_fork();
        if($pid == -1) {
            return false;
        } elseif($pid) {
            $this->_currentJobs[$pid] = $job;
            if(isset($this->_signalQueue[$pid])) {
                $this->childSignalHandler(SIGCHLD, $pid, $this->_signalQueue[$pid]);
                unset($this->_signalQueue[$pid]);
            }
        } else {
            $fifo = new \Example\Controllers\Fifo;
            if(mt_rand(0, 3) == 3) {
                $fifo->updateRetry($job['id']);
            } else {
                $fifo->update(array('status' => 1), array('id' => $job['id']));
            }
            exit(0);
        }
        return true;
    }


    /**
     * This method is call when child exit
     *
     * @param type $signo
     * @param type $pid
     * @param type $status
     * @return boolean
     */
    public function childSignalHandler($signo, $pid=null, $status=null)
    {
        if(!$pid) {
            $pid = pcntl_waitpid(-1, $status, WNOHANG);
        }

        while($pid > 0) {
            if($pid && isset($this->_currentJobs[$pid])) {
                unset($this->_currentJobs[$pid]);
            }
            elseif($pid) {
                $this->_signalQueue[$pid] = $status;
            }
            $pid = pcntl_waitpid(-1, $status, WNOHANG);
        }
        return true;
    }
}