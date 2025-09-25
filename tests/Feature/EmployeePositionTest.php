<?php

use App\Models\EmployeePosition;
use Symfony\Component\HttpFoundation\Response as HttpStatus;

BeforeEach(function () {
    $this->loginAsUser();
});

it('returns a paginated list of employee positions', function () {

    EmployeePosition::factory()->count(15)->create();

    $response = $this->getJson(route('api.v1.employee-positions.index'));
    $response->assertOk();
    $response->assertJsonStructure([
        'data',
        'meta',
    ]);
});

it('creates a new employee position', function () {
    $payload = [
        'name' => 'Team Lead',
    ];
    $response = $this->postJson(route('api.v1.employee-positions.store'), $payload);

    $response->assertStatus(HttpStatus::HTTP_CREATED);
    expect(EmployeePosition::query()->where('name', 'Team Lead')->exists())->toBeTrue();
});

it('fails to create a position with invalid data', function () {
    $response = $this->postJson(route('api.v1.employee-positions.store'), [
        'name' => '',
    ]);

    $response->assertStatus(HttpStatus::HTTP_UNPROCESSABLE_ENTITY);
    $response->assertJsonValidationErrors(['name']);
});


it('updates an existing employee position', function () {
    $position = EmployeePosition::factory()->create([
        'name' => 'Junior Developer',
    ]);

    $response = $this->putJson(route('api.v1.employee-positions.update', $position->id), [
        'name' => 'Senior Developer',
    ]);

    $response->assertOk();
    expect($position->fresh()->name)->toBe('Senior Developer');
});

it('fails to update a position with invalid data', function () {
    $position = EmployeePosition::factory()->create();

    $response = $this->putJson(route('api.v1.employee-positions.update', $position->id), [
        'name' => '',
    ]);

    $response->assertStatus(HttpStatus::HTTP_UNPROCESSABLE_ENTITY);
    $response->assertJsonValidationErrors(['name']);
});


it('deletes an existing employee position', function () {
    $position = EmployeePosition::factory()->create();

    $response = $this->deleteJson(route('api.v1.employee-positions.update', $position->id));

    $response->assertOk();
    expect(EmployeePosition::query()->find($position->id))->toBeNull();
});
