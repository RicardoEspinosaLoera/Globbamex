<?php
namespace App\Enums\ViewPaths\Admin;

enum BlogRoutes
{
    const INDEXBLOG = [
        'URI' => 'blogs',
        'VIEW' => 'admin-views.blogs.index',
    ];

    const CREATEBLOG = [
        'URI' => 'blogs/create',
        'VIEW' => 'admin-views.blogs.create',
    ];

    const STOREBLOG = [
        'URI' => 'storeblogs',
        'VIEW' => '',
    ];

    const SHOWBLOG = [
        'URI' => 'blogs/{id}',
        'VIEW' => 'admin-views.blogs.show',
    ];

    const EDITBLOG = [
        'URI' => 'blogs/{id}/edit',
        'VIEW' => 'admin-views.blogs.edit',
    ];

    const UPDATEBLOG = [
        'URI' => 'blogs/update',
        'VIEW' => '',
    ];

    const DELETEBLOG = [
        'URI' => 'blogs/destroy',
        'VIEW' => '',
    ];
    const PORTALBLOG = [
        'URI' => 'portalblog',
        'VIEW' => 'admin-views.blogs.portal',
    ];
}
