<?php

return [

    'models' => [
        'user' => App\Models\User::class,
    ],

    'table_names' => [
        'roles' => 'roles',
        'permissions' => 'permissions',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles' => 'model_has_roles',
        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [
        'model_morph_key' => 'model_id',
    ],

    'cache' => [
        'expiration_time' => 3600,
        'key' => 'spatie.permission.cache',
        'store' => 'default',
    ],
];
