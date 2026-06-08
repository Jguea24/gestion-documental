<?php

use App\Models\Document;
use App\Models\Folder;
use App\Models\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

it('blocks non owners from renaming documents', function () {
    $owner = User::factory()->create();
    $actor = User::factory()->create();
    $owner->assignRole('Docente');
    $actor->assignRole('Docente');

    $document = Document::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($actor)
        ->patch(route('documents.update', $document), ['original_name' => 'nuevo nombre'])
        ->assertForbidden();

    expect($document->fresh()->original_name)->not->toBe('nuevo nombre');
});

it('allows owners to rename their documents', function () {
    $owner = User::factory()->create();
    $owner->assignRole('Docente');

    $document = Document::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($owner)
        ->patch(route('documents.update', $document), ['original_name' => 'nuevo nombre'])
        ->assertRedirect();

    expect($document->fresh()->original_name)->toBe('nuevo nombre');
});

it('blocks non owners from deleting folders', function () {
    $owner = User::factory()->create();
    $actor = User::factory()->create();
    $owner->assignRole('Docente');
    $actor->assignRole('Docente');

    $folder = Folder::factory()->create(['created_by' => $owner->id]);

    $this->actingAs($actor)
        ->delete(route('folders.destroy', $folder))
        ->assertForbidden();

    expect($folder->fresh()->trashed())->toBeFalse();
});

it('allows owners to delete their folders', function () {
    $owner = User::factory()->create();
    $owner->assignRole('Docente');

    $folder = Folder::factory()->create(['created_by' => $owner->id]);

    $this->actingAs($owner)
        ->delete(route('folders.destroy', $folder))
        ->assertRedirect();

    expect($folder->fresh()->trashed())->toBeTrue();
});
