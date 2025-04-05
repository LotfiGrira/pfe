<?php

namespace App\Services;

use App\Models\Mirath;

class MirathService
{
    protected $input;
    protected $hal;

    public function __construct($input, $hal)
    {
        $this->input = $input;
        $this->hal = $hal;
    }
      public function hissabMawarith()
    {
        // Définir les variables
        $far3WarithDhakar = ($this->input['alabna'] ?? 0) + ($this->input['abna_alabna'] ?? 0) > 0;
        $far3WarithOntha = ($this->input['albanat'] ?? 0) + ($this->input['banat_alabna'] ?? 0) > 0;
        $far3Warith = $far3WarithDhakar || $far3WarithOntha;
        $jam3Alikhwa = array_sum([
            $this->input['alikhwa_alashika'] ?? 0,
            $this->input['alikhwa_li_ab'] ?? 0,
            $this->input['alikhwa_li_om'] ?? 0,
            $this->input['alakhawat_ashakikat'] ?? 0,
            $this->input['alakhawat_li_ab'] ?? 0,
            $this->input['alakhawat_li_om'] ?? 0
        ]) > 1;

        $aslWarithDhaker = !empty($this->input['alab']) || !empty($this->input['aljad']);
        $far3WaAslWarithDhaker = $far3WarithDhakar || $aslWarithDhaker;
        $alikhwaAlashikaWaLiAb = ($this->input['alikhwa_alashika'] ?? 0) + ($this->input['alikhwa_li_ab'] ?? 0) > 0;
        $alikhwaWaAbnaAlikhwa = array_sum([
            $this->input['alikhwa_alashika'] ?? 0,
            $this->input['alikhwa_li_ab'] ?? 0,
            $this->input['abna_alikhwa_alashika'] ?? 0,
            $this->input['abna_alikhwa_li_ab'] ?? 0
        ]) > 0;
        $ala3mam = ($this->input['ala3mam_alashika'] ?? 0) + ($this->input['ala3mam_li_ab'] ?? 0) > 0;

        // أصحاب الفروض
        $this->mirathAzawj();
        $this->mirathAzawjat();
        $this->mirathAlab();
        $this->mirathAljad();
        $this->mirathAlom();
        $this->mirathAljadat();
        $this->mirathAwladAlom();
        $this->mirathAlbanatBiAlfardh();
        $this->mirathAlakhawatAshakikatBiAlfardh();
        $this->mirathAlakhawatLiAbBiAlfardh();

        // أصحاب التعصيب
        $this->mirathAlabnaWaAlbanatBita3seeb();
        $this->mirathAbnaWaBanatAlabnaBita3seeb();

        if ($this->input['aljad_ma3a_alikhwa'] ?? '' == 'LA') {
            $this->mirathAlashikaWaAshakikatBita3seeb(0, false, false);
            $this->mirathAlikhwaWaAlakhawatLiAbBita3seeb(0, false, false);
        } else {
            $this->mirathAljadMa3aAlikhwa();
        }

        // Autres héritiers
        $this->mirathAbnaAlikhwaAlashika();
        $this->mirathAbnaAlikhwaLiAb();
        $this->mirathAla3mamAlashika();
        $this->mirathAla3mamLiAb();
        $this->mirathAbnaAla3mamAlashika();
        $this->mirathAbnaAla3mamLiAb();

        // Vérification des héritiers
        if (empty($this->warathah)) {
            return ['message' => $this->sharh];
        }

        // Calcul des fractions et parts d'héritage
        $this->hissabAlaslWaRo2os();
        $this->hissabAlashom();
        $this->hissabAlbaqiWaRad();

        if ($this->input['aljad_ma3a_alikhwa'] ?? '' == 'MA3A_FARDH') {
            $this->hissabAlahadhLiljad();
        }

        $this->hissabAnsiba();
        $this->hissabAsharh();

        return $this->warathah;
    }
    public function mirathAzawj()
    {
        if (!$this->input->hasZawj()) {
            return;
        }
        $this->hal->saveZawjiaIndex();
        $maqam = 2;
        $sharh = "الزوج يرث ";
        if ($this->input->hasFar3Warith()) {
            $maqam = 4;
            $sharh .= "الربع 1/4 فرضا";
        } else {
            $sharh .= "النصف 1/2 فرضا";
        }
        $this->addMirath(new Mirath('AZAWJ', $sharh, 1, $maqam));
    }

    public function mirathAzawja()
    {
        if (!$this->input->hasZawja()) {
            return;
        }
        $this->hal->saveZawjiaIndex();
        $maqam = 4;
        $sharh = "الزوجة ترث ";
        if ($this->input->hasFar3Warith()) {
            $maqam = 8;
            $sharh .= "الثمن 1/8 فرضا";
        } else {
            $sharh .= "الربع 1/4 فرضا";
        }
        $this->addMirath(new Mirath('AZAWJA', $sharh, 1, $maqam));
    }
    
