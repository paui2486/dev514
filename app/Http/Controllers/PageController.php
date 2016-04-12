<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    //
    public function index()
    {
    }
      
    public function HostGuide()
    {
        return view("page.host-guide");
    }
        
    public function About()
    {
        return view("page.about");
    }
    
    public function Joinus()
    {
        return view("page.joinus");
    }
    
    public function Advertising()
    {
        return view("page.advertising");
    }
    
    public function Privacy()
    {
        return view("page.privacy");
    }
    
    public function FAQ()
    {
        return view("page.faq");
    }
    
    public function PlayGuide()
    {
        return view("page.play-guide");
    }
    
    public function Cooperation()
    {
        return view("page.cowork");
    }

}

