<?php

namespace App\Exports;

use App\Models\StudentMCU;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Events\AfterSheet;
    

class StudentMCUExcel implements FromView, WithEvents
{
    public function __construct($request)
    { 
        $this->level = $request->level;
        $this->kelas = $request->kelas;
        $this->diagnosis_general_id = $request->diagnosis_general_id;
        $this->diagnosis_eye_id = $request->diagnosis_eye_id;
        $this->diagnosis_dental_id = $request->diagnosis_dental_id;
        $this->inspection_date = $request->inspection_date;
        $this->created_at = $request->created_at;
    }
   public function view(): View
        {
            $date = Carbon::now();

            $diagnosis_general_id = $this->diagnosis_general_id;
            $diagnosis_eye_id = $this->diagnosis_eye_id;
            $diagnosis_dental_id = $this->diagnosis_dental_id;
            
            $MCU = StudentMCU::select('id','niy','name', 'level', 'kelas','inspection_date','created_at')
            ->with([
            'jenjang:id,name,code',
            'kelas:id,name,code',
            'studentmcugeneraldiagnosis.generaldiagnosis',
            'studentmcueyediagnosis.visusdiagnosis',
            'studentmcudentalandoraldiagnosis.mcudiagnosis',
            ]) 
            ->when($diagnosis_general_id, function ($MCU) use ($diagnosis_general_id) {
              $MCU->WhereHas('studentmcugeneraldiagnosis', function ($mcu) use($diagnosis_general_id) {
                  return $mcu->where('diagnosis_general_id', '=', $diagnosis_general_id);
                });
            }) 
            ->when($diagnosis_eye_id, function ($MCU) use ($diagnosis_eye_id) {
              $MCU->WhereHas('studentmcueyediagnosis', function ($mcu) use($diagnosis_eye_id) {
                  return $mcu->where('diagnosis_eye_id', '=', $diagnosis_eye_id);
                });
            }) 
            ->when($diagnosis_dental_id, function ($MCU) use ($diagnosis_dental_id) {
              $MCU->WhereHas('studentmcudentalandoraldiagnosis', function ($mcu) use($diagnosis_dental_id) {
                  return $mcu->where('diagnosis_dental_id', '=', $diagnosis_dental_id);
                });
            }) 
            ->orWhere('level', '=', $this->level)
            ->orWhere('kelas', '=', $this->kelas)
            ->orWhereDate('inspection_date', '=', $this->inspection_date)
            ->orWhereDate('created_at', '=', $this->created_at)
            ->orderBy('kelas','ASC')
            ->orderBy('inspection_date','ASC')
            ->orderBy('created_at','ASC')
            ->orderBy('id', 'ASC')
            ->get();

        $data['level'] = $this->level;
        $data['kelas'] = $this->kelas;
        $data['diagnosis_general_id'] = $diagnosis_general_id;
        $data['diagnosis_eye_id'] = $diagnosis_eye_id;
        $data['diagnosis_dental_id'] = $diagnosis_dental_id;
        $data['inspection_date'] = $this->inspection_date;
        $data['created_at'] = $this->created_at;
        $data['MCU'] = $MCU;
        $data['printed_by'] =  $date->format('d/m/Y') ;

        return view('student_mcu', $data );
            // return view('student_mcu', [
            //     'data' => StudentMCU::all()
            // ]);
        }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A4:J4')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                     'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFDBE2F1',
                        ]           
                ],
                ]);
            }
        ];
    }
}
