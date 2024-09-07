<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
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
            'title' => (string) $this->title,
            'slug' => (string) $this->slug,
            'main_image' => (string) $this->main_image,
            'categories' => (string) $this->categories,
            'published_at' => (string) $this->published_at,
            'body' => (string) $this->body,
            'user_id' => (int) $this->user_id,
            'user_name' => (string) $this->user->name,
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
