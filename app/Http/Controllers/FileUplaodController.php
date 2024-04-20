<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FileSystem;



class FileUplaodController extends Controller
{
    public function create(Request $request){

        if($request->isMethod('post')){
            $alidation = $request->validate([

                'title' => 'nullable',
                'thumbnail' => 'mimes:jpeg,png, pdf, docx, zip, jpg,gif', 
            ]);

            $data = new FileUpload;
            $data->title = $request->title;
            $data->save();

            if($request->hasFile('thumbnail')){
                $image = $request->file('thumbnail');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $path = $request->file('thumbnail')->move('uploads', $imageName);
                $data->thumbnail = $imageName;
                $data->save();
            }

            if($request->hasFile("images")){
                $files = $request->file("images");
                foreach($files as $file){
                    $imageName = time().'_'.$file->getClientOriginalName();
                    $request['image'] = $imageName; // Assuming you use 'image' field to store image names
                    $file->move(public_path("/images"), $imageName);
            
                    // Create a new File instance
                    $newFile = new File();
                    $newFile->images = $imageName; 
                    $newFile->file_id = $data->id; 
                    $newFile->save(); 
                }
            }
            
            return redirect('/uploads/list')->with('success', 'Data Added Successfully');
            

        
    }
    return view('uploads.create');
}

        public function list(){
            // Fetch all files
            $files = FileUpload::all();
            // dd($files);

            // Iterate through each file and fetch associated images
            foreach ($files as $file) {
            
                $file->images = File::where('file_id', $file->id)->get();
                // dd($files);
            }

            return view('/uploads/list', ['files' => $files]);
        }


    public function edit($id){
        $data = FileUpload::findOrFail($id);

        $image = File::where('file_id', $data->id)->get();
        return view('uploads.edit', ['data' => $data, 'image' =>$image]);

    }

    public function update(Request $request, $id){
        $data = FileUpload::findOrFail($id);

        if($request->hasFile('thumbnail')){
            if(FileSystem::exists("uploads/".$data->thumbnail)){
                FileSystem::delete("uploads/".$data->thumbnail);
            }
            $image = $request->file('thumbnail');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $path = $request->file('thumbnail')->move('uploads', $imageName);
            $data->thumbnail = $imageName;
        }

        $data->update([
           'title' => $request->title,
           'thumbnail' => $data->thumbnail,
        ]);


        if($request->hasFile("images")){
            $files = $request->file("images");
            foreach($files as $file){
                $imageName = time().'_'.$file->getClientOriginalName();
                $request['image'] = $imageName; // Assuming you use 'image' field to store image names
                $file->move(public_path("/images"), $imageName);
        
                // Create a new File instance
                $newFile = new File();
                $newFile->images = $imageName; 
                $newFile->file_id = $data->id; 
                $newFile->save(); 
            }
        }
        return redirect('/uploads/list')->with('success', 'Data Updated Successfully');

    }

    public function destroy($id){
        $data = FileUpload::findOrFail($id);

        if(FileSystem::exists("uploads/".$data->thumbnail)){
            FileSystem::delete("uploads/".$data->thumbnail);
        }
        $images = File::where('file_id', $data->id)->get();
        foreach($images as $image){
            if(FileSystem::exists("images/".$image->images)){
                FileSystem::delete("images/".$image->images);
            } 
        }
        $data->delete();
        return back()->with('success', 'Data Deleted Successfully');

    }

    public function deleteimage($id){
        $data = File::findOrFail($id);
        if(FileSystem::exists("images/".$data->images)){
            FileSystem::delete("images/".$data->images);
        }
        File::find($id)->delete();
        return back()->with('success', 'Data Deleted Successfully');

    }
}
