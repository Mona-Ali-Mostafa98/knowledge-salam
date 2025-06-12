<?php

namespace App\Imports;

use App\Models\City;
use App\Models\Constant;
use App\Models\Country;
use App\Models\Nationality;
use App\Models\Partie;
use App\Models\PeopleExperience;
use App\Models\PeopleOrientation;
use App\Models\PeopleProfessional;
use App\Models\PeopleSocial;
use App\Models\Person;
use App\Models\Religion;
use App\Models\Sect;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class PersonImport implements ToModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[0] != 'Row ID' && ! empty($row[0]) && ! empty($row[1])) {
            $nationality = null;
            if (isset($row[9]) && ! empty($row[9])) {
                $nationality = Nationality::query()->whereJsonContainsLocale('name', 'ar', $row[9])->first();
            }
            if (isset($row[10]) && ! empty($row[10])) {
                $country = Country::query()->whereJsonContainsLocale('name', 'ar', $row[10])->first();
            }
            if (isset($row[11]) && ! empty($row[11])) {
                $city = City::query()->whereJsonContainsLocale('name', 'ar', $row[11])->first();
            }

            if (isset($row[68]) && ! empty($row[68])) {
                $religion = Religion::query()->whereJsonContainsLocale('name', 'ar', $row[68])->first();
            }
            if (isset($row[69]) && ! empty($row[69])) {
                $sect = Sect::query()->whereJsonContainsLocale('name', 'ar', $row[69])->first();
            }

            $bod = null;
            if (isset($row[7]) && ! empty($row[7])) {
                if (preg_match('/[اأإء-ي]/ui', $row[7]) || $row[7] == '00/00/0000' || $row[7] == '00-00-0000' || $row[7] == 'N/A' || $row[7] == 'Null') {
                    $row[7] = null;
                }
                try {
                    if (! empty($row[7])) {
                        $b1 = str_replace(' - ', '-', $row[7]);
                        $b2 = str_replace('- ', '-', $b1);
                        $b3 = str_replace(' -', '-', $b2);
                    }
                    $bod = Carbon::parse($b3)->format('Y-m-d');
                } catch (\Exception $e) {
                }
            }
            $death_date = null;
            if (isset($row[8]) && ! empty($row[8])) {
                if (preg_match('/[اأإء-ي]/ui', $row[8]) || $row[8] == '00/00/0000' || $row[8] == '00-00-0000' || $row[8] == 'N/A' || $row[8] == 'Null') {
                    $row[8] = null;
                }
                try {
                    if (! empty($row[8])) {
                        $d1 = str_replace(' - ', '-', $row[8]);
                        $d2 = str_replace('- ', '-', $d1);
                        $d3 = str_replace(' -', '-', $d2);
                    }
                    $death_date = Carbon::parse($d3)->format('Y-m-d');
                } catch (\Exception $e) {
                }
            }

            if (isset($row[2]) && ! empty($row[2])) {
                if ($row[2] == 'لا يوجد' || $row[2] == 'لايوجد' || $row[2] == 'غير مذكور' || $row[2] == '-' || $row[2] == 'غير متوفر') {
                    $row[2] = '';
                }
            }
            if (isset($row[5]) && ! empty($row[5])) {
                if ($row[5] == 'لا يوجد' || $row[5] == 'لايوجد' || $row[5] == 'غير مذكور' || $row[5] == '-' || $row[5] == 'غير متوفر') {
                    $row[5] = '';
                }
            }

            $marital_status = null;
            if (isset($row[13]) && ! empty($row[13])) {
                if ($row[13] == 'متزوج/ة') {
                    $marital_status = 'married';
                } elseif ($row[13] == 'غير متزوج/ة') {
                    $marital_status = 'single';
                } else {
                    $marital_status = 'other';
                }

            }
            $global_influencer = 0;
            if (isset($row[16]) && ! empty($row[16])) {
                if ($row[16] == 'نعم') {
                    $global_influencer = 1;
                }
            }

            $fame_reasons_id = 0;
            if (isset($row[17]) && ! empty($row[17])) {
                $fame_reasons = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[17])->where('type', 'fame_reasons')->first();
                if ($fame_reasons) {
                    $fame_reasons_id = $fame_reasons->id;
                } else {
                    $fame_reasons = Constant::create([
                        'name' => ['ar' => $row[17], 'en' => ''],
                        'type' => 'fame_reasons',
                    ]);
                    if ($fame_reasons) {
                        $fame_reasons_id = $fame_reasons->id;
                    }
                }
            }

            $religiosity_id = 0;
            if (isset($row[70]) && ! empty($row[70])) {
                $religiosity = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[70])->where('type', 'religiosity')->first();
                if ($religiosity) {
                    $religiosity_id = $religiosity->id;
                } else {
                    $religiosity = Constant::create([
                        'name' => ['ar' => $row[70], 'en' => ''],
                        'type' => 'religiosity',
                    ]);
                    if ($religiosity) {
                        $religiosity_id = $religiosity->id;
                    }
                }
            }

            $saudi_interested = 0;
            if (isset($row[18]) && ! empty($row[18])) {
                if ($row[18] == 'نعم') {
                    $saudi_interested = 1;
                }
            }

            $status = null;
            if (isset($row[19]) && ! empty($row[19])) {
                if ($row[19] == 'نشط') {
                    $status = 'active';
                } else {
                    $status = 'inactive';
                }

            }

            $has_issues = 0;
            if (isset($row[20]) && ! empty($row[20])) {
                if ($row[20] == 'يوجد' || $row[20] == 'نعم') {
                    $has_issues = 1;
                }
            }

            $person = Person::create([
                'first_name' => ['ar' => $row[1] ?? '', 'en' => $row[4] ?? ''],
                'mid_name' => ['ar' => $row[2] ?? '', 'en' => $row[5] ?? ''],
                'last_name' => ['ar' => $row[3] ?? '', 'en' => $row[6] ?? ''],
                'nationality_id' => $nationality->id ?? 0,
                'bod' => $bod,
                'death_date' => $death_date,
                'birth_country_id' => $country->id ?? 0,
                'birth_city_id' => $city->id ?? 0,
                'accommodation' => $row[12] ?? null,
                'marital_status' => $marital_status,
                'partner_name' => $row[14] ?? null,
                'global_influencer' => $global_influencer,
                'saudi_interested' => $saudi_interested,
                'fame_reasons_id' => $fame_reasons_id,
                'status' => $status,
                'has_issues' => $has_issues,
                'issues' => $row[21] ?? null,
                'mobile' => $row[22] ?? null,
                'email' => $row[23] ?? null,
                'address' => $row[24] ?? null,

                'religion_id' => $religion->id ?? 0,
                'sect_id' => $sect->id ?? 0,
                'religiosity_id' => $religiosity_id,
                'resources' => $row[119] ?? null,

            ]);

            if (isset($row[25]) && ! empty($row[25])) {
                $socials_type = preg_split('/\\r\\n|\\r|\\n/', $row[25]);
                if (isset($row[26]) && ! empty($row[26])) {
                    $socials_links = preg_split('/\\r\\n|\\r|\\n/', $row[26]);
                    if (count($socials_links) == 1) {
                        $socials_links = explode(',', $row[26]);
                    }
                }
                foreach ($socials_type as $key => $social) {
                    if ($social != 'لا يوجد' && $social != 'لا تتوفر المعلومة') {
                        $social_type = Constant::query()->whereJsonContainsLocale('name', 'ar', $social)->where('type', 'social_types')->first();
                        if ($social_type) {
                            $social_type_id = $social_type->id;
                        } else {
                            $social_type = Constant::create([
                                'name' => ['ar' => $social, 'en' => ''],
                                'type' => 'social_types',
                            ]);
                            if ($social_type) {
                                $social_type_id = $social_type->id;
                            }
                        }
                        $influence_level_id = 0;
                        if (isset($row[28]) && ! empty($row[28])) {
                            $influence_level = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[28])->where('type', 'influence_levels')->first();
                            if ($influence_level) {
                                $influence_level_id = $influence_level->id;
                            } else {
                                $influence_level = Constant::create([
                                    'name' => ['ar' => $row[28], 'en' => ''],
                                    'type' => 'influence_levels',
                                ]);
                                if ($influence_level) {
                                    $influence_level_id = $influence_level->id;
                                }
                            }
                        }
                        $status_id = 0;
                        if (isset($row[29]) && ! empty($row[29])) {
                            $status = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[29])->where('type', 'social_statuses')->first();
                            if ($status) {
                                $status_id = $status->id;
                            } else {
                                $status = Constant::create([
                                    'name' => ['ar' => $row[29], 'en' => ''],
                                    'type' => 'social_statuses',
                                ]);
                                if ($status) {
                                    $status_id = $status->id;
                                }
                            }
                        }
                        PeopleSocial::create([
                            'person_id' => $person->id,
                            'type_id' => $social_type_id,
                            'link' => $socials_links[$key] ?? '',
                            'flower_count' => intval($row[27]),
                            'status_id' => $status_id,
                            'influence_level_id' => $influence_level_id,
                        ]);
                    }
                }

            }

            if (isset($row[30]) && ! empty($row[30])) {
                if ($row[30] == 'دكتوراه') {
                    $qualification = 'doctorate';
                } elseif ($row[30] == 'بكالوريوس') {
                    $qualification = 'bachelor';
                } elseif ($row[30] == 'ماجستير') {
                    $qualification = 'master';
                } elseif ($row[30] == 'دبلوم') {
                    $qualification = 'diploma';
                } else {
                    $qualification = 'other';
                }
                $specializations_id = 0;
                if (isset($row[31]) && ! empty($row[31])) {
                    $specializations = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[31])->where('type', 'specializations')->first();
                    if ($specializations) {
                        $specializations_id = $specializations->id;
                    } else {
                        $specializations = Constant::create([
                            'name' => ['ar' => $row[31], 'en' => ''],
                            'type' => 'specializations',
                        ]);
                        if ($specializations) {
                            $specializations_id = $specializations->id;
                        }
                    }
                }

                $start = null;
                if (isset($row[33]) && ! empty($row[33])) {
                    if (preg_match('/[اأإء-ي]/ui', $row[33]) || $row[33] == '00/00/0000' || $row[33] == '00-00-0000' || $row[33] == 'N/A' || $row[33] == 'Null') {
                        $row[33] = null;
                    }
                    try {
                        if (! empty($row[33])) {
                            $d1 = str_replace(' - ', '-', $row[33]);
                            $d2 = str_replace('- ', '-', $d1);
                            $d3 = str_replace(' -', '-', $d2);
                            $start = Carbon::parse($d3)->format('Y-m-d');
                        }
                    } catch (\Exception $e) {
                    }
                }
                $end = null;
                if (isset($row[34]) && ! empty($row[34])) {
                    if (preg_match('/[اأإء-ي]/ui', $row[34]) || $row[34] == '00/00/0000' || $row[34] == '00-00-0000' || $row[34] == 'N/A' || $row[34] == 'Null') {
                        $row[34] = null;
                    }
                    try {
                        if (! empty($row[34])) {
                            $d1 = str_replace(' - ', '-', $row[34]);
                            $d2 = str_replace('- ', '-', $d1);
                            $d3 = str_replace(' -', '-', $d2);
                            $end = Carbon::parse($d3)->format('Y-m-d');
                        }
                    } catch (\Exception $e) {
                    }
                }

                $influence_id = 0;
                if (isset($row[36]) && ! empty($row[36])) {
                    $influence = explode(' ', $row[36]);

                    $influence_level = Constant::query()->whereJsonContainsLocale('name', 'ar', $influence[0])->where('type', 'influence_levels')->first();
                    if ($influence_level) {
                        $influence_id = $influence_level->id;
                    } else {
                        $influence_level = Constant::create([
                            'name' => ['ar' => $influence[0], 'en' => ''],
                            'type' => 'influence_levels',
                        ]);
                        if ($influence_level) {
                            $influence_id = $influence_level->id;
                        }
                    }
                }

                PeopleExperience::create([
                    'person_id' => $person->id,
                    'qualification' => $qualification,
                    'institution' => $row[32] ?? null,
                    'specializations_id' => $specializations_id,
                    'start' => $start,
                    'end' => $end,
                    'details' => $row[35] ?? null,
                    'influence_id' => $influence_id,
                ]);
            }

            if (isset($row[41]) && ! empty($row[41])) {

                $start = null;
                if (isset($row[44]) && ! empty($row[44])) {
                    if (preg_match('/[اأإء-ي]/ui', $row[44]) || $row[44] == '00/00/0000' || $row[44] == '00-00-0000' || $row[44] == 'N/A' || $row[44] == 'Null') {
                        $row[44] = null;
                    }
                    try {
                        if (! empty($row[44])) {
                            $d1 = str_replace(' - ', '-', $row[44]);
                            $d2 = str_replace('- ', '-', $d1);
                            $d3 = str_replace(' -', '-', $d2);
                            $start = Carbon::parse($d3)->format('Y-m-d');
                        }
                    } catch (\Exception $e) {
                    }
                }
                $end = null;

                $organization_type_id = 0;
                if (isset($row[37]) && ! empty($row[37])) {
                    $organization_type = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[37])->where('type', 'organizations_types')->first();
                    if ($organization_type) {
                        $organization_type_id = $organization_type->id;
                    } else {
                        $organization_type = Constant::create([
                            'name' => ['ar' => $row[37], 'en' => ''],
                            'type' => 'organizations_types',
                        ]);
                        if ($organization_type) {
                            $organization_type_id = $organization_type->id;
                        }
                    }
                }
                $organization_level_id = 0;
                if (isset($row[38]) && ! empty($row[38])) {
                    $organization_level = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[38])->where('type', 'organizations_levels')->first();
                    if ($organization_level) {
                        $organization_level_id = $organization_level->id;
                    } else {
                        $organization_level = Constant::create([
                            'name' => ['ar' => $row[38], 'en' => ''],
                            'type' => 'organizations_levels',
                        ]);
                        if ($organization_level) {
                            $organization_level_id = $organization_level->id;
                        }
                    }
                }
                $institution_type_id = 0;
                if (isset($row[39]) && ! empty($row[39])) {
                    $institution_type = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[39])->where('type', 'institution_types')->first();
                    if ($institution_type) {
                        $institution_type_id = $institution_type->id;
                    } else {
                        $institution_type = Constant::create([
                            'name' => ['ar' => $row[39], 'en' => ''],
                            'type' => 'institution_types',
                        ]);
                        if ($institution_type) {
                            $institution_type_id = $institution_type->id;
                        }
                    }
                }
                $position_id = 0;
                if (isset($row[41]) && ! empty($row[41])) {
                    $position = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[41])->where('type', 'positions')->first();
                    if ($position) {
                        $position_id = $position->id;
                    } else {
                        $position = Constant::create([
                            'name' => ['ar' => $row[41], 'en' => ''],
                            'type' => 'positions',
                        ]);
                        if ($position) {
                            $position_id = $position->id;
                        }
                    }
                }
                $specialization_id = 0;
                if (isset($row[42]) && ! empty($row[42])) {
                    $specialization = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[42])->where('type', 'specializations')->first();
                    if ($specialization) {
                        $specialization_id = $specialization->id;
                    } else {
                        $specialization = Constant::create([
                            'name' => ['ar' => $row[42], 'en' => ''],
                            'type' => 'specializations',
                        ]);
                        if ($specialization) {
                            $specialization_id = $specialization->id;
                        }
                    }
                }

                $influence_level_id = 0;
                if (isset($row[43]) && ! empty($row[43])) {
                    $influence = explode(' ', $row[43]);

                    $influence_level = Constant::query()->whereJsonContainsLocale('name', 'ar', $influence[0])->where('type', 'influence_levels')->first();
                    if ($influence_level) {
                        $influence_level_id = $influence_level->id;
                    } else {
                        $influence_level = Constant::create([
                            'name' => ['ar' => $influence[0], 'en' => ''],
                            'type' => 'influence_levels',
                        ]);
                        if ($influence_level) {
                            $influence_level_id = $influence_level->id;
                        }
                    }
                }

                PeopleProfessional::create([
                    'person_id' => $person->id,
                    'institution' => $row[40] ?? null,
                    'start' => $start,
                    'end' => $end,
                    'description' => $row[45] ?? null,
                    'organization_type_id' => $organization_type_id,
                    'organization_level_id' => $organization_level_id,
                    'institution_type_id' => $institution_type_id,
                    'position_id' => $position_id,
                    'specialization_id' => $specialization_id,
                    'influence_level_id' => $influence_level_id,
                ]);
            }

            if (isset($row[71]) && ! empty($row[71])) {
                $has_party = 0;
                if ($row[71] == 'يوجد' || $row[71] == 'نعم') {
                    $has_party = 1;

                    $partie = null;
                    if (isset($row[72]) && ! empty($row[72])) {
                        $partie = Partie::query()->whereJsonContainsLocale('name', 'ar', $row[72])->first();
                    }

                    $orientation_id = 0;
                    if (isset($row[73]) && ! empty($row[73])) {
                        $orientation = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[73])->where('type', 'political_orientation')->first();
                        if ($orientation) {
                            $orientation_id = $orientation->id;
                        } else {
                            $orientation = Constant::create([
                                'name' => ['ar' => $row[73], 'en' => ''],
                                'type' => 'political_orientation',
                            ]);
                            if ($orientation) {
                                $orientation_id = $orientation->id;
                            }
                        }
                    }
                    $commitment_id = 0;
                    if (isset($row[74]) && ! empty($row[74])) {
                        $commitment = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[74])->where('type', 'commitment')->first();
                        if ($commitment) {
                            $commitment_id = $commitment->id;
                        } else {
                            $commitment = Constant::create([
                                'name' => ['ar' => $row[74], 'en' => ''],
                                'type' => 'commitment',
                            ]);
                            if ($commitment) {
                                $commitment_id = $commitment->id;
                            }
                        }
                    }

                    PeopleOrientation::create([
                        'person_id' => $person->id,
                        'has_party' => $has_party,
                        'parties_id' => $partie->id ?? 0,
                        'orientation_id' => $orientation_id,
                        'commitment_id' => $commitment_id,
                        'political_positions' => $row[77] ?? null,
                        'meeting_points' => $row[79] ?? null,
                        'saudi_issue_position' => $row[78] ?? null,
                    ]);
                }
            }

            if (isset($row[86]) && ! empty($row[86]) && isset($row[87]) && ! empty($row[87])) {

                $publish_date = null;
                if (isset($row[88]) && ! empty($row[88])) {
                    if (preg_match('/[اأإء-ي]/ui', $row[88]) || $row[88] == '00/00/0000' || $row[88] == '00-00-0000' || $row[88] == 'N/A' || $row[88] == 'Null') {
                        $row[88] = null;
                    }
                    try {
                        if (! empty($row[88])) {
                            $d1 = str_replace(' - ', '-', $row[88]);
                            $d2 = str_replace('- ', '-', $d1);
                            $d3 = str_replace(' -', '-', $d2);
                            $publish_date = Carbon::parse($d3)->format('Y-m-d');
                        }
                    } catch (\Exception $e) {
                    }
                }
                $position_type_id = 0;
                if (isset($row[85]) && ! empty($row[85])) {
                    $position_type = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[85])->where('type', 'positions_types')->first();
                    if ($position_type) {
                        $position_type_id = $position_type->id;
                    } else {
                        $position_type = Constant::create([
                            'name' => ['ar' => $row[85], 'en' => ''],
                            'type' => 'positions_types',
                        ]);
                        if ($position_type) {
                            $position_type_id = $position_type->id;
                        }
                    }
                }
                $direction_id = 0;
                if (isset($row[90]) && ! empty($row[90])) {
                    $direction = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[90])->where('type', 'saudi_direction')->first();
                    if ($direction) {
                        $direction_id = $direction->id;
                    } else {
                        $direction = Constant::create([
                            'name' => ['ar' => $row[90], 'en' => ''],
                            'type' => 'saudi_direction',
                        ]);
                        if ($direction) {
                            $direction_id = $direction->id;
                        }
                    }
                }
                $tags = null;
                if (isset($row[91]) && ! empty($row[91])) {
                    $tags = preg_split('/\\r\\n|\\r|\\n/', $row[91]);
                    if (count($tags) == 1) {
                        $tags = explode('،', $row[91]);
                    }
                    $tags = implode(',', $tags);
                }

            }

            if (isset($row[94]) && ! empty($row[94]) && isset($row[93]) && ! empty($row[93])) {

                $publish_date = null;
                if (isset($row[95]) && ! empty($row[95])) {
                    if (preg_match('/[اأإء-ي]/ui', $row[95]) || $row[95] == '00/00/0000' || $row[95] == '00-00-0000' || $row[95] == 'N/A' || $row[95] == 'Null') {
                        $row[95] = null;
                    }
                    try {
                        if (! empty($row[95])) {
                            $d1 = str_replace(' - ', '-', $row[95]);
                            $d2 = str_replace('- ', '-', $d1);
                            $d3 = str_replace(' -', '-', $d2);
                            $publish_date = Carbon::parse($d3)->format('Y-m-d');
                        }
                    } catch (\Exception $e) {
                    }
                }
                $position_type_id = 0;
                if (isset($row[92]) && ! empty($row[92])) {
                    $position_type = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[92])->where('type', 'positions_types')->first();
                    if ($position_type) {
                        $position_type_id = $position_type->id;
                    } else {
                        $position_type = Constant::create([
                            'name' => ['ar' => $row[92], 'en' => ''],
                            'type' => 'positions_types',
                        ]);
                        if ($position_type) {
                            $position_type_id = $position_type->id;
                        }
                    }
                }
                $direction_id = 0;
                if (isset($row[97]) && ! empty($row[97])) {
                    $direction = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[97])->where('type', 'saudi_direction')->first();
                    if ($direction) {
                        $direction_id = $direction->id;
                    } else {
                        $direction = Constant::create([
                            'name' => ['ar' => $row[97], 'en' => ''],
                            'type' => 'saudi_direction',
                        ]);
                        if ($direction) {
                            $direction_id = $direction->id;
                        }
                    }
                }
                $tags = null;
                if (isset($row[98]) && ! empty($row[98])) {
                    $tags = preg_split('/\\r\\n|\\r|\\n/', $row[98]);
                    if (count($tags) == 1) {
                        $tags = explode('،', $row[98]);
                    }
                    $tags = implode(',', $tags);
                }

            }

            if (isset($row[101]) && ! empty($row[101]) && isset($row[100]) && ! empty($row[100])) {

                $publish_date = null;
                if (isset($row[102]) && ! empty($row[102])) {
                    if (preg_match('/[اأإء-ي]/ui', $row[102]) || $row[102] == '00/00/0000' || $row[102] == '00-00-0000' || $row[102] == 'N/A' || $row[102] == 'Null') {
                        $row[102] = null;
                    }
                    try {
                        if (! empty($row[102])) {
                            $d1 = str_replace(' - ', '-', $row[102]);
                            $d2 = str_replace('- ', '-', $d1);
                            $d3 = str_replace(' -', '-', $d2);
                            $publish_date = Carbon::parse($d3)->format('Y-m-d');
                        }
                    } catch (\Exception $e) {
                    }
                }
                $position_type_id = 0;
                if (isset($row[99]) && ! empty($row[99])) {
                    $position_type = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[99])->where('type', 'positions_types')->first();
                    if ($position_type) {
                        $position_type_id = $position_type->id;
                    } else {
                        $position_type = Constant::create([
                            'name' => ['ar' => $row[99], 'en' => ''],
                            'type' => 'positions_types',
                        ]);
                        if ($position_type) {
                            $position_type_id = $position_type->id;
                        }
                    }
                }
                $direction_id = 0;
                if (isset($row[104]) && ! empty($row[104])) {
                    $direction = Constant::query()->whereJsonContainsLocale('name', 'ar', $row[104])->where('type', 'saudi_direction')->first();
                    if ($direction) {
                        $direction_id = $direction->id;
                    } else {
                        $direction = Constant::create([
                            'name' => ['ar' => $row[104], 'en' => ''],
                            'type' => 'saudi_direction',
                        ]);
                        if ($direction) {
                            $direction_id = $direction->id;
                        }
                    }
                }
                $tags = null;
                if (isset($row[105]) && ! empty($row[105])) {
                    $tags = preg_split('/\\r\\n|\\r|\\n/', $row[105]);
                    if (count($tags) == 1) {
                        $tags = explode('،', $row[105]);
                    }
                    $tags = implode(',', $tags);
                }
            }

        }
    }
}
