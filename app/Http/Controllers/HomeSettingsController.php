<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HomeSettings;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as Image;
use App\Events\DatabaseChanged;


class HomeSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }



    public function index()
    {
        $categories = Category::orderBy('id')->pluck('name', 'id');
        $homeSettings = HomeSettings::find(1);
        return view('home-settings.index', compact('categories', 'homeSettings'));
    }

    public function UpdateHomeSettings(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'category1_image' => 'mimes:png,jpg,jpeg',
            'category2_image' => 'mimes:png,jpg,jpeg',
            'category3_image' => 'mimes:png,jpg,jpeg',
            'category4_image' => 'mimes:png,jpg,jpeg',
            'center_image1' => 'mimes:png,jpg,jpeg',
        ]);
        $h1 = HomeSettings::find(1);
        $h = HomeSettings::find(1);
        $h->update($request->all());

        if ($request->hasFile('f_s_banner_1')) {
            File::delete($h1->f_s_banner_1);

            $fileName = uniqid() . '.' . $request->file('f_s_banner_1')->getClientOriginalExtension();

            // Home Settings image save in 620 x 277
            $imagePath =  'upload/home-settings/' . $fileName;
            $img = Image::make($request->file('f_s_banner_1'));
            $img->resize(540, 244);
            $img->save($imagePath);

            $h->f_s_banner_1 =   '/upload/home-settings/' . $fileName;
            $h->save();
        }

        if ($request->hasFile('f_s_banner_2')) {
            File::delete($h1->f_s_banner_2);

            $fileName = uniqid() . '.' . $request->file('f_s_banner_2')->getClientOriginalExtension();

            // Home Settings image save in 620 x 277
            $imagePath =  'upload/home-settings/' . $fileName;
            $img = Image::make($request->file('f_s_banner_2'));
            $img->resize(540, 244);
            $img->save($imagePath);

            $h->f_s_banner_2 =  '/upload/home-settings/' . $fileName;
            $h->save();
        }

        if ($request->hasFile('f_s_banner_3')) {
            File::delete($h1->f_s_banner_3);

            $fileName = uniqid() . '.' . $request->file('f_s_banner_3')->getClientOriginalExtension();

            // Home Settings image save in 620 x 277
            $imagePath =  'upload/home-settings/' . $fileName;
            $img = Image::make($request->file('f_s_banner_3'));
            $img->resize(540, 244);
            $img->save($imagePath);

            $h->f_s_banner_3 =  '/upload/home-settings/' . $fileName;
            $h->save();
        }
        // if ($request->hasFile('category1_image')) {
        //     File::delete($h1->category1_image);

        //     $fileName = uniqid() . '.' . $request->file('category1_image')->getClientOriginalExtension();

        //     //Home Settings image save in 295 x 672
        //     $imagePath =  'root/upload/home-settings/' . $fileName;
        //     $img = Image::make($request->file('category1_image'));
        //     $img->resize(295, 672);
        //     $img->save($imagePath);

        //     $h->category1_image = $request->root() . '/root/upload/home-settings/' . $fileName;
        //     $h->save();
        // }

        if ($request->hasFile('center_image1')) {
            File::delete($h1->center_image1);

            $fileName = uniqid() . '.' . $request->file('center_image1')->getClientOriginalExtension();

            //Home Settings image save in 1656 x 302
            $imagePath =  'upload/home-settings/' . $fileName;
            $img = Image::make($request->file('center_image1'));
            $img->resize(1656, 302);
            $img->save($imagePath);

            $h->center_image1 =  '/upload/home-settings/' . $fileName;
            $h->save();
        }

        if ($request->hasFile('e_s_banner_1')) {
            File::delete($h1->e_s_banner_1);

            $fileName = uniqid() . '.' . $request->file('e_s_banner_1')->getClientOriginalExtension();

            // Home Settings image save in 620 x 277
            $imagePath =  'upload/home-settings/' . $fileName;
            $img = Image::make($request->file('e_s_banner_1'));
            $img->resize(540, 244);
            $img->save($imagePath);

            $h->e_s_banner_1 = '/upload/home-settings/' . $fileName;
            $h->save();
        }

        if ($request->hasFile('e_s_banner_2')) {
            File::delete($h1->e_s_banner_2);

            $fileName = uniqid() . '.' . $request->file('e_s_banner_2')->getClientOriginalExtension();

            // Home Settings image save in 620 x 277
            $imagePath =  'upload/home-settings/' . $fileName;
            $img = Image::make($request->file('e_s_banner_2'));
            $img->resize(540, 244);
            $img->save($imagePath);

            $h->e_s_banner_2 =  '/upload/home-settings/' . $fileName;
            $h->save();
        }

        if ($request->hasFile('e_s_banner_3')) {
            File::delete($h1->e_s_banner_3);

            $fileName = uniqid() . '.' . $request->file('e_s_banner_3')->getClientOriginalExtension();

            // Home Settings image save in 620 x 277
            $imagePath =  'upload/home-settings/' . $fileName;
            $img = Image::make($request->file('e_s_banner_3'));
            $img->resize(540, 244);
            $img->save($imagePath);

            $h->e_s_banner_3 =  '/upload/home-settings/' . $fileName;
            $h->save();
        }


        return redirect()->back()->with(Toastr::success('Home Setting Added Successfully!'));
    }
}
