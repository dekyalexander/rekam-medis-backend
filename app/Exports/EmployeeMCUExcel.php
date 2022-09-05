<?php

namespace App\Exports;

use App\Models\EmployeeMCU;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Events\AfterSheet;
    

class EmployeeMCUExcel implements FromView, WithEvents
{
    public function __construct($request)
    { 
        $this->unit = $request->unit;
        $this->diagnosis_id = $request->diagnosis_id;
        $this->inspection_date = $request->inspection_date;
        $this->created_at = $request->created_at;
    }
   public function view(): View
        {
            $date = Carbon::now();

            $diagnosis_id = $this->diagnosis_id;
            
            $MCU = EmployeeMCU::select('id','nik','name', 'unit','inspection_date','created_at')
            ->with([
            'employeeunit:id,name',
            'employeemcugeneraldiagnosis.generaldiagnosis',
            ]) 
            ->when($diagnosis_id, function ($MCU) use ($diagnosis_id) {
              $MCU->WhereHas('employeemcugeneraldiagnosis', function ($mcu) use($diagnosis_id) {
                  return $mcu->where('diagnosis_id', '=', $diagnosis_id);
                });
            }) 
            ->orWhere('unit', '=', $this->unit)
            ->orWhereDate('inspection_date', '=', $this->inspection_date)
            ->orWhereDate('created_at', '=', $this->created_at)
            ->orderBy('inspection_date','ASC')
            ->orderBy('created_at','ASC')
            ->orderBy('id', 'ASC')
            ->get();

        $data['unit'] = $this->unit;
        $data['diagnosis_id'] = $diagnosis_id;
        $data['inspection_date'] = $this->inspection_date;
        $data['created_at'] = $this->created_at;
        $data['MCU'] = $MCU;
        $data['printed_by'] =  $date->format('d/m/Y') ;

        return view('employee_mcu', $data );

            // return view('employee_mcu', [
            //     'data' => EmployeeMCU::all()
            // ]);
        }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A4:G4')->applyFromArray([
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
