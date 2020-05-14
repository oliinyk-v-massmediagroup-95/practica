<?php
declare(strict_types=1);

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        if (\Auth::check()) {
            return redirect(route('user.file.index'));
        }

        return redirect(route('login'));
    }
}
