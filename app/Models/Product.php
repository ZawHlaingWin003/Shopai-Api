<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'discount_percentage',
        'discount_price',
        'quantity',
        'category_id',
        'sub_category_id'
    ];

    protected $with = ['category', 'sub_category', 'images'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters['search'] ?? false,
            fn ($query, $search) =>
            $query->where(
                fn ($query) =>
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
            )
        );

        $query->when(
            $filters['category'] ?? false,
            fn ($query, $category) =>
            $query->whereHas(
                'category',
                fn ($query) =>
                $query->where('slug', $category)
            )
        );

        $query->when(
            $filters['sub_category'] ?? false,
            fn ($query, $sub_category) =>
            $query->whereHas(
                'sub_category',
                fn ($query) =>
                $query->where('slug', $sub_category)
            )
        );
    }

    public function actualPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['discount_percentage'] ? $attributes['discount_price'] : $attributes['price']
        );
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function images()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_product')
            ->withPivot('quantity', 'total_price');
    }
}
