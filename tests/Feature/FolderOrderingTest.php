<?php

use App\Models\Folder;

it('orders semester folders naturally', function () {
    Folder::factory()->create(['name' => 'DECIMO SEMESTRE']);
    Folder::factory()->create(['name' => 'SEGUNDO SEMESTRE']);
    Folder::factory()->create(['name' => 'TERCER SEMESTRE']);
    Folder::factory()->create(['name' => 'PRIMER SEMESTRE']);

    expect(Folder::ordered()->pluck('name')->all())->toBe([
        'PRIMER SEMESTRE',
        'SEGUNDO SEMESTRE',
        'TERCER SEMESTRE',
        'DECIMO SEMESTRE',
    ]);
});
