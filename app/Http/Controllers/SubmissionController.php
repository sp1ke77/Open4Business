<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SubmitDocumentRequest;
use App\Http\Requests\SubmitFormRequest;
use App\Jobs\ProcessCSVSubmission;
use App\Submission;
use Carbon\Carbon;
use Illuminate\Http\FileHelpers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubmissionController extends Controller
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
        $disk       = null;
        $sessionKey = null;
        // Check extension
        if (\in_array(\mb_strtolower($extension), $validCsvextensions, true)) {
            $disk = "local_csvfiles";
            $sessionKey      = 'last_csv_filepath';
        } elseif (\in_array(\mb_strtolower($extension), $validImageextensions, true)) {
            $disk = "local_imgfiles";
            $sessionKey      = 'last_img_filepath';
        } else {
            //We didn't recognize the extension so we die
            return;
        }


        $fileName = Str::slug(Carbon::now()->toDayDateTimeString()).\rand(11111, 99999).'.'.$extension;

        $validated['file']->store(
            $fileName, $disk
        );
        $request->session()->put($sessionKey, $fileName);
    }

    public function submitForm(SubmitFormRequest $request)
    {
        $validated = $request->validated();
        $errors    = [];
        $csv_filepath   = $request->session('last_csv_filepath');
        $img_filepath   = $request->session('last_img_filepath');
        if ($csv_filepath == null) {
            $errors[] = 'Por favor faça upload de um ficheiro CSV.';
        }
        if ($img_filepath == null) {
            $errors[] = 'Por favor faça upload de um logótipo jpeg, jpg ou png.';
        }

        if (\count($errors) > 0) {
            return back()->withErrors($errors)->withInput();
        }

        try {
            $csv_file  = Storage::disk('local_csvfiles')->get($csv_filepath);
            $img_file = Storage::disk('local_imgfiles')->get($img_filepath);
            ProcessCSVSubmission::dispatch($csv_file,$img_file, FileHelpers::extension($csv_filepath));
            Storage::disk('local_csvfiles')->delete($csv_filepath);
            Storage::disk('local_csvfiles')->delete($img_filepath);
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
