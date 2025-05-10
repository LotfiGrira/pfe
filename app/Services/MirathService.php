<?php

namespace App\Services;

use App\Models\Mirath;

class MirathService
{
    protected $far3WarithDhakar;
    protected $far3WarithOntha;
    protected $far3Warith;
    protected $rapport;

    public function calculMirath($mirathInput) {
        $this->far3WarithDhakar = ($mirathInput['alabna'] > 0) + ($mirathInput['abna_alabna'] > 0) > 0;
        $this->far3WarithOntha = ($mirathInput['albanat'] > 0) + ($mirathInput['banat_alabna'] > 0) > 0;
        $this->far3Warith = $this->far3WarithDhakar || $this->far3WarithOntha;
        //les appels:
        $this->mirathazawj($mirathInput);
        $this->mirathazawja($mirathInput);
        $this->mirathalab($mirathInput);
        $this->mirathalom($mirathInput);
        $this->mirathaljad($mirathInput);
        $this->Mirathaljadah_li_ab($mirathInput);
        $this->Mirathaljadat_li_om($mirathInput);
        $this->mirathalbanat($mirathInput);
        $this->mirathbanat_alabna($mirathInput);
        $this->mirathabana_albanat($mirathInput);
        $this->mirathbanat_albanat($mirathInput);
        $this->mirathalikhwa_li_om($mirathInput);
        $this->mirathalakhawat_li_om($mirathInput);
        $this->mirathalakhawat_alashakikat($mirathInput);
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
        return $this->rapport;
    }


    // zawjan//
    public function mirathazawj($mirathInput)
        {
            if (!$mirathInput["zawj"]) {
                return;
            }
            if ($this->far3Warith) {
                $this->rapport .= "الربع 1/4 فرضا\n";
            } else {
                $this->rapport .= "النصف 1/2 فرضا\n";
            }
        }

    public function mirathazawja($mirathInput)
        {
            if (!$mirathInput["zawja"]) {
                return;
            }

            if ($this->far3Warith) {
                $this->rapport .= "الربع 1/4 فرضا\n";
            } else {
                $this->rapport .= "الثمن 1/8 فرضا\n";
            }
        }

    //Al osol//
    public function miratrapportab($mirathInput)
    {
        if (!$mirathInput["alab"])
        {
            return;
        }

        if ($this->far3WarithDhakar)
        {
            // Cas 1: Si un fils existe -> 1/6 فرضا فقط
            $this->rapport .= "السدس 1/6 فرضا فقط\n";
        } elseif ($this->far3WarithOntha)
        {
            // Cas 2: Si une fille seulement -> 1/6 + باقي تعصيب
            $this->rapport .= "السدس 1/6 فرضا والباقي تعصيبا بالنفس\n";
        } else
        {
            //  Cas 3:الأب يأخذ الباقي تعصيبًا
            $this->rapport .= "الباقي تعصيبا بالنفس\n";
        }
    }


    public function miratrapportom($mirathInput)
        {
            if (!$mirathInput["alom"]) {
            return;
        }
        if
            (!$mirathInput['far3_warith']) {
                $this->rapport .= "السدس 1/3 فرضا\n";
            } else  {
                $this->rapport .= "السدس 1/6 فرضا\n";
            }
        }

    public function miratrapportjad($mirathInput)
        {// Si le père est vivant, le grand-père est bloqué
            if (!$mirathInput["aljad"] || $mirathInput["alab"]) {

                return;
            }

        if ($this->far3WarithDhakar)
        {
            // Cas 1: Si un fils existe -> 1/6 فرضا فقط
            $this->rapport .= "السدس 1/6 فرضا فقط\n";
        } elseif ($mirathInput->hasFar3WarithOntha())
        {
            // Cas 2: Si une fille seulement -> 1/6 + باقي تعصيب
            $this->rapport .= "السدس 1/6 فرضا والباقي تعصيبا بالنفس\n";
        } else
        {
            //  Cas 3:الجد يأخذ الباقي تعصيبًا
            $this->rapport .= "الباقي تعصيبا بالنفس\n";
        }
        }


