<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {

    //
    // @TODO
    // - Create App/Http/Controllers/Dashboard/HomeController.php
    // - Move variables ['menuSettings', 'headerSettings', 'breadcrumb'] to HomeController
    //
    $menuSettings = [
        ['name' => 'Dashboard', 'route' => route('dashboard.home'), 'icon' => 'cil-speedometer', 'badge' => 'New'],
        [
            'group' => 'Reports',
            'child' => [
                ['name' => 'Monthly Reports', 'route' => '#monthly-reports', 'icon' => 'cil-grid'],
                ['name' => 'Daily Reports', 'route' => '#daily-reports', 'icon' => 'cil-notes'],
            ],
        ],
        [
            'group' => 'Administrator',
            'icon' => 'cil-shield-alt',
            'child' => [
                [
                    'group' => 'User Management',
                    'icon' => 'cil-user',
                    'child' => [
                        ['name' => 'Show users', 'route' => '#admin-show-users', 'badge' => 'New'],
                        ['name' => 'Create user', 'route' => '#admin-create-user'],
                    ],
                ],
                ['name' => 'Application Logs', 'route' => '#application-logs', 'icon' => 'cil-columns'],
                ['name' => 'Access Logs', 'route' => '#access-logs', 'icon' => 'cil-devices'],
            ],
        ],
    ];

    $headerSettings = [
        'quickMenu' => [
            'Dashboard' => route('dashboard.home'),
            'Users' => route('dashboard.home'),
            'Settings' => route('dashboard.home'),
        ],
        'notificationsMenu' => [
            'cil-bell' => '#notifications',
            'cil-list-rich' => '#event-logs',
        ],
        'userMenu' => [
            'avatar' => url('assets/img/avatars/r0.jpg'),
            'email' => 'me@example.com',
            'dropdown' => [
                [
                    'group' => 'Settings',
                    'items' => [
                        ['name' => 'Profile', 'route' => '#user-profile', 'icon' => 'cil-user'],
                        ['name' => 'Settings', 'route' => '#user-settings', 'icon' => 'cil-settings'],
                    ],
                ],
            ],
        ],
    ];

    $breadcrumb = [
        ['name' => 'home', 'route' => route('dashboard.home')],
        ['name' => 'dashboard', 'route' => route('dashboard.home'), 'active' => 'active'],
    ];

    return view(
        'domain.dashboard.home',
        compact(['menuSettings', 'headerSettings', 'breadcrumb'])
    );

})->middleware([
    'auth'
])->name('dashboard.home');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
