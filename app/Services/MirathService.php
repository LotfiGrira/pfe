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
    $far3WarithDhakar = ($this->input['alabna'] > 0) + ($this->input['abna_alabna'] > 0) > 0;
    $far3WarithOntha = ($this->input['albanat'] > 0) + ($this->input['banat_alabna'] > 0) > 0;
    $far3Warith = $far3WarithDhakar || $far3WarithOntha;
    }
    // zawjan//
public function mirathazawj()
    {
        if (!$this->input["zawj"]) {
            return;
        }
        if ($far3Warith) {    
            $hal .= "الربع 1/4 فرضا\n";
        } else {
            $hal .= "النصف 1/2 فرضا\n";
        }
    }

public function mirathazawja()
    {
        if (!$this->input["zawja"]) {
            return;
        }
        
        if ($far3Warith) {  
            $hal .= "الربع 1/4 فرضا\n";
        } else {
            $hal .= "النصف 1/8 فرضا\n";
        }
    }
    
//Al osol//
public function mirathalab()
{
    if (!$this->input["alab"])
     {
        return;
    }
   
    if ($far3WarithDhakar) 
    {
        // Cas 1: Si un fils existe -> 1/6 فرضا فقط
        $hal .= "السدس 1/6 فرضا فقط\n";
    } elseif ($far3WarithOntha) 
    {
        // Cas 2: Si une fille seulement -> 1/6 + باقي تعصيب
        $hal .= "السدس 1/6 فرضا والباقي تعصيبا بالنفس\n";
    } else 
    {
        //  Cas 3:الأب يأخذ الباقي تعصيبًا
        $hal .= "الباقي تعصيبا بالنفس\n";
    }
}


public function mirathalom()
    {
        if (!$this->input["alom"]) {
        return;
     }
     if
         (!$this->input['far3_warith']) {
            $hal .= "السدس 1/3 فرضا\n";
        } else  {
            $hal .= "السدس 1/6 فرضا\n";
        }
    }
 
 public function mirathaljad()
    {// Si le père est vivant, le grand-père est bloqué
        if (!$this->input["aljad"] || $this->input["alab"]) {
            
            return;
        }
        
     if ($far3WarithDhakar) 
     {
        // Cas 1: Si un fils existe -> 1/6 فرضا فقط
        $hal .= "السدس 1/6 فرضا فقط\n";
     } elseif ($this->input->hasFar3WarithOntha()) 
     {
        // Cas 2: Si une fille seulement -> 1/6 + باقي تعصيب
        $hal .= "السدس 1/6 فرضا والباقي تعصيبا بالنفس\n";
     } else 
     {
        //  Cas 3:الجد يأخذ الباقي تعصيبًا
        $hal .= "الباقي تعصيبا بالنفس\n";
     }
    }


public function mirathaljadah_li_ab()
    {
        if (!$this->input["aljadah_li_ab"] || $this->input["alab"]|| $this->input["alom"]) {
            return; 
        }
        if (!$this->input["aljadah_li_om"]) {
                $hal .= "الجدة لأب في السدس 1/6 فرضا\n"; 
            } else {
                $hal .= "ترث السدس 1/12 فرضا\n";
            }   
    }

public function mirathaljadat_li_om()
    {
        if (!$this->input["aljadah_li_om"] || $this->input["alom"]) {
            return; 
        }
         if (!$this->input["aljadah_li_ab"]) {
                $hal .= "الجدة لأم في السدس 1/6 فرضا\n";   
            } else {
                $hal .= "ترث السدس 1/12 فرضا\n";
            }
   }
//el foro3//
public function  mirathalbanat()
    {
     if (!$this->input["albanat"]) {
        return;
     }
     
     if (($this->input["albanat"] ==1) && ($this->input["alabna"] == 0)){
                $hal .= "ترث  1/2 فرضا\n";
                }
     else if  (($this->input["albanat"] > 1) && ($this->input["alabna"] == 0)) {
                $hal .= "ترث  2/3 فرضا\n";
     }     
     else if  (($this->input["albanat"] > 0) && ($this->input["alabna"] > 0)) {
                $hal .= "ترث  1/2 الابناء\n";
     } 
    } 
 

 public function mirathalabna()
{
    if (!$this->input["alabna"]) {return;  }
    
    if ($input["albanat"] == 0) {
        $hal .= "الباقي تعصيبا بالنفس\n";
    } else {
        $hal .= "للذكر مثل حظ الانثيين\n";
        }
}


public function mirathabna_alabna()
{
 if ($this->input["abna_alabna"] == 0 || $this->input["abna"] > 0) {
            return; 
        }
    $nbr_a = $input["alabna_alabna"];
    if ($nbr_a === 0) {return;}
    
    $nbr_b = $input["banat_alabna"];
    if ($nbr_b === 0) {
        $hal .= "الباقي تعصيبا بالنفس\n";
    } else {
        $hal = 2 * $nbr_a + $nbr_b;
        $hal .= "للذكر مثل حظ الانثيين\n";
        }
}

