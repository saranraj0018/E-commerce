<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;

class TempImagesController extends Controller
{
    public function create(Request $request)
    {
       $image = $request['image'];

       if (filled($image)) {
           $ext = $image->getClientOriginalExtension();
          $new_name = time().'.'.$ext;

          $tempImage = new TempImage();
          $tempImage->name = $new_name;
          $tempImage->save();

          $image->move(public_path().'/temp',$new_name);

          return response()->json([
             'status' => true,
             'image_id' => $tempImage->id,
             'message' => 'Image upload successfully',
          ]);

       }
    }
}
