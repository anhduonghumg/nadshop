<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromQuery, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    // {
    //     return Product::all();
    // }

    public function headings(): array
    {
        return [
            'Tên sản phẩm',
            'Trạng thái',
            'Người tạo',
            'Danh mục',
            'Thời gian'
        ];
    }

    public function query()
    {
        // return Appointment::with('client:id,name')->whereIn('id', $this->selectedRows);
        return Product::leftjoin('m_users', 'm_users.id', '=', 'products.user_id')
            ->leftjoin('brands', 'brands.id', '=', 'products.brand_id')
            ->leftJoin('category_products', 'category_products.id', '=', 'products.product_cat_id')
            ->select('products.product_name', 'products.product_status', 'm_users.fullname', 'category_products.category_product_name', 'products.created_at')
            ->orderByDesc("products.id");
    }
}
