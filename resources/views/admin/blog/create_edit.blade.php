@extends('layouts.admin')
@section('content')


    <div class="col-md-12">
        <!-- general form elements disabled -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title text-uppercase">{{$action." ".$title}}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="post" action="{{$route}}@if(isset($data)){{"/".$data->id }}@endif"
                      enctype="multipart/form-data">
                    @csrf
                    @if(isset($data))
                        @method("PUT")
                    @endif

                    <div class="form-group">
                        <label>Title</label>
                        @error('title')
                        <p class="text-danger" role="alert">
                            <i class="far fa-times-circle"></i>
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Title ..." value="{{ $data->title ?? old('title')}}">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        @error('description')
                        <p class="text-danger" role="alert">
                            <i class="far fa-times-circle"></i>
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="10" placeholder="Description ..."
                                  style="resize: none">{{ $data->description ?? old('description')}}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        @error('link')
                        <p class="text-danger" role="alert">
                            <i class="far fa-times-circle"></i>
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                        <div class="custom-file">
                            <input type="file" name="image" id="customFile"
                                   class="custom-file-input @error('image') is-invalid @enderror">
                            <label class="custom-file-label" for="customFile">Choose Image</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary col-md-12">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <script src="{{asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script !src="">
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@endpush
