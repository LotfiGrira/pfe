<?php

namespace App\Services;

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
        $hasHalf = (
            $mirathInput['zawj'] ||
            ($mirathInput['albanat'] == 1 && $mirathInput['alabna'] == 0) ||
            ($mirathInput['banat_alabna'] == 1 && $mirathInput['abna_alabna'] == 0 && $mirathInput['alabna'] == 0 && $mirathInput['albanat'] < 2) ||
            ($mirathInput['alakhawat_ashakikat'] == 1 && $mirathInput['alab'] == 0 && !$this->far3Warith && $mirathInput['alikhwa_alashika'] == 0 && $mirathInput['aljad'] == 0) ||
            ($mirathInput['alakhawat_li_ab'] == 1 && $mirathInput['alab'] == 0 && !$this->far3Warith && $mirathInput['alikhwa_alashika'] == 0 && $mirathInput['alakhawat_ashakikat'] < 2 && $mirathInput['alikhwa_li_ab'] == 0 && $mirathInput['aljad'] == 0)
        );

        $hasQuarter = (
            ($mirathInput['zawj'] && $this->far3Warith) ||
            ($mirathInput['zawja'] && !$this->far3Warith)
        );

        $hasEighth = (
            $mirathInput['zawja'] && $this->far3Warith
        );

        // === Type Two (⅔, ⅓, ⅙) ===
        $hasTwoThirds = (
            ($mirathInput['albanat'] >= 2 && $mirathInput['alabna'] == 0) ||
            ($mirathInput['banat_alabna'] >= 2 && $mirathInput['abna_alabna'] == 0 && $mirathInput['alabna'] == 0 && $mirathInput['albanat'] == 0) ||
            ($mirathInput['alakhawat_ashakikat'] >= 2 && $mirathInput['alab'] == 0 && !$this->far3Warith && $mirathInput['alikhwa_alashika'] == 0 && $mirathInput['aljad'] == 0) ||
            ($mirathInput['alakhawat_li_ab'] >= 2 && $mirathInput['alab'] == 0 && !$this->far3Warith && $mirathInput['alikhwa_alashika'] == 0 && $mirathInput['alakhawat_ashakikat'] < 2 && $mirathInput['aljad'] == 0)
        );

        $hasOneThird = (
            ($mirathInput['alom'] && !$this->far3Warith) ||
            (($mirathInput['alikhwa_li_om'] + $mirathInput['alakhawat_li_om']) >= 2 && !$this->far3Warith && $mirathInput['alab'] == 0 && $mirathInput['aljad'] == 0)
        );

        $hasOneSixth = (
            ($mirathInput['alom'] && $this->far3Warith) ||
            ($mirathInput['banat_alabna'] == 1 && $mirathInput['albanat'] == 1 && $mirathInput['abna_alabna'] == 0) ||
            ($mirathInput['alakhawat_li_ab'] == 1 && $mirathInput['alakhawat_ashakikat'] == 1 && $mirathInput['alikhwa_alashika'] == 0 && $mirathInput['alikhwa_li_ab'] == 0 && $mirathInput['alab'] == 0 && $mirathInput['aljad'] == 0) ||
            ($mirathInput['alikhwa_li_om'] == 1 && $mirathInput['alakhawat_li_om'] == 0 && !$this->far3Warith && $mirathInput['alab'] == 0 && $mirathInput['aljad'] == 0) ||
            ($mirathInput['alakhawat_li_om'] == 1 && $mirathInput['alikhwa_li_om'] == 0 && !$this->far3Warith && $mirathInput['alab'] == 0 && $mirathInput['aljad'] == 0)
        );

        $hasTypeOne = $hasHalf || $hasQuarter || $hasEighth;
        $hasTypeTwo = $hasTwoThirds || $hasOneThird || $hasOneSixth;

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
        } elseif ($hasHalf && $hasTypeTwo) {
            // Rule 3: Mix of 1/2 and Type Two
            $commonDenominator = 6;
        } elseif ($hasQuarter && $hasTypeTwo) {
            // Rule 4: Mix of 1/4 and Type Two
            $commonDenominator = 12;
        } elseif ($hasEighth && $hasTypeTwo) {
            // Rule 5: Mix of 1/8 and Type Two
            $commonDenominator = 24;
        }
        $totalBast = 0;
        // === Reinitialize the 6 shares ===
        if ($hasHalf) {
            $this->nesef = ["bast" => $commonDenominator / 2, "ma9am" => 0];
            $totalBast = $this->nesef['bast'];
        }
        if ($hasQuarter) {
            $this->robo3 = ["bast" => $commonDenominator / 4, "ma9am" => 0];
            $totalBast += $this->robo3['bast'];
        }
        if ($hasEighth) {
            $this->thomon = ["bast" => $commonDenominator / 8, "ma9am" => 0];
            $totalBast += $this->thomon['bast'];
        }
        if ($hasTwoThirds) {
            $this->tholothin = ["bast" => 2 * $commonDenominator / 3, "ma9am" => 0];
            $totalBast += $this->tholothin['bast'];
        }
        if ($hasOneThird) {
            $this->tholoth = ["bast" => $commonDenominator / 3, "ma9am" => 0];
            $totalBast += $this->tholoth['bast'];
        }
        if ($hasOneSixth) {
            $this->sodoss = ["bast" => $commonDenominator / 6, "ma9am" => 0];
            $totalBast += $this->sodoss['bast'];
        }
        // if ($hasNesefsodos) {
        //     $this->nesefsodos = ["bast" => $commonDenominator / 12, "ma9am" => 0];
        // }

        $this->nesef['ma9am'] = $totalBast;
        $this->robo3['ma9am'] = $totalBast;
        $this->thomon['ma9am'] = $totalBast;
        $this->tholothin['ma9am'] = $totalBast;
        $this->tholoth['ma9am'] = $totalBast;
        $this->sodoss['ma9am'] = $totalBast;
        // $this->nesefsodos['ma9am'] = $totalBast;

        //les appels:
        $this->mirathazawj($mirathInput);
        $this->mirathazawja($mirathInput);
        $this->mirathalom($mirathInput);
        $this->mirathaljadah_li_ab($mirathInput);
        $this->mirathaljadat_li_om($mirathInput);
        $this->mirathbanat_alabna($mirathInput);
        $this->mirathalikhwa_li_om($mirathInput);
        $this->mirathalakhawat_li_om($mirathInput);
        $this->mirathalakhawat_ashakikat($mirathInput);
        $this->mirathalakhawat_li_ab($mirathInput);
        // beta3sib
        $this->mirathalabna($mirathInput);
        // albanat laysat beta3sib laken l part mta3ha depend mel part mta3 labna
        $this->mirathalbanat($mirathInput);
        $this->mirathalab($mirathInput);
        $this->mirathaljad($mirathInput);
        $this->mirathabna_alabna($mirathInput);
        $this->mirathalikhwa_alashika($mirathInput);
        $this->mirathalikhwa_li_ab($mirathInput);
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
        //
        return [
            'rapport' => $commonDenominator,
            'parts' => $this->part,
            'type' => $this->type,
            'tarika' => $totalBast,
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
        if ($this->far3Warith) {
            $part = $this->calculRobo3($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الزوج يرث الربع 1/4 فرضا\n";
        } else {
            $part = $this->calculNesef($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الزوج يرث النصف 1/2 فرضا\n";
        }
        $this->part[] =
            [
                'type' => 'الزوج',
                'part' => $part,
            ];
    }


    public function mirathazawja(&$mirathInput)
    {
        if (!$mirathInput["zawja"]) {
            return;
        }

        if ($this->far3Warith) {
            $part = $this->calculThomon($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الزوجة ترث الثمن 1/8 فرضا\n";
        } else {
            $part = $this->calculRobo3($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الزوجة ترث الربع 1/4 فرضا\n";
        }
        $this->part[] =
            [
                'type' => 'الزوجة',
                'part' => $part,
            ];
    }

    //Al osol//
    private function mirathalom(&$mirathInput)
    {
        if (!$mirathInput["alom"]) return;

        $part = 0;

        if ($this->far3Warith) {
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الأم ترث السدس 1/6 فرضا\n";
        } else {
            $part = $this->calculTholoth($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الأم ترث الثلث 1/3 فرضا\n";
        }
        $this->part[] = [
            'type' => 'الأم',
            'part' => $part
        ];
    }

    public function mirathalab(&$mirathInput)
    {
        if (!$mirathInput["alab"]) {
            return;
        }

        if ($this->far3WarithDhakar) {
            // Cas 1: Si un fils existe -> 1/6 فرضا فقط
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الاب يرث السدس 1/6 فرضا فقط\n";
        } elseif ($this->far3WarithOntha) {
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            // remove 1/2 form the rest
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $part += $mirathInput['reste'];
            $this->rapport .= "الاب يرث السدس 1/6 فرضا والباقي تعصيبا بالغير\n";
        } else {
            $part = $mirathInput['reste'];
            $mirathInput['reste'] = 0;
            $this->rapport .= "الاب يرث الباقي تعصيبا بالنفس\n";
        }
        $this->part[] = [
            'type' => 'الاب',
            'part' => $part,
        ];
    }



    public function mirathaljad(&$mirathInput)
    {
        if (!$mirathInput["aljad"] || $mirathInput["alab"]) {
            return;
        }
        if ($this->far3WarithDhakar) {
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الجد يرث السدس 1/6 فرضا فقط\n";
        } elseif ($this->far3WarithOntha) {
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            // remove 1/2 form the rest
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $part += $mirathInput['reste'];
            $this->rapport .= "الجد يرث السدس 1/6 فرضا والباقي تعصيبا بالغير\n";
        } else {
            $part = $mirathInput['reste'];
            $mirathInput['reste'] = 0;
            $this->rapport .= "الجد يرث الباقي تعصيبا بالنفس\n";
        }
        $this->part[] =
            [
                'type' => 'الجد لاب',
                'part' => $part,
            ];
    }

    public function mirathaljadah_li_ab(&$mirathInput)
    {
        if (!$mirathInput["aljadah_li_ab"] || $mirathInput["alab"] || $mirathInput["alom"]) {
            return;
        }
        if (!$mirathInput["aljadah_li_om"]) {
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            $this->rapport .= "الجدة لأب ترث السدس 1/6 فرضا\n";
        } else {
            $part = $this->calculNesefsodos($mirathInput['safi_tarika']);
            $this->rapport .= "الجدة لأب ترث نصف السدس 1/12 فرضا \n";
        }
        $this->part[] =
            [
                'type' => 'الحدة لاب',
                'part' => $part,
            ];
    }

    public function mirathaljadat_li_om(&$mirathInput)
    {
        if (!$mirathInput["aljadah_li_om"] || $mirathInput["alom"]) {
            return;
        }
        if (!$mirathInput["aljadah_li_ab"] || ($mirathInput["aljadah_li_ab"] && $mirathInput["alab"])) {
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            $this->rapport .= "الجدة لأم ترث السدس 1/6 فرضا\n";
        } else {
            $part = $this->calculNesefsodos($mirathInput['safi_tarika']);
            $this->rapport .= "الجدة لأم  ترث نصف السدس 1/12 فرضا\n";
        }
        $this->part[] =
            [
                'type' => 'الجدة لام',
                'part' => $part,
            ];
    }
    //el foro3//
    public function  mirathalbanat(&$mirathInput)
    {
        if (!$mirathInput["albanat"]) {
            return;
        }

        if (($mirathInput["albanat"] == 1) && ($mirathInput["alabna"] == 0)) {
            $part = $this->calculNesef($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "البنات يرثن  1/2 فرضا \n";
        } else if (($mirathInput["albanat"] > 1) && ($mirathInput["alabna"] == 0)) {
            $part = $this->calculTholothin($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "البنات يرثن  2/3 فرضا \n";
        } else if (($mirathInput["albanat"] > 0) && ($mirathInput["alabna"] > 0)) {
            $alabnaPart = array_filter($this->part, function($item) {
                return $item['type'] === 'الابناء';
            });
            $alabnaPart = reset($alabnaPart); // Get first matching element
            $part = $alabnaPart['part'] * 1 / 2;
            $mirathInput['reste'] -= $part;
            $this->rapport .= "البنات  يرثن  1/2 الابناء\n";
        }
        $this->part[] =
            [
                'type' => 'البنات',
                'part' => $part,
            ];
    }

    public function mirathalabna(&$mirathInput)
    {
        if (!$mirathInput["alabna"]) {
            return;
        }
        if ($mirathInput["albanat"] == 0) {
            $part = $mirathInput['reste'];
            $mirathInput['reste'] = 0;
            $this->rapport .= "الابناء يرثون الباقي تعصيبا بالنفس\n";
        } else {
            $part = $mirathInput['reste'] * 2 / 3;
            $this->rapport .= "الأبناء يرثون للذكر مثل حظ الانثيين\n";
        }
        $this->part[] =
            [
                'type' => 'الابناء',
                'part' => $part,
            ];
    }

    public function mirathabna_alabna(&$mirathInput)
    {
        if ($mirathInput["abna_alabna"] == 0 || $mirathInput["alabna"] > 0) {
            return;
        }
        if ($mirathInput["banat_alabna"] == 0 || ($mirathInput["banat_alabna"] > 0 && $mirathInput["albanat"] > 1)) {
            $part = $mirathInput['reste'];
            $mirathInput['reste'] = 0;
            $this->rapport .= "ابناء الابناء يرثون الباقي تعصيبا بالنفس\n";
        } else {
            $part = $mirathInput['reste'] * 2 / 3;
            $this->rapport .= "ابناء الابناء يرثون للذكر مثل حظ الانثيين\n";
        }
        $this->part[] = [
            'type' => 'أبناء الابن',
            'part' => $part,

        ];
    }


    public function mirathbanat_alabna(&$mirathInput)
    {
        if ($mirathInput["banat_alabna"] == 0 || $mirathInput["alabna"] > 0 || $mirathInput["albanat"] > 1) {
            return;
        }
        // 1 fille du fils, aucun fils du fils
        if ($mirathInput["banat_alabna"] == 1 && $mirathInput["abna_alabna"] == 0) {
            $part = $this->calculNesef($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "بنت الابن ترث النصف فرضا\n";
        }
        // 2+ filles du fils, aucun fils du fils
        elseif ($mirathInput["banat_alabna"] > 1 && $mirathInput["abna_alabna"] == 0) {
            $part = $this->calculTholothin($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "بنات الابن يرثن الثلثين فرضا\n";
        }
        // Fille unique + une fille directe (albanat), pas de fils du fils
        elseif ($mirathInput["banat_alabna"] > 0 && $mirathInput["albanat"] == 1 && $mirathInput["abna_alabna"] == 0) {
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "بنت الابن ترث السدس تكملة للثلثين\n";
        }
        // Présence de fils du fils => taʿṣīb avec eux
        elseif ($mirathInput["banat_alabna"] > 0 && $mirathInput["albanat"] <= 1 && $mirathInput["abna_alabna"] > 0) {
            // On applique taʿṣīb maʿa al-ghayr (pour un garçon le double d'une fille)
            $part = $mirathInput['reste'] * 1 / 3;
            $this->rapport .= "بنات الابن يرثن  1/2 الابناء\n";
        }
        $this->part[] =
            [
                'type' => 'بنات  الابناء',
                'part' => $part,
            ];
    }


    // wasiya wajiba//

    // al 7awachi
    public function mirathalikhwa_li_om(&$mirathInput)
    {
        if ($mirathInput["alikhwa_li_om"] == 0 || $this->far3Warith > 0 || $mirathInput['alab'] || $mirathInput['aljad']) {
            return;
        }

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
                'type' => 'الاخوة لام',
                'part' => $part,
            ];
    }


    public function mirathalakhawat_li_om(&$mirathInput)
    {
        if ($mirathInput["alakhawat_li_om"] == 0 || $this->far3Warith > 0 || $mirathInput["alab"] || $mirathInput["aljad"]) {
            return;
        }

        if ($mirathInput['alikhwa_li_om'] > 0) {
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الإخوات لأم ترثن الثلث 1/6 فرضًا \n";
        } else {
            $part = $this->calculTholoth($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الإخوات لأم ترثن الثلث 1/3 فرضًا \n";
        }
        $this->part[] =
            [
                'type' => 'الاخوات لام',
                'part' => $part,
            ];
    }

    public function mirathalikhwa_alashika(&$mirathInput)
    {
        if (
            $mirathInput["alikhwa_alashika"] == 0 ||
            $this->far3Warith > 0 ||
            $mirathInput["alab"] ||
            ($mirathInput["aljad"] && $this->far3Warith <= 0)
        ) {
            return;
        }

        if ($mirathInput["alakhawat_ashakikat"] == 0) {
            $part = $mirathInput['reste'];
            $mirathInput['reste'] = 0;
            $this->rapport .= "الاخوة الاشقاء يرثون الباقي تعصيبا بالنفس\n";
        } else {
            $part = $mirathInput['reste'] * 2 / 3;
            $this->rapport .= "الاخوة الاشقاء يرثون للذكر مثل حظ الانثيين\n";
        }
        $this->part[] =
            [
                'type' => 'الاخوة الاشقاء',
                'part' => $part,
            ];
    }



    public function mirathalakhawat_ashakikat(&$mirathInput)
    {
        if (
            $mirathInput["alakhawat_ashakikat"] == 0 ||
            $this->far3Warith > 0 ||
            $mirathInput["alab"] || ($mirathInput["aljad"] && $this->far3Warith <= 0)
        ) {
            return;
        }

        if (($mirathInput["alakhawat_ashakikat"] == 1) && ($mirathInput["alikhwa_alashika"] == 0)) {
            $part = $this->calculNesef($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الاخوات الشقيقات يرثن 1/2 فرضا\n";
        }
        if (($mirathInput["alakhawat_ashakikat"] > 1) && ($mirathInput["alikhwa_alashika"] == 0)) {
            $part = $this->calculTholothin($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الاخوات الشقيقات يرثن يرث 2/3 فرضا\n";
        }
        if (($mirathInput["alakhawat_ashakikat"] > 0) && ($mirathInput["alikhwa_alashika"] > 0)) {
            $part = $mirathInput['reste'] * 1 / 3;
            $this->rapport .= "الاخوات الشقيقات يرثن يرثن 1/2 الاخوة الأشقاء\n";
        }
        $this->part[] =
            [
                'type' => 'الاخوات الشقيقات',
                'part' => $part,
            ];
    }


    public function mirathalikhwa_li_ab(&$mirathInput)
    {
        if ($mirathInput["alikhwa_li_ab"] == 0 || $this->far3Warith > 0 || $mirathInput["alab"] || $mirathInput["alikhwa_alashika"] > 0 || ($mirathInput["aljad"] && $this->far3Warith <= 0)) {
            return;
        }

        if ($mirathInput["alakhawat_li_ab"] == 0) {
            $part = $mirathInput['reste'];
            $mirathInput['reste'] = 0;
            $this->rapport .= "الاخوة لاب  يرثون الباقي تعصيبا بالنفس\n";
        } else {
            $part = $mirathInput['reste'] * 2 / 3;
            $this->rapport .= "الاخوة لاب يرثون للذكر مثل حظ الانثيين\n";
        }
        $this->part[] =
            [
                'type' => 'الاخوة لاب',
                'part' => $part,
            ];
    }



    public function mirathalakhawat_li_ab(&$mirathInput)
    {
        if (
            $mirathInput["alakhawat_li_ab"] == 0 || $this->far3Warith > 0 || $mirathInput["alab"] ||
            $mirathInput["alikhwa_alashika"] > 0 || $mirathInput["alakhawat_ashakikat"] > 1
            || ($mirathInput["aljad"] && $this->far3Warith <= 0)
        ) {
            return;
        }

        if (($mirathInput["alakhawat_li_ab"] == 1) && ($mirathInput["alikhwa_li_ab"] == 0) && !$mirathInput["aljad"]) {
            $part = $this->calculNesef($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الاخت لاب ترث  1/2 فرضا\n";
        }
        if (($mirathInput["alakhawat_li_ab"] > 1) && ($mirathInput["alikhwa_li_ab"] == 0) && !$mirathInput["aljad"]) {
            $part = $this->calculTholothin($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الاخوات لاب  يرثن 2/3 فرضا\n";
        }
        if ($mirathInput["alakhawat_li_ab"] > 0 && $mirathInput["alakhawat_ashakikat"] == 1 && $mirathInput["alakhawat_li_ab"] == 0) {
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            $mirathInput['reste'] -= $part;
            $this->rapport .= "الاخوات لاب يرثن السدس1/6  تكملة للثلثين\n";
        }

        if (($mirathInput["alakhawat_li_ab"] > 0) && ($mirathInput["alikhwa_li_ab"] > 0)) {
            $part = $mirathInput['reste'] * 1 / 3;
            $this->rapport .= "الاخوات لاب يرثن  نصف 1/2 الاخوة لاب\n";
        }
        $this->part[] =
            [
                'type' => 'الاخوات لاب',
                'part' => $part,
            ];
    }


    public function mirathabna_alikhwa_alashika(&$mirathInput)
    {
        if (
            $mirathInput["abna_alikhwa_alashika"] == 0 || $this->far3Warith > 0 || $mirathInput["alab"] ||
            $mirathInput["alikhwa_alashika"] > 0 || $mirathInput["alikhwa_li_ab"] > 0 || $mirathInput["aljad"]
        ) {
            return;
        }
        $part = $mirathInput['reste'];
        $this->rapport .= "أبناء الإخوة الأشقاء يرثون الباقي تعصيبا بالنفس \n";
        $this->part[] = [
            'type' => 'أبناء الإخوة الأشقاء',
            'part' => $part,
            'fraction' => 'الباقي تعصيباً'
        ];
        $mirathInput['reste'] = 0;
    }



    public function mirathabna_alikhwa_li_ab(&$mirathInput)
    {
        if (
            $mirathInput["abna_alikhwa_li_ab"] == 0 || $this->far3Warith > 0 || $mirathInput["alab"] ||
            $mirathInput["alikhwa_alashika"] > 0 || $mirathInput["alikhwa_li_ab"] > 0 || $mirathInput["aljad"] ||
            $mirathInput["abna_alikhwa_alashika"] > 0
        ) {
            return;
        }
        $part = $mirathInput['reste'];
        $this->rapport .= "ابناء الاخوة لاب يرثون الباقي تعصيبا بالنفس\n";
        $this->part[] =
            [
                'type' => 'ابناء الاخوة لاب',
                'part' => $part,
                'fraction' => 'الباقي تعصيباً'
            ];
        $mirathInput['reste'] = 0;
    }

    public function mirathala3mam_alashika(&$mirathInput)
    {
        if (
            $mirathInput["ala3mam_alashika"] == 0 || $this->far3Warith > 0 || $mirathInput["alab"] ||
            $mirathInput["alikhwa_alashika"] > 0 || $mirathInput["alikhwa_li_ab"] > 0 || $mirathInput["aljad"] ||
            $mirathInput["abna_alikhwa_alashika"] > 0 || $mirathInput["abna_alikhwa_li_ab"] > 0
        ) {
            return;
        }
        $part = $mirathInput['reste'];
        $this->rapport .= "الاعمام الاشقاء يرثون الباقي تعصيبا بالنفس\n";
        $this->part[] =
            [
                'type' => 'الاعمام الاشقاء',
                'part' => $part,
                'fraction' => 'الباقي تعصيباً'
            ];
        $mirathInput['reste'] = 0;
    }

    public function mirathala3mam_li_ab(&$mirathInput)
    {
        if (
            $mirathInput["ala3mam_li_ab"] == 0 || $this->far3Warith > 0 || $mirathInput["alab"] ||
            $mirathInput["alikhwa_alashika"] > 0 || $mirathInput["alikhwa_li_ab"] > 0 || $mirathInput["aljad"] ||
            $mirathInput["abna_alikhwa_alashika"] > 0 || $mirathInput["abna_alikhwa_li_ab"] > 0 ||
            $mirathInput["ala3mam_alashika"] > 0
        ) {
            return;
        }
        $part = $mirathInput['reste'];
        $this->rapport .= "الاعمام لاب يرثون الباقي تعصيبا بالنفس\n";
        $this->part[] =
            [
                'type' => 'الاعمام لاب',
                'part' => $part,
                'fraction' => 'الباقي تعصيباً'
            ];
        $mirathInput['reste'] = 0;
    }

    public function mirathabna_ala3mam_alashika(&$mirathInput)
    {
        if (
            $mirathInput["abna_ala3mam_alashika"] == 0 || $this->far3Warith > 0 || $mirathInput["alab"] ||
            $mirathInput["alikhwa_alashika"] > 0 || $mirathInput["alikhwa_li_ab"] > 0 || $mirathInput["aljad"] ||
            $mirathInput["abna_alikhwa_alashika"] > 0 || $mirathInput["abna_alikhwa_li_ab"] > 0 ||
            $mirathInput["ala3mam_alashika"] > 0 || $mirathInput["ala3mam_li_ab"] > 0
        ) {
            return;
        }
        $part = $mirathInput['reste'];
        $this->rapport .= "ابناء الاعمام الاشقاء يرثون الباقي تعصيبا بالنفس\n";
        $this->part[] =
            [
                'type' => 'ابناء الاعمام الاشقاء',
                'part' => $part,
                'fraction' => 'الباقي تعصيباً'
            ];
        $mirathInput['reste'] = 0;
    }

    public function mirathabna_ala3mam_li_ab(&$mirathInput)
    {
        if (
            $mirathInput["abna_ala3mam_li_ab"] == 0 || $this->far3Warith > 0 || $mirathInput["alab"] ||
            $mirathInput["alikhwa_alashika"] > 0 || $mirathInput["alikhwa_li_ab"] > 0 || $mirathInput["aljad"] ||
            $mirathInput["abna_alikhwa_alashika"] > 0 || $mirathInput["abna_alikhwa_li_ab"] > 0 ||
            $mirathInput["ala3mam_alashika"] > 0 || $mirathInput["ala3mam_li_ab"] > 0 ||
            $mirathInput["abna_ala3mam_alashika"] > 0
        ) {
            return;
        }
        $part = $mirathInput['reste'];
        $this->rapport .= "ابناء الاعمام لاب  يرثون الباقي تعصيبا بالنفس\n";
        $this->part[] =
            [
                'type' => 'ابناء الاعمام لاب',
                'part' => $part,
                'fraction' => 'الباقي تعصيباً'
            ];
        $mirathInput['reste'] = 0;
    }
}
