<?php

namespace App\Imports;

use App\Models\Good;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow; // Import the WithStartRow concern


class ImportGood implements ToModel,WithStartRow 
{
    protected $user;


    public function __construct($user)
    {
        $this->user = $user;

    }
    public function startRow(): int
    {
        return 2; // Start importing from the second row
    }

    public function model(array $row)
    {
        if($this->user->user_type=='client')
        {
            $client_id=$this->user->id;

        }else
        {
           $client_id=NULL;
        }
        $good = new Good([
            'title_en' => $row[0] ?? null,
            'title_ar' => $row[1] ?? null,
            'SKUS' => $row[2] ?? null,
            'category_id' => $row[3] ?? null,
            'length' => $row[4] ?? null,
            'width' => $row[5] ?? null,
            'height' => $row[6] ?? null,
            'has_expire_date'  =>$row[7]?? null,
            'description_en'  =>$row[8]?? null,
            'description_ar'  =>$row[9]?? null,

            'company_id' => $this->user->company_id,
            'client_id' => $client_id,


        ]);
        return $good;
    }
  
}
