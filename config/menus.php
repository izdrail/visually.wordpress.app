<?php

/*
|--------------------------------------------------------------------------
| Plugin Menus routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the menu routes for a plugin.
| In this context, the route are the menu link.
|
*/

return [
  'visually_slug_menu' => [
    "page_title" => "Visually Importer",
    "menu_title" => "Visually",
    'capability' => 'read',
    'icon'       => 'dashicons-lightbulb',
    'items'      => [
      [
        "page_title" => "Main View",
        "menu_title" => "Main View",
        'capability' => 'read',
        'route'      => [
          'get' => 'Dashboard\DashboardController@index'
        ],
      ],
    ]
  ]
];
