<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PremissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->delete();
        $permissions = [
            //المدن
            ['name' => 'cities-list', 'ar_name' => "قائمة المدن", "routes" => "cities.index"],
            ['name' => 'cities-create', 'ar_name' => "اضافة مدينه", "routes" => "cities.create,cities.store"],
            ['name' => 'cities-edit', 'ar_name' => "تعديل مدينه", "routes" => "cities.edit,cities.update"],
            ['name' => 'cities-delete', 'ar_name' => "حذف مدينه", "routes" => "cities.destroy"],
            //الاحياء
            ['name' => 'regoins-list', 'ar_name' => "قائمة الاحياء", "routes" => "regoins.index"],
            ['name' => 'regoins-create', 'ar_name' => "اضافة حي", "routes" => "regoins.create,regoins.store"],
            ['name' => 'regoins-edit', 'ar_name' => "تعديل حي", "routes" => "regoins.edit,regoins.update"],
            ['name' => 'regoins-delete', 'ar_name' => "حذف حي", "routes" => "regoins.destroy"],
            //الاقسام
            ['name' => 'categories-list', 'ar_name' => "قائمة الاقسام", "routes" => "categories.index"],
            ['name' => 'categories-create', 'ar_name' => "اضافة قسم", "routes" => "categories.create,categories.store"],
            ['name' => 'categories-edit', 'ar_name' => "تعديل قسم", "routes" => "categories.edit,categories.update"],
            ['name' => 'categories-delete', 'ar_name' => "حذف قسم", "routes" => "categories.destroy"],
            //طرق الدفع
            ['name' => 'payment_types-list', 'ar_name' => "قائمة طرق الدفع", "routes" => "payment_types.index"],
            ['name' => 'payment_types-create', 'ar_name' => "اضافة طريقه دفع", "routes" => "payment_types.create,payment_types.store"],
            ['name' => 'payment_types-edit', 'ar_name' => "تعديل طريقه دفع", "routes" => "payment_types.edit,payment_types.update"],
            ['name' => 'payment_types-delete', 'ar_name' => "حذف طريقه دفع", "routes" => "payment_types.destroy"],
            //العروض
            ['name' => 'offers-list', 'ar_name' => "قائمة العروض", "routes" => "offers.index"],
            ['name' => 'offers-create', 'ar_name' => "اضافة عرض", "routes" => "offers.create,offers.store"],
            ['name' => 'offers-edit', 'ar_name' => "تعديل عرض", "routes" => "offers.edit,offers.update"],
            ['name' => 'offers-delete', 'ar_name' => "حذف عرض", "routes" => "offers.destroy"],
            //الرسائل
            ['name' => 'contacts-list', 'ar_name' => "قائمة الرسائل", "routes" => "contacts.index"],
            ['name' => 'contacts-create', 'ar_name' => "اضافة رساله", "routes" => "contacts.create,contacts.store"],
            ['name' => 'contacts-edit', 'ar_name' => "تعديل رساله", "routes" => "contacts.edit,contacts.update"],
            ['name' => 'contacts-delete', 'ar_name' => "حذف رساله", "routes" => "contacts.destroy"],
            //الرتب
            ['name' => 'roles-list', 'ar_name' => "قائمة الرتب", "routes" => "roles.index"],
            ['name' => 'roles-create', 'ar_name' => "اضافة رتبه", "routes" => "roles.index,roles.create,roles.store"],
            ['name' => 'roles-edit', 'ar_name' => "تعديل رتبه", "routes" => "roles.index,roles.edit,roles.update"],
            ['name' => 'roles-delete', 'ar_name' => "حذف رتبه", "routes" => "roles.index,roles.destroy"],
        ];
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
