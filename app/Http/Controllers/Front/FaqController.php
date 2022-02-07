<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\FaqQuestion;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    //
    public function index()
    {
        $data = array();

        $return_data['categories'] = $this->categories;
        return view('front.extra-pages.faq', array_merge($data, $return_data));
    }

    public function find(Request $request)
    {
        $questions = FaqQuestion::where('ques_category_id', $request->id)->where('status', '1')->get();
        $html = '';
        if (count($questions) > 0) {
            foreach ($questions as $key => $value) {
                $html .=    '<div class="accordion-item">
                                <div class="accordion-title">
                                    <h3><i class="fa fa-caret-right" aria-hidden="true"></i>' . $value->question . '</h3>
                                </div>
                                <div class="accordion-content">
                                    <p>' .  $value->answer  . '</p>
                                </div>
                            </div>';
            }
        }

        return response()->json(['success' => true, 'message' => '', 'html' => $html]);
    }
}
