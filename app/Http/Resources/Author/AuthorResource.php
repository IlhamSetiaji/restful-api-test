<?php

namespace App\Http\Resources\Author;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
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
                        'name' => $reference->name,
                        'bio' => $reference->bio,
                        'birth_date' => $reference->birth_date,
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
                'name' => $this->name,
                'bio' => $this->bio,
                'birth_date' => $this->birth_date,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];
        }
    }
}
