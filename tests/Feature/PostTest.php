<?php

use App\Models\Post;
use App\Models\User;

test('can retrieve the post list with pagination', function () {
    loginAsUser();

    User::factory()->count(3)->create();
    Post::factory()->count(3)->create();

    $response = $this->getJson('/api/posts');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => ['id', 'title', 'slug', 'main_image', 'categories', 'published_at']
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'per_page',
                'to',
                'total'
            ]
        ]);
});

test('can retrieve a post by id', function () {
    $user = loginAsUser();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $response = $this->getJson("/api/posts/{$post->id}");

    $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'id',
                'title',
                'slug',
                'main_image',
                'categories',
                'published_at',
                'body',
                'user_id',
                'user_name',
                'comments',
                'created_at',
                'updated_at'
            ]
        ]);
});

test('can create a new post', function () {
    $user = loginAsUser();

    $postData = [
        'title' => 'New Post',
        'slug' => 'new-post',
        'user_id' => $user->id,
        'main_image' => 'image_url',
        'categories' => 'category1, category2',
        'body' => 'Post body content',
        'published_at' => now()->toIso8601ZuluString(),
    ];

    $response = $this->postJson('/api/posts', $postData);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => ['id', 'title', 'slug', 'main_image', 'categories', 'published_at']
        ]);
});

test('can update an existing post', function () {
    $user = loginAsUser();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $updatedData = [
        'title' => 'Updated Post Title',
        'slug' => 'update-post-slug',
        'user_id' => $user->id,
        'main_image' => 'update_new_image_url',
        'categories' => 'category1, category2',
        'body' => 'Updated post body content',
        'published_at' => now()->toIso8601ZuluString(),
    ];

    $response = $this->patchJson("/api/posts/{$post->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => ['id', 'title', 'slug', 'main_image', 'categories', 'published_at']
        ]);
});

test('can delete a post', function () {
    $user = loginAsUser();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $response = $this->deleteJson("/api/posts/{$post->id}");

    $response->assertStatus(200)
        ->assertJson([
            'status' => 200,
            'message' => 'Post deleted successfully',
            'data' => null,
        ]);

    $this->assertDatabaseMissing('posts', ['id' => $post->id, 'deleted_at' => null]);
});
