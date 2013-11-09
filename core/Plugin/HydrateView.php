<?php
namespace Plugin;

use Wise\Plugin\Plugin;
use Wise\Conf\Conf;

/**
 * Plugin HydrateView Add informations to view
 *
 * @author gdievart <dievartg@gmail.com>
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
        list($routeApp, $route) = explode(':', \Wise\Dispatcher\Dispatcher::getRouteName());
        $configToMerge = $this->getConfigView($route);
        
        $response = array_merge($configToMerge, \Wise\Dispatcher\Dispatcher::getResponse());
        

        \Wise\Dispatcher\Dispatcher::setResponse($response);
    }


    /**
     * Retrieve configuration from view.ini
     *
     * @return array
     */
    private function getConfigView($route)
    {
        $configToMerge = array();
        if ($configRoute = Conf::get('hydrate_view.'.$route)) {
            foreach ($configRoute as $directive => $config) {
                if (preg_match('/^[A-Z_]+$/', $config)) {
                    try {
                        $tmpConfig = \Wise\Translation\Translator::translate($config);
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
