@extends('adminlayout.base')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Unit of Measurement</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin_uom') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="{{ route('add_uom_item') }}" method="POST" name="uomForm" id="uomForm">
            @csrf
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name">Measurement Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                <p class="error"></p>
                            </div>
                        </div>									
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('admin_uom') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->

@endsection

@section('customJs')
<script>

    $("#uomForm").submit(function(event){

        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);

        $.ajax({
            url:'{{ route("add_uom_item"); }}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){

                $("button[type=submit]").prop('disabled', false);

                if(response.status){

                    $("#name").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");
                    // Optionally, show a success message
                    alert("UOM added.");
                    // Reset or redirect, if needed
                    window.location.href = "{{ route('admin_uom') }}";

                }else{
                    var errors = response.errors;

                    $(".error").removeClass('invalid-feedback').html('');
                    $("input").removeClass('is-invalid');

                    $.each(errors, function(key, value) {
                        $(`#${key}`).addClass('is-invalid')
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

</script>
@endsection