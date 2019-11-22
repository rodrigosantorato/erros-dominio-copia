<?php

namespace App\Http\Controllers;

use App\Services\FormatErrors;
use App\Services\ManageFiles;
use Illuminate\Support\Facades\DB;
use App\Employee;
use App\EmployeeIntegrationCode;


class ShowErrorsController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function show()
    {
        $pdfPath = request('pdf')->path();
        $txtPath = request('txt')->path();
        $manageFiles = new ManageFiles($pdfPath, $txtPath);

        if($manageFiles->read() === 'pdfError') {
            return view('pdfError');
        }
        if($manageFiles->read() === 'txtError') {
            return view('txtError');
        }
        $manageFiles->read();

        $formatErrors = new FormatErrors($manageFiles);
        $formatErrors->findAndFormat();
        $formatErrors->getEmployeeCodes();
        $lines[] =  $formatErrors->replaceCodeWithName();

        return view ('showErrors',  ['lines' => current($lines)]);
    }
}
