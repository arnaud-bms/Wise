<?php
namespace Example\Models;

use Telelab\Repository\Repository;

/**
 * Description of Fifo
 *
 * @author gdievart <dievartg@gmail.com>
 */
class FifoRepository extends Repository
{
    /**
     * @var string
     */
    protected $_table = 'fifo';

    public function updateRetry($jobId)
    {
        $sql = "UPDATE fifo SET retry = retry+1 where id = ".$jobId;

        return $this->_db->exec($sql);
    }
}
