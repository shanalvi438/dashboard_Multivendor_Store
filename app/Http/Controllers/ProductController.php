<?php

namespace App\Http\Controllers;

use App\Http\Middleware\VendorOnly;
use App\Models\ParcelReview;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Menu;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Conditions;
use App\Models\Locations;
use App\Models\ProductConditions;
use App\Models\ProductContact;
use App\Models\ProductImages;
use App\Models\ProductLocations;
use App\Models\ProductShippment;
use App\Models\ProductSizes;
use App\Models\User;
use App\Models\Color;
use App\Models\ProductColors;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as Image;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        // dd($request->all());

        // return view('products.allproducts');


        if (Auth::user()->role === 'Admin') {
            $allproducts = Product::count();
            $totalSupplier = User::select('id', 'name', 'phone1', 'email', 'status', 'verified_status', 'trusted_status')->whereRole('vendor')->count();
        } else {
            $allproducts = Product::where('p_vendor_id', Auth::user()->id)->count();
            $totalSupplier  = Product::where('p_vendor_id', Auth::user()->id)->count();
        }
        $data = "";
        if (Auth::user()->role == 'Admin') {
            $query = Product::query();
            $brand = Brand::all();
            $categories = Category::all();
            $subcategories = SubCategory::all();
            $products = Product::all();
            $vendors = User::where('role', 'Vendor')->get();
            $colors = Color::all();
            $menus = Menu::all();
            $supplier = User::where('role', 'Vendor')->get();

            if ($request->has('name')) {
                $products = $request->input('name');
                foreach ($products as $product) {
                    if ($product !== null && $product !== '') {
                        if (is_array($products)) {
                            $query->whereIn('name', $products);
                        } else {
                            $query->where('name', $product);
                        }
                    }
                }
            }

            if ($request->has('model_no')) {
                $model_nums = $request->input('model_no');
                foreach ($model_nums as $model_num) {
                    if ($model_num !== null && $model_num !== '') {
                        if (is_array($model_nums)) {
                            $query->whereIn('model_no', $model_nums);
                        } else {
                            $query->where('model_no', $model_nums);
                        }
                    }
                }
            }


            if ($request->has('make')) {
                $makes = $request->input('make');
                foreach ($makes as $make) {
                    if ($make !== null && $make !== '') {
                        if (is_array($makes)) {
                            $query->whereIn('make', $makes);
                        } else {
                            $query->where('make', $makes);
                        }
                    }
                }
            }

            if ($request->has('categories')) {
                $categories = $request->input('categories');
                $query->whereHas('categories', function ($q) use ($categories) {
                    $q->whereIn('id', $categories);
                });
            }

            if ($request->has('subcategories')) {
                $subcategories = $request->input('subcategories');
                $query->whereHas('subcategories', function ($q) use ($subcategories) {
                    $q->whereIn('id', $subcategories);
                });
            }

            if ($request->has('brand_id')) {
                $brand = $request->input('brand_id');
                if (is_array($brand)) {
                    $query->whereIn('brand_id', $brand);
                } else {
                    $query->where('brand_id', $brand);
                }
            }
            if ($request->has('new_sale_price')) {
                $newSalePrice = $request->input('new_sale_price');
                // Check if new_sale_price has been manually changed
                if ($newSalePrice[0] != 0) {
                    if (count($newSalePrice) == 2 && $newSalePrice[0] != $newSalePrice[1]) {
                        $query->whereBetween('new_sale_price', [$newSalePrice[0], $newSalePrice[1]]);
                    } else {
                        $query->where('new_sale_price', $newSalePrice[0]);
                    }
                }
            }

            if ($request->has('tax_charges')) {
                $tax = $request->input('tax_charges');
                // Check if tax_charges has been manually changed
                if ($tax[0] != 0) {
                    if (count($tax) == 2 && $tax[0] != $tax[1]) {
                        $query->whereBetween('tax_charges', [$tax[0], $tax[1]]);
                    } else {
                        $query->where('tax_charges', $tax[0]);
                    }
                }
            }

            if ($request->has('new_warranty_days')) {
                $warranty = $request->input('new_warranty_days');
                // Check if new_warranty_days has been manually changed
                if ($warranty[0] != 0) {
                    if (count($warranty) == 2 && $warranty[0] != $warranty[1]) {
                        $query->whereBetween('new_warranty_days', [$warranty[0], $warranty[1]]);
                    } else {
                        $query->where('new_warranty_days', $warranty[0]);
                    }
                }
            }

            if ($request->has('new_return_days')) {
                $return = $request->input('new_return_days');
                // Check if new_return_days has been manually changed
                if ($return[0] != 0) {
                    if (count($return) == 2 && $return[0] != $return[1]) {
                        $query->whereBetween('new_return_days', [$return[0], $return[1]]);
                    } else {
                        $query->where('new_return_days', $return[0]);
                    }
                }
            }

            // if ($request->has('new_sale_price')) {
            //     $products = $request->input('new_sale_price');
            //     // dd($products);

            //     if (is_array($products)) {
            //         $query->whereNotNull('new_sale_price');
            //     } else {
            //         $query->whereNotNull('new_sale_price');
            //     }
            // }


            // if ($request->has('new_warranty_days')) {
            //     $products = $request->input('new_warranty_days');
            //     if (is_array($products)) {
            //         $query->whereIn('new_warranty_days', $products);
            //     } else {
            //         $query->where('new_warranty_days', $products);
            //     }
            // }

            // if ($request->has('new_return_days')) {
            //     $products = $request->input('new_return_days');
            //     if (is_array($products)) {
            //         $query->whereIn('new_return_days', $products);
            //     } else {
            //         $query->where('new_return_days', $products);
            //     }
            // }

            if ($request->has('dateTime')) {
                $dateTimeRange = explode(' - ', $request->input('dateTime'));
                $startDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[0])->format('Y-m-d H:i:s');
                $endDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[1])->format('Y-m-d H:i:s');

                $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
            }

            $data = $query->get();

            $products = Product::all();

            // dd($request->all());

        } else {
            $query = Product::query();
            $products = Product::all();
            $supplier = User::where('role', 'Vendor')->get();
            $colors = Color::all();
            $menus = Menu::all();
            if ($request->has('name')) {
                $products = $request->input('name');
                foreach ($products as $product) {
                    if ($product !== null && $product !== '') {
                        if (is_array($product)) {
                            $query->whereIn('name', $product);
                        } else {
                            $query->where('name', $product);
                        }
                    }
                }
            }

            if ($request->has('model_no')) {
                $modelNos = $request->input('model_no');
                foreach ($modelNos as $modelNo) {
                    if ($modelNo != null && $modelNo != '') {
                        $query->where('model_no', $modelNo);
                    }
                }
            }

            if ($request->has('make')) {
                $makes = $request->input('make');
                foreach ($makes as $make) {
                    if ($make != null && $make != '') {
                        $query->where('make', $make);
                    }
                }
            }
            if ($request->has('name')) {
                $menu = $request->input('name');
                if (is_array($menu)) {
                    $query->whereIn('name', $menu);
                } else {
                    $query->where('name', $menu);
                }
            }



            if ($request->has('subcategories')) {
                $subcategories = $request->input('subcategories');
                $query->whereHas('subcategories', function ($q) use ($subcategories) {
                    $q->whereIn('id', $subcategories);
                });
            }


            if ($request->has('brand_id')) {
                $brand = $request->input('brand_id');
                $query->whereIn('id', $brand);
            }

            if ($request->has('tax_charges')) {
                $products = $request->input('tax_charges');
                if (is_array($products)) {
                    $query->whereIn('tax_charges', $products);
                } else {
                    $query->where('tax_charges', $products);
                }
            }

            if ($request->has('new_sale_price')) {
                $products = $request->input('new_sale_price');
                if (is_array($products)) {
                    $query->whereIn('new_sale_price', $products);
                } else {
                    $query->where('new_sale_price', $products);
                }
            }

            if ($request->has('new_warranty_days')) {
                $products = $request->input('new_warranty_days');
                if (is_array($products)) {
                    $query->whereIn('new_warranty_days', $products);
                } else {
                    $query->where('new_warranty_days', $products);
                }
            }

            if ($request->has('new_return_days')) {
                $products = $request->input('new_return_days');
                if (is_array($products)) {
                    $query->whereIn('new_return_days', $products);
                } else {
                    $query->where('new_return_days', $products);
                }
            }

            if ($request->has('dateTime')) {
                $dateTimeRange = explode(' - ', $request->input('dateTime'));
                $startDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[0])->format('Y-m-d H:i:s');
                $endDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[1])->format('Y-m-d H:i:s');

                $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
            }

            $data = $query->get();

            $data = Product::with('product_image', 'categories:id,name', 'subcategories:id,name')
                ->where('created_by', Auth::user()->id)
                ->orderBy('id', 'desc')
                ->get();
            $brand = Brand::all();
            $categories = Category::all();
            $subcategories = SubCategory::all();
            $vendors = User::where('role', 'Vendor')->get();
        }



        return view('products.allproducts', compact('data', 'products', 'supplier', 'brand', 'categories', 'subcategories', 'vendors', 'colors', 'menus', 'allproducts', 'totalSupplier'));
    }
    public function productsView()
    {
        $data = "";
        if (Auth::User()->role == 'Admin') {
            $data = Product::with('product_image', 'categories:id,name', 'subcategories:id,name')
                ->OrderBy('id', 'desc')
                ->paginate(16);
            $brand = Brand::all();
            $categories = Category::all();
            $subcategories = SubCategory::all();
            $product = Product::all();
        } else {
            $data = Product::with('product_image', 'categories:id,name', 'subcategories:id,name')
                ->where('created_by', Auth::User()->id)
                ->OrderBy('id', 'desc')
                ->paginate(16);
            $brand = Brand::all();
            $categories = Category::all();
            $subcategories = SubCategory::all();
        }
        return view('products.productsView', compact('data', 'brand', 'categories', 'subcategories'));
    }
    public function create(Request $request)
    {
        $user = Auth::user();

        if (!$user->first_name == '' && !$user->phone1 == '' && !$user->address1 == '' && !$user->city == '') {
            $brands = Brand::orderBy('brand_name')->get(['id', 'brand_name', 'logo']);
            $menus = Menu::orderBy('name')->pluck('name', 'id')->prepend('Select Menu', '');
            $categories = Category::orderBy('name')->pluck('name', 'id')->prepend('Select Category', '');
            $sub_categories = SubCategory::orderBy('name')->pluck('name', 'id')->prepend('Select Sub Category', '');
            $locations = Locations::select('id', 'name')->orderBy('id')->get();
            $conditions = Conditions::select('id', 'name')->orderBy('id')->get();
            $type = array('Parent' => 'Parent', 'Child' => 'Child');
            $productsList = Product::whereType('parent')->orderBy('name')->pluck('sku', 'id');
            $colors = Color::select('id', 'name')->orderBy('id')->get();

            foreach ($brands as $brand) {
                $brand->image_path = asset($brand->logo); // Assuming the logo field contains the image path
            }
            $ActiveAdmin = User::whereId(Auth::User()->id)->first();

            $vendors = User::select(DB::raw('CONCAT(`id`, "_", `name`) AS `id`, `name`'))
                ->whereRole('Vendor')
                ->pluck('name', 'id')
                ->prepend($ActiveAdmin->name, $ActiveAdmin->id . '_' . $ActiveAdmin->name);

            return view('products.addproduct', compact('brands', 'menus', 'categories', 'sub_categories', 'locations', 'conditions', 'type', 'productsList', 'vendors', 'colors'));
        } else {
            Toastr::success('Please Fill Your Profile First', 'Success');
            $user_id = Auth::user()->id;
            return redirect()->to('vendor-profile/' . $user_id);
        }
    }
    public function test()
    {
        return view('products.test');
    }
    public function testupload(Request $request)
    {
        dd($request);
        return view('products.test');
    }
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->first_name == '' && !$user->phone1 == '' && !$user->address1 == '' && !$user->city == '') {
            $this->validate(
                $request,
                [
                    // 'name' => 'required',
                    'make' => 'required',
                    'sku' => 'required|unique:products',
                    'new_price' => 'nullable|gt:new_sale_price',
                    'new_sale_price' => 'nullable',
                    'refurnished_price' => 'nullable|gt:refurnished_sale_price',
                    'refurnished_sale_price' => 'nullable',
                    'feature_image' => 'required',
                    'attachment' => 'mimes:pdf,zip|max:20480',
                    'description' => 'required',
                    'menu_id' => 'required',
                    'category_id' => 'required',
                    'subcategory_id' => 'required',
                    // 'brand_name' => 'required|unique:brands',
                ],
                [

                    'name.required' => 'The Product name field is required',
                    // 'condition.0.required' => 'The Condition field is required',
                    'make.required' => 'The Make field is required',
                    'sku.exists' => 'The SKU already exist',
                    'new_sale_price.lte' => 'Sale price must be less than or equal to the old price.',
                    'refurnished_sale_price.lte' => 'Refurbished Sale price must be less than or equal to the old Refurbished price.',
                    'feature_image.required' => 'The Feature Image field is required',
                    // 'images.0.required' => 'The Image field is required',
                    'description.required' => 'The Description field is required',
                    'menu_id.required' => 'The Menu field is required',
                    'category_id.required' => 'The Category field is required',
                    'subcategory_id.required' => 'The Sub Category field is required',
                ]

            );

            $brand = new Brand;
            $brand->brand_name = $request->brand_name;
            // dd($request->all());
            if ($request->hasFile('feature_image')) {
                $image = $request->file('feature_image');
                $imageName = uniqid() . '.' . $image->extension();
                $image->move('upload/products', $imageName);
            }

            $productData = $request->all();

            if ($request->hasFile('feature_image')) {
                $productData['url'] = asset('upload/products/' . $imageName);
                $productData['feature_image'] = $imageName;
            }
            // echo "<pre>";
            // print_r($productData);
            // echo "</pre>";
            // die;

            $p = Product::create($productData);
            // $p = Product::create($request->all());

            $p->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
            $p->created_by = Auth::User()->id;
            $p->save();

            if (isset($request->condition)) {
                for ($i = 0; $i < count($request->condition); $i++) {
                    $ProductConditions = new ProductConditions();
                    $ProductConditions->pro_id = $p->id;
                    $ProductConditions->condition_id = $request->condition[$i];
                    $$ProductConditions->brand_name = $request->brand_name;
                    $ProductConditions->save();
                }
            }

            if (isset($request->colors)) {
                for ($i = 0; $i < count($request->colors); $i++) {
                    $productColor = new ProductColors();
                    $productColor->pro_id = $p->id;
                    $productColor->color_id = $request->colors[$i];
                    $productColor->save();
                }
            }

            if ($request->hasFile('images')) {
                if (count($request->images) > 0) {
                    for ($i = 0; $i < count($request->images); $i++) {
                        $pImages = new ProductImages();
                        $pImages->pro_id = $p->id;

                        // Get the uploaded image file
                        $uploadedImage = $request->images[$i];

                        // Generate a unique filename for the image
                        $imageName = uniqid() . '_' . $uploadedImage->getClientOriginalName();

                        // Move the uploaded image to the "upload" folder
                        $uploadedImage->move('upload/products', $imageName);

                        // Save the image details
                        $pImages->image = $imageName;
                        $pImages->url =  url('upload/products/' . $imageName); // Adjust this URL as needed
                        $pImages->save();
                    }
                }
            }

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $fileName = uniqid() . $file->getClientOriginalName();
                $file->move('upload/products/attachments', $fileName);

                $p->attachment = $fileName;
                $p->save();
            }

            Toastr::success('Product Added successfully', 'Success');
            return redirect()->back();
        } else {
            Toastr::success('Please Fill Your Profile First', 'Success');
            $user_id = Auth::user()->id;
            return redirect()->to('vendor-profile/' . $user_id);
        }
    }





    public function edit(Request $request, $id)
    {
        $edit = Product::with('shipping_details')
            ->with('locations')
            ->with('conditions')
            ->with('colors')
            ->with('product_images')
            ->findOrFail($id);

        if ($edit) {
            $brands = Brand::orderBy('brand_name')->get(['id', 'brand_name', 'logo']);
            $menus = Menu::orderBy('name')->pluck('name', 'id')->prepend('Select Menu', '');
            $categories = Category::orderBy('name')->pluck('name', 'id')->prepend('Select Category', '');
            $sub_categories = SubCategory::orderBy('name')->pluck('name', 'id')->prepend('Select Sub Category', '');
            $locations = Locations::orderBy('id')->get(['id', 'name']);
            $conditions = Conditions::orderBy('id')->get(['name', 'id']);
            $type = array('Parent' => 'Parent', 'Child' => 'Child');
            $productsList = Product::whereType('parent')->orderBy('name')->pluck('sku', 'id');
            $colors = Color::orderBy('id')->get(['name', 'id']);

            return view('products.edit', compact('edit', 'brands', 'menus', 'categories', 'sub_categories', 'locations', 'type', 'productsList', 'conditions', 'colors'));
        } else {
            abort(404);
        }
    }
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [

                'name' => 'required',
                'make' => 'required',
                // 'min_order' => 'required',
                // 'feature_image' => 'required',
                'sku' => 'required',
                'new_price' => 'nullable|gt:new_sale_price',
                'new_sale_price' => 'nullable',
                'refurnished_price' => 'nullable|gt:refurnished_sale_price',
                'refurnished_sale_price' => 'nullable',
                'description' => 'required',
                'attachment' => 'mimes:pdf,zip|max:20480',
                'menu_id' => 'required',
                'category_id' => 'required',
                'subcategory_id' => 'required',
                'brand_id' => 'required',



            ],
            [
                'name.required' => 'The Product name field is required',
                'make.required' => 'The Make field is required',
                'sku.exists' => 'The SKU already exist',
                'new_sale_price.lte' => 'Sale price must be less than or equal to the old price.',
                'refurnished_sale_price.lte' => 'Refurbished Sale price must be less than or equal to the old Refurbished price.',
                'feature_image.required' => 'The Feature Image field is required',
                // 'images.0.required' => 'The Image field is required',
                'description.required' => 'The Description field is required',
                'brand_id.required' => 'The Brand field is required',
                'menu_id.required' => 'The Menu field is required',
                'category_id.required' => 'The Category field is required',
                'subcategory_id.required' => 'The Sub Category field is required',
            ]

        );


        $edit = Product::findOrFail($id);

        if ($request->hasFile('feature_image')) {
            $image = $request->file('feature_image');
            $imageName = uniqid() . '.' . $image->extension();
            $image->move('upload/products', $imageName);
        }

        $productData = $request->all();
        if ($request->hasFile('feature_image')) {
            $productData['url'] = asset('upload/products/' . $imageName);
            $productData['feature_image'] = $imageName;
        }

        $edit->update($productData);

        // $edit->update($request->all());

        if ($request->type == 'Child') {
            $edit->parent_id = $request->parent_id;
        }

        $edit->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
        $edit->updated_by = Auth::User()->id;
        $edit->save();

        if (isset($request->condition)) {
            if (count($request->condition) > 0) {
                ProductConditions::where('pro_id', $id)->delete();

                for ($i = 0; $i < count($request->condition); $i++) {
                    $ProductConditions = new ProductConditions();
                    $ProductConditions->pro_id = $edit->id;
                    $ProductConditions->condition_id = $request->condition[$i];
                    $ProductConditions->save();
                }
            }
        }
        if (isset($request->colors)) {
            if (count($request->colors) > 0) {
                ProductColors::where('pro_id', $id)->delete();

                for ($i = 0; $i < count($request->colors); $i++) {
                    $ProductColors = new ProductColors();
                    $ProductColors->pro_id = $edit->id;
                    $ProductColors->color_id = $request->colors[$i];
                    $ProductColors->save();
                }
            }
        }

        if ($request->hasFile('images')) {
            if (count($request->images) > 0) {

                ProductImages::where('pro_id', $id)->delete();



                for ($i = 0; $i < count($request->images); $i++) {
                    $pImages = new ProductImages();
                    $pImages->pro_id = $edit->id;

                    // Get the uploaded image file
                    $uploadedImage = $request->images[$i];

                    // Generate a unique filename for the image
                    $imageName = uniqid() . '_' . $uploadedImage->getClientOriginalName();

                    // Move the uploaded image to the "upload" folder
                    $uploadedImage->move('upload/products', $imageName);

                    // Save the image details
                    $pImages->image = $imageName;
                    $pImages->url =  url('upload/products/' . $imageName); // Adjust this URL as needed
                    $pImages->save();
                }
            }
        }

        if ($request->hasFile('attachment')) {
            File::delete('upload/products/attachments/' . $edit->attachment);

            $file = $request->file('attachment');
            $fileName = uniqid() . $file->getClientOriginalName();
            $file->move('upload/products/attachments', $fileName);
            $edit->attachment = $fileName;
            $edit->save();
        }
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = uniqid() . $file->getClientOriginalName();

            // Save the big logo image
            $bigImagePath = 'upload/brands/big/' . $fileName;
            $img = Image::make($file);
            $img->resize(410, 186);
            $img->save($bigImagePath);

            // Save the small logo image
            $smallImagePath = 'upload/brands/small/' . $fileName;
            $img = Image::make($file);
            $img->resize(136, 62);
            $img->save($smallImagePath);

            // Update the logo path in the database
            $edit->brand->logo = $smallImagePath;
            $edit->brand->save();
        }

        return redirect('products')->with(Toastr::success('Product Updated Successfully!'));
    }
    public function dupe($id)
    {

        $edit = Product::with('shipping_details')
            ->with('locations')
            ->with('conditions')
            ->with('colors')
            ->with('product_images')
            // ->where('created_by', Auth::User()->id)
            ->findOrFail($id);
        if ($edit) {
            $brands = Brand::OrderBy('brand_name')->pluck('brand_name', 'id')->prepend('Select Brand', '');
            $menus = Menu::orderBy('name')->pluck('name', 'id')->prepend('Select Menu', '');
            $categories = Category::orderBy('name')->pluck('name', 'id')->prepend('Select Category', '');
            $sub_categories = SubCategory::orderBy('name')->pluck('name', 'id')->prepend('Select Sub Category', '');
            $locations = Locations::orderBy('id')->get(['id', 'name']);
            $conditions = Conditions::orderBy('id')->get(['name', 'id']);
            $type = array('Parent' => 'Parent', 'Child' => 'Child');
            $productsList = Product::whereType('parent')->orderBy('name')->pluck('model_no', 'id');
            $colors = Color::orderBy('id')->get(['name', 'id']);

            return view('products.dupe', compact('edit', 'brands', 'menus', 'categories', 'sub_categories', 'locations', 'type', 'productsList', 'conditions', 'colors'));
        } else {
            abort(404);
        }
    }
    public function duplicate(Request $request, $id)
    {
        $this->validate(
            $request,
            [

                'name' => 'required',
                'make' => 'required',
                // 'min_order' => 'required',
                'attachment' => 'mimes:pdf,zip|max:20480',
                'sku' => 'required|unique:products',
                'new_price' => 'nullable|gt:new_sale_price',
                'new_sale_price' => 'nullable',
                'refurnished_price' => 'nullable|gt:refurnished_sale_price',
                'refurnished_sale_price' => 'nullable',
                'description' => 'required',
                // 'images.0' => 'required',
                'feature_image' => 'required',
                'menu_id' => 'required',
                'category_id' => 'required',
                'subcategory_id' => 'required',
                // 'brand_id' => 'required',
                // 'brand_name' => 'required',


            ],
            [
                'name.required' => 'The Product name field is required',
                'make.required' => 'The Make field is required',
                'sku.exists' => 'The SKU already exist',
                'new_sale_price.lte' => 'Sale price must be less than or equal to the old price.',
                'refurnished_sale_price.lte' => 'Refurbished Sale price must be less than or equal to the old Refurbished price.',
                // 'images.0.required' => 'The Image field is required',
                'description.required' => 'The Description field is required',
                'feature_image.required' => 'The Feature Image field is required',
                'brand_id.required' => 'The Brand field is required',
                'menu_id.required' => 'The Menu field is required',
                'category_id.required' => 'The Category field is required',
                'subcategory_id.required' => 'The Sub Category field is required',
            ]

        );

        // dd($request->all());
        // $p = Product::findOrFail($id);

        if ($request->hasFile('feature_image')) {
            $image = $request->file('feature_image');
            $imageName = uniqid() . '.' . $image->extension();
            $image->move('upload/products', $imageName);
        }

        $productData = $request->all();

        if ($request->hasFile('feature_image')) {
            $productData['url'] = asset('upload/products/' . $imageName);
            $productData['feature_image'] = $imageName;
        }

        $p = Product::create($productData);


        // $p = Product::create($request->all());

        if ($request->type == 'Child') {
            $p->parent_id = $request->parent_id;
        } else {
            $p->parent_id = $p->id;
        }

        $p->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
        $p->created_by = Auth::User()->id;
        $p->save();

        if (isset($request->condition)) {
            for ($i = 0; $i < count($request->condition); $i++) {
                $ProductConditions = new ProductConditions();
                $ProductConditions->pro_id = $p->id;
                $ProductConditions->condition_id = $request->condition[$i];
                $ProductConditions->save();
            }
        }

        if (isset($request->colors)) {
            if (count($request->colors) > 0) {
                ProductColors::where('pro_id', $id)->delete();

                for ($i = 0; $i < count($request->colors); $i++) {
                    $ProductColors = new ProductColors();
                    $ProductColors->pro_id = $p->id;
                    $ProductColors->color_id = $request->colors[$i];
                    $ProductColors->save();
                }
            }
        }

        // if (count($request->images) > 0) {
        //     for ($i = 0; $i < count($request->images); $i++) {
        //         $pImages = new ProductImages();
        //         $pImages->pro_id = $p->id;
        //         $pImages->image = $request->images[$i];
        //         $pImages->url = 'root/upload/products/'.$request->images[$i];
        //         $pImages->save();
        //     }
        // }
        if ($request->hasFile('images')) {
            if (count($request->images) > 0) {
                for ($i = 0; $i < count($request->images); $i++) {
                    $pImages = new ProductImages();
                    $pImages->pro_id = $p->id;
                    $uploadedImage = $request->images[$i];
                    $imageName = uniqid() . '_' . $uploadedImage->getClientOriginalName();
                    $uploadedImage->move('upload/products', $imageName);

                    $pImages->image = $imageName;
                    $pImages->url =  url('upload/products/' . $imageName);
                    $pImages->save();
                }
            }
        }

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = uniqid() . $file->getClientOriginalName();
            $file->move('upload/products/attachments', $fileName);
            $p->attachment = $fileName;
            $p->save();
        }

        Toastr::success('Product Duplicated Successfully!', 'Success');
        return redirect()->back();
        // return redirect()->back()->with(Toastr::success('Product Duplicated Successfully!','success'));

    }
    public function destroy($id)
    {
        $pro = Product::findOrFail($id);

        File::delete('upload/products/attachments/' . $pro->attachment);
        $pro->delete();

        ProductConditions::where('pro_id', $id)->delete();
        $pImages = ProductImages::where('pro_id', $id)->get();
        foreach ($pImages as $value) {
            File::delete('upload/products/' . $value->image);
        }
        ProductImages::where('pro_id', $id)->delete();
        ProductLocations::where('pro_id', $id)->delete();
        ProductSizes::where('pro_id', $id)->delete();
        ProductShippment::where('pro_id', $id)->delete();

        // Toastr::success('Product Deleted successfully', 'Success');
        return redirect()->back()->with(Toastr::success('Product Deleted Successfully!'));
    }
    public function GetCategories(Request $request)
    {
        $categories = Category::whereMenuId($request->menu_id)->get(['id', 'name']);
        return json_encode($categories);
    }
    public function GetSubCategories(Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->cat_id)->get(['id', 'name']);
        return json_encode($subcategories);
    }
    public function UploadImageAJax(Request $request)
    {
        // return count($request->select_file);
        $validation = Validator::make($request->all(), [
            'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if (!$validation->failed()) {
            $imagesName = [];
            foreach ($request->select_file as $key => $file) {
                $image = $file;
                $new_name = uniqid() . $image->getClientOriginalName();

                // $image->move('root/upload/products', $new_name);

                $imagePath =  base_path('upload/products/' . $new_name);
                $img = Image::make($image);
                $img->resize(1000, 957);
                $img->save($imagePath);

                $imagesName[$key] = $new_name;
            }
            return response()->json($imagesName);
            // return response()->json([
            //   'message'   => 'Image Upload Successfully',
            //   'uploaded_image' =>
            //   '<label id="row' . $new_name . '">
            //     <img src="../root/upload/products/' . $new_name . '" class="img-thumbnail" style="width:100px;height:80px;" />
            //       <span data-path="' . $new_name . '" id="remove_button" style="position:relative;top:-35px;left:-10px;background:red;color:white;padding:0px 5px 3px 5px;border-radius:100%;cus">x</span>
            //     </div>
            //    </label>',
            //   'class_name'  => 'alert-success',
            //   'name' => $new_name
            // ]);
        } else {
            return response()->json([
                'message'   => $validation->errors()->all(),
                'uploaded_image' => '',
                'class_name'  => 'alert-danger'
            ]);
        }
    }
    public function DeleteImageAJax(Request $request)
    {
        File::delete('upload/products/' . $request->path);

        ProductImages::where('image', $request->path)->delete();
        return "Deleted";
    }
    public function UploadAttachmentAJax(Request $request)
    {
        if ($request->hasFile('attachment')) {
            return 1;
        } else {
            return 2;
        }
        return $request->all();
        $image = $request->file('attachment');
        $new_name = uniqid() . $image->getClientOriginalName();

        $image->move('upload/products/attachments', $new_name);
        return response()->json([
            'message'   => 'Image Upload Successfully'
        ]);
    }
    public function ProductsContacts(Request $request)
    {
        if (Auth::User()->role == 'Admin') {
            $productContacts = array();
            if ($request->from_date != null && $request->to_date != null) {
                $productContacts = ProductContact::whereDate('created_at', '>=', $request->from_date)
                    ->whereDate('created_at', '<=', $request->to_date)
                    ->orderBy('id', 'desc')->get();
            }
            return view('products.contacts', compact('productContacts'));
        } else if (Auth::User()->role == 'Vendor') {
            $productContacts = ProductContact::where('vendor_id', Auth::User()->id)->orderBy('id', 'desc')->get();
            return view('products.vendor_contacts', compact('productContacts'));
        }
    }

    public function getProductChartData()
    {
        $productCounts = Product::groupBy('category_id')
            ->selectRaw('count(*) as total_count, category_id')
            ->pluck('total_count', 'category_id');

        // Get the category names for the chart labels
        $categories = Category::whereIn('id', $productCounts->keys())->pluck('name');

        $data = [
            'categories' => $categories,
            'productCounts' => array_values($productCounts->toArray()),
        ];

        return response()->json($data);
    }
    public function productReviews(Request $request)
    {
        $query = ParcelReview::query();

        if ($request->has('order_item_id')) {
            $item = $request->input('order_item_id');
            if (is_array($item)) {
                $query->whereIn('order_item_id', $item);
            } else {
                $query->where('order_item_id', $item);
            }
        }

        if ($request->has('customer_id')) {
            $item = $request->input('customer_id');
            if (is_array($item)) {
                $query->whereIn('customer_id', $item);
            } else {
                $query->where('customer_id', $item);
            }
        }

        if ($request->has('id')) {
            $item = $request->input('id');
            $query->whereHas('product', function ($products) use ($item) {
                $products->whereIn('id', $item);
            });
        }

        if ($request->has('name')) {
            $item = $request->input('name');
            $query->whereHas('product', function ($products) use ($item) {
                $products->whereIn('name', $item);
            });
        }

        if ($request->has('model_no')) {
            $item = $request->input('model_no');
            $query->whereHas('product', function ($products) use ($item) {
                $products->whereIn('model_no', $item);
            });
        }

        if ($request->has('sku')) {
            $item = $request->input('sku');
            $query->whereHas('product', function ($products) use ($item) {
                $products->whereIn('sku', $item);
            });
        }

        if ($request->has('new_sale_price')) {
            $item = $request->input('new_sale_price');
            $query->whereHas('product', function ($products) use ($item) {
                $products->whereIn('new_sale_price', $item);
            });
        }

        if ($request->has('dateTime')) {
            $dateTimeRange = explode(' - ', $request->input('dateTime'));
            if (count($dateTimeRange) == 2) {
                $startDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[0])->format('Y-m-d H:i:s');
                $endDateTime = Carbon::createFromFormat('m/d/Y h:i A', $dateTimeRange[1])->format('Y-m-d H:i:s');

                $query->whereBetween('created_at', [$startDateTime, $endDateTime]);
            }
        }

        if (Auth::user()->role === 'Admin') {
            $review = ParcelReview::with('product')->get();
        } else {
            $review = ParcelReview::with('product')->whereHas('product', function ($query) {
                $query->where('created_by', Auth::user()->id);
            })->get();
        }



        if (Auth::user()->role === 'Admin') {
            $review = ParcelReview::with('order')->get();
        } else {
            $review = ParcelReview::with('order')->whereHas('order', function ($query) {
                $query->where('created_by', Auth::user()->id);
            })->get();
        }

        $review = $query->get();
        return view('products.productreviews', compact('review', 'query'));
    }

}
