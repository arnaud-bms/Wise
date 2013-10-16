<?php
namespace {{app_name}}\Controllers;

use {{app_name}}\{{app_name}}Controller;

/**
 * Description of Main
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Main extends {{app_name}}Controller 
{
    
    /**
     * Method index
     * 
     * @return array $response
     */
    public function index()
    {
        $response['content'] = "Ce contenu provient de ".__FILE__;
        
        return $response;
    }
}
