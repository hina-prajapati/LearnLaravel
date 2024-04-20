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
              <h2>Add New Post</h2>
            </div>
            <div class="card-body">
                <form action="/update/{{ $data->id }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    @method("put")
                    <input type="text" name="title" class="form-control m-2" placeholder="title" value="{{ $data->title }}">
                
                    <!-- <input type="text" name="author" class="form-control m-2" placeholder="author"> -->
                    <!-- <Textarea name="body" cols="20" rows="4" class="form-control m-2" placeholder="body"></Textarea> -->

                    <input type="file" id="input-file-now-custom-3" class="form-control m-2" name="thumbnail" >
                    <img src="/uploads/<?=$data['thumbnail']?>">


                    <label class="m-2">Images</label>
                    <input type="file" id="input-file-now-custom-3" class="form-control m-2" name="images[]" multiple>
                   
                    <br><br>
                    <button type="submit" class="btn btn-success mt-3 ">Submit</button>
                    </form>
                    <br><br>
                    @foreach($image as $val)
                      <div class="d-flex dsasdgfd">
                      <!-- <img src="/images/{{ $val->images }} "> -->
                      <a href="/images/{{ $val->images }}" target="_blank">{{ $val->images }}</a><br>
                <form action="/deleteimage/{{ $val->id }}" method="post">
                 <button class="btn text-danger">X</button>
                 @csrf
                 @method('delete')
                </form>
                @endforeach
                </div>
            </div>                  
        </div>
    </div>                        
</div>
@endsection