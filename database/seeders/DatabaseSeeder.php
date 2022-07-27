<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Location;
use App\Models\Outage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run()
    {

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@evnopower.com',
            'password' => Hash::make('123')
        ]);
//
//        $areas = ['Берово', 'Скопје', 'Тетово', 'Куманово', 'Штип', 'Делчево'];
//
//        foreach ($areas as $area) {
//            Area::factory()->create(['name' => $area]);
//        }
//
//        $outages = array(
//            array("2022-07-25 08:40", "2022-07-25 12:00", "Берово", "Маршал Тито, Чаката"),
//            array("2022-07-25 10:40", "2022-07-25 16:00", "Куманово", "дел од с.Никуљане"),
//            array("2022-07-25 7:56", "2022-07-25 10:30", "Тетово",
//                "ЈЕЛОВЈАНЕ: корисниците кои се наоѓаат кај џамијата, во центарот на селото и во новата населба, Ново Село: корисниците кои се наоѓаат во кај школото и наспрема горниот дел од селото"),
//            array("2022-07-25 11:35", "2022-07-25 14:10", "Штип", "Карбинци"),
//            array("2022-07-25 10:40", "2022-07-25 14:21", "Делчево", "дел од с.Никуљане"),
//            array("2022-07-25 15:10", "2022-07-25 17:25", "Скопје", "Ул.Фрањо Клуз, бр.2, влез 1 и влез 2 дел од с.Никуљане"),
//            array("2022-07-25 2:36", "2022-07-25 15:00", "Скопје", "ИЛИНДЕН: Дел од Индустриска Зона Илинден односно  фирмите Шенкер, Јуба,Бане Сомбор,ПП Лукс)"
//            ),
//        );
//
//
//        foreach ($outages as $outage) {
//            Outage::factory()->create(['start' => $outage[0], 'end' => $outage[1], 'area' => $outage[2], 'address' => $outage[3]]);
//        }
    }


}
