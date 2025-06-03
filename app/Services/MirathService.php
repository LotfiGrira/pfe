<?php

namespace App\Services;

use App\Data\MirathInput;
use App\Models\Mirath;
use Symfony\Component\VarDumper\VarDumper;

class MirathService
{
    protected $input;
    protected $far3WarithDhakar;
    protected $far3WarithOntha;
    protected $far3Warith;
    protected $rapport;
    protected $part;
    protected $type;
    protected float $tarika = 0;
    protected float $doyon = 0;
    protected float $wasiya = 0;
    protected float $partActuel = 0.0;
    protected float $reste = 0;
    // 6 variable
    protected array $nesef = ["bast" => 1, "ma9am" => 2];
    protected array $robo3 = ["bast" => 1, "ma9am" => 4];
    protected array $thomon = ["bast" => 1, "ma9am" => 8];
    protected array $tholothin = ["bast" => 2, "ma9am" => 3];
    protected array $tholoth = ["bast" => 1, "ma9am" => 3];
    protected array $sodoss = ["bast" => 1, "ma9am" => 6];
    protected array $nesefsodos = ["bast" => 1, "ma9am" => 12];


    public function __construct(array $input = [])
    {
        $this->input = $input;

        // Initialiser tarika, doyoun, wasiya à partir des données d'entrée
        $this->tarika = isset($input['tarika']) ? (float) $input['tarika'] : 0;
        $this->doyon = isset($input['doyon']) ? (float) $input['doyon'] : 0;
        $this->wasiya = isset($input['wasiya']) ? (float) $input['wasiya'] : 0;
    }



