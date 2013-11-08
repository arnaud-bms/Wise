<?php

return array(
    'routing' => array(
        'home' => array(
            'pattern' => '/',
            'controller' => '/',
            'method' => '/',
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
