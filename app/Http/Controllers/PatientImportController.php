<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PatientsPrescriptionImport;

class PatientImportController extends Controller
{
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new PatientsPrescriptionImport, $request->file('file'));

        return back()->with('success', 'Excel imported successfully');
    }
}
