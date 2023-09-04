<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public function uploadImage(Request $request){
        $rules = array(
            'file' => 'required | mimes:jpeg,jpg,png | max:20000',
            'fileName' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 402);
        }
        else{
            if($request->hasFile('file')){
                $destination = 'public/uploads';
                $image = uniqid('', true) . '.' . $request->file('file')->guessClientExtension();
                $request->file('file')->storeAs($destination, $image);

                $imageTable = DB::table('images');
                $images = $imageTable->insertOrIgnore([
                    'file' => $image,
                    'fileName' => $request->fileName
                ]);

                if($images){
                    return response()->json(['result' => 'Uploaded successfully'], 200);
                }
                else{
                    return response()->json(['result' => 'Upload failed'], 404);
                }
            }else{
                return response()->json(['result' => 'Upload file'], 404);
            }
        }
    }
}