    public function miratrapportjadah_li_ab($mirathInput)
        {
            if (!$mirathInput["aljadah_li_ab"] || $mirathInput["alab"]|| $mirathInput["alom"]) {
                return;
            }
            if (!$mirathInput["aljadah_li_om"]) {
                    $this->rapport .= "الجدة لأب في السدس 1/6 فرضا\n";
                } else {
                    $this->rapport .= "ترث السدس 1/12 فرضا\n";
                }
        }

    public function miratrapportjadat_li_om($mirathInput)
        {
            if (!$mirathInput["aljadah_li_om"] || $mirathInput["alom"]) {
                return;
            }
            if (!$mirathInput["aljadah_li_ab"]) {
                    $this->rapport .= "الجدة لأم في السدس 1/6 فرضا\n";
                } else {
                    $this->rapport .= "ترث السدس 1/12 فرضا\n";
                }
    }
    //el foro3//
    public function  miratrapportbanat($mirathInput)
        {
        if (!$mirathInput["albanat"]) {
            return;
        }

        if (($mirathInput["albanat"] ==1) && ($mirathInput["alabna"] == 0)){
                    $this->rapport .= "ترث  1/2 فرضا\n";
                    }
        else if  (($mirathInput["albanat"] > 1) && ($mirathInput["alabna"] == 0)) {
                    $this->rapport .= "ترث  2/3 فرضا\n";
        }
        else if  (($mirathInput["albanat"] > 0) && ($mirathInput["alabna"] > 0)) {
                    $this->rapport .= "ترث  1/2 الابناء\n";
        }
        }


    public function miratrapportabna($mirathInput)
    {
        if (!$mirathInput["alabna"]) {return;  }

        if ($mirathInput["albanat"] == 0) {
            $this->rapport .= "الباقي تعصيبا بالنفس\n";
        } else {
            $this->rapport .= "للذكر مثل حظ الانثيين\n";
            }
    }


    public function mirathabna_alabna($mirathInput)
    {
        if ($mirathInput["abna_alabna"] == 0 || $mirathInput["abna"] > 0) {
            return;
        }
        if ($mirathInput["alabna_alabna"] === 0) {return;}

        if ($mirathInput["banat_alabna"] === 0) {
            $this->rapport .= "الباقي تعصيبا بالنفس\n";
        } else {
            $this->rapport = 2 * $mirathInput["alabna_alabna"] + $mirathInput["banat_alabna"];
            $this->rapport .= "للذكر مثل حظ الانثيين\n";
        }
    }

    public function  mirathbanat_alabna($mirathInput)
        {
            if ($mirathInput["banat_alabna"]== 0 || $mirathInput["abna"] > 0 || $mirathInput["albanat"] > 1 ) {
                return;
            }

            if (($mirathInput["banat_alabna"] ==1) && ($mirathInput["abna_alabna"] == 0)){
                $this->rapport .= "ترث  1/2 فرضا\n";
            }
            if (($mirathInput["banat_alabna"] > 1) && ($mirathInput["abna_alabna"] == 0)) {
                $this->rapport .= "ترث  2/3 فرضا\n";
            }
            if (($mirathInput["banat_alabna"] > 0) && ($mirathInput["abna_alabna"] > 0)) {
                $this->rapport .= "ترث نصف 1/2 الابناء\n";
            }
        }

    // wasiya wajiba//
    public function  mirathabana_albanat($mirathInput)
        {
            if ($mirathInput["abna_albanat"]== 0 || $mirathInput["albanat"] > 0  ) {
                return;
            }
            if($mirathInput["banat_albanat"]== 0){
                $this->rapport .= "ميراث الام 1/3\n";
            } else {
                $nbr_b = $mirathInput["banat_alabna"];
                $nbr_a = $mirathInput["abna_alabna"];
                $this->rapport = 2 * $nbr_a + $nbr_b;
                $this->rapport .= "ترث نصف 1/2 الابناء\n";
            }
        }

