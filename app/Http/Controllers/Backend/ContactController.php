<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Yajra\DataTables\DataTables;


class ContactController extends Controller
{
    public function index()
    {
        return view('Backend.contact-us.index');
    }

    public function getContacts()
    {
        $data = ContactUs::latest()->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->rawColumns([])
            ->make(true);
    }
}
