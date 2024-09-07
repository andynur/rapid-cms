<?php

use App\Models\User;

test('can retrieve a user by id', function () {
    $user = loginAsUser();
    $response = $this->getJson("/api/users/{$user->id}");

    $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => ['id', 'name', 'email', 'email_verified_at', 'created_at', 'updated_at']
        ]);
});

test('can register a new user', function () {
    $userData = [
        'name' => 'John Kuala',
        'email' => 'john.kuala@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = $this->postJson('/api/register', $userData);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => ['id', 'name', 'token']
        ]);

    $this->assertDatabaseHas('users', ['email' => $userData['email']]);
});

test('can login a user', function () {
    $user = User::factory()->create();
    $loginData = [
        'email' => $user->email,
        'password' => 'password',
    ];

    $response = $this->postJson('/api/login', $loginData);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => ['id', 'name', 'token']
        ]);
});

test('can logout a user', function () {
    loginAsUser();
    $response = $this->postJson('/api/logout');

    $response->assertStatus(200)
        ->assertJson([
            'status' => 200,
            'message' => 'Successfully logged out',
            'data' => null,
        ]);
});
