<?php

return array(
    'name'        => 'DEFAULT',
    'date_format' => 'Y-m-d H:i:s',
    'format'      => "[%datetime%] [%channel%] [%level_name%] %message% %context% %extra%\n",
    'handler'     => array(
        array(
            'type'      => 'stream',
            'options'   => '/tmp/alerting',
            'log_level' => 'error'
        ),
        array(
            'type'      => 'stream',
            'options'   => '/tmp/debug',
            'log_level' => 'debug'
        )
    )
);