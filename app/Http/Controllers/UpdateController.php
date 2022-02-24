<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UpdateController extends Controller
{
    public function index(\Codedge\Updater\UpdaterManager $updater)
   {
       return view('update',[
           'new_version_available' => $updater->source()->isNewVersionAvailable(),
           'current_version' => $updater->source()->getVersionInstalled(),
           'new_version' => $updater->source()->getVersionAvailable()
       ]);
   }
   public function update(Request $request, \Codedge\Updater\UpdaterManager $updater)
   {
       // Get the new version available
       $versionAvailable = $updater->source()->getVersionAvailable();

       // Create a release
       $release = $updater->source()->fetch($versionAvailable);

       // Run the update process
       $updater->source()->update($release);

       return redirect('update')->with('message', 'Päivitys onnistui');
   }
}
