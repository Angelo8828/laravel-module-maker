<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Template123 as Template123;

class Template123sController extends Controller
{
    protected $request;

    public function __construct(Request $request, Template123 $template123)
    {
        $this->request = $request;
        $this->template123 = $template123;
    }

    public function index()
    {
        return;
    }
}
