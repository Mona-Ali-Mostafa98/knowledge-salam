<?php

namespace App\Imports;

use App\Models\City;
use App\Models\Constant;
use App\Models\Country;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class ArticleImport implements ToModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[0] != 'Row ID' && ! empty($row[0]) && ! empty($row[1])) {

            $article_type_id = 0;
            if (isset($row[1]) && ! empty($row[1])) {
                if (! in_array($row[1], ['تقرير', 'مقالة'])) {
                    $row[1] = 'أخرى';
                }
                $article_type = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[1])->where('type', 'articles_types')->first();
                if ($article_type) {
                    $article_type_id = $article_type->id;
                } else {
                    $article_type = Constant::create([
                        'name' => ['ar' => $row[1], 'en' => ''],
                        'type' => 'articles_types',
                    ]);
                    if ($article_type) {
                        $article_type_id = $article_type->id;
                    }
                }
            }
            $publish_date = null;
            if (isset($row[4]) && ! empty($row[4])) {
                if (preg_match('/[اأإء-ي]/ui', $row[4]) || $row[4] == '00/00/0000' || $row[4] == '00-00-0000' || $row[4] == 'N/A' || $row[4] == 'Null') {
                    $row[88] = null;
                }
                try {
                    if (! empty($row[4])) {
                        $d1 = str_replace(' - ', '-', $row[4]);
                        $d2 = str_replace('- ', '-', $d1);
                        $d3 = str_replace(' -', '-', $d2);
                        $publish_date = Carbon::parse($d3)->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                }
            }

            $publish_institution_type_id = 0;
            if (isset($row[5]) && ! empty($row[5])) {
                $publish_institution_type = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[5])->where('type', 'institution_types')->first();
                if ($publish_institution_type) {
                    $publish_institution_type_id = $publish_institution_type->id;
                } else {
                    $publish_institution_type = Constant::create([
                        'name' => ['ar' => $row[5], 'en' => ''],
                        'type' => 'institution_types',
                    ]);
                    if ($publish_institution_type) {
                        $publish_institution_type_id = $publish_institution_type->id;
                    }
                }
            }

            $continent_id = 0;
            if (isset($row[7]) && ! empty($row[7])) {
                $continent = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[7])->where('type', 'continent')->first();
                if ($continent) {
                    $continent_id = $continent->id;
                } else {
                    $continent = Constant::create([
                        'name' => ['ar' => $row[7], 'en' => ''],
                        'type' => 'continent',
                    ]);
                    if ($continent) {
                        $continent_id = $continent->id;
                    }
                }
            }

            $language_id = 0;
            if (isset($row[13]) && ! empty($row[13])) {
                $language = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[13])->where('type', 'languages')->first();
                if ($language) {
                    $language_id = $language->id;
                } else {
                    $language = Constant::create([
                        'name' => ['ar' => $row[13], 'en' => ''],
                        'type' => 'languages',
                    ]);
                    if ($language) {
                        $language_id = $language->id;
                    }
                }
            }

            $report_direction_id = 0;
            if (isset($row[15]) && ! empty($row[15])) {
                $report_direction = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[15])->where('type', 'report_directions')->first();
                if ($report_direction) {
                    $report_direction_id = $report_direction->id;
                } else {
                    $report_direction = Constant::create([
                        'name' => ['ar' => $row[15], 'en' => ''],
                        'type' => 'report_directions',
                    ]);
                    if ($report_direction) {
                        $report_direction_id = $report_direction->id;
                    }
                }
            }
            $added_reason_id = 0;
            if (isset($row[16]) && ! empty($row[16])) {
                $added_reasons = preg_split('/\\r\\n|\\r|\\n/', $row[16]);
                if (count($added_reasons) > 0) {
                    $added_reason = Constant::query()->whereJsonContainsLocale('name', 'ar', $added_reasons[0])->where('type', 'added_reasons')->first();
                    if ($added_reason) {
                        $added_reason_id = $added_reason->id;
                    } else {
                        $added_reason = Constant::create([
                            'name' => ['ar' => $added_reasons[0], 'en' => ''],
                            'type' => 'added_reasons',
                        ]);
                        if ($added_reason) {
                            $added_reason_id = $added_reason->id;
                        }
                    }
                }
            }

            $repetition_id = 0;
            if (isset($row[17]) && ! empty($row[17])) {
                $repetition = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[17])->where('type', 'repetitions')->first();
                if ($repetition) {
                    $repetition_id = $repetition->id;
                } else {
                    $repetition = Constant::create([
                        'name' => ['ar' => $row[17], 'en' => ''],
                        'type' => 'repetitions',
                    ]);
                    if ($repetition) {
                        $repetition_id = $repetition->id;
                    }
                }
            }

            $saudi_issue_direction_id = 0;
            if (isset($row[18]) && ! empty($row[18])) {
                $saudi_issue_direction = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[18])->where('type', 'saudi_issue_direction')->first();
                if ($saudi_issue_direction) {
                    $saudi_issue_direction_id = $saudi_issue_direction->id;
                } else {
                    $saudi_issue_direction = Constant::create([
                        'name' => ['ar' => $row[18], 'en' => ''],
                        'type' => 'saudi_issue_direction',
                    ]);
                    if ($saudi_issue_direction) {
                        $saudi_issue_direction_id = $saudi_issue_direction->id;
                    }
                }
            }
            $contribution_type_id = 0;
            if (isset($row[21]) && ! empty($row[21])) {
                $contribution_type = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[21])->where('type', 'contribution_type')->first();
                if ($contribution_type) {
                    $contribution_type_id = $contribution_type->id;
                } else {
                    $contribution_type = Constant::create([
                        'name' => ['ar' => $row[21], 'en' => ''],
                        'type' => 'contribution_type',
                    ]);
                    if ($contribution_type) {
                        $contribution_type_id = $contribution_type->id;
                    }
                }
            }
            $dimension_id = 0;
            if (isset($row[19]) && ! empty($row[19])) {
                $dimension = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[19])->where('type', 'dimensions')->first();
                if ($dimension) {
                    $dimension_id = $dimension->id;
                } else {
                    $dimension = Constant::create([
                        'name' => ['ar' => $row[19], 'en' => ''],
                        'type' => 'dimensions',
                    ]);
                    if ($dimension) {
                        $dimension_id = $dimension->id;
                    }
                }
            }

            $organizations_role_id = 0;
            if (isset($row[24]) && ! empty($row[24])) {
                $organizations_role = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[24])->where('type', 'organizations_roles')->first();
                if ($organizations_role) {
                    $organizations_role_id = $organizations_role->id;
                } else {
                    $organizations_role = Constant::create([
                        'name' => ['ar' => $row[24], 'en' => ''],
                        'type' => 'organizations_roles',
                    ]);
                    if ($organizations_role) {
                        $organizations_role_id = $organizations_role->id;
                    }
                }
            }

            $contribution_role_id = 0;
            if (isset($row[25]) && ! empty($row[25])) {
                $contribution_role = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[25])->where('type', 'contribution_roles')->first();
                if ($contribution_role) {
                    $contribution_role_id = $contribution_role->id;
                } else {
                    $contribution_role = Constant::create([
                        'name' => ['ar' => $row[25], 'en' => ''],
                        'type' => 'contribution_roles',
                    ]);
                    if ($contribution_role) {
                        $contribution_role_id = $contribution_role->id;
                    }
                }
            }

            if (isset($row[8]) && ! empty($row[8])) {
                $country = Country::query()->whereJsonContainsLocale('name', 'ar', $row[8])->first();
            }

            $tags = null;
            if (isset($row[14]) && ! empty($row[14])) {
                $tags = preg_split('/\\r\\n|\\r|\\n/', $row[14]);
                if (count($tags) == 1) {
                    $tags = explode('،', $row[14]);
                }
                $tags = implode(',', $tags);
            }

            $countries_array = [];
            if (isset($row[11]) && ! empty($row[11])) {
                $countries = preg_split('/\\r\\n|\\r|\\n/', $row[11]);
                if (count($countries) > 0) {
                    foreach ($countries as $c) {
                        $country = Country::query()->whereJsonContainsLocale('name', 'ar', $c)->first();
                        if ($country) {
                            $countries_array[] = $country->id;
                        }
                    }
                }
            }

            $cities_array = [];
            if (isset($row[12]) && ! empty($row[12])) {
                $cities = preg_split('/\\r\\n|\\r|\\n/', $row[12]);
                if (count($cities) > 0) {
                    foreach ($cities as $c) {
                        $city = City::query()->whereJsonContainsLocale('name', 'ar', $c)->first();
                        if ($city) {
                            $cities_array[] = $city->id;
                        }
                    }
                }
            }
        }
    }
}
