
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
                <a href="{{ url('/uploads/create') }}" class="btn btn-success btn-sm" title="Add New Post">Add New Post</a>
                <br/><br/>
                <div class="table-responsive">
                <h2>Blog Post List</h2>
                <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Multiple Images</th>
                    <th>Action</th>
                </tr>
            </thead>
                <tbody>
                    @foreach($files as $val)
                    <tr>
                        <td>{{ $val->id }}</td>
                        <td>{{ $val->title }}</td>
                        <td><img src="/uploads/{{ $val->thumbnail }}" alt="Image"></td>
                        
                        <!-- <td>
                        @foreach ($val->images as $image)
                            <img src="/images/{{ $image->images }}" alt="Image" width="50">
                        @endforeach          
                    </td> -->
                    <td>
                    @foreach ($val->images as $image)
                        @if (strpos($image->images, '.') !== false)
                            <?php $extension = pathinfo($image->images, PATHINFO_EXTENSION); ?>
                            @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                <img src="/images/{{ $image->images }}" alt="Image" width="50">
                            @elseif (in_array($extension, ['pdf', 'docx', 'zip']))
                                <a href="/images/{{ $image->images }}" target="_blank">{{ $image->images }}</a><br>
                            @else
                                <!-- Handle other file types or unknown types -->
                                <span>{{ $image->images }}</span><br>
                            @endif
                        @endif
                    @endforeach
                </td>

                        <td>
                            <a href="/uploads/edit/{{ $val->id }}" class="btn btn-outline-primary">Edit</a>
                            <form action="/delete/{{ $val->id }}" method="post" style="display: inline;">
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