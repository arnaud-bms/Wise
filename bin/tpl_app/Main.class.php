<?php
namespace {{app_name}}\Controllers;

use {{app_name}}\{{app_name}}Controller;

/**
 * Description of Main
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class Main extends {{app_name}}Controller 
{
    
    /**
     * Method index
     * 
     * @param string $var 
     * @param string $var 
     * @return array $response
     */
    public function index($var, $var2)
    {
        $response['title'] = "Titre de la page";
        
        return $response;
    }
}
