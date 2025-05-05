<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\ReportReason;

class FoodController extends Controller
{
    private $post;
    private $reportReason;

    public function __construct(Post $post, ReportReason $reportReason){
        $this->post = $post;
        $this->reportReason = $reportReason;
    }

    public function index()
    {
        $all_report_reasons = $this->reportReason->all();
        $all_posts = Post::where('category_id', 2)->get();

        return view('posts.categories.foods.index', compact('all_posts', 'all_report_reasons'));
    }

    public function show($id)
    {
        return view('posts.categories.foods.show');
    }
}
