@extends('admin.layouts.master')

@section('content')
    <section class="section">
      <div class="section-header">
        <h1>Category</h1>
       
      </div>

      <div class="section-body">
       
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4>Create Category</h4>
              
              </div>
              <div class="card-body">
                <form action="">
                    <div class="form-group">
                        <label>Icon</label>
                      <div>
                        <button class="btn btn-primary" data-selected-class="btn-success" data-unselected-class="btn-info" role="iconpicker"></button>
                      </div>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" value="" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputState">Status</label>
                        <select id="inputState" name="status" class="form-control">
                            <option value="1" >Active</option>
                            <option value="0" >Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"> Create </button>
                </form>
              </div>

            </div>
          </div>
        </div>

      </div>
    </section>
@endsection

