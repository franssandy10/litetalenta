<?php

use Illuminate\Database\Seeder;
use App\Models\Province;
class ProvinceDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Province::firstOrCreate(['id'=>1,'name'=>'Aceh',               'amount'=>'1900000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>2,'name'=>'Bangka Belitung',    'amount'=>'2100000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>3,'name'=>'Bali',               'amount'=>'1621172','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>4,'name'=>'Banten',             'amount'=>'1600000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>5,'name'=>'Bengkulu',           'amount'=>'1500000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>6,'name'=>'Jambi',              'amount'=>'1710000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>7,'name'=>'Gorontalo',          'amount'=>'1600000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>8,'name'=>'DKI Jakarta',        'amount'=>'2700000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>9,'name'=>'Sumatera Barat',     'amount'=>'1615000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>10,'name'=>'Sumatera Selatan',   'amount'=>'1974346','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>11,'name'=>'Sumatera Utara',     'amount'=>'1625000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>12,'name'=>'Sulawesi Utara',     'amount'=>'2150000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>13,'name'=>'Sulawesi Tenggara',  'amount'=>'1625000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>14,'name'=>'Sulawesi Tengah',    'amount'=>'1500000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>15,'name'=>'Sulawesi Selatan',   'amount'=>'2000000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>16,'name'=>'Sulawesi Barat',     'amount'=>'1655500','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>17,'name'=>'Kalimantan Selatan', 'amount'=>'1870000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>18,'name'=>'Kalimantan Tengah',  'amount'=>'1896367','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>19,'name'=>'Kalimantan Timur',   'amount'=>'2026216','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>20,'name'=>'Kalimantan Barat',   'amount'=>'1560000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>21,'name'=>'Nusa Tenggara Timur','amount'=>'1250000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>22,'name'=>'Nusa Tenggara Barat','amount'=>'1330000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>23,'name'=>'Kepulauan Riau',     'amount'=>'1954000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>24,'name'=>'Maluku',             'amount'=>'1650000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>25,'name'=>'Riau',               'amount'=>'1878000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>26,'name'=>'Lampung',            'amount'=>'1581000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>27,'name'=>'Papua',              'amount'=>'2193000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>28,'name'=>'Papua Barat',        'amount'=>'2015000','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>29,'name'=>'Maluku Utara',       'amount'=>'1577617','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>30,'name'=>'Jawa Tengah',        'amount'=>'0','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>31,'name'=>'Jawa Barat',         'amount'=>'0','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>32,'name'=>'Jawa Timur',         'amount'=>'0','effective_date'=>'2015-01-01']);
        Province::firstOrCreate(['id'=>33,'name'=>'Yogyakarta',         'amount'=>'0','effective_date'=>'2015-01-01']);
    }
}
