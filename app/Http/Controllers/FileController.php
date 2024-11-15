<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class FileController extends Controller
{
    /**
     * Tiedostojen listaus näkymä
     */
    public function index(Request $request)
    {
        session(['token' => Str::random(40)]);

        return view('files.index', [
            'files' => File::all(),
            'token' => session('token'),
            'categories' => collect(config('kota.files.categories')),
            'canDelete' => $request->user()->hasPermissionTo('access_management')
        ]);
    }

    /**
     * Tiedoston lataus
     */
    public function download(File $file, $token)
    {
        if ($token == session('token')) {

            $extension = pathinfo(storage_path('files/' . $file->path), PATHINFO_EXTENSION);

            //check if file exists
            if (!Storage::exists($file->path)) {
                return abort(404, 'Tiedostoa ei löydy');
            }

            return Storage::download($file->path, str_replace(' ', '_', $file->name) . "." . $extension);
        } else {
            return abort(400, 'Token ei täsmää');
        }
    }

    /**
     * Uuden tiedoston luonti
     */
    public function create()
    {
        return view('files.create', [
            'categories' => collect(config('kota.files.categories'))
        ]);
    }

    /**
     * Tallentaa tiedoston tietokantaan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'nullable',
            'category' => ['required', 'string', Rule::in(config('kota.files.categories'))],
            'link' => 'nullable|url|max:255',
            'type' => 'in:Linkki,Tiedosto'
        ]);

        try {

            if ($validated['type'] == 'Linkki') {
                File::create([
                    'name' => $validated['name'],
                    'path' => $validated['link'],
                    'category' => $validated['category'],
                    'isUrl' => true,
                ]);
            } else {
                $filePath = $request->file('file')->store('files');

                File::create([
                    'name' => $validated['name'],
                    'path' => $filePath,
                    'category' => $validated['category'],
                    'isUrl' => false,
                ]);
            }

            return response()->json([
                'message' => 'Onnistui'
            ]);
        } catch (\Throwable $th) {

            Log::error($th->getMessage());

            return response()->json([
                'message' => 'Tallennus epäonnistui'
            ],500);
        }
    }

    /**
     * Deletes file from storage and database
     */
    public function destroy(File $file)
    {
        
        if(!$file->isUrl)
        {
            Storage::delete($file->path);
        }

        $file->delete();

        return response()->json([
            'message' => 'Tiedosto poistettu'
        ]);
    }
}
