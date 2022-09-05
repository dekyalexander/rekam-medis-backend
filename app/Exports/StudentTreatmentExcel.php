<?php

namespace App\Exports;

use App\Models\StudentTreatment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Http\Request;
use Carbon\Carbon; 
    

class StudentTreatmentExcel implements FromView, WithEvents
{
    public function __construct($request)
    { 
        $this->level = $request->level;
        $this->kelas = $request->kelas;
        $this->diagnosis_id = $request->diagnosis_id;
        $this->inspection_date = $request->inspection_date;
        $this->created_at = $request->created_at;
    }
   public function view(): View
        {
            $date = Carbon::now();

            $diagnosis_id = $this->diagnosis_id;
            
            $Treatment = StudentTreatment::select('id','niy','name', 'level', 'kelas', 'inspection_date','created_at')
            ->with([
            'jenjang:id,name,code',
            'kelas:id,name,code',
            'studenttreatmentgeneraldiagnosis.generaldiagnosis',
            ]) 
            ->when($diagnosis_id, function ($Treatment) use ($diagnosis_id) {
              $Treatment->WhereHas('studenttreatmentgeneraldiagnosis', function ($treatment) use($diagnosis_id) {
                  return $treatment->where('diagnosis_id', '=', $diagnosis_id);
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
        $data['diagnosis_id'] = $diagnosis_id;
        $data['inspection_date'] = $this->inspection_date;
        $data['created_at'] = $this->created_at;
        $data['Treatment'] = $Treatment;
        $data['printed_by'] =  $date->format('d/m/Y') ;

        return view('student_treatment', $data );
        
            // return view('student_treatment', [
            //     'data' => StudentTreatment::all()
            // ]);
        }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A4:H4')->applyFromArray([
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
