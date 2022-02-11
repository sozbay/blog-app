<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\FormRequests\CategoryFormRequest;
use App\Models\Category;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{

    /** @var \Illuminate\Cache\Repository */
    protected $cache;

    public function __construct()
    {
        $this->cache = app('cache');
    }

    public function create(CategoryFormRequest $request)
    {
        try {
            $input = $request->toArray();
            $categoryName = data_get($input, 'category_name');
            $category = Category::where('category_name', $categoryName)->first();
            if ($category instanceof Category) {
                return response()->json([
                    'success' => false,
                    'error' => 'Category already exist!'
                ], 400);
            }
            $categoryModel = new Category([
                'category_name' => $categoryName
            ]);

            $categoryModel->save();
            $this->cache->delete('categories');
            return response()->json([
                'success' => true
            ], 201);
        } catch (ValidationException $validationException) {
            return response()->json([
                'error' => $validationException->errors(),
                'success' => false
            ], 400);
        }

    }

    public function show($id)
    {
        $category = Category::whereId($id)->first();
        if ($category instanceof Category) {
            return response()->json([
                'success' => true,
                'data' => $category
            ], 201);
        }
        return response()->json([
            'error' => 'Category Not Found!',
            'success' => false,
        ], 404);
    }

    public function collection()
    {
        $cacheKey =  'categories';
        $categories = $this->cache->remember($cacheKey,  600,function ()  {
              return  Category::all();
        });
        return response()->json([
            'success' => true,
            'data' => $categories
        ], 200);
    }

    public function update(CategoryFormRequest $request, int $id)
    {
        try {
            $input = $request->toArray();
            $categoryName = data_get($input, 'category_name');
            $category = Category::whereId($id)->first();
            if (!$category instanceof Category) {
                return response()->json([
                    'success' => false,
                    'error' => 'Category not Found!'
                ], 400);
            }
            $category->category_name = $categoryName;
            $category->save();
            $this->cache->delete('categories');
            return response()->json([
                'success' => true
            ], 200);
        } catch (ValidationException $validationException) {
            return response()->json([
                'error' => $validationException->errors(),
                'success' => false
            ], 400);
        }

    }

    public function delete(int $id)
    {
        try {
            $category = Category::whereId($id)->first();
            if (!$category instanceof Category) {
                return response()->json([
                    'success' => false,
                    'error' => 'Category not Found!'
                ], 400);
            }
            $category->delete();
            $this->cache->delete('categories');
            return response()->json([
                'success' => true
            ], 204);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Delete Error!',
                'success' => false
            ], 500);
        }
    }
}
