@extends('Backend.layouts.app', ['title' => __('FAQ')])

@section('content')

<div class="header bg-primary pb-6 pt-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('faq-create') }}" class="btn btn-sm btn-neutral">Add New Question</a>
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
                    <h3 class="mb-0">FAQ</h3>
                </div>
                <div class="card-body">
                    <!-- Light table -->
                    <div class="table-responsive back_faq_table">
                        <table class="table align-items-center table-flush yajra-datatable" id="faq-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Category</th>
                                    <th scope="col" class="back_quesion_clm">Question</th>
                                    <th scope="col" class="back_answer_clm">Answer</th>
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

    @include('Backend.layouts.footers.auth')
</div>
@endsection

@section('extra-js')
<script type="text/javascript">
    $('#faq-datatable').DataTable({
        ajax: {
            type: 'POST',
            url: "{{ route('getFaq-datatable')}}"
        },
        processing: true,
        serverSide: true,
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'ques_category_id',
                name: 'Category'
            },
            {
                data: 'question',
                name: 'Name'
            },
            {
                data: 'answer',
                name: 'Answer'
            },
            {
                data: 'status',
                name: 'Status'
            },
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            }
        ]
    });

    $(document).on('click', '.delete', function() {
        var href = $(this).data('href');
        swal({
                title: "",
                text: "Are you sure? Delete this Question!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true
            },
            function() {
                location.href = href;
            });
    });

    $(document).on('click', '.statusUpdateQuestion', function() {
        var _this = $(this);
        let status = $(this).data('status');
        const id = $(this).data('id');
        let isFor = "";
        if (_this.hasClass('approve-status') || (_this.hasClass('active-inactive') && _this.is(":checked"))) {
            status = 1;
            isFor = 'Active';
        } else {
            status = 2;
            isFor = 'Inactive';
        }
        swal({
                title: "",
                text: "Are you sure? " + isFor + " this Question!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, " + isFor + " it!",
                closeOnConfirm: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "post",
                        url: "{{route('question-status-update')}}",
                        data: {
                            id: id,
                            status: status,
                        },
                        success: function(data) {
                            if (data.success) {
                                if (data.status == 1) {
                                    $(_this).parents('tr').find('.active-inactive').prop('checked', true);
                                    $(_this).parents('tr').find('.question-badge').removeClass('badge-danger').addClass('badge-success');
                                    $(_this).parents('tr').find('.question-badge').text('Active');
                                } else {
                                    $(_this).parents('tr').find('.active-inactive').prop('checked', false);
                                    $(_this).parents('tr').find('.question-badge').removeClass('badge-success').addClass('badge-danger');
                                    $(_this).parents('tr').find('.question-badge').text('In-Active');
                                }
                            }
                        }
                    });
                } else {
                    if (_this.hasClass('active-inactive') && _this.is(":checked")) {
                        $(_this).parents('tr').find('.active-inactive').prop('checked', false);
                    } else {
                        $(_this).parents('tr').find('.active-inactive').prop('checked', true);
                    }
                }
            });
    });
</script>
@endsection