<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\FaqQuestionRequest;
use App\Models\FaqQuestion;
use App\Repositories\FaqQuestionRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Str;

class FaqController extends Controller
{
    private $faqRepository;

    public function __construct(FaqQuestionRepository $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    public function index()
    {
        return view('Backend.faq.index');
    }

    public function getFaq(Request $request)
    {
        if ($request->ajax()) {
            $data = FaqQuestion::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('ques_category_id', function ($row) {
                    $ques_categories = $this->faqRepository->ques_categories;
                    return $ques_categories[$row->ques_category_id - 1]['name'];
                })
                ->addColumn('question', function ($row) {
                    $ques = Str::limit($row->answer, 50, ' ...');
                    return $ques;
                })
                ->addColumn('answer', function ($row) {
                    $ans = Str::limit($row->answer, 50, ' ...');
                    return $ans;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return '<div class="status-main"><span class="question-badge badge badge-pill badge-success">Active</span></div>';
                    } else {
                        return '<div class="status-main"><span class="question-badge badge badge-pill badge-danger">InActive</span></div>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $statusBtn = "";
                    $checked = "";
                    if ($row->status == 1) {
                        $checked = "checked";
                    }

                    $statusBtn = '<label class="custom-toggle">
                            <input type="checkbox" value="1" ' . $checked . ' class="statusUpdateQuestion question-status active-inactive" data-id="' . $row->id . '" >
                            <span class="custom-toggle-slider rounded-circle"></span>
                            </label>';

                    $actionBtn =
                        '<a class="btn btn-info  btn-sm" href="' . route('question-show', $row->id) . '"><i class="fa fa-eye"></i></a>
                          <a href="' . route('faq-edit', $row->id) . '" class="edit btn btn-success btn-sm"><i class="fa fa-pen"></i></a>
                          <a href="javascript:void(0);" data-href="' . route('question-delete', $row->id) . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $statusBtn . $actionBtn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }

    public function show($id)
    {
        $question = FaqQuestion::find($id);
        $ques_categories = $this->faqRepository->ques_categories;
        return view('Backend.faq.show', compact('ques_categories', 'question'));
    }

    public function create()
    {
        $faq = new FaqQuestion();
        $url = 'question-create';
        $ques_categories = $this->faqRepository->ques_categories;
        return view('Backend.faq.create', compact('ques_categories', 'faq', 'url'));
    }

    public function store(FaqQuestionRequest $faqRequest)
    {
        $data = $faqRequest->validated();
        if(!$data['status'] || $data['status'] == '') {
            $data['status'] = 2;
        }
        $this->faqRepository->create($data);

        return redirect()->route('faq-question')
            ->with('success', 'Question Added Successfully!');

    }
    
    public function edit($id)
    {
        $faq =  FaqQuestion::where('id', $id)->first();
        $url = 'question-update';
        $ques_categories = $this->faqRepository->ques_categories;
        return view('Backend.faq.create', compact('ques_categories', 'faq', 'url'));

    }

    public function update(FaqQuestionRequest $faqRequest)
    {
        $data = $faqRequest->validated();
        if(!$data['status'] || $data['status'] == '') {
            $data['status'] = 2;
        }
        $this->faqRepository->update($data, $faqRequest->id);

        return redirect()->route('faq-question')
            ->with('success', 'Question Update Successfully!');

    }

    public function destroy($id)
    {
        $question = $this->faqRepository->delete($id);

        return redirect()->route('faq-question')
            ->with('success', 'Question deleted successfully');
    }

    public function updateStatus(Request $request)
    {
        $question = FaqQuestion::find($request->id);
        if ($question->status == 1) {
            $question['status'] = 2;
        } else {
            $question['status'] = 1;
        }
        $question = $question->update([$question]);
        $question = FaqQuestion::find($request->id);
        return response()->json(['success' => true, 'message' => 'Question status successfully updated', 'status' => $question['status']]);
    }
}
