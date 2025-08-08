<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    $this->actingAs($user = User::factory()->affiliate()->create());

    $this->get('/dashboard')->assertRedirect('/affiliate/dashboard');
});

test('admin users can visit the admin dashboard', function () {
    $this->actingAs($user = User::factory()->admin()->create());

    $this->get('/dashboard')->assertRedirect('/admin/dashboard');
});
