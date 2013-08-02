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
     * @return array $response
     */
    public function index()
    {
        $response['title'] = "Titre de la page";
        
        return $response;
    }
}
