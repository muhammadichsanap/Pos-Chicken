<?php

return [
    'class_namespace' => 'App\\Livewire',

    'view_path' => resource_path('views/livewire'),

    'layout' => 'components.layouts.app',

    'class_namespaces' => [
        'default' => 'App\\Livewire',
    ],

    'components' => [
        'sidebar-cart' => \App\Livewire\SidebarCart::class,
    ],
];
