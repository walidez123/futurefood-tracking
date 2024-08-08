<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $transactionTypes = [
            ['type' => 'cost', 'description' => 'The cost of shipping for order', 'description_ar' => 'تكلفة شحن الطلب '],
            ['type' => 'reshipping', 'description' => 'The cost of reshipping for order', 'description_ar' => 'تكلفة إعادة شحن الطلب '],
            ['type' => 'cash_fees', 'description' => 'Fees for collecting money for order', 'description_ar' => 'رسوم تحصيل مبلغ مالي للطلب '],
            ['type' => 'amount', 'description' => 'Collecting a sum of money for order', 'description_ar' => 'تحصيل مبلغ مالي للطلب '],
            ['type' => 'cost_weight', 'description' => 'The cost of extra weight for order', 'description_ar' => 'تكلفة الوزن الزائد للطلب '],
            ['type' => 'cost_collect_order', 'description' => 'The cost of receiving orders from your store', 'description_ar' => 'تكلفه استلام الطلبات من متجرك '],
            ['type' => 'debtor', 'description' => 'debtor', 'description_ar' => 'مدين '],
            ['type' => 'creditor', 'description' => 'creditor', 'description_ar' => 'دائن '],
            ['type' => 'Pick_process_packag', 'description' => 'The cost of picking up, processing and packaging order', 'description_ar' => 'تكلفة  التقاط وتجهيز وتغليف الطلب '],
            ['type' => 'print_waybill', 'description' => 'The cost of printing a policy order', 'description_ar' => 'تكلفة طباعة بوليصة  '],
            ['type' => 'sort_by_city', 'description' => 'The cost sorted by city  order', 'description_ar' => 'تكلفة فرز حسب المدينة  '],
            ['type' => 'store_return_shipment', 'description' => 'The cost cost of storing the reversed shipmentorder', 'description_ar' => 'تكلفة  تخزين الشحنة المعكوسة للطلب '],
            ['type' => 'reprocess_return_shipment', 'description' => 'The cost of reprocessing the reversed shipment order', 'description_ar' => 'تكلفة إعادة تجهيز الشحنة المعكوسة للطلب'],
            ['type' => 'cost_of_new_orde', 'description' => 'The cost of new order', 'description_ar' => 'سعر اوردر جديد'],
        ];

        DB::table('transaction_types')->insert($transactionTypes);
    }
}