    public function calculMirath(&$mirathInput)
    {
        // nsjlou table 9esma bech yaatina id (cle primaire)
        $this->far3WarithDhakar = ($mirathInput['alabna'] > 0) + ($mirathInput['abna_alabna'] > 0) > 0;
        $this->far3WarithOntha = ($mirathInput['albanat'] > 0) + ($mirathInput['banat_alabna'] > 0) > 0;
        $this->far3Warith = $this->far3WarithDhakar || $this->far3WarithOntha;
        $mirathInput['safi_tarika'] = $mirathInput['tarika'] - $mirathInput['doyon'] - $mirathInput['wasiya'];
        $mirathInput['reste'] = $mirathInput['safi_tarika'];

        // === Type One (½, ¼, ⅛) ===
        $hasHalfConditions = [
            'zawj' => ($mirathInput['zawj'] && !$this->far3Warith),
            'albanat' => ($mirathInput['albanat'] == 1 && $mirathInput['alabna'] == 0),
            'banat_alabna' => ($mirathInput['banat_alabna'] == 1 && $mirathInput['abna_alabna'] == 0 && $mirathInput['alabna'] == 0 && $mirathInput['albanat'] < 2),
            'alakhawat_ashakikat' => ($mirathInput['alakhawat_ashakikat'] == 1 && $mirathInput['alab'] == 0 && !$this->far3Warith && $mirathInput['alikhwa_alashika'] == 0 && $mirathInput['aljad'] == 0),
            'alakhawat_li_ab' => ($mirathInput['alakhawat_li_ab'] == 1 && $mirathInput['alab'] == 0 && !$this->far3Warith && $mirathInput['alikhwa_alashika'] == 0 && $mirathInput['alakhawat_ashakikat'] < 2 && $mirathInput['alikhwa_li_ab'] == 0 && $mirathInput['aljad'] == 0)
        ];

        $hasQuarterConditions = [
            'zawj_with_far3' => ($mirathInput['zawj'] && $this->far3Warith),
            'zawja_without_far3' => ($mirathInput['zawja'] && !$this->far3Warith)
        ];

        $hasEighthConditions = [
            'zawja_with_far3' => ($mirathInput['zawja'] && $this->far3Warith)
        ];

        $hasTwoThirdsConditions = [
            'albanat' => ($mirathInput['albanat'] >= 2 && $mirathInput['alabna'] == 0),
            'banat_alabna' => ($mirathInput['banat_alabna'] >= 2 && $mirathInput['abna_alabna'] == 0 && $mirathInput['alabna'] == 0 && $mirathInput['albanat'] < 2),
            'alakhawat_ashakikat' => ($mirathInput['alakhawat_ashakikat'] >= 2 && $mirathInput['alab'] == 0 && !$this->far3Warith && $mirathInput['alikhwa_alashika'] == 0 && $mirathInput['aljad'] == 0),
            'alakhawat_li_ab' => ($mirathInput['alakhawat_li_ab'] >= 2 && $mirathInput['alab'] == 0 && !$this->far3Warith && $mirathInput['alikhwa_alashika'] == 0 && $mirathInput['alakhawat_ashakikat'] < 2 && $mirathInput['aljad'] == 0)
        ];

        $hasOneThirdConditions = [
            'alom' => ($mirathInput['alom'] && !$this->far3Warith),
            'alikhwa_li_om' => (($mirathInput['alikhwa_li_om'] + $mirathInput['alakhawat_li_om']) >= 2 && !$this->far3Warith && $mirathInput['alab'] == 0 && $mirathInput['aljad'] == 0)
        ];

        $hasOneSixthConditions = [
            'alab' => ($mirathInput['alab'] && $this->far3Warith),
            'aljad' => ($mirathInput['aljad'] && $this->far3Warith),
            'alom_with_far3' => ($mirathInput['alom'] && $this->far3Warith),
            'banat_alabna' => ($mirathInput['banat_alabna'] == 1 && $mirathInput['albanat'] == 1 && $mirathInput['abna_alabna'] == 0),
            'alakhawat_ashakikat' => ($mirathInput['alakhawat_ashakikat'] == 1 && $mirathInput['alikhwa_alashika'] == 0   && $mirathInput['alab'] == 0 && $mirathInput['aljad'] == 0 && !$this->far3Warith),
            'alakhawat_li_ab' => ($mirathInput['alakhawat_li_ab'] == 1 && $mirathInput['alakhawat_ashakikat'] == 1 && $mirathInput['alikhwa_alashika'] == 0 && $mirathInput['alikhwa_li_ab'] == 0 && $mirathInput['alab'] == 0 && $mirathInput['aljad'] == 0 && !$this->far3Warith),
            'alikhwa_li_om' => ($mirathInput['alikhwa_li_om'] == 1 && $mirathInput['alakhawat_li_om'] == 0 && !$this->far3Warith && $mirathInput['alab'] == 0 && $mirathInput['aljad'] == 0),
            'alakhawat_li_om' => ($mirathInput['alakhawat_li_om'] == 1 && $mirathInput['alikhwa_li_om'] == 0 && !$this->far3Warith && $mirathInput['alab'] == 0 && $mirathInput['aljad'] == 0),
            'aljadah_li_om' => ($mirathInput['aljadah_li_om'] && !$mirathInput['aljadah_li_ab'] && !$mirathInput['alom']),
            'aljadah_li_ab' => ($mirathInput['aljadah_li_ab'] && !$mirathInput['aljadah_li_om'] && $mirathInput['alab'] && $mirathInput['alom'])
        ];
        $hasOnetwelfthConditions = [
            'aljadah_li_om' => ($mirathInput['aljadah_li_om'] && $mirathInput['aljadah_li_ab'] && !$mirathInput['alom']),
            'aljadah_li_ab' => ($mirathInput['aljadah_li_ab'] && $mirathInput['aljadah_li_om'] && !$mirathInput['alab'] && !$mirathInput['alom'])
        ];


        $hasHalf = in_array(true, $hasHalfConditions);
        $hasQuarter = in_array(true, $hasQuarterConditions);
        $hasEighth = in_array(true, $hasEighthConditions);
        $hasTwoThirds = in_array(true, $hasTwoThirdsConditions);
        $hasOneThird = in_array(true, $hasOneThirdConditions);
        $hasOneSixth = in_array(true, $hasOneSixthConditions);
        $hasOnetwelfth = in_array(true, $hasOnetwelfthConditions);

        $halfCount = count(array_filter($hasHalfConditions));
        $quarterCount = count(array_filter($hasQuarterConditions));
        $eighthCount = count(array_filter($hasEighthConditions));
        $twoThirdsCount = count(array_filter($hasTwoThirdsConditions));
        $oneThirdCount = count(array_filter($hasOneThirdConditions));
        $oneSixthCount = count(array_filter($hasOneSixthConditions));
        $onetwelfthCount = count(array_filter($hasOnetwelfthConditions));

        $hasTypeOne = $hasHalf || $hasQuarter || $hasEighth;
        $hasTypeTwo = $hasTwoThirds || $hasOneThird || $hasOneSixth || $hasOnetwelfth;

        // === Rule Determination ===
        $commonDenominator = 1;

        if ($hasTypeOne && !$hasTypeTwo) {
            // Rule 1: Only Type One
            if ($hasEighth) {
                $commonDenominator = 8;
            } elseif ($hasQuarter) {
                $commonDenominator = 4;
            } elseif ($hasHalf) {
                $commonDenominator = 2;
            }
        } elseif (!$hasTypeOne && $hasTypeTwo) {
            // Rule 2: Only Type Two
            $commonDenominator = 6;
        } elseif ($hasHalf && !$hasQuarter && !$hasEighth &&  $hasTypeTwo) {
            // Rule 3: Mix of 1/2 and Type Two
            $commonDenominator = 6;
        } elseif ($hasQuarter && !$hasHalf && !$hasEighth &&  $hasTypeTwo) {
            // Rule 4: Mix of 1/4 and Type Two
            $commonDenominator = 12;
        } elseif ($hasEighth && !$hasHalf && !$hasQuarter && $hasTypeTwo) {
            // Rule 5: Mix of 1/8 and Type Two
            $commonDenominator = 24;
        } elseif ($hasHalf && $hasQuarter && !$hasEighth &&  $hasTypeTwo) {
            // Rule 3: Mix of 1/2 and Type Two
            $commonDenominator = 12;
        } elseif ($hasHalf && !$hasQuarter && $hasEighth &&  $hasTypeTwo) {
            // Rule 3: Mix of 1/2 and Type Two
            $commonDenominator = 24;
        } elseif (!$hasHalf && $hasQuarter && $hasEighth &&  $hasTypeTwo) {
            // Rule 3: Mix of 1/2 and Type Two
            $commonDenominator = 24;
        }
        $totalBast = 0;
        $totalBastDisplay = "";
        // === Reinitialize the 6 shares ===
        if ($hasHalf) {
            $this->nesef = ["bast" => $commonDenominator / 2, "ma9am" => 0];
            $totalBast = $this->nesef['bast'] * $halfCount;
            $totalBastDisplay .= "nesef " . $this->nesef['bast'] . " => " . $halfCount . " total \n";
        }
        if ($hasQuarter) {
            $this->robo3 = ["bast" => $commonDenominator / 4, "ma9am" => 0];
            $totalBast += $this->robo3['bast'] * $quarterCount;
            $totalBastDisplay .= "robo3 " . $this->robo3['bast'] . " => " . $quarterCount . " total \n";
        }
        if ($hasEighth) {
            $this->thomon = ["bast" => $commonDenominator / 8, "ma9am" => 0];
            $totalBast += $this->thomon['bast'] * $eighthCount;
            $totalBastDisplay .= "thomon " . $this->thomon['bast'] . " => " . $eighthCount . " total \n";
        }
        if ($hasTwoThirds) {
            $this->tholothin = ["bast" => 2 * $commonDenominator / 3, "ma9am" => 0];
            $totalBast += $this->tholothin['bast'] * $twoThirdsCount;
            $totalBastDisplay .= "tholothin " . $this->tholothin['bast'] . " => " . $twoThirdsCount . " total \n";
        }
        if ($hasOneThird) {
            $this->tholoth = ["bast" => $commonDenominator / 3, "ma9am" => 0];
            $totalBast += $this->tholoth['bast'] * $oneThirdCount;
            $totalBastDisplay .= "tholoth " . $this->tholoth['bast'] . " => " . $oneThirdCount . " total \n";
        }
        if ($hasOneSixth) {
            $this->sodoss = ["bast" => $commonDenominator / 6, "ma9am" => 0];
            $totalBast += $this->sodoss['bast'] * $oneSixthCount;
            $totalBastDisplay .= "sodos " . $this->sodoss['bast'] . " => " . $oneSixthCount . " total \n";
        }

        if ($hasOnetwelfth) {
            $this->nesefsodos = ["bast" => $commonDenominator / 12, "ma9am" => 0];
            $totalBast += $this->nesefsodos['bast'] * $onetwelfthCount;
            $totalBastDisplay .= "nesefsodos " . $this->nesefsodos['bast'] . " => " . $onetwelfthCount . " total \n";
        }
        if ($totalBast < $commonDenominator) {
            $totalBast = $commonDenominator;
        }

        $this->nesef['ma9am'] = $totalBast;
        $this->robo3['ma9am'] = $totalBast;
        $this->thomon['ma9am'] = $totalBast;
        $this->tholothin['ma9am'] = $totalBast;
        $this->tholoth['ma9am'] = $totalBast;
        $this->sodoss['ma9am'] = $totalBast;
        $this->nesefsodos['ma9am'] = $totalBast;

        //les appels:
        $this->mirathazawj($mirathInput);
        $this->mirathazawja($mirathInput);
        $this->mirathalom($mirathInput);
        $this->mirathaljadah_li_om($mirathInput);
        $this->mirathaljadah_li_ab($mirathInput);

        if (($mirathInput["abna_alabna"] > 0) || ($mirathInput["alabna"] > 0)) {
            $this->mirathalab($mirathInput);
        }
        if (($mirathInput["abna_alabna"] > 0) || ($mirathInput["alabna"] > 0) || ($mirathInput["alikhwa_alashika"] > 0) || ($mirathInput["alikhwa_li_ab"] > 0)) {
            $this->mirathaljad($mirathInput);
        }
        if ($mirathInput['alabna'] == 0) {
            $this->mirathalbanat($mirathInput);
        }
        if ($mirathInput['alikhwa_alashika'] == 0) {
            $this->mirathalakhawat_ashakikat($mirathInput);
        }
        $this->mirathalikhwa_li_om($mirathInput);
        $this->mirathalakhawat_li_om($mirathInput);
        $this->mirathalakhawat_li_ab($mirathInput);


        if (!($mirathInput["banat_alabna"] == 0)) {
            $this->mirathabna_alabna($mirathInput);
        }

        $this->mirathbanat_alabna($mirathInput);
        // beta3sib

        $this->mirathalabna($mirathInput);
        $this->mirathalikhwa_alashika($mirathInput);

        if ($mirathInput['alabna'] > 0) {
            $this->mirathalbanat($mirathInput);
        }
        if ($mirathInput['alikhwa_alashika'] > 0) {
            $this->mirathalakhawat_ashakikat($mirathInput);
        }

        if (($mirathInput["banat_alabna"] == 0) && ($mirathInput["alabna"] == 0)) {
            $this->mirathabna_alabna($mirathInput);
        }

        if (!($mirathInput["abna_alabna"] > 0) &&  !($mirathInput["alabna"] > 0)) {
            $this->mirathalab($mirathInput);
        }

        $this->mirathalikhwa_alashika($mirathInput);
        $this->mirathalikhwa_li_ab($mirathInput);
        if (!($mirathInput["abna_alabna"] > 0) && !($mirathInput["alabna"] > 0) && !($mirathInput["alikhwa_alashika"] > 0) && !($mirathInput["alikhwa_li_ab"] > 0)) {
            $this->mirathaljad($mirathInput);
        }
        $this->mirathabna_alikhwa_alashika($mirathInput);
        $this->mirathabna_alikhwa_li_ab($mirathInput);
        $this->mirathala3mam_alashika($mirathInput);
        $this->mirathala3mam_li_ab($mirathInput);
        $this->mirathabna_ala3mam_alashika($mirathInput);
        $this->mirathabna_ala3mam_li_ab($mirathInput);
        // si thama reste > 0 yaani 9esma na9sa => n9asmou reste bin lwaratha gad gad
        if ($mirathInput['reste'] > 0) {
            $partReste = $mirathInput['reste'] / count($this->part);
            foreach ($this->part as $key => $value) {
                $this->part[$key]['part'] += $partReste;
            }
        }
        $this->doyon = $mirathInput['doyon'] ?? 0;
        $this->wasiya = $mirathInput['wasiya'] ?? 0;
        
        return [
            'rapport' => $this->rapport,
            'parts' => $this->part,
            'type' => $this->type,
            'safiTarika' => $mirathInput['safi_tarika'],
            'totalBast' => $totalBast,
            'commonDenominator' => $commonDenominator,
            'tafsilNesef' => implode(' | ', $hasHalfConditions),
            'totalBastDisplay' => $totalBastDisplay,
        ];
    }


