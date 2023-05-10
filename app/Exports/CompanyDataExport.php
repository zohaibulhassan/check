<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompanyDataExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $companyid = $this->data['companyId'];
        $companyname = $this->data['companyname'];
        $sharedCompanyid = $this->data['sharedcompanyid'];
        $sharedCompanyname = $this->data['sharedCompanyname'];
        $years = $this->data['years'];
        $regno = $this->data['regno'];

        $rows = [];

        foreach ($sharedCompanyname as $index => $sharedCompany) {
            $rows[] = [
                $companyid[0],
                $companyname[0],
                $sharedCompanyid[$index],
                $sharedCompany,
                null,
                null,
                null,
                $regno[$index],
                null,
                $years,
            ];
        }


        $collection = new Collection($rows);

        return $collection;
    }

    public function headings(): array
    {
        return [
            'Company Id',
            'Company',
            "Shared Company Id",
            'Shared Company name',
            'Percentage',
            'NoShares',
            'sharedholdertype',
            'Regnumber',
            "StockYear",
            'StockYearSpan',
        ];
    }
}