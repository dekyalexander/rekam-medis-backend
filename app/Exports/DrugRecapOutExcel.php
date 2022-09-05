<?php

namespace App\Exports;

use App\Models\Transactions;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Http\Request;
use Carbon\Carbon;
    

class DrugRecapOutExcel implements FromView, WithEvents
{
    public function __construct($request)
    { 
        $this->location_id = $request->location_id;
        $this->created_at = $request->created_at;
        $this->updated_at = $request->updated_at;
    }
   public function view(): View
        {
            $date = Carbon::now();
            
            $Drug = Transactions::select('id','drug_id','location_id','date_expired','qty_take','leftover_qty','description','created_at','updated_at')
            ->with([
            'drugname:id,drug_kode,drug_name',
            'listofukslocations:id,uks_name'
            ]) 
            ->Where('location_id', '=', $this->location_id)
            ->orWhereDate('created_at', '=', $this->created_at)
            ->orWhereDate('updated_at', '=', $this->updated_at)
            ->orderBy('location_id','ASC')
            ->orderBy('created_at','ASC')
            ->orderBy('updated_at','ASC')
            ->orderBy('id', 'ASC')
            ->get();

        $data['location_id'] = $this->location_id;
        $data['created_at'] = $this->created_at;
        $data['updated_at'] = $this->updated_at;
        $data['Drug'] = $Drug;
        $data['printed_by'] =  $date->format('d/m/Y') ;

        return view('recap_remaining_of_drug', $data );
            // return view('recap_remaining_of_drug', [
            //     'data' => Transactions::all()
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
