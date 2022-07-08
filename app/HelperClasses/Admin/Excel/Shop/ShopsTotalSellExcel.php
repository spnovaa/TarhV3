<?php


namespace App\HelperClasses\Admin\Excel\Shop;


use App\Http\Controllers\Admin\StatsController;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ShopsTotalSellExcel implements FromCollection, WithHeadings
{
    public function collection()
    {
        return (new StatsController())->getShopsTotalSellData();
    }

    public function headings(): array
    {
        return [
            'فروشگاه',
            'تعداد جلد فروش',
        ];
    }
}
