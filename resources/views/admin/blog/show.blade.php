@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">

                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <a class="btn btn-outline-secondary" href="{{$route}}">Return Blog Page</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="col-12">
                                <img src='{{asset("uploads/$data->image")}}' class="product-image" alt="{{$data->title}}">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <h3 class="my-3">Description</h3>
                            <span class="my-5">{{$data->created_at}}</span>
                            <p>{{$data->description}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
