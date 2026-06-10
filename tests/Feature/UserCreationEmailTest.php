<?php

use App\Models\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

it('generates an institutional email from the user name when creating users', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Administrador');

    $this->actingAs($admin)
        ->post(route('users.store'), [
            'name' => 'Maria Fernanda',
            'password' => 'password',
            'password_confirmation' => 'password',
            'roles' => ['Estudiante'],
        ])
        ->assertRedirect(route('users.index'));

    $this->assertDatabaseHas('users', [
        'name' => 'Maria Fernanda',
        'email' => 'maria.fernanda.wini@gmail.com',
    ]);
});

it('rejects manually entered emails outside the wini extension', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Administrador');

    $this->actingAs($admin)
        ->post(route('users.store'), [
            'name' => 'Maria Fernanda',
            'email' => 'maria@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'roles' => ['Estudiante'],
        ])
        ->assertSessionHasErrors('email');
});
