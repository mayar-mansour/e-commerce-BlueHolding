<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Modules\MedicineModule\Entities\Medicine;
use Modules\MedicineModule\Entities\StrengthUnit;

class ExcelImport implements ToModel{
    
    protected $hasData = false;
    public function model($row)
    {
        
        if ($this->isHeaderRow($row)) {
            return null;
        }
    
        $scientificName = $row[0];
        $tradeName = $row[1];
        $sizeUnit = $this->getIdForColumn('size_units', 'name_ar', $row[7]);
        $strengthUnit = $this->getIdForColumn('strength_units', 'name_ar', $row[3]);
        $administrationRoute = $this->getIdForColumn('administration_routes', 'name_ar', $row[5]);
        
        
        $packageType = $this->getIdForColumn('package_types', 'name_ar', $row[8]);

        $legalStatus = $this->getIdForColumn('legal_statuses', 'name_ar', $row[10]);
    
        $pharmaceuticalForm = $this->getIdForColumn('pharmaceutical_forms', 'name_ar', $row[4]);
        // sperate the strength value after comma
        $strengthValues = explode(',', $row[2]); 

        $medicines = [];

        foreach ($strengthValues as $strengthValue) {
            $medicine = new Medicine([
            'scientific_name_en' => $scientificName,
            'scientific_name_ar' => $scientificName,
            'trade_name_en' => $tradeName,
            'trade_name_ar' => $tradeName,
            'strength_unit_id' => $strengthUnit,
            'administration_route_id' => $administrationRoute,
            'size_unit_id' => $sizeUnit,
            'package_type_id' => $packageType,
            'legal_status_id' => $legalStatus,
            'pharmaceutical_form_id' => $pharmaceuticalForm,
            'Strength' => trim($strengthValue),
            'size' => empty($row[6]) ? null : $row[6],
            'package_size' => empty($row[9]) ? null : $row[9],
            'storage_conditions_ar' => empty($row[14]) ? null : $row[14],
            'storage_conditions_en' => empty($row[13]) ? null : $row[13],
            'agent_name_en' => empty($row[17]) ? null : $row[17],
            'agent_name_ar' => empty($row[17]) ? null : $row[17],
            'price' => empty($row[11]) ? null : (double)$row[11],
            'shelfLife' => empty($row[12]) ? null : (double)$row[12],
            'manufacture_country_ar' => empty($row[16]) ? null : $row[16],
            'manufacture_country_en' => empty($row[16]) ? null : $row[16],
            'manufacture_name_ar' => empty($row[15]) ? null : $row[15],
            'manufacture_name_en' => empty($row[15]) ? null : $row[15],
        ]);

        $medicines[] = $medicine;
    }

    return $medicines;
    }
    
    private function getIdForColumn($table, $columnName, $value) { 
        $model = DB::table($table)->where($columnName, $value)->first();
        return $model ? $model->id : 0;
    }
    
    
    private function isHeaderRow($row) {
        return isset($row[0]) && $row[0] === "Scientific Name";
    }
    

    public function hasData()
    {
        return $this->hasData;
    }
    
}



   

