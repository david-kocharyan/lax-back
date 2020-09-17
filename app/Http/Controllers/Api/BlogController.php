<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class BlogController extends Controller
{
    private $base_url;

    public function __construct()
    {
        $this->base_url = URL::to('/');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit = !is_numeric($request->limit) ? 20 : $request->limit;
        $blog = Blog::selectRaw("id, title, description, concat('".$this->base_url."','/uploads/', image) as image")->paginate($limit);
        return ResponseHelper::success($blog, true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function article(Request $request)
    {
        if (!is_numeric($request->id)){
            return ResponseHelper::fail("Article id must be integer!", ResponseHelper::UNPROCESSABLE_ENTITY_EXPLAINED);
        }

        $article = Blog::where('id', $request->id)->selectRaw("id, title, description, concat('".$this->base_url."','/uploads/', image) as image")->first();
        return ResponseHelper::success($article, false);
    }


}
