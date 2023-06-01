<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'discount_percentage' => $this->discount_percentage,
            'discount_price' => $this->discount_price,
            'actual_price' => $this->actual_price,
            'quantity' => $this->quantity,
            'category' => new CategoryResource($this->category),
            'sub_category' => new SubCategoryResource($this->sub_category),
            'images' => MediaResource::collection($this->images),
            'image' => $this->images ? asset('products/' . $this->images()->first()->filepath) : null,
        ];
    }
}
