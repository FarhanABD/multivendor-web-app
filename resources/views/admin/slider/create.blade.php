@extends('admin.layouts.master')

@section('content')
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{ route('admin.slider.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Slider</h1>
      </div>

      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4>Create Slider</h4>
              </div>
              <div class="card-body">
                <form action="{{route('admin.slider.store')}}" method="POST" enctype="multipart/form-data">
                  @csrf

                    <div class="form-group">
                        <label>Banner</label>
                        <input type="file" name="banner" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Type</label>
                        <input type="text" value="{{old('type')}}" name="type" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" value="{{old('title')}}" name="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Starting Price</label>
                        <input type="text" name="starting_price" value="{{old('starting_price')}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Button URL </label>
                        <input type="text" name="btn_url" class="form-control" value="{{old('btn_url')}}">
                    </div>
                    <div class="form-group">
                        <label>Serial </label>
                        <input type="text" name="serial" class="form-control" value="{{old('serial')}}">
                    </div>
                    <div class="form-group">
                        <label for="inputState">Status</label>
                        <select id="inputState" name="status" class="form-control">
                            <option value="1" >Active</option>
                            <option value="0" >Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
@endsection