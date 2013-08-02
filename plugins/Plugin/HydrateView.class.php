<?php
namespace Plugin;

use Telelab\Plugin\Plugin;
use Telelab\FrontController\FrontController;
use Telelab\Conf\Conf;

/**
 * Plugin HydrateView Add informations to view
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class HydrateView extends Plugin
{
    /**
     * Method call on precall
     */
    public function precall()
    {

    }


    /**
     * Method call on precall
     */
    public function postcall()
    {
        list($routeApp, $route) = explode(':', FrontController::getRouteName());

        $configToMerge = $this->_getConfigView($route);
        
        $response = array_merge($configToMerge, FrontController::getResponse());
        

        FrontController::setResponse($response);
    }


    /**
     * Retrieve configuration from view.ini
     *
     * @return array
     */
    private function _getConfigView($route)
    {
        $configToMerge = array();
        if ($configRoute = Conf::getConfig('hydrate_view.'.$route)) {
            foreach ($configRoute as $directive => $config) {
                if (preg_match('/^[A-Z_]+$/', $config)) {
                    try {
                        $tmpConfig = \Telelab\Translation\Translator::translate($config);
                    } catch(\Exception $e) {
                        $tmpConfig = $config;
                    }
                    $config = $tmpConfig;
                }

                $listDepth = explode('.', $directive);
                if (count($listDepth) === 1) {
                    $configToMerge[$directive] = $config;
                } else {
                    $configToMerge[$listDepth[0]][$listDepth[1]] = $config;
                }
            }
        }

        return $configToMerge;
    }
}
