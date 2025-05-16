<?php

namespace App\Imports;

use App\Models\City;
use App\Models\Constant;
use App\Models\Country;
use App\Models\Organization;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class OrganizationImport implements ToModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[0] != 'Row ID' && ! empty($row[0]) && ! empty($row[1])) {
            if (isset($row[9]) && ! empty($row[9])) {
                $country = Country::query()->whereJsonContainsLocale('name', 'ar', $row[9])->first();
            }
            if (isset($row[10]) && ! empty($row[10])) {
                $city = City::query()->whereJsonContainsLocale('name', 'ar', $row[10])->first();
            }

            $foundation_date = null;
            if (isset($row[3]) && ! empty($row[3])) {
                if (preg_match('/[اأإء-ي]/ui', $row[3]) || $row[3] == '00/00/0000' || $row[3] == '00-00-0000' || $row[3] == 'N/A' || $row[3] == 'Null') {
                    $row[3] = null;
                }
                try {
                    if (! empty($row[3])) {
                        $b1 = str_replace(' - ', '-', $row[3]);
                        $b2 = str_replace('- ', '-', $b1);
                        $b3 = str_replace(' -', '-', $b2);
                    }
                    $foundation_date = Carbon::parse($b3)->format('Y-m-d');
                } catch (\Exception $e) {
                }
            }
            $type_id = 0;
            if (isset($row[4]) && ! empty($row[4])) {
                $type = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[4])->where('type', 'organizations_types')->first();
                if ($type) {
                    $type_id = $type->id;
                } else {
                    $type = Constant::create([
                        'name' => ['ar' => $row[4], 'en' => ''],
                        'type' => 'organizations_types',
                    ]);
                    if ($type) {
                        $type_id = $type->id;
                    }
                }
            }
            $organization_level_id = 0;
            if (isset($row[5]) && ! empty($row[5])) {
                $organization_level = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[5])->where('type', 'organizations_levels')->first();
                if ($organization_level) {
                    $organization_level_id = $organization_level->id;
                } else {
                    $organization_level = Constant::create([
                        'name' => ['ar' => $row[5], 'en' => ''],
                        'type' => 'organizations_levels',
                    ]);
                    if ($organization_level) {
                        $organization_level_id = $organization_level->id;
                    }
                }
            }
            $money_resource_id = 0;
            if (isset($row[6]) && ! empty($row[6])) {
                $money_resources = explode('(', $row[6]);
                if (isset($money_resources[0])) {
                    $money_resource = Constant::query()->whereJsonContainsLocale('name', 'ar', $money_resources[0])->where('type', 'money_resources')->first();
                    if ($money_resource) {
                        $money_resource_id = $money_resource->id;
                    } else {
                        $money_resource = Constant::create([
                            'name' => ['ar' => $money_resources[0], 'en' => ''],
                            'type' => 'money_resources',
                        ]);
                        if ($money_resource) {
                            $money_resource_id = $money_resource->id;
                        }
                    }
                }
            }
            $continent_id = 0;
            if (isset($row[8]) && ! empty($row[8])) {
                $continent = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[8])->where('type', 'continent')->first();
                if ($continent) {
                    $continent_id = $continent->id;
                } else {
                    $continent = Constant::create([
                        'name' => ['ar' => $row[8], 'en' => ''],
                        'type' => 'continent',
                    ]);
                    if ($continent) {
                        $continent_id = $continent->id;
                    }
                }
            }

            $boss_join = null;
            if (isset($row[18]) && ! empty($row[18])) {
                if (preg_match('/[اأإء-ي]/ui', $row[18]) || $row[18] == '00/00/0000' || $row[18] == '0-0-0000' || $row[18] == '0000-00-00' || $row[18] == '00-00-0000' || $row[18] == 'N/A' || $row[18] == 'Null') {
                    $row[18] = null;
                }
                try {
                    if (! empty($row[18])) {
                        $b1 = str_replace(' - ', '-', $row[18]);
                        $b2 = str_replace('- ', '-', $b1);
                        $b3 = str_replace(' -', '-', $b2);
                    }
                    $boss_join = Carbon::parse($b3)->format('Y-m-d');
                } catch (\Exception $e) {
                }
            }
            $boss_leave = null;
            if (isset($row[19]) && ! empty($row[19])) {
                if (preg_match('/[اأإء-ي]/ui', $row[19]) || $row[19] == '00/00/0000' || $row[19] == '0000-00-00' || $row[19] == '00-00-0000' || $row[19] == 'N/A' || $row[19] == 'Null') {
                    $row[19] = null;
                }
                try {
                    if (! empty($row[19])) {
                        $b1 = str_replace(' - ', '-', $row[19]);
                        $b2 = str_replace('- ', '-', $b1);
                        $b3 = str_replace(' -', '-', $b2);
                    }
                    $boss_leave = Carbon::parse($b3)->format('Y-m-d');
                } catch (\Exception $e) {
                }
            }

            $global_influencer = 0;
            if (isset($row[13]) && ! empty($row[13])) {
                if ($row[13] == 'نعم') {
                    $global_influencer = 1;
                }
            }
            $saudi_interested = 0;
            if (isset($row[14]) && ! empty($row[14])) {
                if ($row[14] == 'نعم') {
                    $saudi_interested = 1;
                }
            }

            $status_id = 0;
            if (isset($row[15]) && ! empty($row[15])) {
                $status = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[15])->where('type', 'organizations_statuses')->first();
                if ($status) {
                    $status_id = $status->id;
                } else {
                    $status = Constant::create([
                        'name' => ['ar' => $row[15], 'en' => ''],
                        'type' => 'organizations_statuses',
                    ]);
                    if ($status) {
                        $status_id = $status->id;
                    }
                }
            }

            $organization = Organization::create([
                'name' => ['ar' => $row[1] ?? '', 'en' => $row[2] ?? ''],
                'foundation_date' => $foundation_date,
                'type_id' => $type_id,
                'continent_id' => $continent_id,
                'country_id' => $country->id ?? 0,
                'boss' => ['ar' => $row[16] ?? '', 'en' => $row[17] ?? ''],
                'details' => $row[11] ?? null,
                'website' => $row[12] ?? null,
                'status_id' => $status_id,
                'email' => $row[50] ?? null,
                'mobile' => $row[49] ?? null,
                'organization_level_id' => $organization_level_id,
                'money_resource_id' => $money_resource_id,
                'city_id' => $city->id ?? 0,
                'global_influencer' => $global_influencer,
                'saudi_interested' => $saudi_interested,
                'boss_join' => $boss_join,
                'boss_leave' => $boss_leave,
                'address' => $row[51] ?? null,
                'resources' => $row[52] ?? null,

            ]);

        }
    }
}
