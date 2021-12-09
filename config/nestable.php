<?php

return [
    'parent'       => 'parent_id',
    'primary_key'  => 'id',
    'generate_url' => true,
    'childNode'    => 'children',
    'body'         => [
        'id',
        'title',
        'slug',
        'imageCover',
    ],
    'html'         => [
        'label' => 'title',
        'href'  => 'slug',
    ],
    'dropdown'     => [
        'prefix' => '',
        'label'  => 'title',
        'value'  => 'id',
    ],
];
