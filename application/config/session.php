<?php

return array(
    'cookie' => array(
        'name' => 'takara_session',
        'encrypted' => TRUE,
        'lifetime' => 43200,
    ),
    'native' => array(
        'name' => 'takara_session',
        'encrypted' => TRUE,
        'lifetime' => 43200,
    ),
    'database' => array(
        'group' => 'default',
        'table' => 'sessions',
    ),
);