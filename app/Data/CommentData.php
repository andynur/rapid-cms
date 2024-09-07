<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class CommentData extends Data
{
    public function __construct(
        public ?int $post_id,
        public string $name,
        public string $email,
        public string $comment,
    ) {}
}
