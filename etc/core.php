<?php

return array(
    'core' => array(
        'exception_handler' => array(
            'class' => 'Wise\ExceptionHandler\ExceptionHandler',
            'method' => 'catchException',
        ),
        'error_handler' => array(
            'class' => 'Wise\ErrorHandler\ErrorHandler',
            'method' => 'catchError',
        )
    )
);
