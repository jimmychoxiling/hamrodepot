@extends('Backend.layouts.app', ['title' => __('Service-Category')])
@section('extra-css')
<link href="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection
@section('content')
@php
$title = "Category";
@endphp
<div class="header bg-primary pb-6 pt-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Services</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('services-create') }}" class="btn btn-sm btn-neutral">Add New Services</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <h3 class="mb-0">Services</h3>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush yajra-datatable" id="service-category-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('extra-js')
<script src="{{ asset('assets/js/dataTables.min.js')}}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
<script type="text/javascript">
    var categoryTable =  $('#service-category-datatable').DataTable({
        ajax: {
            type: 'POST',
            url: "{{ route('getServiceCategory-datatable')}}",
        },
        language: {
            paginate: {
                next: '<i class="fas fa-chevron-right">' , 
                previous: '<i class="fas fa-chevron-left">'  
            }
        },
        processing: true,
        serverSide: true,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'Name'},
            {data: 'status', name: 'Status'},
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            }
        ]
    });
    $(document).on('click', '.category-status', function (e) {
        var _this = $(this);
        if(!_this.hasClass('no-call')){
            var id = _this.attr('id'); 
            var categoryName = "";
            if(_this.hasClass('approve-reject')){
                var status = _this.attr('data-status'); 
                var title = $(this).attr('title');
                categoryName = $(this).attr('data-name');
            } else {
                var status = _this.prop('checked') == true ? 1 : 2; 
                var title = _this.prop('checked') == true ? 'Active' : 'InActive';
            }
            swal({
                title: 'Are you sure you want to '+title+' this category?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                allowOutsideClick: false,
            }).then(function (confirm) {
                if(confirm.value !== "undefined" && confirm.value){
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        dataType: "json",
                        url: "{{ route('service.category.change-status') }}",
                        data: {'status': status, 'id': id, 'type':'approve-reject'},
                        success: function(data){
                            if(data.success === true){
                                swal({
                                    title: data.message,
                                    confirmButtonColor: "#66BB6A",
                                    type: "success",
                                    confirmButtonText: 'OK',
                                    confirmButtonClass: 'btn btn-success',
                                }).then(function (){
                                    $(_this).parents('td').find('.before-active').hide();
                                    if(data.status != 3){
                                        $(_this).parents('td').find('.after-active').show();
                                    }
                                    $(_this).parents('tr').find('.status').text(data.statusText);
                                    if(data.status == 1){
                                        $(_this).parents('tr').find('.status').removeClass('badge-info badge-danger').addClass('badge-success');
                                        $(_this).parents('td').find('.active-inactive').prop('checked',true);
                                    } else if(data.status == 2 || data.status == 3){
                                        $(_this).parents('tr').find('.status').removeClass('badge-success').addClass('badge-danger');
                                    }
                                    $(_this).parents('tr').find('.changed-request').remove();
                                    if(categoryName != ""){
                                        $(_this).parents('tr').find('.category-name').text(categoryName);
                                    }
                                });
                            } else {
                                swal({
                                    title: data.message,
                                    confirmButtonColor: "#ef5350",
                                    type: "error",
                                    confirmButtonText: 'OK',
                                    confirmButtonClass: 'btn btn-danger',
                                }).then(function (){
                                    
                                });
                            }
                        }
                    });
                }else{
                    $('.check').css("background-color", "#fff");
                    _this.addClass('no-call');
                    _this.trigger('click');
                }
            });
        } else {
            _this.removeClass('no-call');
        }
    });
</script>
@endsection