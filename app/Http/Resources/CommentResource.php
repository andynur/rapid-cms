<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->id,
            'post_id' => (int) $this->post_id,
            'name' => (string) $this->name,
            'email' => (string) $this->email,
            'comment' => (string) $this->comment,
            'created_at' => (string) $this->created_at,
        ];
    }
}
