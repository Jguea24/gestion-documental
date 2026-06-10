<?php

use App\Models\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

it('blocks students from viewing the dashboard', function () {
    $student = User::factory()->create();
    $student->assignRole('Estudiante');

    $this->actingAs($student)
        ->get(route('dashboard'))
        ->assertForbidden();
});

it('keeps dashboard blocked for students even with direct permission', function () {
    $student = User::factory()->create();
    $student->assignRole('Estudiante');
    $student->givePermissionTo('dashboard.ver');

    $this->actingAs($student)
        ->get(route('dashboard'))
        ->assertForbidden();
});

it('redirects students to explorer after login', function () {
    $student = User::factory()->create([
        'email' => 'student.user.wini@gmail.com',
    ]);
    $student->assignRole('Estudiante');

    $this->post('/login', [
        'email' => $student->email,
        'password' => 'password',
    ])->assertRedirect(route('explorer.index', absolute: false));
});
