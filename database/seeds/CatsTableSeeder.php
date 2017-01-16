<?php

use Illuminate\Database\Seeder;

class CatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now_time = \Carbon\Carbon::now();
        $cat_data = array(
            ['name'=>'AUDI','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'BENZ','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'BMW','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'VOLKSWAGEN','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'FIAT','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'OPEL','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'PEUGEOT','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'RENAULT','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'FORD','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'IVECO','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'SKODA','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'LAND ROVER','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'SAAB','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'ALFA','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'SCANIA TRUCK','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'VOLVO TRUCK','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'BENZ TRUCK','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'Mack/MAN/DAF TRUCK','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'MITSUBISHI','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'ISUZU TRUCK','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'HINO TRUCK','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'TOYOTA','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'HONDA','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'HYUNDAI','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'KIA','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'JEEP','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'CHRYSLER','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'DODGE','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'CHEVROLET','created_at'=>$now_time,'updated_at'=>$now_time],
            ['name'=>'ISUZU','created_at'=>$now_time,'updated_at'=>$now_time]
        );
        DB::table('om_goods_cat')->insert($cat_data);
    }
}
