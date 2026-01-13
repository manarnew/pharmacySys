<?php

namespace App\Imports;

use App\Models\Patient;
use App\Models\Examination;
use App\Models\Prescription;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class PatientsPrescriptionImport implements ToCollection
{

    /**
     * Transform Excel date safely
     */
    private function transformDate($value)
    {
        if (empty($value)) {
            return now();
        }

        try {
            // If it's a numeric Excel date (e.g., 45691)
            if (is_numeric($value)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
            }
            
            // If it's a string, try to parse it
            return \Carbon\Carbon::parse($value);
        } catch (\Exception $e) {
            // Fallback to now if parsing fails
            return now();
        }
    }

    public function collection(Collection $rows)
    {
        // Skip header rows (row 0 & 1)
        foreach ($rows->skip(2) as $row) {

            // Skip empty rows
            if (empty($row[0]) || empty($row[1])) {
                continue;
            }

            DB::transaction(function () use ($row) {

                // 1️⃣ Patient
                $patient = Patient::create(
                    [
                        'name'       => $row[0],
                        'phone'      => $row[1],
                        'age'        =>0,
                        'date'       => $this->transformDate($row[12] ?? null),
                        'created_by' => auth()->id(),
                    ]
                );

                // 2️⃣ EMPTY Examination
                $examination = Examination::create([
                    'patient_id'    => $patient->id,
                    'specialist_id' => auth()->id(),
                    'created_by'    => auth()->id(),
                ]);

                // 3️⃣ Prescription (OD / OS)
                Prescription::create([
                    'patient_id'     => $patient->id,
                    'examination_id' => $examination->id,

                    // 🔵 RIGHT EYE (OD)
                    'sphere_od' => $row[2],
                    'cyl_od'    => $row[3],
                    'axis_od'   => $row[4],
                    'add_od'    => $row[5],

                    // 🔴 LEFT EYE (OS)
                    'sphere_os' => $row[6],
                    'cyl_os'    => $row[7],
                    'axis_os'   => $row[8],
                    'add_os'    => $row[9],

                    'ipd'          => $row[10] ?? null,
                    'notes'        => null,
                    'specialist_id'=> auth()->id(),
                    'created_by'   => auth()->id(),
                ]);
            });
        }
    }
}
