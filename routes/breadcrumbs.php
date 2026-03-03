<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

Breadcrumbs::for('customers', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Customers', route('customers'));
});

// Layanan
Breadcrumbs::for('services.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Layanan', route('services.index'));
});

Breadcrumbs::for('services.create', function (BreadcrumbTrail $trail) {
    $trail->parent('services.index');
    $trail->push('Tambah Layanan');
});

Breadcrumbs::for('services.edit', function (BreadcrumbTrail $trail, $service) {
    $trail->parent('services.index');
    $trail->push('Edit Layanan');
});

// Orders
Breadcrumbs::for('orders.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Orders', route('orders.index'));
});

Breadcrumbs::for('orders.create', function (BreadcrumbTrail $trail) {
    $trail->parent('orders.index');
    $trail->push('Buat Order');
});

Breadcrumbs::for('orders.store', function (BreadcrumbTrail $trail) {
    $trail->parent('orders.index');
    $trail->push('Simpan Order');
});

Breadcrumbs::for('orders.success', function (BreadcrumbTrail $trail) {
    $trail->parent('orders.index');
    $trail->push('Pembayaran');
});

// Pembelajaran
Breadcrumbs::for('materials.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Materi Pelatihan', route('materials.index'));
});

Breadcrumbs::for('progress.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Progress Belajar', route('progress.index'));
});

Breadcrumbs::for('progress.show', function (BreadcrumbTrail $trail, $customer) {
    $trail->parent('progress.index');
    $trail->push('Detail Progress');
});
