<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Region;
use App\Models\Township;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = ['ကချင်ပြည်နယ်', 'ချင်းပြည်နယ်', 'နေပြည်တော်', 'မန္တလေးတိုင်းဒေသကြီး', 'ရန်ကုန်တိုင်းဒေသကြီး'];

        $districts = [
            [
                'name' => 'မြစ်ကြီးနားခရိုင်',
                'region_id' => 1,
            ],
            [
                'name' => 'ဗန်းမော်ခရိုင်',
                'region_id' => 1,
            ],
            [
                'name' => 'ဖလမ်းခရိုင်',
                'region_id' => 2,
            ],
            [
                'name' => 'ဟားခါးခရိုင်',
                'region_id' => 2,
            ],
            [
                'name' => 'ဒက္ခိဏခရိုင်',
                'region_id' => 3,
            ],
            [
                'name' => 'ဥတ္တရခရိုင်',
                'region_id' => 3,
            ],
            [
                'name' => 'မန္တလေးခရိုင်',
                'region_id' => 4,
            ],
            [
                'name' => 'ရန်ကုန်(မြောက်ပိုင်း)',
                'region_id' => 5,
            ],
            [
                'name' => 'ရန်ကုန်(အရှေ့ပိုင်း)',
                'region_id' => 5,
            ],
            [
                'name' => 'ရန်ကုန်(တောင်ပိုင်း)',
                'region_id' => 5,
            ],
        ];

        $townships = [
            [
                'name' => 'ပျဉ်းမနား',
                'district_id' => 5,
            ],
            [
                'name' => 'ဇေယျာသီရိ',
                'district_id' => 6,
            ],
            [
                'name' => 'မဟာအောင်မြေ',
                'district_id' => 7,
            ],
            [
                'name' => 'အောင်မြေသာစံ',
                'district_id' => 7,
            ],
            [
                'name' => 'အင်းစိန်',
                'district_id' => 8,
            ],
            [
                'name' => 'မှော်ဘီ',
                'district_id' => 8,
            ],
            [
                'name' => 'သင်္ဃန်းကျွန်း',
                'district_id' => 9,
            ],
            [
                'name' => 'တာမွေ',
                'district_id' => 9,
            ],
            [
                'name' => 'သန်လျင်',
                'district_id' => 10,
            ],
            [
                'name' => 'ခရမ်း',
                'district_id' => 10,
            ],
        ];

        foreach ($regions as $region) {
            Region::create([
                'name' => $region,
            ]);
        }

        foreach ($districts as $district) {
            District::create([
                'name' => $district['name'],
                'region_id' => $district['region_id']
            ]);
        }

        foreach ($townships as $township) {
            Township::create([
                'name' => $township['name'],
                'district_id' => $township['district_id']
            ]);
        }

        // \App\Models\User::factory(10)->create();
        User::factory()->create([
            'name' => 'Kylo',
            'email' => 'kylo@gmail.com',
            'gender' => 'male',
            'password' => 'password'
        ]);
        Media::create([
            'filepath' => 'https://i.pravatar.cc/150?img=12',
            'filetype' => 'png',
            'filesize' => '1.8',
            'mediable_id' => 1,
            'mediable_type' => User::class
        ]);
        UserAddress::create([
            'user_id' => 1,
            'region_id' => 5,
            'district_id' => 9,
            'township_id' => 7,
            'address' => 'No(15), Zabutheingi St, BoKanNyut Wd',
            'zip_code' => 11011
        ]);

        User::factory()->create([
            'name' => 'Clair',
            'email' => 'clair@gmail.com',
            'gender' => 'female',
            'password' => 'password'
        ]);
        Media::create([
            'filepath' => 'https://i.pravatar.cc/150?img=47',
            'filetype' => 'png',
            'filesize' => '1.2',
            'mediable_id' => 2,
            'mediable_type' => User::class
        ]);
        UserAddress::create([
            'user_id' => 2,
            'region_id' => 4,
            'district_id' => 7,
            'township_id' => 4,
            'address' => '34830 Ronny Way Apt. 643 Cavill Avenue',
            'zip_code' => 11121
        ]);
    }
}
