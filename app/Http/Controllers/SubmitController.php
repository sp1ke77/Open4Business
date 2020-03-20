<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubmitController extends Controller
{
    public function index() {
        return view('submission.company_files');
    }

    public function submitDocuments(Request $request) {
        if($request->hasFile('file')) {
            
            // Get file extension
            $extension = $request->file('file')->getClientOriginalExtension();
            
            // Valid extensions
            $validCsvextensions = array("csv",);
            $validImageextensions = array("jpeg","jpg","png");
            
            // Check extension
            if(in_array(strtolower($extension), $validCsvextensions)){

                $destinationPath = 'csvfiles/';
            
                // Create directory if not exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                
                
                // Rename file 
                $fileName = str_slug(\Carbon\Carbon::now()->toDayDateTimeString()).rand(11111, 99999) .'.' . $extension;
                
                // Uploading file to given path
                $request->file('file')->move($destinationPath, $fileName);
                session()->put('last_csvfile',$fileName);
            }

            if(in_array(strtolower($extension), $validImageextensions)){
                
                $destinationPath = 'imgfiles/';
            
                // Create directory if not exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
            
                // Rename file 
                $fileName = str_slug(\Carbon\Carbon::now()->toDayDateTimeString()).rand(11111, 99999) .'.' . $extension;
                
                // Uploading file to given path
                $request->file('file')->move($destinationPath, $fileName);
                session()->put('last_imgfile',$fileName); 
            }
            
        }
    }

    public function submitForm(Request $request) {

        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'email' => 'required',
            'telefone' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/submit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $errors = [];
        $csvfile = session('last_csvfile');
        $imgfile = session('last_imgfile');
        if($csvfile == null) $errors[] = 'Por favor faça upload de um ficheiro CSV.';
        if($imgfile == null) $errors[] = 'Por favor faça upload de um logótipo jpeg, jpg ou png.';

        if(count($errors) > 0) {
            return redirect('/submit')
                        ->withErrors($errors)
                        ->withInput();
        }

        $submission = null;
        try {
            $submission = \App\Submission::create([
                'nome' => $request->get('nome'),
                'telefone' => $request->get('telefone'),
                'email' => $request->get('email'),
                'csv_file' => $csvfile,
                'logo_file' => $imgfile,
            ]);
        }catch(\Exception $e) {
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
