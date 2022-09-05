<?php

namespace App\Exports;

// use App\Models\DrugMutation;
use App\Models\DrugDistribution;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Http\Request;
use Carbon\Carbon;
    

class DrugRecapMutationExcel implements FromView, WithEvents
{
    public function __construct($request)
    { 
        $this->drug_type_id = $request->drug_type_id;
        $this->location_id = $request->location_id;
        $this->created_at = $request->created_at;
        $this->updated_at = $request->updated_at;
        
        // Option Mutation

        // $this->location_id = $request->location_id;
        // $this->created_at = $request->created_at;
        // $this->updated_at = $request->updated_at;
    }
   public function view(): View
        {
            $date = Carbon::now();

            $Drug = DrugDistribution::select('id','drug_id','drug_name_id','drug_type_id', 'drug_unit_id', 'drug_expired_id', 'description', 'location_id','qty','created_at','updated_at')
            ->with([
            'drugname:id,drug_kode,drug_name',
            'drugtype:id,drug_type',
            'drugunit:id,drug_unit',
            'drugexpired:id,date_expired',
	    'listofukslocations:id,uks_name',
            ])
            //->with('locationdrug.listofukslocations')  
            ->where('drug_type_id', '=', $this->drug_type_id)
            ->orWhere('location_id', '=', $this->location_id)
            ->orWhereDate('created_at', '=', $this->created_at)
            ->orWhereDate('updated_at', '=', $this->updated_at)
            ->orderBy('drug_type_id','ASC')
            ->orderBy('location_id','ASC')
            ->orderBy('created_at','ASC')
            ->orderBy('updated_at','ASC')
            ->orderBy('id', 'ASC')
            ->get();

        $data['drug_type_id'] = $this->drug_type_id;
        $data['location_id'] = $this->location_id;
        $data['created_at'] = $this->created_at;
        $data['updated_at'] = $this->updated_at;
        $data['Drug'] = $Drug;
        $data['printed_by'] =  $date->format('d/m/Y') ;

        // Option Mutation
            
        //     $Drug = DrugMutation::select('id','drug_id','location_id','drug_expired_id','qty','created_at','updated_at')
        //     ->with([
        //     'drugname:id,drug_kode,drug_name',
        //     'listofukslocations:id,uks_name'
        //     ]) 
        //     ->Where('location_id', '=', $this->location_id)
        //     ->orWhereDate('created_at', '=', $this->created_at)
        //     ->orWhereDate('updated_at', '=', $this->updated_at)
        //     ->orderBy('location_id','ASC')
        //     ->orderBy('created_at','ASC')
        //     ->orderBy('updated_at','ASC')
        //     ->orderBy('id', 'ASC')
        //     ->get();

        // $data['location_id'] = $this->location_id;
        // $data['created_at'] = $this->created_at;
        // $data['updated_at'] = $this->updated_at;
        // $data['Drug'] = $Drug;
        // $data['printed_by'] =  $date->format('d/m/Y') ;

        return view('drug_mutation', $data );
            // return view('drug_mutation', [
            //     'data' => DrugMutation::all()
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
