<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class HasilSurveiExport implements WithMultipleSheets
{
    protected $instrumenId;

    public function __construct($instrumenId)
    {
        $this->instrumenId = $instrumenId;
    }

    public function sheets(): array
    {
        return [
            new Sheets\UserDetailSheet($this->instrumenId),
            new Sheets\SummaryPerRoleSheet($this->instrumenId),
            new Sheets\AveragePerRoleSheet($this->instrumenId),
            new Sheets\GlobalNilaiSheet($this->instrumenId),
            new Sheets\DetailSheet($this->instrumenId),
        ];
    }
}