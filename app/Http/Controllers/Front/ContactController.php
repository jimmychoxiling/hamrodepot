<?php

namespace App\Http\Controllers\Front;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    //
    public function contact()
    {
        $data = array();
        $return_data['categories'] = $this->categories;

        return view('front.contact.contact', array_merge($data, $return_data));
    }

    public function makeContact(Request $request)
    {
        $contact = new ContactUs();
        $contact->full_name = $request->full_name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact = $contact->create($contact->toArray());
        NotificationHelper::contactUs($contact);

        return response()->json(['success'=> true, 'message' => 'We will contact you shortly']);
    }
}
