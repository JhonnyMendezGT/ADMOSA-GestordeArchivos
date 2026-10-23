<?php

return [



    'default' => env('FILESYSTEM_DISK', 'local'),


// Definimos la carpeta que usaremos para almacenar los archivos
    'disks' => [
        'archivos' => [
            'driver'     => 'local',
            'root'       => storage_path('app/archivos_usuarios'),
            'visibility' => 'private',
            'throw'      => false,
        ],
    ],

  

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