    public function  mirathbanat_albanat($mirathInput)
        {
            if ($mirathInput["banat_albanat"]== 0 || $mirathInput["albanat"] > 0  ) {
                return;
            }
            if($mirathInput["abna_albanat"]== 0){
                $this->rapport .= "ميراث الام 1/3\n";
            } else {
                $this->rapport .= "ترث نصف 1/2 الابناء\n";
            }
        }
    // al 7awachi //
    public function miratrapportikhwa_li_om($mirathInput)
        {
            if ($mirathInput["alikhwa_li_om"] == 0 || $this->far3Warith > 0 || !$mirathInput['alab'] || !$mirathInput['aljad']) {
                return;
            }

            if ($mirathInput["alakhawat_li_om"] > 0) {
                $this->rapport .= "الإخوة لأم يرثون الثلث 1/3 فرضًا بالتساوي\n";
            } else {
                $this->rapport .= "الإخوة لأم يرثون الثلث 1/6 فرضًا بالتساوي\n";
            }
        }


    public function miratrapportakhawat_li_om($mirathInput)
        {
            if ($mirathInput["alakhawat_li_om"] == 0 || $this->far3Warith > 0 || !$mirathInput["alab"] || !$mirathInput["aljad"]) {
                return;
            }

            if ($mirathInput['alikhwa_li_om'] > 0) {
                $this->rapport .= "الإخوات لأم ترثن الثلث 1/3 فرضًا بالتساوي\n";
            } else {
                $this->rapport .= "الإخوات لأم ترثن الثلث 1/6 فرضًا بالتساوي\n";
            }
        }

    public function miratrapportikhwa_alashika($mirathInput)
        {
            if ($mirathInput["alikhwa_alashika"] == 0 || $this->far3Warith > 0 || !$mirathInput["alab"]) {
                return;
            }

            if ($mirathInput["alakhawat_alashakikat"] == 0) {
                $this->rapport .= "الباقي تعصيبا بالنفس\n";
            } else {
                $this->rapport = 2 * $mirathInput["alikhwa_alashika"] + $mirathInput["alakhawat_alashakikat"];
            }
        }


    public function miratrapportakhawat_alashakikat($mirathInput)
        {
            if ($mirathInput["alakhawat_alashakikat"] == 0 || $this->far3Warith > 0 || !$mirathInput["alab"]) {
                return;
            }

            if (($mirathInput["alakhawat_alashakikat"] == 1) && ($mirathInput["alikhwa_alashika"] == 0)) {
                $this->rapport .= "ترث 1/2 فرضا\n";
            }
            if (($mirathInput["alakhawat_alashakikat"] > 1) && ($mirathInput["alikhwa_alashika"] == 0)) {
                $this->rapport .= "ترث 2/3 فرضا\n";
            }
            if (($mirathInput["alakhawat_alashakikat"] > 0) && ($mirathInput["alikhwa_alashika"] > 0)) {
                $this->rapport .= "ترث 1/2 الاخوة الأشقاء\n";
            }
        }


    public function miratrapportikhwa_li_ab($mirathInput)
        {
            if ($mirathInput["alikhwa_li_ab"] == 0 || $this->far3Warith > 0 || !$mirathInput["alab"] || $mirathInput["alikhwa_alashika"] > 0) {
                return;
            }

            if ($mirathInput["alakhawat_li_ab"] == 0) {
                $this->rapport .= "الباقي تعصيبا بالنفس\n";
            } else {
                $this->rapport = 2 * $mirathInput["alikhwa_li_ab"] + $mirathInput["alakhawat_li_ab"];
            }
        }

    public function miratrapportakhawat_li_ab($mirathInput)
        {
            if ($mirathInput["alakhawat_li_ab"] == 0 || $this->far3Warith > 0 || !$mirathInput["alab"] || 
                $mirathInput["alikhwa_alashika"] > 0 || $mirathInput["alakhawat_alashakikat"] > 1) {
                return;
            }

            if (($mirathInput["alakhawat_li_ab"] == 1) && ($mirathInput["alikhwa_li_ab"] == 0) && !$mirathInput["aljad"]) {
                $this->rapport .= "ترث 1/2 فرضا\n";
            }
            if (($mirathInput["alakhawat_li_ab"] > 1) && ($mirathInput["alikhwa_li_ab"] == 0) && !$mirathInput["aljad"]) {
                $this->rapport .= "ترث 2/3 فرضا\n";
            }
            if (($mirathInput["alakhawat_li_ab"] > 0) && ($mirathInput["alikhwa_li_ab"] > 0)) {
                $this->rapport .= "ترث 1/2 الاخوة الأشقاء\n";
            }
        }


