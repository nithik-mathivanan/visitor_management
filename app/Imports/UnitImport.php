<?php

namespace App\Imports;

use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;

class UnitImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {      
        return new Unit([
            'unit_name'     => $row['unit_name'],
            'name'    => $row['name'], 
            'vehicle_no_1'     => $row['vehicle_no_1'],
            'vehicle_no_2'    => $row['vehicle_no_2'], 
            'vehicle_no_3'     => $row['vehicle_no_3'],
            'contact_no'    => $row['contact_no'], 
            'ic_number'    => $row['ic_number'], 
            'location_id'    => $row['location_id'], 
        ]);
    }
}
