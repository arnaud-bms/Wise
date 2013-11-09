<?php

return array(
    'routing' => array(
        'home' => array(
            'pattern' => '/',
            'controller' => '{{app_name}}\Controller\Main::index',
            'precall' => array(
                
            ),
            'postcall' => array(
                'Plugin\HydrateView',
                'Plugin\View',
                'Plugin\Output',
            ),
        )
    )
);
