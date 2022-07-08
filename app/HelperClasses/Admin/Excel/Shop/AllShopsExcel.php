<?php


namespace App\HelperClasses\Admin\Excel\Shop;


use App\Http\Controllers\Admin\ResumeController;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AllShopsExcel implements FromCollection, WithHeadings
{
    public function collection()
    {
        return (new ResumeController())->getAllShopData();
    }

    public function headings(): array
    {
        return [
            'سطر',
            'تایید مدیریت',
            'فعال',
            'نام',
            'نام خانوادگی',
            'نام فروشگاه',
            'کدملی',
            'همراه',
            'تلفن فروشگاه',
            'عکس پروفایل',
            'استان',
            'شهر',
            'منطقه',
            'خیابان',
            'ارسال رزومه',
            'پورسانت',
            'شبا',
            'شماره کارت',
            'مساحت فروشگاه',
            'کدپستی',
            'ارسال گزارش',
            'سیستمی',
            'سیستمی',
            'سیستمی',
            'سیستمی',
        ];
    }
}
