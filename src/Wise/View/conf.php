<?php

return array(
    'view' => array(
        'driver' => 'smarty',
        'default_template' => "main.tpl",
        'smarty' => array(
            'template_dir' => ROOT_DIR."tpl",
            'compile_dir' => ROOT_DIR."var/cache/tpl_c",
        )
    )
);