public function  mirathbanat_alabna()
    {
        if ($this->input["banat_alabna"]== 0 || $this->input["abna"] > 0 || $this->input["albnat"] > 1 ) {
            return; 
        }
     
     if (($this->input["banat_alabna"] ==1) && ($this->input["abna_alabna"] == 0)){
                $hal .= "ترث  1/2 فرضا\n";
                }
     if  (($this->input["banat_elabna"] > 1) && ($this->input["abna_alabna"] == 0)) {
                $hal .= "ترث  2/3 فرضا\n";
     }     
     if  (($this->input["banat_albanat"] > 0) && ($this->input["abna_alabna"] > 0)) {
                $hal .= "ترث نصف 1/2 الابناء\n";
     } 
    } 

 // wasiya wajiba//
 public function  mirathabana_albanat()
    {
        if ($this->input["abna_albanat"]== 0 || $this->input["albanat"] > 0  ) {
            return; 
        }
      if($this->input["banat_albanat"]== 0){
                $hal .= "ميراث  الام && 1/3";
                }
                else{
                    $nbr_b = $input["banat_alabna"];
                    $nbr_a = $input["alabna_alabna"];
                    $hal = 2 * $nbr_a + $nbr_b;
                    $hal .= "ترث نصف 1/2 الابناء\n";
                }

    }
public function  mirathbanat_albanat()
    {
        if ($this->input["banat_albanat"]== 0 || $this->input["albanat"] > 0  ) {
            return; 
        }
      if($this->input["abna_albanat"]== 0){
                $hal .= "ميراث  الام && > 1/3";
                }
                else{
                 $hal .= "ترث نصف 1/2 الابناء\n";
                }
    }
// al 7awachi //
public function mirathalikhwa_li_om()
    {
    
        if ($this->input["alikhwa_li_om"] == 0|| $this->input["fara3_warith"]> 0 ||!input['alab']
        || !input['aljad']) {
              return; 
            }
            
                if ($this->input["alakhawat_li_om"] > 0){
                  $hal .= "الإخوة لأم يرثون الثلث 1/3 فرضًا بالتساوي\n";  }
                  else{
                  $hal .= "الإخوة لأم يرثون الثلث 1/6 فرضًا بالتساوي\n";
                  }

    }
            

public function mirathalakhawat_li_om()
    {
        
        if ($this->input["alakhawat_li_om"] == 0|| $this->input["fara3_warith"]> 0 ||!input["alab"]
        || !input["aljad"]){
              return; 
            }
            
                if($this->input['alikhwa_li_om'] > 0){
                  $hal .= "الإخوات  لأم ترثن الثلث 1/3 فرضًا بالتساوي\n";}
                  else{
                  $hal .= "الإخوات لأم ترثن الثلث 1/6 فرضًا بالتساوي\n";
                  }
                
    }

public function mirathalikhwa_alashika()
    {
        $nbr_a = $input["alikhwa_alashika"] > 0;
        $nbr_b = $input["alakhawat_ashakikat"] > 0;
        
        if ($this->input["alikhwa_alashika"] == 0|| $this->input["fara3_warith"]> 0 ||!input["alab"]) {
              return; 
            }
              
                    if ($nbr_b == 0) {
        $hal .= "الباقي تعصيبا بالنفس\n";
     } else {
        $hal = 2 * $nbr_a + $nbr_b;}
    }


public function mirathalakhawat_alashakikat()
    {
        $nbr_a = $input["alikhwa_alashika"] > 0;
        $nbr_b = $input["alakhawat_ashakikat"] > 0;
        
        if (
            $this->input["alakhawat_alashakikat"] == 0
            || $this->input["fara3_warith"]> 0 
            ||!input["alab"]
            ) {
              return; 
            }
            
     if (($this->input["alakhawat_ashakikat"] ==1) && ($this->input["alikhwa_alashika"] == 0)){
                $hal .= "ترث  1/2 فرضا\n";
                }
     if  (($this->input["alakhawat_ashakikat"] > 1) && ($this->input["alikhwa_alashika"] == 0)) {
                $hal .= "ترث  2/3 فرضا\n";
     }     
     if  (($this->input["alakhawat_ashakikat"] > 0) && ($this->input["alikhwa_alashika"] > 0)) {
                $hal .= "ترث  1/2 الاخوة الأشقاء\n";
     } 
 } 
 

public function mirathalikhwa_li_ab()
    {
        $nbr_a = $input["alikhwa_li_ab"] > 0;
        $nbr_b = $input["alakhawat_li_ab"] > 0;
        
        if (
            $this->input["alikhwa_li_ab"] == 0
            || $this->input["fara3_warith"]> 0 
            ||!input["alab"]
            || $this->input["alikhwa_alashika"]> 0
             ) {
              return; 
            }
              
                    if ($nbr_b == 0) {
        $hal .= "الباقي تعصيبا بالنفس\n";
     } else {
        $hal = 2 * $nbr_a + $nbr_b;
     }
}

