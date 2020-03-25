<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitDocumentRequest;
use App\Http\Requests\SubmitFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

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
        $extension = $validated["file"]->getClientOriginalExtension();
            
        // Valid extensions
        $validCsvextensions = array("csv",);
        $validImageextensions = array("jpeg","jpg","png");
            
        // Check extension
        if (in_array(strtolower($extension), $validCsvextensions)) {
            $destinationPath = 'csvfiles/';
            
            // Create directory if not exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
                
                
            // Rename file
            $fileName = str_slug(Carbon::now()->toDayDateTimeString()).rand(11111, 99999) .'.' . $extension;
                
            // Uploading file to given path
            $validated["file"]->move($destinationPath, $fileName);
            session()->put('last_csvfile', $fileName);
        }

        if (in_array(strtolower($extension), $validImageextensions)) {
            $destinationPath = 'imgfiles/';
            
            // Create directory if not exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            // Rename file
            $fileName = str_slug(Carbon::now()->toDayDateTimeString()).rand(11111, 99999) .'.' . $extension;
                
            // Uploading file to given path
            $validated["file"]->move($destinationPath, $fileName);
            session()->put('last_imgfile', $fileName);
        }
    }

    public function submitForm(SubmitFormRequest $request)
    {
        $validated = $request->validated();
        $errors = [];
        $csvfile = session('last_csvfile');
        $imgfile = session('last_imgfile');
        if ($csvfile == null) {
            $errors[] = 'Por favor faça upload de um ficheiro CSV.';
        }
        if ($imgfile == null) {
            $errors[] = 'Por favor faça upload de um logótipo jpeg, jpg ou png.';
        }

        if (count($errors) > 0) {
            return redirect('/submit')
                        ->withErrors($errors)
                        ->withInput();
        }

        $submission = null;
        try {
            $validated['csv_file'] = $csvfile;
            $validated['logo_file'] = $imgfile;
            $submission = \App\Submission::create($validated);
        } catch (\Exception $e) {
            $errorId = uniqid();
            \Log::emergency($errorId." => ".$e);
            $errors = [
                'Ocorreu um erro no formulário. Pedimos que nos envie um e-mail para hello@vost.pt com o ID: '.$errorId
            ];
            return redirect('/submit')
                        ->withErrors($errors)
                        ->withInput();
        }

        return redirect('/submit')->with('success_message', 'Agradecemos a submissão. Esta informação será validada e inserida na plataforma assim que possível.');
    }
}
