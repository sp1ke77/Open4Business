<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SubmitDocumentRequest;
use App\Http\Requests\SubmitFormRequest;
use App\Jobs\ProcessCSVSubmission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MassSubmissionController extends Controller
{
    public function index()
    {
        return view('mass_submission.company_files');
    }

    public function submitDocuments(SubmitDocumentRequest $request)
    {
        $validated = $request->validated();

        // Get file extension
        $extension = $validated['file']->getClientOriginalExtension();

        // Valid extensions
        $validCsvextensions   = ['csv',];
        $validImageextensions = ['jpeg','jpg','png'];
        $disk                 = null;
        $sessionKey           = null;
        // Check extension
        if (\in_array(\mb_strtolower($extension), $validCsvextensions, true)) {
            $disk       = 'local_csvfiles';
            $sessionKey = 'last_csv_filepath';
        } elseif (\in_array(\mb_strtolower($extension), $validImageextensions, true)) {
            $disk       = 'local_imgfiles';
            $sessionKey = 'last_img_filepath';
        } else {
            //We didn't recognize the extension so we die
            return;
        }


        $fileName = Str::slug(Carbon::now()->toDayDateTimeString()).\rand(11111, 99999).'.'.$extension;

        $validated['file']->storeAs(
            '',
            $fileName,
            $disk
        );
        $request->session()->put($sessionKey, $fileName);
    }

    public function submitForm(SubmitFormRequest $request)
    {
        $validated    = $request->validated();
        $errors       = [];
        $csv_filepath = $request->session()->get('last_csv_filepath');
        $img_filepath = $request->session()->get('last_img_filepath');
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
            ProcessCSVSubmission::dispatch($validated['firstname'], $validated['lastname'], $validated['contact'], $validated['email'], $csv_filepath, $img_filepath, Auth::user()->id);
        } catch (\Exception $e) {
            if ($e->getMessage() == 'VOSTPT_INVALID_CSV') {
                return back()->withErrors([
                    'Não foi possível validar o seu formulário. Verifique que o ficheiro obedece a todas as instruções de formatação indicadas. Se pensa tratar-se de um erro contacte-nos pelo e-mail o4b@vost.pt',
                ])->withInput();
            }
            $errorId = Str::uuid();
            dd($e);
            Log::emergency($errorId.' => '.$e);
            return back()->withErrors([
                'Ocorreu um erro no formulário. Pedimos que nos envie um e-mail para o4b@vost.pt com o ID: '.$errorId,
            ])->withInput();
        }

        return redirect()->route('mass_submission.index')->with('success_message', 'Agradecemos a submissão. Esta informação será validada e inserida na plataforma assim que possível.');
    }
}