public function mirathalakhawat_li_ab()
    {
        if (
            $this->input["alakhawat_li_ab"] == 0
            || $this->input["fara3_warith"]> 0 
            ||!$input["alab"]
            || $this->input["alikhwa_alashika"]> 0 
            || $this->input["alakhwat_alashakikat"]> 1 
            ) {
              return; 
            }
            
     if (($this->input["alakhawat_li_ab"] ==1) && ($this->input["alikhwa_li_ab"] == 0)&& !input["aljad"]) {
                $hal .= "ترث  1/2 فرضا\n";
                }
     if  (($this->input["alakhawat_li_ab"] > 1) && ($this->input["alikhwa_li_ab"] == 0) &&!input["aljad"]) {
                $hal .= "ترث  2/3 فرضا\n";
     }     
     if  (($this->input["alakhawat_li_ab"] > 0) && ($this->input["alikhwa_li_ab"] > 0)) {
                $hal .= "ترث  1/2 الاخوة الأشقاء\n";
     } 
   } 
 

 public function mirathabna_alikhwa_alashika()
{
    if (
        $this->input["abna_alikhwa_alashika"] == 0
        || $this->input["fara3_warith"]> 0 
        ||!input["alab"]
        || $this->input["alikhwa_alashika"]> 0 
        || $this->input["alikhwa_li_ab"]> 0 
        ||!input["aljad"]
        ) {
              return; 
            }

    $hal .= "الباقي تعصيبا بالنفس\n";
}

public function mirathabna_alikhwa_li_ab()
{
    if ($this->input["abna_alikhwa_li_ab"] == 0
    || $this->input["fara3_warith"]> 0 
    ||!input["alab"]
    || $this->input["alikhwa_alashika"]> 0 
    || $this->input["alikhwa_li_ab"]> 0 
    ||!input["aljad"]
    || $this->input["abna_alikhwa_alashika"]> 0
    ) {
              return; 
            }

    $hal .= "الباقي تعصيبا بالنفس\n";
}

public function mirathala3mam_alashika()
{
    if ($this->input["ala3mam_alashika"] == 0 
    || $this->input["fara3_warith"]> 0 ||!input["alab"]
    || $this->input["alikhwa_alashika"]> 0 
    || $this->input["alikhwa_li_ab"]> 0 
    ||!input["aljad"]
    || $this->input["abna_alikhwa_alashika"]> 0
    || $this->input["abna_alikhwa_li_ab"]> 0
    ) {
              return; 
            }

    $hal .= "الباقي تعصيبا بالنفس\n";
}

public function mirathala3mam_li_ab()
{
    if ($this->input["ala3mam_li_ab"] == 0
    || $this->input["fara3_warith"]> 0 
    ||!input["alab"]
    || $this->input["alikhwa_alashika"]> 0 
    || $this->input["alikhwa_li_ab"]> 0 
    ||!input["aljad"]
    || $this->input["abna_alikhwa_alashika"]> 0
    || $this->input["abna_alikhwa_li_ab"]> 0
    || $this->input["ala3mam_alashika"]> 0
    ){
              return; 
            }

    $hal .= "الباقي تعصيبا بالنفس\n";
}

public function mirathabna_ala3mam_alashika()
{
    if (
        $this->input["abna_ala3mam_alashika"] == 0
        || $this->input["fara3_warith"]> 0 
        ||!input["alab"]
        || $this->input["alikhwa_alashika"]> 0 
        || $this->input["alikhwa_li_ab"]> 0 
        ||!input["aljad"]
        || $this->input["abna_alikhwa_alashika"]> 0
        || $this->input["abna_alikhwa_li_ab"]> 0
        || $this->input["ala3mam_alashika"]> 0
        || $this->input["ala3mam_li_ab"]> 0){
              return; 
            }
    $hal .= "الباقي تعصيبا بالنفس\n";
}

public function mirathabna_ala3mam_li_ab()
{
    if (
        $this->input["abna_ala3mam_li_ab"] == 0
        || $this->input["fara3_warith"]> 0 
        ||!input["alab"]
        || $this->input["alikhwa_alashika"]> 0 
        || $this->input["alikhwa_li_ab"]> 0 
        ||!input["aljad"]
        || $this->input["abna_alikhwa_alashika"]> 0
        || $this->input["abna_alikhwa_li_ab"]> 0
        || $this->input["ala3mam_alashika"]> 0
        || $this->input["ala3mam_li_ab"]> 0 
        || $this->input["abna_ala3mam_alashika"]> 0
         ){
              return; 
            }
    $hal .= "الباقي تعصيبا بالنفس\n";
}}
}
}