    public function mirathabna_alikhwa_alashika($mirathInput)
    {
        if ($mirathInput["abna_alikhwa_alashika"] == 0 || $this->far3Warith > 0 || !$mirathInput["alab"] || 
            $mirathInput["alikhwa_alashika"] > 0 || $mirathInput["alikhwa_li_ab"] > 0 || !$mirathInput["aljad"]) {
            return;
        }

        $this->rapport .= "الباقي تعصيبا بالنفس\n";
    }

    public function mirathabna_alikhwa_li_ab($mirathInput)
    {
        if ($mirathInput["abna_alikhwa_li_ab"] == 0 || $this->far3Warith > 0 || !$mirathInput["alab"] || 
            $mirathInput["alikhwa_alashika"] > 0 || $mirathInput["alikhwa_li_ab"] > 0 || !$mirathInput["aljad"] || 
            $mirathInput["abna_alikhwa_alashika"] > 0) {
            return;
        }

        $this->rapport .= "الباقي تعصيبا بالنفس\n";
    }

    public function miratrapporta3mam_alashika($mirathInput)
    {
        if ($mirathInput["ala3mam_alashika"] == 0 || $this->far3Warith > 0 || !$mirathInput["alab"] || 
            $mirathInput["alikhwa_alashika"] > 0 || $mirathInput["alikhwa_li_ab"] > 0 || !$mirathInput["aljad"] || 
            $mirathInput["abna_alikhwa_alashika"] > 0 || $mirathInput["abna_alikhwa_li_ab"] > 0) {
            return;
        }

        $this->rapport .= "الباقي تعصيبا بالنفس\n";
    }

    public function miratrapporta3mam_li_ab($mirathInput)
    {
        if ($mirathInput["ala3mam_li_ab"] == 0 || $this->far3Warith > 0 || !$mirathInput["alab"] || 
            $mirathInput["alikhwa_alashika"] > 0 || $mirathInput["alikhwa_li_ab"] > 0 || !$mirathInput["aljad"] || 
            $mirathInput["abna_alikhwa_alashika"] > 0 || $mirathInput["abna_alikhwa_li_ab"] > 0 || 
            $mirathInput["ala3mam_alashika"] > 0) {
            return;
        }

        $this->rapport .= "الباقي تعصيبا بالنفس\n";
    }

    public function mirathabna_ala3mam_alashika($mirathInput)
    {
        if ($mirathInput["abna_ala3mam_alashika"] == 0 || $this->far3Warith > 0 || !$mirathInput["alab"] || 
            $mirathInput["alikhwa_alashika"] > 0 || $mirathInput["alikhwa_li_ab"] > 0 || !$mirathInput["aljad"] || 
            $mirathInput["abna_alikhwa_alashika"] > 0 || $mirathInput["abna_alikhwa_li_ab"] > 0 || 
            $mirathInput["ala3mam_alashika"] > 0 || $mirathInput["ala3mam_li_ab"] > 0) {
            return;
        }

        $this->rapport .= "الباقي تعصيبا بالنفس\n";
    }

    public function mirathabna_ala3mam_li_ab($mirathInput)
    {
        if ($mirathInput["abna_ala3mam_li_ab"] == 0 || $this->far3Warith > 0 || !$mirathInput["alab"] || 
            $mirathInput["alikhwa_alashika"] > 0 || $mirathInput["alikhwa_li_ab"] > 0 || !$mirathInput["aljad"] || 
            $mirathInput["abna_alikhwa_alashika"] > 0 || $mirathInput["abna_alikhwa_li_ab"] > 0 || 
            $mirathInput["ala3mam_alashika"] > 0 || $mirathInput["ala3mam_li_ab"] > 0 || 
            $mirathInput["abna_ala3mam_alashika"] > 0) {
            return;
        }

        $this->rapport .= "الباقي تعصيبا بالنفس\n";
    }

}
