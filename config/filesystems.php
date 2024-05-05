<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'escuelaLogos' => [
            'driver' => 'local',
            'root' => storage_path('app/escuelaLogos'),
            'url' => env('APP_URL') . '/escuelaLogos',
            'visibility' => 'escuelaLogos',
        ],

        'documentos' => [
            'driver' => 'local',
            'root' => storage_path('app/documentos'),
            'url' => env('APP_URL') . '/documentos',
            'visibility' => 'documentos',
        ],

        'certificados' => [
            'driver' => 'local',
            'root' => storage_path('app/certificados'),
            'url' => env('APP_URL') . '/certificados',
            'visibility' => 'certificados',
        ],

        'facultadLogos' => [
            'driver' => 'local',
            'root' => storage_path('app/facultadLogos'),
            'url' => env('APP_URL') . '/facultadLogos',
            'visibility' => 'facultadLogos',
        ],

        'empresasLogos' => [
            'driver' => 'local',
            'root' => storage_path('app/empresasLogos'),
            'url' => env('APP_URL') . '/empresasLogos',
            'visibility' => 'empresasLogos',
        ],
        'imagenOfertas' => [
            'driver' => 'local',
            'root' => storage_path('app/imagenOfertas'),
            'url' => env('APP_URL') . '/imagenOfertas',
            'visibility' => 'imagenOfertas',
        ],
        'conveniosArchivos' => [
            'driver' => 'local',
            'root' => storage_path('app/conveniosArchivos'),
            'url' => env('APP_URL') . '/conveniosArchivos',
            'visibility' => 'conveniosArchivos',
        ],
        'ofertaLaboralArchivos' => [
            'driver' => 'local',
            'root' => storage_path('app/ofertaLaboralArchivos'),
            'url' => env('APP_URL') . '/ofertaLaboralArchivos',
            'visibility' => 'ofertaLaboralArchivos',
        ],

        'voucher' => [
            'driver' => 'local',
            'root' => storage_path('app/voucher'),
            'url' => env('APP_URL') . '/voucher',
            'visibility' => 'voucher',
        ],

        'recomendacionEvidencia' => [
            'driver' => 'local',
            'root' => storage_path('app/recomendacionEvidencia'),
            'url' => env('APP_URL') . '/recomendacionEvidencia',
            'visibility' => 'recomendacionEvidencia',
        ],

        'oferta_certificados' => [
            'driver' => 'local',
            'root' => storage_path('app/oferta_certificados'),
            'url' => env('APP_URL') . '/oferta_certificados',
            'visibility' => 'oferta_certificados',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
        public_path('escuelaLogos') => storage_path('app/escuelaLogos'),
        public_path('documentos') => storage_path('app/documentos'),
        public_path('certificados') => storage_path('app/certificados'),
        public_path('facultadLogos') => storage_path('app/facultadLogos'),
        public_path('empresasLogos') => storage_path('app/empresasLogos'),
        public_path('conveniosArchivos') => storage_path('app/conveniosArchivos'),
        public_path('ofertaLaboralArchivos') => storage_path('app/ofertaLaboralArchivos'),
        public_path('imagenOfertas') => storage_path('app/imagenOfertas'),
        public_path('voucher') => storage_path('app/voucher'),
        public_path('recomendacionEvidencia') => storage_path('app/recomendacionEvidencia'),
        public_path('oferta_certificados') => storage_path('app/oferta_certificados')
    ],

];
