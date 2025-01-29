@extends('adminlayout.base')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin_category') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="{{ route('edit_category_item', $category->id) }}" method="POST" id="editCategoryForm" name="editCategoryForm">
        @csrf
        <div class="card">
            <div class="card-body">								
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category_name">Name</label>
                            <input type="text" name="category_name" id="category_name" value="{{ $category->name }}"
                            class="form-control" placeholder="Category Name">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option {{ ($category->status=='')? 'selected' : ''}} value="">Select</option>
                                <option {{ ($category->status==1)? 'selected' : ''}} value="1">Active</option>
                                <option {{ ($category->status==0)? 'selected' : ''}} value="0">Inactive</option>
                            </select>	
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-6">
                            <input type="hidden" id="image_id" name="image_id" value="">
                            <label for="image">Upload Image</label>
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">    
                                    <br>Drop files here or click to upload.<br><br>                                           
                                </div>
                            </div>
                        </div>
                        @if(!empty($category->image))
                        <div class="mb-6">
                            <img width="100%" height="100%" src="{{ asset('public/uploads/category/'.$category->image)}}" alt="">
                        </div>
                        @endif
                    </div>									
                </div>
            </div>							
        </div>
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="brands.html" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')
<script>

    $("#editCategoryForm").submit(function(event){

        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);

        $.ajax({
            url:'{{ route("edit_category_item", $category->id) }}',
            type: 'PUT',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){

                $("button[type=submit]").prop('disabled', false);

                if(response.status){

                    $("#category_name").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");
                    // Optionally, show a success message
                    alert("Category Updated.");
                    // Reset or redirect, if needed
                    window.location.href = "{{ route('admin_category') }}";

                }else{

                    if(response['notFound'] == true){
                        window.location.href = "{{ route('admin_category') }}";
                    }

                    var errors = response.errors;

                    if(errors.category_name){
                        $("#category_name").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors.category_name);
                    }else{
                        $("#category_name").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                    }
                }
            }, error: function(jqXHR, textStatus, errorThrown){

                $("button[type=submit]").prop('disabled', false);
                console.log("Error:", textStatus, errorThrown);
                alert("Something went wrong. Please try again.");

            }
        });
    });

    Dropzone.autoDiscover = false;    
    const dropzone = $("#image").dropzone({ 

        init: function() {
            this.on('addedfile', function(file) {
                if (this.files.length > 1) {
                    this.removeFile(this.files[0]);
                }
            });
        },

        url:  "{{ route('add_category_image') }}",
        maxFiles: 1,
        paramName: 'image',
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif",

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }, success: function(file, response){
            $("#image_id").val(response.image_id);
            //console.log(response)
        }
    });

</script>
@endsection