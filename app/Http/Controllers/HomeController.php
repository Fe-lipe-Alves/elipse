<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Retorna a tela inicial
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Index');
    }

    /**
     * Retorna a tela de dashboard
     *
     * @return \Inertia\Response
     */
    public function dashboard()
    {
        return Inertia::render('admin/Dashboard');
    }
}
