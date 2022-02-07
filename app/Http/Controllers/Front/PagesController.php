<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function aboutUs()
    {
        $data = array();

        $return_data['categories'] = $this->categories;
        return view('front.extra-pages.about-us', array_merge($data, $return_data));
    }

    public function trackYourOrder()
    {
        $data = array();

        $return_data['categories'] = $this->categories;
        return view('front.extra-pages.track-your-order', array_merge($data, $return_data));
    }

    public function easyReturns()
    {
        $data = array();

        $return_data['categories'] = $this->categories;
        return view('front.extra-pages.easy-returns', array_merge($data, $return_data));
    }

    public function aboutHardware()
    {
        $data = array();

        $return_data['categories'] = $this->categories;
        return view('front.extra-pages.about-hardware', array_merge($data, $return_data));
    }

    public function sellWithUs()
    {
        $data = array();

        $return_data['categories'] = $this->categories;
        return view('front.extra-pages.sell-with-us', array_merge($data, $return_data));
    }

    public function community()
    {
        $data = array();

        $return_data['categories'] = $this->categories;
        return view('front.extra-pages.community', array_merge($data, $return_data));
    }

    public function brandWeLove()
    {
        $data = array();

        $return_data['categories'] = $this->categories;
        return view('front.extra-pages.brand-we-love', array_merge($data, $return_data));
    }

    public function giftCards()
    {
        $data = array();

        $return_data['categories'] = $this->categories;
        return view('front.extra-pages.gift-cards', array_merge($data, $return_data));
    }

}
