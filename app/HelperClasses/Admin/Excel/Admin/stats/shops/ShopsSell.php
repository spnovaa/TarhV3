<?php


namespace App\HelperClasses\Admin\Excel\Admin\stats\shops;


use App\Http\Controllers\Admin\StatsController;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ShopsSell implements FromCollection, WithHeadings
{
    public function collection()
    {
        return (new StatsController())->getShopsSellData();
    }

    public function headings(): array
    {
        return [];
    }
}
