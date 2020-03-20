<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function submitForm() {
        
    }
}
