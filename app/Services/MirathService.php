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
    // 6 variable //
    protected flot $nesef = [ "bast" => 1, "ma9am" =>2];
    protected flot $robo3 = [ "bast" => 1, "ma9am" => 4];
    protected flot $thomon = [ "bast" => 1, "ma9am" => 8];
    protected flot $tholothin = [ "bast" => 2, "ma9am" => 3];
    protected flot $tholoth = [ "bast" => 1, "ma9am" => 3];
    protected flot $sodoss = [ "bast" => 1, "ma9am" => 6];
    protected flot $nesefsodos = [ "bast" => 1, "ma9am" => 12];


    public function __construct(array $input = [])
    {
        $this->input = $input;

        // Initialiser tarika, doyoun, wasiya à partir des données d'entrée
        $this->tarika = isset($input['tarika']) ? (float) $input['tarika'] : 0;
        $this->doyon = isset($input['doyon']) ? (float) $input['doyon'] : 0;
        $this->wasiya = isset($input['wasiya']) ? (float) $input['wasiya'] : 0;
    }

    protected function ta3sibBiNafes($tarika, $partActuel = 0): float
    {
        return $tarika - $partActuel;
    }
    protected function ta3sibBiGhayr($tarika, $partActuel = 0): float
    {
        return $tarika - $partActuel;
    }
    protected function ta3sibMa3aGhayr($tarika, $partActuel = 0): float
    {
        return $tarika - $partActuel;
    }

    public function getRapport()
    {
        return $this->rapport;
    }

    public function getType()
    {
        return $this->type;
    }

    public function calculMirath(&$mirathInput)
    {
        // nsjlou table 9esma bech yaatina id (cle primaire)
        $this->far3WarithDhakar = ($mirathInput['alabna'] > 0) + ($mirathInput['abna_alabna'] > 0) > 0;
        $this->far3WarithOntha = ($mirathInput['albanat'] > 0) + ($mirathInput['banat_alabna'] > 0) > 0;
        $this->far3Warith = $this->far3WarithDhakar || $this->far3WarithOntha;
        $mirathInput['safi_tarika'] = $mirathInput['tarika'] - $mirathInput['doyon'] - $mirathInput['wasiya'];
        $mirathInput['reste'] = $mirathInput['safi_tarika'];

        // n7aded naw3 l9a3da li bech nkamlou beha bina2an 3al  waratha (hal tab3in naw3 1 wala 2 wala mkhaltin)
        // mithal li yorthou nos 1/2 homa li tab3in naw3 l2awal elli homa mithal zawj, albent men ghir khou, ...
        
        // =======================
        // NAWA3 AWAL (1/2, 1/4, 1/8)
        // =======================
                    
        if ($mirathInput['zawj'] || $mirathInput['albanat'] || $mirathInput['banat_alabna'] || $mirathInput['alakhawat_ashakikat'] || $mirathInput['alakhawat_li_ab']) {
            if ()
        }


// TODO clean
if ($this->has('zawj') &&
 !$this->has('Fara3Warith')) {
    $this->mirathazawj('1/2');
}

if ($this->has('albanat') === 1 &&
 !$this->has('alabna')) {
    $this->mirathalbanat('1/2');
}

if ($this->has('banat_alabna') === 1 &&
 !$this->has('alabna') && 
 !$this->has('abna_alabna')&&
  $this->has('albanat')<2) {
    $this->mirathbanat_alabna('1/2');
}

if ($this->has('alakhawat_ashakikat') === 1 &&
 !$this->has('alab') && 
 !$this->has('Fara3Warith') && 
 !$this->has('alikhwa_ashakika') && 
 !$this->has('aljad')) {
    $this->mirathalakhawat_ashakikat('1/2');
}

if ($this->has('alakhawat_li_ab') === 1 &&
 !$this->has('alab') && 
 !$this->has('Fara3Warith') && 
 !$this->has('alikhwa_ashakika') &&
  $this->has('alakhawat_ashakikat') < 2 &&
 !$this->has('alikhwa_li_ab') && 
 !$this->has('aljad')) {
    $this->mirathalakhawat_li_ab('1/2');
}
//1/3
// === 1/4 (robo3)
if ($this->has('zawj') &&
 $this->has('Fara3Warith')) {
    $this->mirathazawj('1/4');
}

if ($this->has('zawja') && 
!$this->has('Fara3Warith')) {
    $this->mirathazawja('1/4');
}

// === 1/8 (thomoun)
if ($this->has('zawja') && 
$this->has('Fara3Warith')) {
    $this->mirathazawja('1/8');
}

// =======================
// NAWA3 THANI (2/3, 1/3, 1/6)
// =======================

// === 2/3 (thoulouthayn)
if ($this->has('albanat') >= 2 && 
!$this->has('alabna')) {
    $this->mirathalbanat('2/3');
}

if ($this->has('banat_alabna') >= 2 && 
!$this->has('alabna') && 
!$this->has('abna_alabna')&&
!$this->has('alabnat')) {
    $this->mirathbanat_alabna('2/3');
}

if ($this->has('alakhawat_ashakikat') >= 2 && 
!$this->has('alab') && 
!$this->has('Fara3Warith') && 
!$this->has('alikhwa_ashakika') && 
!$this->has('aljad')) {
    $this->mirathalakhawat_ashakikat('2/3');
}
if ($this->has('alakhawat_li_ab') >= 2 && 
!$this->has('alab') && 
!$this->has('Fara3Warith') && 
!$this->has('alikhwa_ashakika') &&
 !$this->has('alakhawat_ashakikat')  && 
 !$this->has('alikhwa_li_ab') && 
 !$this->has('aljad')) {
    $this->mirathalakhawat_li_ab('2/3');
}

// === 1/3 (tholoth)

if (($this->has('alikhwa_li_om') >= 2 || $this->has('alakhawat_li_om') >0) &&
 !$this->has('Fara3Warith') &&
  !$this->has('alab') && 
  !$this->has('aljad')) {
    $this->mirathalikhwa_li_om('1/3');
}
if (($this->has('alakhawat_li_om') >= 2 || $this->has('alikhwa_li_om') >0) &&
 !$this->has('Fara3Warith') &&
  !$this->has('alab') && 
  !$this->has('aljad')) {
    $this->mirathalakhawat_li_om('1/3');
}
if ($this->has('alom') && 
!$this->has('Fara3Warith')) {
    $this->mirathalom('1/3');
}

// === 1/6 (sodos)
if ($this->has('alab') && 
   $this->has('Fara3Warith')) {
    $this->mirathalab('1/6');
}
if ($this->has('alom') && 
   $this->has('Fara3Warith')) {
    $this->mirathalom('1/6');
}

if ($this->has('banat_alabna') === 1 &&
 !$this->has('abna_alabna')) {
    $this->mirathbanat_albna('1/6');
}

if ($this->has('alakhawat_alashika') === 1 &&
 !$this->has('alab') && 
 !$this->has('Fara3Warith_alashika') && 
 !$this->has('alikhwa_li_ab') && 
 !$this->has('aljad')) {
    $this->mirathalakhawat_li_ab('1/6');
}

if ($this->has('alikhwa_li_om') === 1 &&
 !$this->has('alakhawat_li_om') &&
  !$this->has('Fara3Warith') && 
  !$this->has('alab') && 
  !$this->has('aljad')) {
    $this->mirathalikhwa_li_om('1/6');
}

if ($this->has('alakhawat_li_om') === 1 &&
 !$this->has('alikhwa_li_om') && 
 !$this->has('Fara3Warith') && 
 !$this->has('alab') && 
 !$this->has('aljad')) {
    $this->mirathalakhawat_li_om('1/6');
}

if ($this->has('aljadah_li_om') &&
 !$this->has('aljadah_li_ab') && 
 !$this->has('alom')) {
    $this->mirathaljadah_li_om('1/6');
}

if ($this->has('aljadah_li_ab') &&
 !$this->has('aljadah_li_om') && 
 !$this->has('alom') && 
 !$this->has('alab')) {
    $this->mirathaljadah_li_ab('1/6');
}
if ($this->has('aljad') &&
 $this->has('Fara3Warith') && 
 !$this->has('alab')) {
    $this->mirathaljad('1/6');
}
        {
            if(ay wa7ed mena naw3 theni) 
            {
               // re initialisation des 6 variable(sodos nosf ...)
            //    9a3da 3
               $nosf = {bast => 3, ma9am => 6};
               .. 
            } else (ma3andi hata wa7ed mena naw3 theni) {
                9a3da 1
            }
        }
        else if((ay wa7ed men jma3et tholoth && men sodos) || (...))) {
            9a3da 2
        }
        .. tkamal tasna3 les if

        //les appels:
        $this->mirathazawj($mirathInput);
        $this->mirathazawja($mirathInput);
        $this->mirathalom($mirathInput);
        $this->mirathalab($mirathInput);
        $this->mirathaljad($mirathInput);
        $this->mirathaljadah_li_ab($mirathInput);
        $this->mirathaljadat_li_om($mirathInput);
        $this->mirathalbanat($mirathInput);
        $this->mirathbanat_alabna($mirathInput);
        $this->mirathalikhwa_li_om($mirathInput);
        $this->mirathalakhawat_li_om($mirathInput);
        $this->mirathalakhawat_ashakikat($mirathInput);
        $this->mirathalakhawat_li_ab($mirathInput);
        // beta3sib
        $this->mirathalabna($mirathInput);
        $this->mirathabna_alabna($mirathInput);
        $this->mirathalikhwa_alashika($mirathInput);
        $this->mirathalikhwa_li_ab($mirathInput);
        $this->mirathabna_alikhwa_alashika($mirathInput);
        $this->mirathabna_alikhwa_li_ab($mirathInput);
        $this->mirathala3mam_alashika($mirathInput);
        $this->mirathala3mam_li_ab($mirathInput);
        $this->mirathabna_ala3mam_alashika($mirathInput);
        $this->mirathabna_ala3mam_li_ab($mirathInput);
        // n3amrou table jdid resultat b données (id_9esma men fog, $this->rapport)
        $this->doyon = $mirathInput['doyon'] ?? 0;
        $this->wasiya = $mirathInput['wasiya'] ?? 0;
        //
        return [
            'rapport' => $this->rapport,
            'parts' => $this->part,
            'type' => $this->type,
            'tarika' => $mirathInput['safi_tarika'],
        ];
    }

    
    function calculNesef($tarika)
    {
        return $tarika * (1 / 2);
    }
    
    function calculRobo3($tarika)
    {
        return $tarika * (1 / 4);
    }
    function calculThomon($tarika)
    {
        return $tarika * (1 / 8);
    }
    function calculTholothin($tarika)
    {
        return $tarika * (2 / 3);
    }
    function calculTholoth($tarika)
    {
        return $tarika * (1 / 3);
    }
    function calculSodoss($tarika)
    {
        return $tarika * (1 / 6);
    }
    function calculNesefsodos($tarika)
    {
        return $tarika * (1 / 12);
    }

    // zawjan//
    public function mirathazawj(&$mirathInput)
    {
        if (!$mirathInput["zawj"]) {
            return;
        }
        if ($this->far3Warith) {
            $part = $this->calculRobo3($mirathInput['safi_tarika']);
            $this->rapport .= "الزوج يرث الربع 1/4 فرضا\n";
        } else {
            $part = $this->calculNesef($mirathInput['safi_tarika']);
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
            $this->rapport .= "الزوجة ترث الثمن 1/8 فرضا\n";
        } else {
            $part = $this->calculRobo3($mirathInput['safi_tarika']);
            $this->rapport .= "الزوجة ترث الربع 1/4 فرضا\n";
        }
        $mirathInput['reste'] -= $part;
        $this->part[] =
            [
                'type' => 'الزوجة',
                'part' => $part,
            ];
    }

    //Al osol//
    public function mirathalom(&$mirathInput)
    {
        if (!$mirathInput["alom"]) {
            return;
        }
        if ($this->far3Warith) {
            $part = $this->calculSodoss($mirathInput['safi_tarika']);
            $this->rapport .= "الام ترث السدس 1/6 فرضا\n";
        } else {
            $part = $this->calculTholoth($mirathInput['safi_tarika']);
            $this->rapport .= "الام ترث السدس 1/3 فرضا\n";
        }
        $mirathInput['reste'] -= $part;
        $this->part[] =
            [
                'type' => 'الام ',
                'part' => $part,
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
            $mirathInput['reste'] -= $mirathInput['reste'] / 2;
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
            $mirathInput['reste'] -= $mirathInput['reste'] / 2;
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
                'type' => ' الجد لاب',
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
                'type' => 'الحدة لاب ',
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
                'type' => 'الجدة لام ',
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
            $part = $mirathInput['reste'] * 1 / 3;
            $this->rapport .= "البنات  يرثن  1/2 الابناء\n";
        }
        $this->part[] =
            [
                'type' => 'البنات ',
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
                'type' => 'الابناء ',
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
                'type' => '   بنات  الابناء',
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
                'type' => 'الاخوة لام ',
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
                'type' => 'الاخوات لام  ',
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
                'type' => 'الاخوة الاشقاء ',
                'part' => $part,
            ];
    }



    public function mirathalakhawat_ashakikat(&$mirathInput)
    {
        if ($mirathInput["alakhawat_ashakikat"] == 0 || $this->far3Warith > 0 || $mirathInput["alab"] || ($mirathInput["aljad"] && $this->far3Warith <= 0)) {
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
                'type' => 'الاخوات الشقيقات ',
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
                'type' => 'الاخوة لاب ',
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
                'type' => 'الاخوات لاب ',
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
                'type' => 'ابناء الاخوة لاب ',
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
                'type' => 'الاعمام الاشقاء ',
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
                'type' => 'الاعمام لاب ',
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
                'type' => 'ابناء الاعمام الاشقاء ',
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
                'type' => 'ابناء الاعمام لاب ',
                'part' => $part,
                'fraction' => 'الباقي تعصيباً'
            ];
        $mirathInput['reste'] = 0;
    }
}
