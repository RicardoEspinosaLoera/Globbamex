<?php

namespace App\Enums\ViewPaths\Admin;

enum Video
{
    const LIST = [
        URI => 'list',
        VIEW => 'admin-views.video.list'
    ];

    const ADD = [
        URI => 'add-new',
        VIEW => 'admin-views.video.add-new'
    ];

    const UPDATE = [
        URI => 'update',
        VIEW => 'admin-views.video.edit'
    ];

    const DELETE = [
        URI => 'delete',
        VIEW => ''
    ];
}
