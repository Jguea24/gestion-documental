<?php

use App\Models\Document;
use App\Models\Folder;
use App\Models\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

it('allows students to see only assigned folders in explorer', function () {
    $student = User::factory()->create();
    $student->assignRole('Estudiante');

    $allowedFolder = Folder::factory()->create(['name' => 'PERMITIDA']);
    $blockedFolder = Folder::factory()->create(['name' => 'BLOQUEADA']);

    Document::factory()->create([
        'folder_id' => $allowedFolder->id,
        'original_name' => 'documento permitido',
    ]);

    Document::factory()->create([
        'folder_id' => $blockedFolder->id,
        'original_name' => 'documento bloqueado',
    ]);

    $student->permittedFolders()->sync([$allowedFolder->id]);

    $this->actingAs($student)
        ->get(route('explorer.index', ['folder' => $allowedFolder->id]))
        ->assertOk()
        ->assertSee('PERMITIDA')
        ->assertSee('documento permitido')
        ->assertDontSee('BLOQUEADA')
        ->assertDontSee('documento bloqueado');
});

it('blocks students from opening unassigned folders directly', function () {
    $student = User::factory()->create();
    $student->assignRole('Estudiante');

    $allowedFolder = Folder::factory()->create();
    $blockedFolder = Folder::factory()->create();

    $student->permittedFolders()->sync([$allowedFolder->id]);

    $this->actingAs($student)
        ->get(route('explorer.index', ['folder' => $blockedFolder->id]))
        ->assertForbidden();
});

it('blocks students from previewing documents in unassigned folders directly', function () {
    $student = User::factory()->create();
    $student->assignRole('Estudiante');

    $allowedFolder = Folder::factory()->create();
    $blockedDocument = Document::factory()->create();

    $student->permittedFolders()->sync([$allowedFolder->id]);

    $this->actingAs($student)
        ->get(route('documents.preview', $blockedDocument))
        ->assertForbidden();
});

it('allows students to preview documents in assigned folders', function () {
    $student = User::factory()->create();
    $student->assignRole('Estudiante');

    $allowedFolder = Folder::factory()->create();
    $document = Document::factory()->create(['folder_id' => $allowedFolder->id]);

    $student->permittedFolders()->sync([$allowedFolder->id]);

    $this->actingAs($student)
        ->get(route('documents.preview', $document))
        ->assertOk();
});
