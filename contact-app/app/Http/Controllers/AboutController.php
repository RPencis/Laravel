<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * this controller is meant for single action
     * as there will not be any other action __invoke can be used
     */
    public function __invoke(Request $request)
    {
        //
    }
}
