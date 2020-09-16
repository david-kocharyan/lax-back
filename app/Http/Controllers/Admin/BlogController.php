<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{

    const TITLE = 'Blog';
    const ROUTE = "/blog";
    const FOLDER = 'admin.blog';
    const UPLOAD = 'blog';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Blog::orderBy('id', "ASC")->paginate(10);
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . ".index", compact('title', 'route', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Create";
        return view(self::FOLDER . ".create_edit", compact('title', 'route', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);

        $image_name = "image_".Carbon::now()->timestamp.".". $request->image->getClientOriginalExtension();
        $image = Storage::disk('local')->putFileAs(self::UPLOAD, $request->image, $image_name);

        $data = new Blog();
        $data->title = $request->title;
        $data->description = $request->description;
        $data->image = $image;
        $data->save();

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        $data = $blog;
        $title = $blog->title;
        $route = self::ROUTE;
        return view(self::FOLDER . ".show", compact('title', 'route', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        $data = $blog;
        return view(self::FOLDER . ".create_edit", compact('title', 'route', 'action', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        if($request->image != null){
            Storage::disk('local')->delete("$blog->image");
            $image_name = "image_".Carbon::now()->timestamp.".". $request->image->getClientOriginalExtension();
            $image = Storage::disk('local')->putFileAs(self::UPLOAD, $request->image, $image_name);
            $blog->image = $image;
        }

        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->save();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        Storage::disk('local')->delete("$blog->image");
        Blog::destroy($blog->id);
        return redirect(self::ROUTE);
    }
}
