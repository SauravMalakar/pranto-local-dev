@extends('adminlayout.base')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Unit of Measurement</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('add_uom')}}" class="btn btn-primary">New UoM</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        @include('message')
        <form action="" method="GET">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <div class="input-group input-group" style="width: 250px;">
                            <input type="text" name="keywords" class="form-control float-right" placeholder="Search">
        
                            <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">								
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">Sl.</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($uoms->isNotEmpty())
                                @foreach ($uoms as $uom)

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $uom->name }}</td>

                                        <td>
                                            <a href="#" onclick="deleteUom({{ $uom->id }})" class="text-danger w-4 h-4 mr-1">
                                                <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </a>
                                        </td>

                                    </tr>

                                @endforeach
                            @else
                                    <tr>
                                        <td colspan="3"><p style="text-align: center;">Nothing to show!</p></td>
                                    </tr>
                            @endif
                        </tbody>
                    </table>										
                </div>
                <div class="card-footer clearfix">
                    <ul class="pagination pagination m-0 float-right">
                        {{$uoms->links()}}
                    </ul>
                </div>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')
<script>
    function deleteuom(id){

        var url= '{{ route("delete_uom", "id") }}';

        var newUrl = url.replace("id", id);

        if(confirm('Are you sure you want to delete?')){

            $.ajax({
                url: newUrl,
                type: 'DELETE',
                data: {},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){

                    if(response.status){

                        // Reset or redirect, if needed
                        window.location.href = "{{ route('admin_uom') }}";

                    }else{
                        alert('Failed to delete the UoM.');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle any AJAX errors (e.g., server error, network issues)
                    alert('An error occurred while trying to delete the UoM.');
                }
            });

        }

    }
</script>
@endsection