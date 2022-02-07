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
                            <li class="breadcrumb-item"><a href="{{ route('faq-question') }}">Faq</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Question</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">{{$faq->id ? 'Update' : 'Add'}} Question</h3>
                    </div>
                </div>
                <div class="card-body">
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
                    <form method="post" action="{{ route($url, $faq->id ?['id' => $faq->id]: []) }}" autocomplete="off" data-parsley-validate="">
                        @csrf
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-ques_category">Question Categories</label>
                                        <select name="ques_category_id" class="form-control form-control-alternative" required data-parsley-required-message="Question Category is required">
                                            <option value="">Select question category
                                            </option>
                                            @foreach($ques_categories as $category)
                                            <option value="{{$category['id']}}" {{(old('ques_category_id', $faq->ques_category_id) == $category['id'] ? 'selected':'')}}>{{$category['name']}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-status">Status</label>
                                        <select name="status" class="form-control form-control-alternative">
                                            <option value="">Select status
                                            </option>
                                            <option value="1" {{(old('status', $faq->status) == 1 ? 'selected':'')}}>Active
                                            </option>
                                            <option value="2" {{(old('status', $faq->status) == 2 ? 'selected':'')}}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-question">Question</label>
                                        <input type="text" name="question" id="input-question" class="form-control form-control-alternative" placeholder="Question" value="{{ old('question', $faq->question) }}" required autofocus data-parsley-required-message="Question is required">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-answer">Answer</label>
                                        <textarea name="answer" id="input-answer" class="form-control form-control-alternative" placeholder="Answer" required data-parsley-required-message="Answer is required">{{ old('answer', $faq->answer) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{$faq->id ? 'Update' : 'Add'}} </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('Backend.layouts.footers.auth')
</div>
@endsection

@section('extra-js')
<script>

</script>
@endsection