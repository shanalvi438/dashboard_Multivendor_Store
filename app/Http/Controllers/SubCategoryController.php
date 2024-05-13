<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class SubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data = \App\Models\SubCategory::with('categories:id,name')->orderBy('name', 'asc')->get();
        $query = \App\Models\SubCategory::with('categories:id,name')->orderBy('name', 'asc');

        // Filter by slug
        if ($request->has('slug')) {
            $slug = $request->input('slug');
            $query->whereIn('slug', $slug);
        }

        // Filter by category name
        if ($request->has('name')) {
            $names = $request->input('name');
            if (is_array($names) && !empty($names)) {
                $query->whereHas('categories', function ($query) use ($names) {
                    $query->whereIn('name', $names);
                });
            }
        }


        // Filter by commission
        if ($request->has('commission')) {
            $commission = $request->input('commission');
            if ($commission[0] != 0) {
                if (count($commission) == 2 && $commission[0] != $commission[1]) {
                    $query->whereBetween('commission', [$commission[0], $commission[1]]);
                } else {
                    $query->where('commission', $commission[0]);
                }
            }
        }

        // if ($request->has('commission')) {
        //     $donor = $request->input('commission');
        //     if ($donor[0] != 0) {
        //         if (count($donor) == 2 && $donor[0] != $donor[1]) {
        //             $query->whereBetween('commission', [$donor[0], $donor[1]]);
        //         } else {
        //             $query->where('commission', $donor[0]);
        //         }
        //     }
        // }
        $data = $query->get();
        $data = $query->with('categories:id,name')->orderBy('name', 'asc')->get();
        $query = SubCategory::query();
        $subcategories = SubCategory::all();
        // Fetch dropdown options
        // $dropdownOptions = $dropdownQuery->distinct()->pluck('name')->toArray();

        $data = $query->get();
        return view('category.allsubcat', compact('data'));
    }


    public function create()
    {
        $categories = Category::OrderBy('id', 'asc')->pluck('name', 'id');
        return view('category.createsubcat', Compact('categories'));
    }
    
    public function store(Request $request)
    {
        $this->validate($request,[
            'category_id'=>'required',
            'name' => 'required',
            'img'=>'mimes:png,jpg,jpeg',
            'slug'=>'required',
        ]);
        
        
        // @dd($s);
        $s = SubCategory::create($request->all());
        print_r($s);
        // $s->slug = Str::slug($request->name);
        $s->save();
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $fileName = uniqid() . $file->getClientOriginalName();
            $imagePath =  'upload/subcategory/' .$fileName;

            $img = Image::make($file);
            // $img->resize(100, 100);
            $img->save($imagePath);

            $s->img = 'upload/subcategory/'.$fileName;
            $s->save();
        }
        Toastr::success('Sub-Category Added Successfully!', 'Success');
        return redirect()->route('sub-category.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit = SubCategory::findOrFail($id);
        $categories = Category::OrderBy('id', 'asc')->pluck('name', 'id');
        return view('category.editsubcat', Compact('edit', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'category_id'=>'required',
            'name' => 'required',
        ]);
        $update = SubCategory::findOrFail($id);
        $update1 = SubCategory::findOrFail($id);
        $update->update($request->all());
        $update->slug = Str::slug($request->name);
        $update->save();
        if ($request->hasFile('img')) {
            File::delete($update1->img);
            $file = $request->file('img');
            $fileName = uniqid() . $file->getClientOriginalName();
            $imagePath =  'upload/subcategory/' .$fileName;

            $img = Image::make($file);
            // $img->resize(100, 100);
            $img->save($imagePath);

            $update->img = 'upload/subcategory/'.$fileName;
            $update->save();
        }
        Toastr::success('Sub-Category Update Successfully!', 'Success');
        return redirect()->route('sub-category.index');
    }

    public function destroy($id)
    {
        $delete = SubCategory::findOrFail($id);
        File::delete($delete->img);
        // File::delete($delete->imageforapp);
        $delete->delete();

        Toastr::success('Sub-Category Delete Successfully!', 'Deleted');
        return redirect()->route('sub-category.index');


    }
}
