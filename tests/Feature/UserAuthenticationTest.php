<?php

use App\Models\User;
use Symfony\Component\HttpFoundation\Response as HttpStatus;

it('registers a new user and returns user with token', function () {
    $response = $this->postJson(route('api.v1.register'), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
    ]);

    $response->assertCreated();
    $response->assertJsonStructure([
        'user' => [
            'id',
            'name',
            'email',
            'updated_at',
            'created_at',
        ],
        'token',
    ]);

    expect(User::query()->where('email', 'john@example.com')->exists())->toBeTrue();
});


it('logs in an existing user with correct credentials', function () {
    $user = User::factory()->create([
        'email' => 'jane@example.com',
        'password' => Hash::make('secret123'),
    ]);

    $response = $this->postJson(route('api.v1.login'), [
        'email' => 'jane@example.com',
        'password' => 'secret123',
    ]);

    $response->assertOk();
    $response->assertJsonStructure([
        'user' => [
            'id',
            'name',
            'email',
        ],
        'token',
    ]);
});


it('fails to login with incorrect password', function () {

    User::factory()->create([
        'email' => 'jane@example.com',
        'password' => Hash::make('correct-password'),
    ]);

    $response = $this->postJson(route('api.v1.login'), [
        'email' => 'jane@example.com',
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(HttpStatus::HTTP_UNPROCESSABLE_ENTITY);
    $response->assertJsonValidationErrors(['email']);
});
