<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\BlogsCategories;
use App\Models\BlogsSubCategories;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Notifications\TestingNotification;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BlogsController extends Controller
{
   // {{-- code === Saliha --}}

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $categories = BlogsCategories::all();
        $blogs = Blogs::with('blogSubCategory', 'blogCategory')->get();
        $query = Blogs::query();


        if ($request->has('dateTime')) {
            $dateTimeRange = explode(' - ', $request->input('dateTime'));
            $startDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[0])->format('Y-m-d H:i:s');
            $endDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[1])->format('Y-m-d H:i:s');

            $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
        }
        $data = $query->get();
        return view('blogs.index', compact('categories', 'blogs'));
    }

    public function create()
    {
        $categories = BlogsCategories::orderBy('id')->get();
        $BlogsSubCategories = BlogsSubCategories::orderBy('id')->get();
        return view('blogs.create', compact('categories', 'BlogsSubCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'blog_category_id' => 'required',
            'blog_sub_category_id' => 'required',
            'feature_image' => 'required|image|mimes:jpeg,jpg,png',
            'description' => 'required',
        ]);

        $blog = new Blogs;
        $blog->title = $request->title;
        $blog->blog_category_id = $request->blog_category_id;
        $blog->blog_sub_category_id = $request->blog_sub_category_id;
        $blog->description = $request->description;
        $blog->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title)));


        if ($request->hasFile('feature_image')) {
            $file = $request->file('feature_image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/blogs/'), $fileName);
            $blog->feature_image = 'upload/blogs/' . $fileName;
        }
        $blog->save();
        notify()->success('Blog added successfully', 'Blog added successfully');
        return redirect('blogs')->with('success', 'Blog Created Successfully');
    }
    public function show(BlogsCategories $blogsCategories)
    {
        //
    }



    public function edit($id)
    {
        $edit = Blogs::findOrFail($id);
        $categories = BlogsCategories::all();
        $BlogsSubCategories = BlogsSubCategories::orderBy('id')->get();

        return view('blogs.edit', compact('edit', 'categories', 'BlogsSubCategories'));
    }


    public function update($id, Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'title' => 'required',
            'blog_category_id' => 'required',
            'blog_sub_category_id' => 'required',
            'feature_image' => 'image|mimes:jpeg,jpg,png',
            'description' => 'required',
        ]);

        $edit = Blogs::findOrFail($id);
        $edit->title = $request->title;
        $edit->blog_category_id = $request->blog_category_id;
        $edit->blog_sub_category_id = $request->blog_sub_category_id;
        $edit->description = $request->description;
        $edit->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title)));
        if ($request->hasFile('feature_image')) {
            File::delete($edit->feature_image);
            $file = $request->file('feature_image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/blogs/'), $fileName);
            $edit->feature_image = 'upload/blogs/' . $fileName;
            $edit->save();
        }

        $edit->save();
        // Notification::success('Blogs updated successfully', 'Success');
     notify()->success('Blogs update successfully', 'Blog update successfully');
        return redirect('blogs')->with(Toastr::success('Blog  Updated Successfully'));
    }

    public function destroy($id)
    {

        $blog = Blogs::findOrFail($id);
        File::delete($blog->feature_image);

        $blog->delete();
        notify()->success('Blogs deleted successfully', 'Blogs deleted successfully');
        return redirect()->back()->with(Toastr::success('Blogs Deleted Successfully'));
    }


    public function getSubCategories(Request $request)
    {
        $blogssubCategories = BlogsSubCategories::where('blog_category_id', $request->cat_id)->get(['id', 'name']);
        return response()->json($blogssubCategories);
    }
}