    public function mirathAlab()
    {
        if (!$this->input->hasAlab())
         {
            return;
        }
        $bast = 0;
        $maqam = 1;
        $ro2os = 1;
        $ta3seeb = true;
        $sharh = "الأب يرث ";
        if ($this->input->hasFar3WarithDhakar()) 
        {
            // Cas 1: Si un fils existe -> 1/6 فرضا فقط
            $bast = 1;
            $maqam = 6;
            $ro2os = 1;
            $ta3seeb = false;
            $sharh .= "السدس 1/6 فرضا فقط";
        } elseif ($this->input->hasFar3WarithOntha()) 
        {
            // Cas 2: Si une fille seulement -> 1/6 + باقي تعصيب
            $bast = 1;
            $maqam = 6;
            $ro2os = 1;
            $ta3seeb = true;
            $sharh .= "السدس 1/6 فرضا والباقي تعصيبا بالنفس";
        } else 
            {
                //  Cas 3:الأب يأخذ الباقي تعصيبًا
                $sharh .= "الباقي تعصيبا بالنفس";
            }
        
             $this->addMirath(new Mirath('ALAB', $sharh, $bast, $maqam, $ta3seeb, $ro2os));
    }

    public function mirathAlom()
    {
        if (empty($this->input['alom'])) return;

        $bast = 1;
        $maqam = 3;
        $ro2os = 1;
        $ta3seeb = false;
        $sharh = "الأم ترث ";

        if ($this->input['jam3_alikhwa'] || $this->input['far3_warith']) {
            $sharh .= "السدس 1/6 فرضا";
            $maqam = 6;
        } elseif (!empty($this->input['alab']) && (!empty($this->input['azawjat']) || !empty($this->input['zawj']))) {
            $sharh = "الأم ترث ثلث 1/3 الباقي";
            $bast = 0;
            $maqam = 3;
            $ro2os = 3;
            $ta3seeb = true;
        } else {
            
            $sharh .= "الثلث 1/3 فرضا";
        }

    }

    public function mirathAljad()
    {// Si le père est vivant, le grand-père est bloqué
        if (!$this->input->hasAljad() || $this->input->hasAlab()) {
            return;
        }
        $sharh = '';
        $bast = 0;
        $maqam = 1;
        $ta3seeb = false;
        // Vérifier s'il y a des frères ou sœurs
        $hasBrothersAndSisters = ($this->input->getAlakhawatAshakikat() + $this->input->getAlakhawatLiAb()) > 0;

        // Cas où il hérite obligatoirement
        if ($this->input->hasFar3WarithDhakar()) {
            $sharh = "السدس 1/6 فرضا فقط";
            $bast = 1;
            $maqam = 6;
            $this->addMirath('ALJAD', $sharh, $bast, $maqam);
        }
        // Cas où il hérite en obligation et en priorité
        elseif (!$this->input->hasAlikhwaAlashikaWaLiAb() && !$hasBrothersAndSisters) {
            if ($this->input->hasFar3WarithOntha()) {
                $sharh = "السدس 1/6 فرضا و";
                $bast = 1;
                $maqam = 6;
            }
            $sharh .= "الباقي تعصيبا بالنفس";
            $ta3seeb = true;
            $this->addMirath('ALJAD', $sharh, $bast, $maqam, $ta3seeb);
        }
        //  le grand-père hérite avec les frères selon la meilleure option
        else {
            $this->input->setAljadMa3aAlikhwa(true);
        }
    }
   
    public function MirathAljadat()
    {
        if (!empty($this->input['alom'])) {
            return []; // La mère est présente, donc les grands-mères n'héritent pas
        }

        if (!empty($this->input['aljadah_li_ab']) && 
            (empty($this->input['alab']))) {
            
            $sharh = "الجدة لأب ";
            $ro2os = 1;

            if (!empty($this->input['aljadah_li_om'])) {
                $sharh .= "تشترك (بالتساوي) مع الجدة لأم في السدس 1/6 فرضا";
                $ro2os = 2;
            } else {
                $sharh .= "ترث السدس 1/6 فرضا";
            }

            $this->addMirath('الجدة لأب', $sharh, 1, 6, $ro2os);
        }

        if (!empty($this->input['aljadah_li_om'])) {
            $sharh = "الجدة لأم ";
            $ro2os = 1;

            if (!empty($this->input['aljadah_li_ab']) && 
                (empty($this->input['alab']))) {
                
                $sharh .= "تشترك (بالتساوي) مع الجدة لأب في السدس 1/6 فرضا";
                $ro2os = 2;
            } else {
                $sharh .= "ترث السدس 1/6 فرضا";
            }

            $this->addMirath('الجدة لأم', $sharh, 1, 6, $ro2os);
        }
    }
     
