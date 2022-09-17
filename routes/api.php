<?php

return [

    // ***Items routes***
    [
        'method' => 'GET',
        'pattern' => 'items',
        'action' => '\App\Controllers\ItemsController@index',
    ],
    [
        'method' => 'POST',
        'pattern' => 'items',
        'action' => '\App\Controllers\ItemsController@store',
    ],
    [
        'method' => 'PUT',
        'pattern' => 'items',
        'action' => '\App\Controllers\ItemsController@update',
    ],
    [
        'method' => 'DELETE',
        'pattern' => 'items',
        'action' => '\App\Controllers\ItemsController@destroy',
    ],
];
