<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    private $paginator;

    public function __construct($resource, $paginator = null)
    {
        parent::__construct($resource);
        $this->paginator = $paginator;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->paginator != null) {
            return [
                'authors' => $this->resource->transform(function ($reference) {
                    return [
                        'id' => $reference->id,
                        'title' => $reference->title,
                        'description' => $reference->description,
                        'publish_date' => $reference->publish_date,
                        'author' => [
                            'id' => $reference->author->id,
                            'name' => $reference->author->name,
                            'bio' => $reference->author->bio,
                            'birth_date' => $reference->author->birth_date,
                            'created_at' => $reference->author->created_at,
                            'updated_at' => $reference->author->updated_at,
                        ],
                        'created_at' => $reference->created_at,
                        'updated_at' => $reference->updated_at,
                    ];
                }),
                'current_page' => $this->paginator ? $this->paginator->currentPage() : null,
                'from' => $this->paginator ? $this->paginator->firstItem() : null,
                'last_page' => $this->paginator ? $this->paginator->lastPage() : null,
                'per_page' => $this->paginator ? $this->paginator->perPage() : null,
                'to' => $this->paginator ? $this->paginator->lastItem() : null,
                'total' => $this->paginator ? $this->paginator->total() : null,
            ];
        } else {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'description' => $this->description,
                'publish_date' => $this->publish_date,
                'author' => [
                    'id' => $this->author->id,
                    'name' => $this->author->name,
                    'bio' => $this->author->bio,
                    'birth_date' => $this->author->birth_date,
                    'created_at' => $this->author->created_at,
                    'updated_at' => $this->author->updated_at,
                ],
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];
        }
    }
}