    public function MirathAwladAlom()
    {
        $nbrA = $this->input['alikhwa_li_om'] ?? 0; // Nombre de frères utérins
        $nbrB = $this->input['alakhawat_li_om'] ?? 0; // Nombre de sœurs utérines
        $awladAlom = $nbrA + $nbrB;

        if ($awladAlom === 0) return [];

        // Si un descendant hérite, les frères et sœurs utérins sont bloqués
        if (!empty($this->input['far3_warith']) || !empty($this->input['alab']) || !empty($this->input['aljad'])) {
            {
            if ($nbrA > 0) {
                $this->addHajb('الإخوة لأم', $nbrA, "محجوب بسبب الفرع الوارث او الجد او الاب");
            }
            if ($nbrB > 0) {
                $this->addHajb('الإخوة لأم', $nbrB, "محجوب بسبب الفرع الوارث او الجد او الاب");
            }
            return [];
        }
        if ($awladAlom > 1) {
            // Vérifier s'il y a une situation "مشتركة" (cas particulier)
            $ishtirak = false;
            $ro2os = $awladAlom;

            if ($nbrA > 0 && $nbrB > 0) {
                // Cas où frères et sœurs utérins héritent ensemble
                $sharhA = "الإخوة لأم يرثون الثلث 1/3 فرضًا بالتساوي";
                $sharhB = "الأخوات لأم يرثن الثلث 1/3 فرضًا بالتساوي";

                $this->addMirath('الإخوة لأم', $nbrA, $sharhA, 1, 3, $ro2os);
                $this->addMirath('الأخوات لأم', $nbrB, $sharhB, 1, 3, $ro2os);
            } elseif ($nbrA > 0) {
                $sharh = "الإخوة لأم يرثون الثلث 1/3 فرضًا";
                $this->addMirath('الإخوة لأم', $nbrA, $sharh, 1, 3, $ro2os);
            } else {
                $sharh = "الأخوات لأم يرثن الثلث 1/3 فرضًا";
                $this->addMirath('الأخوات لأم', $nbrB, $sharh, 1, 3, $ro2os);
            }
        } elseif ($nbrA === 1) {
            $sharh = "الأخ لأم يرث السدس 1/6 فرضًا";
            $this->addMirath('الأخ لأم', 1, $sharh, 1, 6);
        } else {
            $sharh = "الأخت لأم ترث السدس 1/6 فرضًا";
            $this->addMirath('الأخت لأم', 1, $sharh, 1, 6);
        }

        return $this->mirath;
        }
    }

    public function  mirathAlbanatBiAlfardh()
    {
     if (($this->input['alabna'] ?? 0) > 0) {
        return;
     }

     $nbr = $this->input['albanat'] ?? 0;
     $sharh = '';
     $bast = 0;
     $maqam = 1;

     if ($nbr === 1) {
        $sharh = __('ALBANAT') . ' - النصف 1/2 فرضا';
        $this->addMirath('ALBANAT', $sharh, 1, 2);

        if (($this->input['abna_alabna'] ?? 0) === 0 && ($this->input['banat_alabna'] ?? 0) > 0) {
            $sharh = __('BANAT_ALABNA') . ' - السدس 1/6 تتمة الثلثين فرضا';
            $this->addMirath('BANAT_ALABNA', $sharh, 1, 6, $this->input['banat_alabna']);
        }

     } elseif ($nbr >= 2) {
        $sharh = __('ALBANAT') . " ($nbr) - الثلثين 2/3 فرضا";
        $this->addMirath('ALBANAT', $sharh, 2, 3, $nbr);

        if (($this->input['abna_alabna'] ?? 0) === 0 && ($this->input['banat_alabna'] ?? 0) > 0) {
            $this->addHajb('BANAT_ALABNA', $this->input['banat_alabna'], 'الجمع من البنات');
        }

     } else { // $nbr === 0
        if (($this->input['abna_alabna'] ?? 0) === 0 && ($this->input['banat_alabna'] ?? 0) > 0) {
            $nbr_banat_alabna = $this->input['banat_alabna'];

            if ($nbr_banat_alabna === 1) {
                $bast = 1;
                $maqam = 2;
                $sharh = __('BANAT_ALABNA') . ' - النصف 1/2 فرضا';
            } else {
                $bast = 2;
                $maqam = 3;
                $sharh = __('BANAT_ALABNA') . " ($nbr_banat_alabna) - الثلثين 2/3 فرضا";
            }

            $this->addMirath('BANAT_ALABNA', $sharh, $bast, $maqam, $nbr_banat_alabna);
        }
    }
}
}