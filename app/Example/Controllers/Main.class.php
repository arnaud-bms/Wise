<?php
namespace Test\Controllers;

use Test\TestController;
use Telco\DB\DB;
use Telco\Conf\Conf;
use Telco\Router\Router;
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
        $db = DB::getInstance();
        $stmt = $db->query("SELECT * FROM test");
        $return = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $return['page'] = 'TOTO';
        
        return $return;
    }
    
    
    /**
     * Method redirect
     * 
     * @param string $var 
     */
    public function generateIndex($var, $var2)
    {
        $this->index($var, $var2);
    }
    
    
    /**
     * Method redirect
     * 
     * @param string $var 
     */
    public function redirect()
    {
        $this->_redirect('/Test titi chuc');
    }
}
