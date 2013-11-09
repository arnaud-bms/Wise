<?php

return array(
    'logger' => array(
        'enable' => true,
        'driver' => 'file',
        'output' => false,
        'log_level' => 'DEBUG',
        'file' => array(
            'file' => ROOT_DIR."var/log/core.log"
        )
    )
);