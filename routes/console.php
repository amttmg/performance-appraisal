<?php

/*use App\Notifications\SendReport;
use App\Session;
use App\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;*/

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

/*Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');*/

/*Artisan::command('send', function () {
    $users      = User::all();
    $fileSystem = new Filesystem();
    $session    = Session::where('is_active', 1)->firstOrFail();
    foreach ($users as $user) {
        $parts            = explode("@", $user->email);
        $fileName         = $parts[0].'.pdf';
        $newFileName      = uniqid().".pdf";
        $directory        = __DIR__.'/../files/';
        $directoryUploads = __DIR__.'/../public/uploads/';
        $file             = $directory.$fileName;
        $exist            = $fileSystem->exists($file);
        if ($exist) {
            $fileSystem->copy($file, $directoryUploads.$newFileName);
            send($user, $newFileName, $session);
            $this->comment("Sent to $user->name");
        } else {
            $this->comment("not exist: ".$user->name);
        }
    }
});

function send($user, $file, $session)
{
    $user->reports()->updateOrCreate(
        ['session_id' => $session->id],
        [
            'session_id' => $session->id,
            'report'     => $file,
        ]
    );*/
//}
