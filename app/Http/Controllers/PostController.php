<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FileSystem;

class PostController extends Controller
{
    public function add(Request $request){

        if($request->isMethod('post')){
            $validator = $request->validate([
                'title' => 'nullable',
                'cover' => 'mimes:jpeg,jpg,png,gif' // max 10000kb
            ]);

            $posts = new Post;
            $posts->title = $request->title;
            $posts->save();

            if($request->hasFile('cover')){
                $image = $request->file('cover');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $path = $request->file('cover')->move("covers", $imageName);
                $posts->cover = $imageName;
                $posts->save();
            }

            if($request->hasFile("photo")){
                $files = $request->file('photo');
                foreach($files as $file){
                    $imageName = time().'.'.$file->getClientOriginalExtension();
                   $request['photo'] = $imageName;
                   $file->move(public_path("photos"), $imageName);

                   $newfile = new Photo;
                   $newfile->photo = $imageName;
                   $newfile->post_id = $posts->id;
                //    dd($newfile);
                   $newfile->save();
                }

            }
            return redirect('/post/list')->with('success', 'Data Added Successfully');
            
        }
        return view('post.add');
    }

    public function list(){
        $posts = Post::all();
        $photos = Post::with('photos')->get(); 
        return view('post.list', ['posts' => $posts, 'photos' =>$photos]);
    }

    public function edit($id){
        $posts = Post::findOrFail($id);
        $photos = Photo::where('post_id', $posts->id)->get();
        return view('post.edit', ['posts' => $posts, 'photos' => $photos]);
    }


    public function update(Request $request, $id){

        $posts = Post::findOrFail($id);

        if($request->hasFile('cover')){
            if(FileSystem::exists("covers/".$posts->cover)){
               FileSystem::delete("covers/".$posts->cover);
            }
            $image = $request->file('cover');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $path = $request->file('cover')->move("covers", $imageName);
            $posts->cover = $imageName;
        }
        
            $posts->update([
                'title' => $request->title,
                'cover' => $posts->cover,

            ]);

            if($request->hasFile("photo")){
                $files = $request->file('photo');
                foreach($files as $file){
                    $imageName = time().'.'.$file->getClientOriginalExtension();
                   $request['photo'] = $imageName;
                   $file->move(public_path("photos"), $imageName);

                   $newfile = new Photo;
                   $newfile->photo = $imageName;
                   $newfile->post_id = $posts->id;
                //    dd($newfile);
                   $newfile->save();
                }

            }

        
        return redirect('/post/list')->with('success', 'Data Updated Successfully');

    }

    public function destroy($id){
        $posts = Post::findOrFail($id);
        if(FileSystem::exists("covers/".$posts->cover)){
            FileSystem::delete("covers/".$posts->cover);
        }
        $posts->delete();
        return redirect('/post/list')->with('success', 'Data Deleted Successfully');

    }

    public function deleteimage($id){
        $data = Photo::findOrFail($id);
        if(FileSystem::exists("photos/".$data->photo)){
            FileSystem::delete("photos/".$data->photo);
        }
        Photo::find($id)->delete();
        return back()->with('success', 'Data Deleted Successfully');

    }
}
