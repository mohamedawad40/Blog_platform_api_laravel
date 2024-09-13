<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class postResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'category_name' => $this->category->name,
            'author_id' => $this->user->id,
            'author_name' => $this->user->name,
            'author_email' => $this->user->email,

        ];    }
}
