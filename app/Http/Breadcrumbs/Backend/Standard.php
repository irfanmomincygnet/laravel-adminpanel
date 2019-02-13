<?php

Breadcrumbs::register('admin.standards.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.standards.management'), route('admin.standards.index'));
});

Breadcrumbs::register('admin.standards.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.standards.index');
    $breadcrumbs->push(trans('menus.backend.standards.create'), route('admin.standards.create'));
});

Breadcrumbs::register('admin.standards.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.standards.index');
    $breadcrumbs->push(trans('menus.backend.standards.edit'), route('admin.standards.edit', $id));
});
