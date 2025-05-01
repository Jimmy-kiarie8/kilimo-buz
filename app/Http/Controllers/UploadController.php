<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Upload;
Use Auth;

class UploadController extends Controller
{
    public function getUploadTestPage(){
        return view('upload');
    }

    //
    public static function uploadFile(Request $request)
    {
            if($request->isMethod("post"))
            {
                $files=$request->file('files');
                //dd($files);
                $fileuploads=[];

                foreach ($files as $file) 
                {
                    $path="uploads";
                    $extention=$file->getClientOriginalExtension();
                    $filename=date('UNIX').".".$extention;
                    $file->move($path,$filename);
					
					
                    $upload=new Upload;
                    $upload->filename=$filename;
                    $upload->extention=$extention;
                    $upload->user_id=Auth::user()->id;
                    $upload->save();
                    $url=url('/uploads/'.$filename);
                    $deleteurl=url('/uploads/delete/'.$filename);
                    //dd($url);

                    $fileuploads[]=['name'=>$filename,'size'=>2343456,'url'=>$url,'thumbnailUrl'=>$url,'deleteUrl'=>$deleteurl,'deleteType'=>'DELETE','id'=>$upload->id];

                }
                return response()->json(['files'=>$fileuploads]);
                exit;
            }
        
    }

    public static function fetchFiles()
    {
        $images=Upload::where('user_id',Auth::user()->id)->orderBy('id','DESC')->take(21)->get();
        return json_encode($images);
    }

    public function mediaIndex()
    {
        $data['images']=Upload::take(21)->get();

        return view('images.list',$data);
    }
    public function deleteImage($id)
    {
        $image=Upload::find($id);
        if($image)
        {            
            File::delete('uploads/'.$image->filename);
            $image->delete();
        }
    }
}
