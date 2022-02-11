<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Newsletter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function calculate()
    {
        $allArticlesCount = Article::all()->count();
        $allSubscriberCount = Newsletter::all()->count();
        $articlesShowCount=Article::query()->select(DB::raw("SUM(show_count) as show_count")
        )->first();
        $thisWeekArticlesCount = Article::query()->whereBetween('created_at',
            [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
        )->count();
        $thisMonthSubscriberCount = Newsletter::query()->whereBetween('created_at',
            [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
        )->count();
        return response()->json([
            'success' => true,
            'data' => [
                'total_article_count' => $allArticlesCount,
                'total_article_show_count' => (int)data_get($articlesShowCount,'show_count',0),
                'total_week_articles_count' => $thisWeekArticlesCount,
                'total_subscriber_count' => $allSubscriberCount,
                'total_month_subscriber_count' => $thisMonthSubscriberCount
            ]
        ], 200);
    }
}
