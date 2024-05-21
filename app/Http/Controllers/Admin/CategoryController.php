<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Image;

class CategoryController extends Controller
{

    public function list(Request $request)
    {
     $category = Category::latest();
     if (filled($request['keyword'])){
         $category = $category->where('name','like','%'.$request['keyword'].'%');
     }
     $category = $category->paginate(10);
     return view('admin.category.list',compact('category'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function save(Request $request)
    {
     $validator = Validator::make($request->all(),[
         'name' => 'required',
         'slug' => 'required|unique:categories',
     ]);
     if ($validator->passes()){
         $category = new Category();
         $category->name = $request['name'];
         $category->slug = $request['slug'];
         $category->status = $request['status'];
         $category->save();

         if (!empty($request['image_id'])) {
         $temp_image = TempImage::find($request['image_id']);
         $ext_array = explode('.',$temp_image->name);
         $ext = last($ext_array);

         $new_image = $category->id.'.'.$ext;
         $save_path = public_path().'/temp/'.$temp_image->name;
         $de_path = public_path().'/uploads/category/'.$new_image;
         File::copy($save_path,$de_path);

//             $de_path = public_path().'/uploads/category/thumb/'.$new_image;
//             $image = Image::make($save_path);
//             $image->resize('450,600');
//             $image->save($de_path);

         $category->image = $new_image;
         $category->save();
         }

         $request->session()->flash('success','Category added successfully');

         return response()->json([
             'status' => true,
             'errors' => 'Category added successfully',
         ]);

     } else {
        return response()->json([
           'status' => false,
            'errors' => $validator->errors(),
        ]);
     }
    }
}
