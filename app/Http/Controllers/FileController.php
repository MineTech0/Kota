<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function __construct() {
       // $this->middleware('auth');
    }
    public function index()
    {

        session(['token' => Str::uuid()]);
        return view('files',[
        'files'=> File::all(),
        'token'=> session('token')
        ]);
    }
    public function download(File $file, $token)
    {
        if ($token== session('token')){
            return Storage::download('files/'.$file->path,$file->name .'.'. $file->extension);
        }
        else {
            return abort(404);
        }
    }
}
