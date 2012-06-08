<?php
namespace Test\Controllers;

use Test\TestController;
use Telco\DB\DB;
use Telco\Conf\Conf;
use PDO;

/**
 * Description of Main
 *
 * @author gdievart
 */
class Main extends TestController 
{
    
    /**
     * Method test
     * 
     * @param string $var 
     */
    public function index($var, $var2)
    {
        $db = DB::getInstance(Conf::getConfig('database'));
        $stmt = $db->query("SELECT * FROM test");
        $return = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $return['page'] = 'TOTO';
        
        return $return;
    }
}
