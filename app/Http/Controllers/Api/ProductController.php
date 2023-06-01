<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Media;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()
            ->filter(request(['search', 'category', 'sub_category']))
            ->when(request()->has('page'), function ($query) {
                $perPage = request()->perPage ? request()->perPage : 6;
                return $query->paginate($perPage);
            }, function ($query) {
                return $query->get();
            });

        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request)
    {
        try {

            DB::beginTransaction();
            $product = Product::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'price' => $request->price,
                'discount_percentage' => $request->discount_percentage,
                'discount_price' => $request->discount_price,
                'quantity' => $request->quantity,
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
            ]);

            if (count(request()->file('images'))) {
                foreach (request()->file('images') as $image) {
                    $filename = time() . '_' . uniqid() . $request->slug . '.' . $image->getClientOriginalExtension();

                    $image->storeAs('media/products/' . $request->slug . '/images', $filename);

                    $filepath = $request->slug . '/images/' . $filename;

                    Media::create([
                        'filepath' => $filepath,
                        'filetype' => $image->extension(),
                        'filesize' => $image->getSize(),
                        'mediable_id' => $product->id,
                        'mediable_type' => Product::class,
                    ]);
                }
            }

            DB::commit();

            return new ProductResource($product);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        }
    }

    public function show(Request $request, Product $product)
    {
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }

    public function checkSlug()
    {
        $name = request()->name ? request()->name : '';
        $slug = SlugService::createSlug(Product::class, 'slug', $name);
        return response()->json([
            'slug' => $slug
        ]);
    }

    public function generateDiscount()
    {
        $discount_price = request()->price - (request()->price * (request()->discount_percentage / 100));

        return response()->json([
            'discount_price' => $discount_price
        ]);
    }
}
