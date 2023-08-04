<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Session;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\models\User;

class UserExport implements FromCollection , WithHeadings
{
    protected $id;
    
    function __construct($id) {
            $this->id = $id;
    }

    public function collection()
    {   
            $key = 1;
            $exportData = [];
            foreach($this->id as $record) {
                $exportData[$key]['count']  	       = $key;
                $exportData[$key]['name']  	           = $record;
                $key++;
            }
            $exportData = collect($exportData);
            return $exportData;
    }

   
    public function headings() :array
    { 
        $current_url = url()->full();
       
        if(url('/adminpnlx/products/export/sample') == $current_url) {
            return [
                ["Sr No", "Name","Price","Discount","Quantity","Description"],

                ["1", "Jhon", "2500", "12", "1", "Best Product"],
                ["2", "Jack", "2000", "42", "5", "Super Product"],
                ["3", "Kom", "3000", "62", "8", "Excellent Product"]
              ];
        }else{
            return ["Sr No", "Name"];
        }

    }


}