    function calculNesef($tarika)
    {
        return $tarika * ($this->nesef['bast'] / $this->nesef['ma9am']);
    }

    function calculRobo3($tarika)
    {
        return $tarika * ($this->robo3['bast'] / $this->robo3['ma9am']);
    }
    function calculThomon($tarika)
    {
        return $tarika * ($this->thomon['bast'] / $this->thomon['ma9am']);
    }
    function calculTholothin($tarika)
    {
        return $tarika * ($this->tholothin['bast'] / $this->tholothin['ma9am']);
    }
    function calculTholoth($tarika)
    {
        return $tarika * ($this->tholoth['bast'] / $this->tholoth['ma9am']);
    }
    function calculSodoss($tarika)
    {
        return $tarika * ($this->sodoss['bast'] / $this->sodoss['ma9am']);
    }
    function calculNesefsodos($tarika)
    {
        return $tarika * ($this->nesefsodos['bast'] / $this->nesefsodos['ma9am']);
    }

    // zawjan//
    public function mirathazawj(&$mirathInput)
    {
        if (!$mirathInput["zawj"]) {
            return;
        }
        $count = $mirathInput['zawj'];
        if ($this->far3Warith) {
            $part = $this->calculRobo3($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الزوج يرث الربع 1/4 فرضا لوجود فرع وارث \n";
        } else {
            $part = $this->calculNesef($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الزوج يرث النصف 1/2 فرضا لعدم وجود فرع وارث \n";
        }
        $this->part[] =
            [
                'type' => 'الزوج(' . $count . ')',
                'part' => $part,
                'count' => $count,
            ];
    }


    public function mirathazawja(&$mirathInput)
    {
        if (!$mirathInput["zawja"]) {
            return;
        }
        $count = $mirathInput['zawja'];
        if ($this->far3Warith) {
            $part = $this->calculThomon($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الزوجة ترث الثمن 1/8 فرضا لوجود فرع وارث \n";
        } else {
            $part = $this->calculRobo3($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الزوجة ترث الربع 1/4 فرضا لعدم وجود فرع وارث \n";
        }
        $this->part[] =
            [
                'type' => 'الزوجة(' . $count . ')',
                'part' => $part,
                'count' => $count,
            ];
    }

    //Al osol//
    private function mirathalom(&$mirathInput)
    {
        if (!$mirathInput["alom"]) {
            return;
        }
        $count = $mirathInput['alom'];
        if ($this->far3Warith) {
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الأم ترث السدس 1/6 فرضا لوجود فرع وارث \n";
        } else {
            $part = $this->calculTholoth($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الأم ترث الثلث 1/3 فرضا لعدم وجود فرع وارث \n";
        }
        $this->part[] = [
            'type' => 'الأم(' . $count . ')',
            'part' => $part,
            'count' => $count,
        ];
    }

    public function mirathalab(&$mirathInput)
    {
        if (!$mirathInput["alab"]) {
            return;
        }
        $count = $mirathInput['alab'];

        if ($this->far3WarithDhakar) {
            // Cas 1: Si un fils existe -> 1/6 فرضا فقط
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= " الاب يرث السدس 1/6 فرضا فقط لوجود الفرع الوارث الذكر\n";
        } elseif ($this->far3WarithOntha) {
            // remove 1/2 form the rest
            $part = $mirathInput['reste'];
            $mirathInput['reste'] = 0;
            $this->rapport .= "الاب يرث السدس 1/6 فرضا  و الباقي تعصيبا لوجود الفرع الوارث الأنثى \n";
        } else {
            $part = $mirathInput['reste'];
            $mirathInput['reste'] = 0;
            $this->rapport .= " الاب يرث الباقي تعصيبا بالنفس لعدم وجود الفرع الوارث\n";
        }
        $this->part[] = [
            'type' => 'الاب(' . $count . ')',
            'part' => $part,
            'count' => $count,
        ];
    }



    public function mirathaljad(&$mirathInput)
    {
        if (!$mirathInput["aljad"]) {
            return;
        }
        if ($mirathInput["alab"]) {
            $this->rapport .= "الجد محجوب بالأب \n";
            return;
        }
        $count = $mirathInput['aljad'];

        if ($this->far3WarithDhakar || $mirathInput["alikhwa_alashika"] || $mirathInput["alakhawat_ashakikat"] || $mirathInput["alikhwa_li_ab"] || $mirathInput["alakhawat_li_ab"]) {
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= " الجد يرث السدس 1/6 فرضا فقط لوجود الفرع الوارث الذكر\n";
        } elseif ($this->far3WarithOntha) {
            $part = $mirathInput['reste'];
            $mirathInput['reste'] = 0;
            $this->rapport .= "الجد يرث السدس 1/6 فرضا  و الباقي تعصيبا لوجود الفرع الوارث الأنثى \n";
        } else {
            $part = $mirathInput['reste'];
            $mirathInput['reste'] = 0;
            $this->rapport .= " الجد يرث الباقي تعصيبا بالنفس لعدم وجود الفرع الوارث\n";
        }
        $this->part[] =
            [
                'type' => 'الجد لاب(' . $count . ')',
                'part' => $part,
                'count' => $count,
            ];
    }


    public function mirathaljadah_li_ab(&$mirathInput)
    {
        if (!$mirathInput["aljadah_li_ab"]) {
            return;
        }

        if ($mirathInput["alab"]) {
            $this->rapport .= "الجدة لأب محجوبة بالأب \n";
            return;
        }

        if ($mirathInput["alom"]) {
            $this->rapport .= "الجدة لأب محجوبة بالأم \n";
            return;
        }
        $count = $mirathInput['aljadah_li_ab'];

        if (!$mirathInput["aljadah_li_om"]) {
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= " الجدة لأب ترث السدس 1/6 فرضا فقط\n";
        } else {
            $part = $this->calculNesefsodos($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الجدة لأب ترث نصف السدس 1/12 فرضا فقط\n";
        }
        $this->part[] =
            [
                'type' => 'الجدة لاب(' . $count . ')',
                'part' => $part,
                'count' => $count,
            ];
    }


    public function mirathaljadah_li_om(&$mirathInput)
    {
        if (!$mirathInput["aljadah_li_om"]) {
            return;
        }
        // Si la mère est présente, la grand-mère maternelle est exclue
        if ($mirathInput["alom"]) {
            $this->rapport .= "الجدة لأم محجوبة بالأم \n";
            return;
        }
        $count = $mirathInput['aljadah_li_om'];

        if (!$mirathInput["aljadah_li_ab"] || ($mirathInput["aljadah_li_ab"] && $mirathInput["alab"])) {
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الجدة لأم ترث السدس 1/6 فرضا فقط\n";
        } else {
            $part = $this->calculNesefsodos($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الجدة لأم  ترث نصف السدس 1/12 فرضا فقط\n";
        }
        $this->part[] =
            [
                'type' => 'الجدة لام(' . $count . ')',
                'part' => $part,
                'count' => $count,
            ];
    }


    //el foro3//
    public function mirathalbanat(&$mirathInput)
    {
        if (empty($mirathInput["albanat"])) {
            return;
        }
        $count = $mirathInput['albanat'];
        $nbFilles = $mirathInput["albanat"];
        $nbFils = $mirathInput["alabna"] ?? 0;
        $safiTarika = $mirathInput['safi_tarika'];
        $part = 0;
        // Cas : 1 fille seule, pas de fils
        if ($nbFilles === 1 && $nbFils === 0) {
            $part = $this->calculNesef($safiTarika);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "البنات يرثن 1/2 فرضا فقط لانفرادها دون  عاصب \n";
        }
        // Cas : plusieurs filles, pas de fils
        else if ($nbFilles > 1 && $nbFils === 0) {
            $part = $this->calculTholothin($safiTarika);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "البنات يرثن 2/3 فرضا فقط لتعددهن\n";
        }
        // Cas : filles + fils → تعصيب مع الغير
        else if ($nbFilles > 0 && $nbFils > 0) {
            $alabnaPart = array_filter($this->part, fn($item) => str_starts_with($item['type'], 'الابناء'));
            $alabnaPart = reset($alabnaPart);

            if ($alabnaPart) {
                $partParFille = ($alabnaPart['part'] / (2 * $nbFils)) * 1;
                $part = $partParFille * $nbFilles;

                $mirathInput['reste'] -= $part;
                $this->rapport .= "البنات يرثن للذكر مثل حظ الأنثيين\n";
            } else {
                $this->rapport .= "خطأ: لم يتم تحديد نصيب الأبناء بعد لحساب نصيب البنات\n";
            }
        }

        $this->part[] = [
            'type' => 'البنات(' . $count . ')',
            'part' => $part,
            'count' => $count,
        ];
    }


    public function mirathalabna(&$mirathInput)
    {
        if (empty($mirathInput["alabna"])) {
            return;
        }

        $count = $mirathInput['alabna'];
        $nbFils = $mirathInput["alabna"];
        $nbFilles = $mirathInput["albanat"] ?? 0;

        // Cas : pas de filles → les fils prennent tout en تعصيب بالنفس
        if ($nbFilles == 0) {
            $part = $mirathInput['reste'];
            $mirathInput['reste'] = 0;

            $this->rapport .= "الأبناء يرثون الباقي تعصيبا بالنفس\n";

            $this->part[] = [
                'type' => 'الابناء(' . $count . ')',
                'part' => $part,
                'count' => $count,
            ];
        }
        // Cas : fils et filles → للذكر مثل حظ الأنثيين
        else {
            $totalTêtes = (2 * $nbFils) + $nbFilles;
            $partFils = ($mirathInput['reste'] * (2 * $nbFils)) / $totalTêtes;
            $mirathInput['reste'] = 0;

            $this->rapport .= "الأبناء يرثون للذكر مثل حظ الانثيين\n";

            $this->part[] = [
                'type' => 'الابناء(' . $count . ')',
                'part' => $partFils,
                'count' => $count,
            ];
        }
    }
    public function mirathabna_alabna(&$mirathInput)
    {
        $nbFils = $mirathInput["abna_alabna"] ?? 0;
        $nbFilles = $mirathInput["banat_alabna"] ?? 0;
        $nbAlbanat = $mirathInput["albanat"] ?? 0;

        if ($nbFils == 0) {
            return;
        }

        if ($mirathInput["alabna"]) {

            $this->rapport .= "أبناء الإبن محجوبون بالأبناء\n";
            return;
        }
        $countFils = $mirathInput['abna_alabna'];
        $countFilles = $mirathInput['banat_alabna'];
        // Cas : uniquement des fils → تعصيب بالنفس
        if ($nbFilles == 0) {
            $part = $mirathInput['reste'];
            $mirathInput['reste'] = 0;

            $this->rapport .= "أبناء الابن يرثون الباقي تعصيبا بالنفس\n";
            $this->part[] = [
                'type' => 'أبناء الابن(' . $countFils . ')',
                'part' => $part,
                'count' => $countFils,
            ];
        }
        // Cas : fils + filles → للذكر مثل حظ الأنثيين **si albanat < 2**
        elseif ($nbAlbanat < 2) {
            $totalTêtes = (2 * $nbFils) + $nbFilles;
            $partParTête = $mirathInput['reste'] / $totalTêtes;
            $partFils = $partParTête * 2 * $nbFils;
            $partFilles = $partParTête * $nbFilles;
            $mirathInput['reste'] = 0;

            $this->rapport .= "أبناء الابن يرثون للذكر مثل حظ الأنثيين\n";

            if ($partFils > 0) {
                $this->part[] = [
                    'type' => 'أبناء الابن(' . $countFils . ')',
                    'part' => $partFils,
                    'count' => $countFils,
                ];
            }

            if ($partFilles > 0) {
                $this->part[] = [
                    'type' => 'بنات الابن(' . $countFilles . ')',
                    'part' => $partFilles,
                    'count' => $countFilles,
                ];
            }

            // Évite double héritage pour بنات الابن
            $mirathInput['banat_alabna_incluses'] = true;
        }
        // Sinon : seules les أبناء الابن héritent
        else {
            $part = $mirathInput['reste'];
            $mirathInput['reste'] = 0;

            $this->rapport .= "أبناء الابن يرثون الباقي تعصيبا بالنفس\n";
            $this->part[] = [
                'type' => 'أبناء الابن(' . $countFils . ')',
                'part' => $part,
                'count' => $countFils,
            ];

            // Précise que les filles de fils sont exclues
            $mirathInput['banat_alabna_incluses'] = true;
        }
    }

    public function mirathbanat_alabna(&$mirathInput)
    {
        // Pas de بنات الابن
        if (($mirathInput["banat_alabna"] ?? 0) == 0) {
            return;
        }
        $causes = [];
        // 1. محجوبات بالأبناء
        if (!empty($mirathInput["alabna"])) {
            $causes[] = "الأبناء";
        }
        // 2. محجوبات بالبنتين فأكثر
        if (!empty($mirathInput["albanat"]) && $mirathInput["albanat"] >= 2) {
            $causes[] = "البنتين فأكثر";
        }

        // Si elles sont exclues
        if (count($causes) > 0) {
            $causeText = implode(' و', $causes);
            $this->rapport .= "بنات الابن محجوبات بـ{$causeText}\n";
            return;
        }
        $count = $mirathInput['banat_alabna'];


        $nbFilles = $mirathInput["banat_alabna"];
        $nbFils = $mirathInput["abna_alabna"] ?? 0;
        $nbAlbanat = $mirathInput["albanat"] ?? 0;
        $safiTarika = $mirathInput['safi_tarika'];
        $part = 0;

        // Cas 1 : une seule بنت الابن sans أبناء الابن et sans filles directes (ou une seule)
        if ($nbFilles === 1 && $nbFils === 0 && $nbAlbanat < 1) {
            $part = $this->calculNesef($safiTarika);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "بنت الابن ترث النصف فرضا\n";
        }
        // Cas 2 : plusieurs بنات الابن sans أبناء الابن et sans filles directes (ou une seule)
        elseif ($nbFilles > 1 && $nbFils === 0 && $nbAlbanat <= 1) {
            $part = $this->calculTholothin($safiTarika);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "بنات الابن يرثن الثلثين فرضا\n";
        }
        // Cas 3 : بنت الابن seule avec بنت واحدة لتكملة الثلثين
        elseif ($nbFilles > 0 && $nbAlbanat === 1 && $nbFils === 0) {
            $part = $this->calculSodoss($safiTarika);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "بنت الابن ترث السدس تكملة للثلثين\n";
        }
        // Cas 4 : تعصيب مع الغير
        elseif ($nbFilles > 0 && $nbFils > 0 && ($mirathInput["alabna"] ?? 0) === 0 && $nbAlbanat <= 1) {
            $abnaAlabnaPart = array_filter($this->part, fn($item) => $item['type'] === 'أبناء الابن');
            $abnaAlabnaPart = reset($abnaAlabnaPart);

            if ($abnaAlabnaPart) {
                $partParFille = ($abnaAlabnaPart['part'] / (2 * $nbFils)) * 1;
                $part = $partParFille * $nbFilles;
                $mirathInput['reste'] -= $part;
                $this->rapport .= "بنات الابن يرثن للذكر مثل حظ الأنثيين\n";
            } else {
                $this->rapport .= "بنات الابن يرثن للذكر مثل حظ الأنثيين\n";
            }
        }

        // Ajouter uniquement si part > 0
        if ($part > 0) {
            $this->part[] = [
                'type' => 'بنات الابن(' . $count . ')',
                'part' => $part,
                'count' => $count,
            ];
        }
    }


    // wasiya wajiba//

    // al 7awachi
    public function mirathalikhwa_li_om(&$mirathInput)
    {
        // Pas d'héritiers de type الإخوة لأم
        if (($mirathInput["alikhwa_li_om"] ?? 0) == 0) {
            return;
        }

        $causes = [];

        // Exclusion par un descendant héritier
        if ($this->far3Warith > 0) {
            $causes[] = "الفرع الوارث";
        }

        // Exclusion par le père
        if (!empty($mirathInput['alab'])) {
            $causes[] = "الأب";
        }

        // Exclusion par le grand-père
        if (!empty($mirathInput['aljad'])) {
            $causes[] = "الجد";
        }

        // S'il y a une ou plusieurs causes d'exclusion
        if (count($causes) > 0) {
            $causeText = implode(' و', $causes);
            $this->rapport .= "الإخوة لأم محجوبون بـ{$causeText}\n";
            return;
        }
        $count = $mirathInput['alikhwa_li_om'];

        if ($mirathInput["alakhawat_li_om"] > 0) {
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الإخوة لأم يرثون الثلث 1/6 فرضًا \n";
        } else {
            $part = $this->calculTholoth($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الإخوة لأم يرثون الثلث 1/3 فرضًا \n";
        }
        $this->part[] =
            [
                'type' => "\u{200F}الإخوة لام($count)",
                'part' => $part,
                'count' => $count,
            ];
    }



    public function mirathalakhawat_li_om(&$mirathInput)
    {
        // Conditions d'exclusion des الأخوات لأم
        if (
            ($mirathInput["alakhawat_li_om"] ?? 0) == 0
        ) {
            return;
        }
        $causes = [];
        if ($this->far3Warith > 0) {
            $causes[] = "الفرع الوارث";
        }
        if ($mirathInput["alab"]) {
            $causes[] = "الأب";
        }
        if ($mirathInput["aljad"]) {
            $causes[] = "الجد";
        }
        // Si une cause est présente → l'héritier est éliminé
        if (count($causes) > 0) {
            $causeText = implode(' و', $causes); // "الأب و الجد", etc.
            $this->rapport .= "الأخوات لأم محجوبات بـ{$causeText} \n";
            return;
        }
        $count = $mirathInput['alakhawat_li_om'];
        if (($mirathInput['alikhwa_li_om'] ?? 0) > 0) {
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الإخوات لأم ترثن السدس 1/6 فرضًا \n";
        } else {
            $part = $this->calculTholoth($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الإخوات لأم ترثن الثلث 1/3 فرضًا \n";
        }
        $this->part[] = [
            'type' => 'الاخوات لام(' . $count . ')',
            'part' => $part,
            'count' => $count,
        ];
    }



    public function mirathalikhwa_alashika(&$mirathInput)
    {
        $nbFreres = $mirathInput["alikhwa_alashika"] ?? 0;
        $nbSoeurs = $mirathInput["alakhawat_ashakikat"] ?? 0;

        if ($nbFreres == 0) {
            return;
        }

        $causes = [];
        if ($this->far3Warith > 0) {
            $causes[] = "الفرع الوارث";
        }
        if (!empty($mirathInput["alab"])) {
            $causes[] = "الأب";
        }

        if (count($causes) > 0) {
            if (empty($mirathInput['alikhwa_alashika_exclus'])) {
                $causeText = implode(' و', $causes);
                $this->rapport .= "الإخوة الأشقاء محجوبون بـ{$causeText}\n";
                $mirathInput['alikhwa_alashika_exclus'] = true;
            }
            return;
        }

        $countFils = $nbFreres;
        $countFilles = $nbSoeurs;

        if ($nbSoeurs == 0) {
            $part = $mirathInput['reste'];
            $mirathInput['reste'] = 0;
            $this->rapport .= "الإخوة الأشقاء يرثون الباقي تعصيبا بالنفس\n";

            $this->part[] = [
                'type' => 'الإخوة الأشقاء(' . $countFils . ')',
                'part' => $part,
                'count' => $countFils,
            ];
        } else {
            $totalTêtes = (2 * $nbFreres) + $nbSoeurs;
            $partParTête = $mirathInput['reste'] / $totalTêtes;
            $partFreres = $partParTête * 2 * $nbFreres;
            $partSoeurs = $partParTête * $nbSoeurs;

            $mirathInput['reste'] = 0;

            $this->rapport .= "الإخوة الأشقاء يرثون مع الأخوات للذكر مثل حظ الأنثيين\n";

            if ($partFreres > 0) {
                $this->part[] = [
                    'type' => 'الإخوة الأشقاء(' . $countFils . ')',
                    'part' => $partFreres,
                    'count' => $countFils,
                ];
            }

            if ($partSoeurs > 0) {
                $this->part[] = [
                    'type' => 'الأخوات الشقيقات(' . $countFilles . ')',
                    'part' => $partSoeurs,
                    'count' => $countFilles,
                ];
            }

            $mirathInput['alakhawat_ashakikat_incluses'] = true;
        }
    }
    public function mirathalakhawat_ashakikat(&$mirathInput)
    {
        $nbSoeurs = $mirathInput["alakhawat_ashakikat"] ?? 0;
        $nbFreres = $mirathInput["alikhwa_alashika"] ?? 0;

        if ($nbSoeurs == 0 || !empty($mirathInput['alakhawat_ashakikat_exclus']) || !empty($mirathInput['alikhwa_alashika_incluses'])) {
            return;
        }

        $causes = [];
        if ($this->far3Warith > 0) {
            $causes[] = "الفرع الوارث";
        }
        if (!empty($mirathInput["alab"])) {
            $causes[] = "الأب";
        }

        if (count($causes) > 0) {
            if (empty($mirathInput['alakhawat_ashakikat_exclus'])) {
                $causeText = implode(' و', $causes);
                $this->rapport .= "الأخوات الشقيقات محجوبات بـ{$causeText}\n";
                $mirathInput['alakhawat_ashakikat_exclus'] = true;
            }
            return;
        }

        $count = $nbSoeurs;
        $part = 0;

        if ($nbSoeurs === 1 && $nbFreres === 0) {
            $part = $this->calculNesef($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الأخت الشقيقة ترث النصف فرضا\n";
        } elseif ($nbSoeurs > 1 && $nbFreres === 0) {
            $part = $this->calculTholothin($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الأخوات الشقيقات يرثن الثلثين فرضا\n";
        }

        if ($part > 0) {
            $this->part[] = [
                'type' => 'الأخوات الشقيقات(' . $count . ')',
                'part' => $part,
                'count' => $count,
            ];
        }
    }

    public function mirathalikhwa_li_ab(&$mirathInput)
    {
        $nbFreres = $mirathInput["alikhwa_li_ab"] ?? 0;
        if ($nbFreres == 0) {
            return;
        }

        $causes = [];

        if ($this->far3Warith > 0) {
            $causes[] = "الفرع الوارث";
        }

        if (!empty($mirathInput["alab"])) {
            $causes[] = "الأب";
        }

        if (($mirathInput["alikhwa_alashika"] ?? 0) > 0) {
            $causes[] = "الإخوة الأشقاء";
        }

        if (count($causes) > 0) {
            $causeText = implode(' و', $causes);
            if (empty($mirathInput['alikhwa_li_ab_exclus'])) {
                $this->rapport .= "الإخوة لأب محجوبون بـ{$causeText}\n";
                $mirathInput['alikhwa_li_ab_exclus'] = true;
            }
            return;
        }

        $nbSoeurs = $mirathInput["alakhawat_li_ab"] ?? 0;
        $countFils = $nbFreres;
        $countFilles = $nbSoeurs;

        if ($nbSoeurs == 0) {
            $part = $mirathInput['reste'];
            $mirathInput['reste'] = 0;
            $this->rapport .= "الإخوة لأب يرثون الباقي تعصيبا بالنفس\n";
            $this->part[] = [
                'type' => 'الإخوة لأب(' . $countFils . ')',
                'part' => $part,
                'count' => $countFils,
            ];
        } elseif (($mirathInput["alakhawat_ashakikat"] ?? 0) < 2) {
            $totalTêtes = (2 * $nbFreres) + $nbSoeurs;
            $partParTête = $mirathInput['reste'] / $totalTêtes;
            $partFreres = $partParTête * 2 * $nbFreres;
            $partSoeurs = $partParTête * $nbSoeurs;
            $mirathInput['reste'] = 0;

            $this->rapport .= "الإخوة لأب والأخوات لأب يرثون تعصيبا، للذكر مثل حظ الأنثيين\n";

            if ($nbFreres > 0) {
                $this->part[] = [
                    'type' => 'الإخوة لأب(' . $countFils . ')',
                    'part' => $partFreres,
                    'count' => $countFils,
                ];
            }

            if ($nbSoeurs > 0) {
                $this->part[] = [
                    'type' => 'الأخوات لأب(' . $countFilles . ')',
                    'part' => $partSoeurs,
                    'count' => $countFilles,
                ];
            }

            $mirathInput['alakhawat_li_ab_incluses'] = true;
        } else {
            $part = $mirathInput['reste'];
            $mirathInput['reste'] = 0;
            $this->rapport .= "الإخوة لأب يرثون الباقي تعصيبا بالنفس لوجود أخوات شقيقات حاجبات\n";
            $this->part[] = [
                'type' => 'الإخوة لأب(' . $countFils . ')',
                'part' => $part,
                'count' => $countFils,
            ];
            $mirathInput['alakhawat_li_ab_incluses'] = true;
        }
    }


    public function mirathalakhawat_li_ab(&$mirathInput)
    {
        $nbFilles = $mirathInput["alakhawat_li_ab"] ?? 0;
        if ($nbFilles == 0) {
            return;
        }

        $nbFreresGermains = $mirathInput["alikhwa_alashika"] ?? 0;
        $nbSoeursGermaines = $mirathInput["alakhawat_ashakikat"] ?? 0;
        $nbFreresPaternels = $mirathInput["alikhwa_li_ab"] ?? 0;

        if (!empty($mirathInput["alakhawat_li_ab_incluses"])) {
            return;
        }

        $causes = [];

        if ($nbFreresGermains > 0) {
            $causes[] = "الإخوة الأشقاء";
        }
        if ($nbSoeursGermaines > 1) {
            $causes[] = "الأخوات الشقيقات";
        }
        if (!empty($mirathInput["alab"])) {
            $causes[] = "الأب";
        }
        if (!empty($this->far3Warith)) {
            $causes[] = "الفرع الوارث";
        }
        if ($nbSoeursGermaines == 1 && !empty($mirathInput["aljad"])) {
            $causes[] = "الجد مع أخت شقيقة واحدة";
        }

        if (count($causes) > 0) {
            $causeText = implode(' و', $causes);
            if (empty($mirathInput['alakhawat_li_ab_exclus'])) {
                $this->rapport .= "الأخوات لأب محجوبات بـ{$causeText}\n";
                $mirathInput['alakhawat_li_ab_exclus'] = true;
            }
            return;
        }

        $safiTarika = $mirathInput['safi_tarika'];
        $part = 0;

        if (
            $nbFilles === 1 &&
            $nbFreresGermains == 0 &&
            $nbSoeursGermaines == 0 &&
            $nbFreresPaternels == 0 &&
            empty($mirathInput["aljad"])
        ) {
            $part = $this->calculNesef($safiTarika);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الأخت لأب ترث النصف 1/2 فرضًا\n";
        } elseif (
            $nbFilles > 1 &&
            $nbFreresGermains == 0 &&
            $nbSoeursGermaines == 0 &&
            $nbFreresPaternels == 0
        ) {
            $part = $this->calculTholothin($safiTarika);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الأخوات لأب يرثن الثلثين 2/3 فرضًا\n";
        } elseif (
            $nbFilles > 0 &&
            $nbSoeursGermaines == 1 &&
            $nbFreresPaternels == 0 &&
            !$mirathInput["alab"] &&
            !$this->far3Warith
        ) {
            $part = $this->calculSodoss($safiTarika);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الأخوات لأب يرثن السدس 1/6 تكملة للثلثين\n";
        } elseif (
            $nbFilles > 0 &&
            $nbFreresPaternels > 0 &&
            !$mirathInput["alab"] &&
            !$this->far3Warith &&
            $nbFreresGermains === 0 &&
            $nbSoeursGermaines <= 1
        ) {
            $FreresPaternelsPart = array_filter($this->part, fn($item) => $item['type'] === 'الإخوة لأب(' . $nbFreresPaternels . ')');
            $FreresPaternelsPart = reset($FreresPaternelsPart);

            if ($FreresPaternelsPart) {
                $partParFilles = ($FreresPaternelsPart['part'] / (2 * $nbFreresPaternels)) * 1;
                $part = $partParFilles * $nbFilles;
                $mirathInput['reste'] -= $part;
                $this->rapport .= "بالاخوات لأب يرثن للذكر مثل حظ الأنثيين\n";
            } else {
                $this->rapport .= "خطأ: لم يتم تحديد نصيب الإخوة لأب لحساب نصيب الأخوات\n";
            }
        }

        if ($part > 0) {
            $this->part[] = [
                'type' => 'الأخوات لأب(' . $nbFilles . ')',
                'part' => $part,
                'count' => $nbFilles,
            ];
        }

        $mirathInput["alakhawat_li_ab_incluses"] = true;
    }

    public function mirathabna_alikhwa_alashika(&$mirathInput)
    {
        $nb = $mirathInput["abna_alikhwa_alashika"] ?? 0;
        if ($nb == 0) {
            return;
        }
        $causes = [];
        // Causes d'exclusion
        if (!empty($this->far3Warith)) {
            $causes[] = "الفرع الوارث";
        }
        if (!empty($mirathInput["alab"])) {
            $causes[] = "الأب";
        }
        if (!empty($mirathInput["alikhwa_alashika"])) {
            $causes[] = "الإخوة الأشقاء";
        }
        if (!empty($mirathInput["alikhwa_li_ab"])) {
            $causes[] = "الإخوة لأب";
        }
        if (!empty($mirathInput["aljad"])) {
            $causes[] = "الجد";
        }
        if (!empty($mirathInput["abna_alikhwa_alashika_inclus"])) {
            // Déjà traités
            return;
        }
        if (count($causes) > 0) {
            $causeText = implode(' و', $causes);
            if (empty($mirathInput['abna_alikhwa_alashika_exclus'])) {
                $this->rapport .= "أبناء الإخوة الأشقاء محجوبون بـ{$causeText}\n";
                $mirathInput['abna_alikhwa_alashika_exclus'] = true;
            }
            return;
        }
        $count = $mirathInput['abna_alikhwa_alashika'];

        $part = $mirathInput['reste'];
        $this->rapport .= "أبناء الإخوة الأشقاء يرثون الباقي تعصيبا بالنفس \n";
        $this->part[] = [
            'type' => 'أبناء الإخوة الأشقاء(' . $count . ')',
            'part' => $part,
            'count' => $count,
            'fraction' => 'الباقي تعصيباً'
        ];
        $mirathInput['reste'] = 0;
    }



    public function mirathabna_alikhwa_li_ab(&$mirathInput)
    {
        $nb = $mirathInput["abna_alikhwa_li_ab"] ?? 0;
        if ($nb == 0) {
            return;
        }

        $causes = [];

        // Causes d'exclusion
        if (!empty($this->far3Warith)) {
            $causes[] = "الفرع الوارث";
        }
        if (!empty($mirathInput["alab"])) {
            $causes[] = "الأب";
        }
        if (!empty($mirathInput["alikhwa_alashika"])) {
            $causes[] = "الإخوة الأشقاء";
        }
        if (!empty($mirathInput["alikhwa_li_ab"])) {
            $causes[] = "الإخوة لأب";
        }
        if (!empty($mirathInput["aljad"])) {
            $causes[] = "الجد";
        }
        if (!empty($mirathInput["abna_alikhwa_alashika"])) {
            $causes[] = "أبناء الإخوة الأشقاء";
        }

        if (!empty($mirathInput["abna_alikhwa_li_ab_inclus"])) {
            // Déjà traités
            return;
        }

        if (count($causes) > 0) {
            $causeText = implode(' و', $causes);
            if (empty($mirathInput['abna_alikhwa_li_ab_exclus'])) {
                $this->rapport .= "أبناء الإخوة لأب محجوبون بـ{$causeText}\n";
                $mirathInput['abna_alikhwa_li_ab_exclus'] = true;
            }
            return;
        }
        $count = $mirathInput['abna_alikhwa_li_ab'];

        $part = $mirathInput['reste'];
        $this->rapport .= "ابناء الاخوة لاب يرثون الباقي تعصيبا بالنفس\n";
        $this->part[] =
            [
                'type' => 'ابناء الاخوة لاب(' . $count . ')',
                'part' => $part,
                'count' => $count,
                'fraction' => 'الباقي تعصيباً'
            ];
        $mirathInput['reste'] = 0;
    }

    public function mirathala3mam_alashika(&$mirathInput)
    {
        $nb = $mirathInput["ala3mam_alashika"] ?? 0;
        if ($nb == 0) {
            return;
        }

        $causes = [];

        // Causes d'exclusion
        if (!empty($this->far3Warith)) {
            $causes[] = "الفرع الوارث";
        }
        if (!empty($mirathInput["alab"])) {
            $causes[] = "الأب";
        }
        if (!empty($mirathInput["alikhwa_alashika"])) {
            $causes[] = "الإخوة الأشقاء";
        }
        if (!empty($mirathInput["alikhwa_li_ab"])) {
            $causes[] = "الإخوة لأب";
        }
        if (!empty($mirathInput["aljad"])) {
            $causes[] = "الجد";
        }
        if (!empty($mirathInput["abna_alikhwa_alashika"])) {
            $causes[] = "أبناء الإخوة الأشقاء";
        }
        if (!empty($mirathInput["abna_alikhwa_li_ab"])) {
            $causes[] = "أبناء الإخوة لأب";
        }

        if (!empty($mirathInput["ala3mam_alashika_inclus"])) {
            // Déjà traités
            return;
        }

        if (count($causes) > 0) {
            $causeText = implode(' و', $causes);
            if (empty($mirathInput['ala3mam_alashika_exclus'])) {
                $this->rapport .= "العمام الأشقاء محجوبون بـ{$causeText}\n";
                $mirathInput['ala3mam_alashika_exclus'] = true;
            }
            return;
        }
        $count = $mirathInput['ala3mam_alashika'];

        $part = $mirathInput['reste'];
        $this->rapport .= "الاعمام الاشقاء يرثون الباقي تعصيبا بالنفس\n";
        $this->part[] =
            [
                'type' => 'الاعمام الاشقاء(' . $count . ')',
                'part' => $part,
                'count' => $count,
                'fraction' => 'الباقي تعصيباً'
            ];
        $mirathInput['reste'] = 0;
    }

    public function mirathala3mam_li_ab(&$mirathInput)
    {
        $nb = $mirathInput["ala3mam_li_ab"] ?? 0;
        if ($nb == 0) {
            return;
        }

        $causes = [];

        // Causes d'exclusion
        if (!empty($this->far3Warith)) {
            $causes[] = "الفرع الوارث";
        }
        if (!empty($mirathInput["alab"])) {
            $causes[] = "الأب";
        }
        if (!empty($mirathInput["alikhwa_alashika"])) {
            $causes[] = "الإخوة الأشقاء";
        }
        if (!empty($mirathInput["alikhwa_li_ab"])) {
            $causes[] = "الإخوة لأب";
        }
        if (!empty($mirathInput["aljad"])) {
            $causes[] = "الجد";
        }
        if (!empty($mirathInput["abna_alikhwa_alashika"])) {
            $causes[] = "أبناء الإخوة الأشقاء";
        }
        if (!empty($mirathInput["abna_alikhwa_li_ab"])) {
            $causes[] = "أبناء الإخوة لأب";
        }
        if (!empty($mirathInput["ala3mam_alashika"])) {
            $causes[] = "العمام الأشقاء";
        }

        if (!empty($mirathInput["ala3mam_li_ab_inclus"])) {
            // Déjà traités
            return;
        }

        if (count($causes) > 0) {
            $causeText = implode(' و', $causes);
            if (empty($mirathInput['ala3mam_li_ab_exclus'])) {
                $this->rapport .= "العمام لأب محجوبون بـ{$causeText}\n";
                $mirathInput['ala3mam_li_ab_exclus'] = true;
            }
            return;
        }
        $count = $mirathInput['ala3mam_li_ab'];

        $part = $mirathInput['reste'];
        $this->rapport .= "الاعمام لاب يرثون الباقي تعصيبا بالنفس\n";
        $this->part[] =
            [
                'type' => 'الاعمام لاب(' . $count . ')',
                'part' => $part,
                'count' => $count,
                'fraction' => 'الباقي تعصيباً'
            ];
        $mirathInput['reste'] = 0;
    }

    public function mirathabna_ala3mam_alashika(&$mirathInput)
    {
        $nb = $mirathInput["abna_ala3mam_alashika"] ?? 0;
        if ($nb == 0) {
            return;
        }

        $causes = [];

        // Causes d'exclusion
        if (!empty($this->far3Warith)) {
            $causes[] = "الفرع الوارث";
        }
        if (!empty($mirathInput["alab"])) {
            $causes[] = "الأب";
        }
        if (!empty($mirathInput["alikhwa_alashika"])) {
            $causes[] = "الإخوة الأشقاء";
        }
        if (!empty($mirathInput["alikhwa_li_ab"])) {
            $causes[] = "الإخوة لأب";
        }
        if (!empty($mirathInput["aljad"])) {
            $causes[] = "الجد";
        }
        if (!empty($mirathInput["abna_alikhwa_alashika"])) {
            $causes[] = "أبناء الإخوة الأشقاء";
        }
        if (!empty($mirathInput["abna_alikhwa_li_ab"])) {
            $causes[] = "أبناء الإخوة لأب";
        }
        if (!empty($mirathInput["ala3mam_alashika"])) {
            $causes[] = "العمام الأشقاء";
        }
        if (!empty($mirathInput["ala3mam_li_ab"])) {
            $causes[] = "العمام لأب";
        }

        if (!empty($mirathInput["abna_ala3mam_alashika_inclus"])) {
            // Déjà traités
            return;
        }

        if (count($causes) > 0) {
            $causeText = implode(' و', $causes);
            if (empty($mirathInput['abna_ala3mam_alashika_exclus'])) {
                $this->rapport .= "أبناء العمام الأشقاء محجوبون بـ{$causeText}\n";
                $mirathInput['abna_ala3mam_alashika_exclus'] = true;
            }
            return;
        }
        $count = $mirathInput['abna_ala3mam_alashika'];

        $part = $mirathInput['reste'];
        $this->rapport .= "ابناء الاعمام الاشقاء يرثون الباقي تعصيبا بالنفس\n";
        $this->part[] =
            [
                'type' => 'ابناء الاعمام الاشقاء(' . $count . ')',
                'part' => $part,
                'count' => $count,
                'fraction' => 'الباقي تعصيباً'
            ];
        $mirathInput['reste'] = 0;
    }

    public function mirathabna_ala3mam_li_ab(&$mirathInput)
    {
        $nb = $mirathInput["abna_ala3mam_li_ab"] ?? 0;
        if ($nb == 0) {
            return;
        }

        $causes = [];

        // Causes d'exclusion
        if (!empty($this->far3Warith)) {
            $causes[] = "الفرع الوارث";
        }
        if (!empty($mirathInput["alab"])) {
            $causes[] = "الأب";
        }
        if (!empty($mirathInput["alikhwa_alashika"])) {
            $causes[] = "الإخوة الأشقاء";
        }
        if (!empty($mirathInput["alikhwa_li_ab"])) {
            $causes[] = "الإخوة لأب";
        }
        if (!empty($mirathInput["aljad"])) {
            $causes[] = "الجد";
        }
        if (!empty($mirathInput["abna_alikhwa_alashika"])) {
            $causes[] = "أبناء الإخوة الأشقاء";
        }
        if (!empty($mirathInput["abna_alikhwa_li_ab"])) {
            $causes[] = "أبناء الإخوة لأب";
        }
        if (!empty($mirathInput["ala3mam_alashika"])) {
            $causes[] = "العمام الأشقاء";
        }
        if (!empty($mirathInput["ala3mam_li_ab"])) {
            $causes[] = "العمام لأب";
        }
        if (!empty($mirathInput["abna_ala3mam_alashika"])) {
            $causes[] = "أبناء العمام الأشقاء";
        }

        if (!empty($mirathInput["abna_ala3mam_li_ab_inclus"])) {
            // Déjà traités
            return;
        }

        if (count($causes) > 0) {
            $causeText = implode(' و', $causes);
            if (empty($mirathInput['abna_ala3mam_li_ab_exclus'])) {
                $this->rapport .= "أبناء العمام لأب محجوبون بـ{$causeText}\n";
                $mirathInput['abna_ala3mam_li_ab_exclus'] = true;
            }
            return;
        }
        $count = $mirathInput['abna_ala3mam_li_ab'];
        $part = $mirathInput['reste'];
        $this->rapport .= "ابناء الاعمام لاب  يرثون الباقي تعصيبا بالنفس\n";
        $this->part[] =
            [
                'type' => 'ابناء الاعمام لاب(' . $count . ')',
                'part' => $part,
                'count' => $count,
                'fraction' => 'الباقي تعصيباً'
            ];
        $mirathInput['reste'] = 0;
    }
}
