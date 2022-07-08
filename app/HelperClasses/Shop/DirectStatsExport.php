<?php


namespace App\HelperClasses\Shop;


use App\Http\Controllers\Shop\InventoryController;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DirectStatsExport implements FromArray, WithHeadings
{

    /**
     * @inheritDoc
     */
    public function array(): array
    {
        return (new InventoryController)->getShopDirectSellStats();
    }

    public function headings(): array
    {
        return [
            'سطر',
            'بارکد',
            'نام کتاب',
            'فی',
            'انتشارات',
            'تعداد فروش',
            'دریافتی از مشتری',
        ];
    }
}
