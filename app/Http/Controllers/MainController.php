<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Alumni;
use App\Models\Narahubung;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MainController extends Controller
{
    public function index()
    {
        return view('home', [
            "title" => "Home | SI Data Alumni",
            "alumni" => Alumni::join('angkatan', 'alumni.id_angkatan', '=', 'angkatan.id')
                        ->orderBy('tahun_angkatan', 'desc')
                        ->orderBy('id_prodi', 'desc')
                        ->orderBy('nim', 'asc')
                        ->get(),
            // "narahubung" => Narahubung::all()->orderBy('tahun_'),
            "posts" => Post::where('approved', true)->latest()->take(5)->get()
        ]);
    }

    public function posts()
    {
        return view('posts', [
            "title" => "Berita | SI Data Alumni",
            "posts" => Post::where('approved', true)->latest()->simplePaginate(15)
        ]);
    }

    public function team()
    {
        return view('team', [
            "title" => "Team | SI Data Alumni"
        ]);
    }

    public function test()
    {
        return view('test', [
            "posts" => Post::where('approved', true)->latest()->take(5)->get()
        ]);
    }
}
