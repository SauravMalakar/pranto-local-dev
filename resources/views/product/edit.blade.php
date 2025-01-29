@extends('adminlayout.base')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Product</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('admin_product')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <form action="{{ route('edit_product_item', $product->id) }}" method="POST" id="editProductForm" name="editProductForm">
        @csrf
        @method('PUT')
        <!-- Default box -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">								
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Title</label>
                                        <input type="text" value="{{ $product->title }}" name="title" id="title" class="form-control" placeholder="Title">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description">
                                            {{ $product->description }}
                                        </textarea>
                                    </div>
                                </div>
                                <p class="error"></p>                                            
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Media</h2>								
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">    
                                    <br>Drop files here or click to upload.<br><br>                                            
                                </div>
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="row" id="product-gallery">
                        @if($productImages->isNotEmpty())
                            @foreach($productImages as $image)
                                <div class="col-md-3" id="image-row-{{ $image->id }}">
                                    <div class="card">
                                        <input type="hidden" name="image_array[]" value="{{ $image->id }}">
                                        <img src="{{ asset('public/uploads/product/small/'.$image->image) }}" class="card-img-top" alt="">
                                        <div class="card-body">
                                            <a href="javascript:void(0)" onclick="deleteImage({{ $image->id }})" class="btn btn-danger">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Pricing</h2>								
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="price">Price</label>
                                        <input type="text" value="{{ $product->price }}" name="price" id="price" class="form-control" placeholder="Price">
                                        <p class="error"></p>	
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="compare_price">Compare at Price</label>
                                        <input type="text" value="{{ $product->compare_price }}" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price">
                                        <p class="error"></p>
                                        <p class="text-muted mt-3">
                                            To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                        </p>	
                                    </div>
                                </div>                                            
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Inventory</h2>								
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                        <input type="text" value="{{ $product->sku }}" name="sku" id="sku" class="form-control" placeholder="sku" disabled>	
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" value="{{ $product->barcode }}" name="barcode" id="barcode" class="form-control" placeholder="Barcode">	
                                        <p class="error"></p>
                                    </div>
                                </div>   
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="hidden" name="track_qty" value="No">
                                            <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="Yes" 
                                            {{ ($product->track_qty == 'Yes') ? 'checked' : ''}}>
                                            <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="number" min="0" value="{{ $product->qty }}" name="qty" id="qty" class="form-control" placeholder="Qty">	
                                    </div>
                                </div>                                         
                            </div>
                        </div>	                                                                      
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Product status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option {{ ($product->status=='')? 'selected' : ''}} value="">Select</option>
                                    <option {{ ($product->status=='1')? 'selected' : ''}} value="1">Active</option>
                                    <option {{ ($product->status=='0')? 'selected' : ''}} value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="card">
                        <div class="card-body">	
                            <h2 class="h4  mb-3">Product Class</h2>
                            <div class="mb-3">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select</option>
                                    @if($category->isNotEmpty())
                                        @foreach ($category as $categoryitem)
                                            <option {{ ($product->category_id == $categoryitem->id) ? 'selected' : '' }} 
                                                value="{{ $categoryitem->id }}">{{ $categoryitem->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="sub_category">Sub category</label>
                                <select name="sub_category" id="sub_category" class="form-control">
                                    @if($subcategory->isNotEmpty())
                                        @foreach ($subcategory as $subcategoryitem)
                                            <option {{ ($product->sub_category_id == $subcategoryitem->id) ? 'selected' : '' }} 
                                                value="{{ $subcategoryitem->id }}">{{ $subcategoryitem->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Measurement</h2>
                            <div class="mb-3">
                                <select name="uom" id="uom" class="form-control">
                                    <option value="">Select</option>
                                    @if($uoms->isNotEmpty())
                                        @foreach ($uoms as $uom)
                                            <option {{ ($product->uom_id == $uom->id) ? 'selected' : '' }} 
                                                value="{{ $uom->id }}">{{ $uom->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Featured product</h2>
                            <div class="mb-3">
                                <select name="is_featured" id="is_featured" class="form-control">
                                    <option {{ ($product->is_featured=='No')? 'selected' : ''}} value="No">No</option>
                                    <option {{ ($product->is_featured=='Yes')? 'selected' : ''}} value="Yes">Yes</option>                                                
                                </select>
                            </div>
                        </div>
                    </div>                                 
                </div>
            </div>
            
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route("admin_product") }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </div>
        <!-- /.card -->
    </form>

</section>
<!-- /.content -->
@endsection

@section('customJs')
<script>
    $("#editProductForm").submit(function(event){

    event.preventDefault();
    var element = $(this);
    $("button[type=submit]").prop('disabled', true);

        $.ajax({
            url:'{{ route('edit_product_item', $product->id) }}',
            type: 'PUT',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){

                $("button[type=submit]").prop('disabled', false);

                if(response.status){

                    $("#title").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");
                    // Optionally, show a success message
                    alert("Product updated.");
                    // Reset or redirect, if needed
                    window.location.href = "{{ route('admin_product') }}";

                }else{
                    var errors = response.errors;

                    // if(errors.title){
                    //     $("#title").addClass('is-invalid')
                    //     .siblings('p')
                    //     .addClass('invalid-feedback').html(errors.title);
                    // }else{
                    //     $("#title").removeClass('is-invalid')
                    //     .siblings('p')
                    //     .removeClass('invalid-feedback').html("");
                    // }
                    $(".error").removeClass('invalid-feedback').html('');

                    $("input[type=text], select, input[type=number]").removeClass('is-invalid');

                    $.each(errors, function(key, value){
                        $('#${key}').addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(value);
                    });


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

    // init: function() {
    //     this.on('addedfile', function(file) {
    //         if (this.files.length > 1) {
    //             this.removeFile(this.files[0]);
    //         }
    //     });
    // },

    url:  "{{ route('edit_product_image') }}",
    maxFiles: 5,
    paramName: 'image',
    params: {'product_id': '{{ $product->id }}'},
    addRemoveLinks: true,
    acceptedFiles: "image/jpeg,image/png,image/gif",

    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }, success: function(file, response){
        $("#image_id").val(response.image_id);
        //console.log(response);

        const html = `
            <div class="col-md-3" id="image-row-${response.image_id}">
                <div class="card">
                    <input type="hidden" name="image_array[]" value="${response.image_id}">
                    <img src="${response.ImagePath}" class="card-img-top" alt="">
                    <div class="card-body">
                        <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="btn btn-danger">Remove</a>
                    </div>
                </div>
            </div>`;
        $("#product-gallery").append(html);
        },
        complete: function(file){
            this.removeFile(file);
        }
    });

    function deleteImage(id){
        
        if (confirm("Are you sure to remove the image?")) {
            $.ajax({
                url: '{{ route("delete_product_image") }}',
                type: 'DELETE',
                data: { id: id },
                success: function(response) {
                    if (response.status) {
                        alert(response.message);
                        document.getElementById(`image-row-${id}`).remove();
                        // $("#image-row-"+id).remove();
                    }else{
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    alert('An error occurred while deleting the image: ' + error);
                }
            });
        }
        
    }

    $("#category").change(function() {
    var category_id = $(this).val();
    var subCategoryDropdown = $("#sub_category");

    subCategoryDropdown.empty();
    subCategoryDropdown.append('<option>Loading...</option>');

    if (!category_id) {
        subCategoryDropdown.html('<option value="">Select Subcategory</option>');
        return;
    }

    $.ajax({
        url: '{{ route("get_product_subcategories") }}',
        type: 'GET',
        data: { category_id: category_id },
        dataType: 'json',
        success: function(response) {
            subCategoryDropdown.empty();
            if (response.subcategories.length > 0) {
                subCategoryDropdown.append('<option value="">Select Subcategory</option>');
                $.each(response.subcategories, function(index, subcategory) {
                    subCategoryDropdown.append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                    });
                } else {
                    subCategoryDropdown.append('<option value="">No Subcategories Available</option>');
                }
            },
            error: function(xhr, status, error) {
                alert('Failed to load subcategories. Please try again later.');
            }
        });
    });


</script>
@endsection