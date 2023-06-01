<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Resources\SubCategoryResource;
use Cviebrock\EloquentSluggable\Services\SlugService;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::when(request()->has('category_id'), function ($query, $category_id) {
            return $query->where('category_id', $category_id);
        })
            ->with('category')
            ->orderBy('slug')
            ->get();

        return SubCategoryResource::collection($subCategories);
    }

    public function store(StoreSubCategoryRequest $request)
    {
        $subCategory = SubCategory::create([
            'name' => $request->name,
            'slug' => SlugService::createSlug(SubCategory::class, 'slug', $request->name),
            'category_id' => $request->category['id']
        ]);

        return new SubCategoryResource($subCategory);
    }

    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();

        return response()->noContent();
    }
}
