
@extends('layout')
     
@section('content')

<style>
    img{
        width: 100px;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
              <!-- <h2>Laravel CRUD (create read update and delete) With Multiple Image Upload</h2> -->
            </div>
            <div class="card-body">
                <a href="{{ url('/post/add') }}" class="btn btn-success btn-sm" title="Add New Post">Add New Post</a>
                <br/><br/>
                <div class="table-responsive">
                <!-- <h2>Blog Post List</h2> -->
                <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Multiple Images</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td><img src="/covers/{{ $post->cover }}"></td>
                    <td>
            @foreach($post->photos as $photo)
                    <img src="/photos/{{ $photo->photo }}">
                @endforeach
            </td>
                    <td>
                        <a href="/post/edit/{{ $post->id }}" class="btn btn-outline-primary">Edit</a></td>
                        <td>
                        <form action="/delete/{{ $post->id }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-outline-danger" onclick="return confirm('Are you sure?');" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
              </div>  
            </div>                  
        </div>
    </div>                        
</div>
@endsection