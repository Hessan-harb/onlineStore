<?php


return[
    [
        'icon'=>'box',
        'route'=>'/dashboard',
        'title'=>'Dashboard'
    ],
    [
        'icon'=>'circle',
        'route'=>'/dashboard/categories',
        'title'=>'Categories',
        'ability'=>'categories.view' 
    ],

    [
        'icon'=>'circle',
        'route'=>'/dashboard/products',
        'title'=>'Products',
        'ability'=>'products.view'
        
    ],

    [
        'icon'=>'circle',
        'route'=>'/dashboard/orders',
        'title'=>'Orders',
        //'ability'=>'orders.view',
    ],

    [
        'icon'=>'circle',
        'route'=>'/dashboard/roles',
        'title'=>'Roles'
    ],

    [
        'icon'=>'circle',
        'route'=>'/dashboard/products/import',
        'title'=>'Jobs'
    ],
    [
        'icon'=>'user',
        'route'=>'/dashboard/users',
        'title'=>'Users'
    ],
    
];