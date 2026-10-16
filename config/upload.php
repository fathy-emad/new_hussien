<?php

return [

    /*
    |--------------------------------------------------------------------------
    | STORE-PATH header → disk mapping
    |--------------------------------------------------------------------------
    |
    | Used by Dropzone (header STORE-PATH). Files go to public/uploads/.
    |
    */

    'paths' => [
        'lessons/images' => [
            'type' => 'public',
            'disk' => 'uploads',
            'folder' => 'lessons/images',
        ],
        'lessons/files' => [
            'type' => 'public',
            'disk' => 'uploads',
            'folder' => 'lessons/files',
        ],
        'website/images' => [
            'type' => 'public',
            'disk' => 'uploads',
            'folder' => 'website/images',
        ],
        'capacitors/lessons/images' => [
            'type' => 'public',
            'disk' => 'uploads',
            'folder' => 'capacitors/lessons/images',
        ],
        'capacitors/lessons/files' => [
            'type' => 'public',
            'disk' => 'uploads',
            'folder' => 'capacitors/lessons/files',
        ],
        'students/images' => [
            'type' => 'public',
            'disk' => 'uploads',
            'folder' => 'students/images',
        ],
        'admins/images' => [
            'type' => 'public',
            'disk' => 'uploads',
            'folder' => 'admins/images',
        ],
        'exams/questions/images' => [
            'type' => 'public',
            'disk' => 'uploads',
            'folder' => 'exams/questions/images',
        ],
    ],

];
