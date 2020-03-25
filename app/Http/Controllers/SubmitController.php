<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SubmitDocumentRequest;
use App\Http\Requests\SubmitFormRequest;
use App\Submission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubmitController extends Controller
{
    public function index()
    {
        return view('submission.company_files');
    }

    public function submitDocuments(SubmitDocumentRequest $request)
    {
        $validated = $request->validated();

        // Get file extension
        $extension = $validated['file']->getClientOriginalExtension();

        // Valid extensions
        $validCsvextensions   = ['csv',];
        $validImageextensions = ['jpeg','jpg','png'];
        $destinationPath      = null;
        $sessionKey           = null;
        // Check extension
        if (\in_array(\mb_strtolower($extension), $validCsvextensions, true)) {
            $destinationPath = 'csvfiles/';
            $sessionKey      = 'last_csvfile';
        } elseif (\in_array(\mb_strtolower($extension), $validImageextensions, true)) {
            $destinationPath = 'imgfiles/';
            $sessionKey      = 'last_imgfile';
        } else {
            //We didn't recognize the extension so we die
            return;
        }

        if (Storage::exists($destinationPath)) {
            Storage::makeDirectory($destinationPath, 0775, true);
        }


        $fileName = Str::slug(Carbon::now()->toDayDateTimeString()).\rand(11111, 99999).'.'.$extension;

        $validated['file']->storeAs(
            $destinationPath,
            $fileName
        );

        $request->session()->put($sessionKey, $fileName);
    }

    public function submitForm(SubmitFormRequest $request)
    {
        $validated = $request->validated();
        $errors    = [];
        $csvfile   = $request->session('last_csvfile');
        $imgfile   = $request->session('last_imgfile');
        if ($csvfile == null) {
            $errors[] = 'Por favor faça upload de um ficheiro CSV.';
        }
        if ($imgfile == null) {
            $errors[] = 'Por favor faça upload de um logótipo jpeg, jpg ou png.';
        }

        if (\count($errors) > 0) {
            return back()->withErrors($errors)->withInput();
        }

        try {
            $validated['csv_file']  = $csvfile;
            $validated['logo_file'] = $imgfile;
            Submission::create($validated);
        } catch (\Exception $e) {
            $errorId = Str::uuid();
            Log::emergency($errorId.' => '.$e);
            return back()->withErrors([
                'Ocorreu um erro no formulário. Pedimos que nos envie um e-mail para hello@vost.pt com o ID: '.$errorId,
            ])->withInput();
        }

        return redirect('/submit')->with('success_message', 'Agradecemos a submissão. Esta informação será validada e inserida na plataforma assim que possível.');
    }
}
