<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\FormRequests\ArticleFormRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Validation\ValidationException;

class ArticleController extends Controller
{
    public function create(ArticleFormRequest $request)
    {
        try {
            $input = $request->toArray();
            $categoryId = data_get($input, 'category_id');
            $category = Category::whereId($categoryId)->first();
            if (!$category instanceof Category) {
                return response()->json([
                    'success' => false,
                    'error' => 'Category not Found!'
                ], 400);
            }
            $article = new Article([
                'author' => data_get($input, 'author'),
                'title' => data_get($input, 'title'),
                'description' => data_get($input, 'description'),
                'category_id' => $categoryId
            ]);
            $article->save();
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
        $article = Article::with(['category' => function ($query) {
            $query->select('id', 'category_name');
            $query->get();
        }])->whereId($id)->first();
        if ($article instanceof Article) {
        $article->increment('show_count');
            return response()->json([
                'success' => true,
                'data' => $article
            ], 201);
        }
        return response()->json([
            'error' => 'Article Not Found!',
            'success' => false,
        ], 404);
    }

    public function collection()
    {
        $articles = Article::query()->with(['category' => function ($query) {
            $query->select('id', 'category_name');
            $query->get();
        }])->get() ;

        return response()->json([
            'success' => true,
            'data' => $articles
        ], 200);
    }

    public function update(ArticleFormRequest $request, int $id)
    {
        try {
            $input = $request->toArray();
            $author = data_get($input, 'author');
            $title = data_get($input, 'title');
            $description = data_get($input, 'description');
            $categoryId = data_get($input, 'category_id');

            $category = Category::whereId($categoryId)->first();
            $article = Article::whereId($id)->first();
            if (!$article instanceof Article) {
                return response()->json([
                    'success' => false,
                    'error' => 'Article not Found!'
                ], 400);
            }
            if (!$category instanceof Category) {
                return response()->json([
                    'success' => false,
                    'error' => 'Category not Found!'
                ], 400);
            }
            $article->author = $author;
            $article->title = $title;
            $article->description = $description;
            $article->category_id = $categoryId;
            $article->save();

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
            $article = Article::whereId($id)->first();
            if (!$article instanceof Article) {
                return response()->json([
                    'success' => false,
                    'error' => 'Article not Found!'
                ], 400);
            }
            $article->delete();
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
