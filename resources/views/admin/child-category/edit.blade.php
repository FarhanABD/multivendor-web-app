@extends('admin.layouts.master')

@section('content')
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{ route('admin.child-category.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Child Category</h1>
      </div>

      <div class="section-body">
       
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4>Edit Child Category</h4>
              </div>
              <div class="card-body">
                <form action="{{ route('admin.child-category.update', $childCategory->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label for="inputState">Category</label>
                    <select id="inputState" name="category" class="form-control">
                        <option value="" >Select</option>
                        @foreach ( $categories as $category )
                        <option {{ $category->id == $childCategory->category_id ? 'selected' : '' }} value="{{ $category->id }}" >{{ $category->name }}</option>
                        @endforeach
                       
                    </select>
                  </div>

                <div class="form-group">
                  <label for="inputState">Sub Category</label>
                  <select id="inputState" name="sub_category" class="form-control sub-category">
                    @foreach ( $subCategories as $subcategory ) 
                    <option {{ $subcategory->id == $childCategory->sub_category_id ? 'selected' : '' }} value="{{ $subcategory->id }}" >{{ $subcategory->name }}</option>
                    @endforeach  
                  </select>
                </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" value="{{ $childCategory->name }}" name="name" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="inputState">Status</label>
                        <select id="inputState" name="status" class="form-control">
                            <option {{ $childCategory->status == 1 ? 'selected' : '' }} value="1" >Active</option>
                            <option {{ $childCategory->status == 0 ? 'selected' : '' }} value="0" >Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"> Update </button>
                </form>
              </div>

            </div>
          </div>
        </div>

      </div>
    </section>
@endsection

@push('scripts')
  <script>
    $(document).ready(function() {
      $('body').on('change', '.main-category', function(e) {
        let id = $(this).val();
        $.ajax({
          method: 'PUT',
          url: "{{ route('admin.get-subcategories') }}",
          data: {
            id:id
          },
          success: function(data) {
            console.log(data);
            $('.sub-category').html(' <option value="" >Select</option>');
            $.each(data, function(i, item) {
              $('.sub-category').append(`<option value="${item.id}">${item.name}</option>`)
            })
          },
          error: function(xhr, status, error){
            console.log(error)
          }
        })
        
    })
  })
  </script>
@endpush

