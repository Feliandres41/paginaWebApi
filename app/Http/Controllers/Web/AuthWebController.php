<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class AuthWebController extends Controller
{
    public function logout()
    {
        session()->forget('api_token');
        return redirect()->route('login');
    }
}
