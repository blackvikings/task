<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImageUpload;

class ImageUploadController extends Controller
{
    public function getFiles()
    {
        $images = ImageUpload::all();

        foreach($images as $image){
            $tableImages[] = $image['filename'];
        }
        $storeFolder = public_path('gallery');
        $file_path = public_path('gallery');
        $files = scandir($storeFolder);
        foreach ( $files as $file ) {
            if ($file !='.' && $file !='..' && in_array($file,$tableImages)) {
                $obj['name'] = $file;
                $file_path = public_path('gallery/').$file;
                $obj['path'] = url('gallery/'.$file);
                $data[] = $obj;
            }

        }
//        dd($data);
        return response()->json($data);
    }
    public function fileStore(Request $request)
    {
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('gallery'),$imageName);

        $imageUpload = new ImageUpload();
        $imageUpload->filename = $imageName;
        $imageUpload->save();
        return response()->json(['success'=>$imageName]);
    }

    public function fileDestroy(Request $request)
    {
        $filename =  $request->get('filename');
        ImageUpload::where('filename',$filename)->delete();
        $path = public_path('gallery/').$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return response()->json(['success'=>$filename]);
    }
}
