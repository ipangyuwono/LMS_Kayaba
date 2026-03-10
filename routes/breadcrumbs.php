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

// Service
Breadcrumbs::for('services.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Service', route('services.index'));
});

Breadcrumbs::for('services.create', function (BreadcrumbTrail $trail) {
    $trail->parent('services.index');
    $trail->push('Tambah Service');
});

Breadcrumbs::for('services.edit', function (BreadcrumbTrail $trail, $service) {
    $trail->parent('services.index');
    $trail->push('Edit Service');
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
    $trail->push('Materi', route('materials.index'));
});

// Quiz
Breadcrumbs::for('quiz.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Quiz', route('quiz.index'));
});

Breadcrumbs::for('quiz.create', function (BreadcrumbTrail $trail) {
    $trail->parent('quiz.index');
    $trail->push('Tambah Quiz');
});

Breadcrumbs::for('quiz.edit', function (BreadcrumbTrail $trail, $quiz) {
    $trail->parent('quiz.index');
    $trail->push('Edit Quiz');
});

Breadcrumbs::for('quiz.show', function (BreadcrumbTrail $trail, $quiz) {
    $trail->parent('quiz.index');
    $trail->push('Detail Quiz');
});

Breadcrumbs::for('quiz.take', function (BreadcrumbTrail $trail, $quiz, $customer) {
    $trail->parent('quiz.index');
    $trail->push('Kerjakan Quiz');
});

Breadcrumbs::for('quiz.result', function (BreadcrumbTrail $trail, $quiz, $customer) {
    $trail->parent('quiz.index');
    $trail->push('Hasil Quiz');
});

Breadcrumbs::for('progress.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Progress', route('progress.index'));
});

Breadcrumbs::for('progress.show', function (BreadcrumbTrail $trail, $customer) {
    $trail->parent('progress.index');
    $trail->push('Detail Progress');
});
