<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;

class PostData extends Data
{
    public function __construct(
        public string $title,
        public string $slug,
        public ?string $main_image = null,
        public ?string $categories = null,
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?Carbon $published_at = null,
        public string $body,
        public ?int $user_id,
    ) {}
}
