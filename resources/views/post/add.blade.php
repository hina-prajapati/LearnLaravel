@extends('layout')
     
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
              <h2>Add New Post</h2>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="title" class="form-control m-2" placeholder="title">
                    <!-- <input type="text" name="author" class="form-control m-2" placeholder="author"> -->
                    <!-- <Textarea name="body" cols="20" rows="4" class="form-control m-2" placeholder="body"></Textarea> -->
                    <label class="m-2">Cover Image</label>
                    <input type="file" id="input-file-now-custom-3" class="form-control m-2" name="cover">
 
                    <label class="m-2">Images</label>
                    <input type="file" id="input-file-now-custom-3" class="form-control m-2" name="photo[]" multiple>
 
                    <button type="submit" class="btn btn-success mt-3 ">Submit</button>
                </form>
            </div>                  
        </div>
    </div>                        
</div>
@endsection