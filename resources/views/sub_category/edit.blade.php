@extends('adminlayout.base')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Sub Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin_sub_category') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form action="{{ route('edit_sub_category_item', $subcategory->id) }}" method="POST" name="editSubCategoryForm" id="editSubCategoryForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="_method" value="PUT">
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name">Sub Category Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $subcategory->name }}">
                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    @if($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ ($subcategory->category_id == $category->id) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">Category not found!</option>
                                    @endif
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Select</option>
                                    <option value="1" {{ ($subcategory->status == 1) ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ ($subcategory->status == 0) ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>									
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin_sub_category') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
    </div>
</section>

@endsection

@section('customJs')
<script>
$("#editSubCategoryForm").submit(function(event) {
    event.preventDefault();
    var element = $(this);
    $("button[type=submit]").prop('disabled', true);

    $.ajax({
        url: '{{ route("edit_sub_category_item", $subcategory->id) }}',
        type: 'PUT',
        data: element.serializeArray(),
        dataType: 'json',
        success: function(response) {
            $("button[type=submit]").prop('disabled', false);

            if (response.status) {
                alert("Sub-category Updated.");
                window.location.href = "{{ route('admin_sub_category') }}";
            } else {
                if (response.errors) {
                    if (response.errors.name) {
                        $("#name").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(response.errors.name);
                    } else {
                        $("#name").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html("");
                    }
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $("button[type=submit]").prop('disabled', false);
            alert("Something went wrong. Please try again.");
        }
    });
});
</script>
@endsection
