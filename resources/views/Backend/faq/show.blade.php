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
                                <li class="breadcrumb-item"><a href="{{ route('faq-question') }}">FAQ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Show</li>
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
                        <div class="row">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th><b>Question Category</b></th>
                                    <td>{{$ques_categories[$question->ques_category_id]['name']}}</td>
                                </tr>
                                <tr>
                                    <th><b>Question</b></th>
                                    <td>
                                     {{$question->question}}
                                    </td>
                                </tr>

                                <tr>
                                    <th><b>Answer</b></th>
                                    <td>
                                     {{$question->answer}}
                                    </td>
                                </tr>

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

@endsection
