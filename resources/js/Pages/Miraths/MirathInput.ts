// types/MirathInput.ts
export interface MirathInput {
    // lmotawafi

    gender: "ذكر" | "أنثى";
    tarika: number;
    doyon: number;
    wasiya: number;

    // lwaratha
    zawj?: boolean;
    zawja?: boolean;
    azawjat?: number;
    aljad_ma3a_alikhwa?: "LA" | "MA3A_FARDH" | string;

    alab?: number;
    alom?: number;
    aljad?: number;
    aljadah_li_ab?: number;
    aljadah_li_om?: number;

    alabna?: number;
    albanat?: number;
    abna_alabna?: number;
    banat_alabna?: number;

    alikhwa_alashika?: number;
    alikhwa_li_ab?: number;
    alikhwa_li_om?: number;
    alakhawat_ashakikat?: number;
    alakhawat_li_ab?: number;
    alakhawat_li_om?: number;

    // Page 5: Nephews/Nieces and Others
    abna_alikhwa_alashika?: number;
    abna_alikhwa_li_ab?: number;
    ala3mam_alashika?: number;
    ala3mam_li_ab?: number;
    abna_ala3mam_alashika?: number;
    abna_ala3mam_li_ab?: number;

    // Derived/computed flags (can be calculated server-side if needed)
    far3warith?: boolean;

    // === Cas particuliers ===

    heirDiedBeforeInheritance?: boolean; // توفي أحد الورثة قبل التركة (المناسخات)
    hasPregnancy?: boolean; // يوجد حمل
    haswasiya?: boolean; // وصية واجبة
    hasmafgod?: boolean; // مفقود
    hasgatel?: boolean; // قاتل
    haskafer?: boolean; // كافر
    noSpecialCases?: boolean; // لا توجد حالات خاصة
}
