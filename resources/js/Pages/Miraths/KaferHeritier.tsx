import { useEffect, useState } from "react";
import GuestLayout from "@/Layouts/GuestLayout";
import type { MirathInput } from "./MirathInput";
import { router } from "@inertiajs/react";

export default function KaferHeritier() {
    const [mirathInput, setMirathInput] = useState<MirathInput | null>(null);
    const [formValues, setFormValues] = useState<Partial<MirathInput>>({});

    const heirLabels: Partial<Record<keyof MirathInput, string>> = {
        zawj: "الزوج",
        zawja: "الزوجة",
        alab: "الأب",
        alom: "الأم",
        aljad: "الجد (أب الأب)",
        aljadah_li_ab: "الجدة (أم الأب)",
        aljadah_li_om: "الجدة (أم الأم)",
        alabna: "الابن",
        albanat: "البنت",
        abna_alabna: "ابن الابن",
        banat_alabna: "بنت الابن",
        alikhwa_alashika: "الأخ الشقيق",
        alikhwa_li_ab: "الأخ لأب",
        alikhwa_li_om: "الأخ لأم",
        alakhawat_ashakikat: "الأخت الشقيقة",
        alakhawat_li_ab: "الأخت لأب",
        alakhawat_li_om: "الأخت لأم",
        abna_alikhwa_alashika: "ابن الأخ الشقيق",
        abna_alikhwa_li_ab: "ابن الأخ لأب",
        ala3mam_alashika: "العم الشقيق",
        ala3mam_li_ab: "العم لأب",
        abna_ala3mam_alashika: "ابن العم الشقيق",
        abna_ala3mam_li_ab: "ابن العم لأب",
    };

    useEffect(() => {
        const stored = localStorage.getItem("mirathInput");
        if (stored) {
            setMirathInput(JSON.parse(stored));
        }
    }, []);

    if (!mirathInput) {
        return (
            <GuestLayout>
                <div className="text-center p-6 text-red-600 font-bold">
                    لا توجد بيانات ورثة محفوظة.
                </div>
            </GuestLayout>
        );
    }

    const filteredFields = Object.entries(mirathInput).filter(([key, value]) => {
        if (
            [
                "gender", "tarika", "doyon", "wasiya", "hasPregnancy", "hasgatel",
                "haskafer", "hasmafgod", "haswasiya", "heirDiedBeforeInheritance",
                "noSpecialCases", "azawjat", "aljad_ma3a_alikhwa"
            ].includes(key)
        ) return false;

        return (typeof value === "boolean" && value) || (typeof value === "number" && value !== 0);
    }) as [keyof MirathInput, number | boolean][];

    const handleChange = (key: keyof MirathInput, value: number | boolean) => {
        setFormValues(prev => ({
            ...prev,
            [key]: value,
        }));
    };

    const handleNext = () => {
        if (!mirathInput) return;
        const kafer : Record<string, number> = {};
        for (const [key, value] of Object.entries(formValues)) {
            const originalValue = mirathInput[key as keyof MirathInput];

            if (typeof originalValue === "number") {
                const numericValue = typeof value === "number" ? value : Number(value);
                if (!isNaN(numericValue)) {
                    mirathInput[key as keyof MirathInput] = originalValue - numericValue;
                    kafer[key] = value;
                }
            } else if (typeof originalValue === "boolean") {
                if (value) {
                    mirathInput[key as keyof MirathInput] = false;
                    kafer[key] = 1;
                }
            }
        }
        mirathInput["kafer"] = kafer;
        localStorage.setItem("mirathInput", JSON.stringify(mirathInput));
        router.visit("/cas-heritier");
    };
        const handleSubmit = () => {
        if (!mirathInput) return;
        const kafer : Record<string, number> = {};
        for (const [key, value] of Object.entries(formValues)) {
            const originalValue = mirathInput[key as keyof MirathInput];

            if (typeof originalValue === "number") {
                const numericValue = typeof value === "number" ? value : Number(value);
                if (!isNaN(numericValue)) {
                    mirathInput[key as keyof MirathInput] = originalValue - numericValue;
                    kafer[key] = value;
                }
            } else if (typeof originalValue === "boolean") {
                if (value) {
                    mirathInput[key as keyof MirathInput] = false;
                    kafer[key] = 1;
                }
            }
        }
        mirathInput["kafer"] = kafer;
        localStorage.setItem("mirathInput", JSON.stringify(mirathInput));
        const to_back = JSON.parse(localStorage.getItem("mirathInput") || "{}");
        console.log(mirathInput)
        router.post('/cas-heritier', { mirathInput : to_back }, {
            onError: (err: any) => alert(err),
        });
    };


    return (
        <GuestLayout>
            <div className="p-6 max-w-3xl mx-auto bg-white shadow rounded-lg min-h-[300px]">
                <h1 className="text-2xl font-bold mb-4 text-center">هل يوجد وريث كافر؟</h1>

                {filteredFields.length === 0 ? (
                    <div className="text-center text-gray-600 mt-8 text-xl font-semibold">
                        لا يوجد ورثة مختارون.
                    </div>
                ) : (
                    <form onSubmit={(e) => e.preventDefault()}>
                        <ul className="space-y-4">
                            {filteredFields.map(([key, value]) => {
                                const label = heirLabels[key] || key;

                                return (
                                    <li key={key} className="bg-yellow-100 p-4 rounded shadow text-lg">
                                        <div className="font-semibold">{label}</div>

                                        {typeof value === "boolean" ? (
                                            <div className="flex items-center gap-4 mt-2">
                                                <label className="flex items-center gap-2">
                                                    <input
                                                        type="radio"
                                                        name={key}
                                                        value="true"
                                                        checked={formValues[key] === true}
                                                        onChange={() => handleChange(key, true)}
                                                    />
                                                    نعم
                                                </label>
                                                <label className="flex items-center gap-2">
                                                    <input
                                                        type="radio"
                                                        name={key}
                                                        value="false"
                                                        checked={formValues[key] === false}
                                                        onChange={() => handleChange(key, false)}
                                                    />
                                                    لا
                                                </label>
                                            </div>
                                        ) : (
                                            <input
                                                type="number"
                                                className="mt-2 p-2 border rounded w-full"
                                                value={formValues[key] ?? 0}
                                                onChange={(e) => handleChange(key, Number(e.target.value))}
                                                min={0}
                                                max={value}
                                            />
                                        )}
                                    </li>
                                );
                            })}
                        </ul>

                        <div className="mt-6 text-center">
                            <button
                                type="button"
                                onClick={handleSubmit}
                                className="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                            >
                                حساب الميراث
                            </button>
                            <button
                                type="button"
                                onClick={handleNext}
                                className="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                            >
                                الحالات الخاصة
                            </button>
                        </div>
                    </form>
                )}
            </div>
        </GuestLayout>
    );
}
