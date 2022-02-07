<?php

namespace App\Repositories;

use App\Models\FaqQuestion;

class FaqQuestionRepository
{
    public $ques_categories = array(
        // array('id' => 0, 'name' => 'None'),
        array('id' => 1, 'name' => 'Shopping Guide'),
        array('id' => 2, 'name' => 'Order Question'),
        array('id' => 3, 'name' => 'Payment Issue'),
        array('id' => 4, 'name' => 'Shipping Question'),
        array('id' => 5, 'name' => 'Account and Membership')
    );
    public function __constuct()
    {
        //
    }
    public function create($data)
    {
        FaqQuestion::create($data);
    }

    public function update($data, $id)
    {
        $question = FaqQuestion::findOrFail($id);
        $question->fill($data);
        $question->save();
        return $question;

    }
    public function delete($id)
    {
        $question = FaqQuestion::findOrFail($id);
        return FaqQuestion::destroy($id);
    }
}
