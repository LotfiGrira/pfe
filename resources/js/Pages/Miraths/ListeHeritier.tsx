import { useState, useEffect } from "react";
import GuestLayout from "@/Layouts/GuestLayout";
import { Link } from "@inertiajs/react";

export default function ListeHeritier() {
    const [gender, setGender] = useState<"ذكر" | "أنثى">(() => {
        return localStorage.getItem("deceasedGender") === "أنثى" ? "أنثى" : "ذكر";
    });

    const [heirs, setHeirs] = useState<Record<string, string | number>>(() => {
        // Ne pas charger depuis localStorage au départ
        return {};
    });

    const booleanHeirs = [
        "هل يوجد أب؟", "هل يوجد أم؟",
        "جد (أب الأب)؟", "جدة (أم الأب)؟",
        "جد (أب أب الأب)؟", "جدة (أم أم الأب)؟",
        "جدة (أم الأم)؟", "جدة (أم أم الأم)؟"
    ];

    const numericHeirs = [
        "الابن", "البنت", "الأخ الشقيق",
        "الأخت الشقيقة", "الأخ لأب", "الأخت لأب",
        "الأخ لأم", "الأخت لأم", "ابن الأخ الشقيق",
        "ابن لأخ لأب", "ابن ابن الأخ الشقيق",
        "ابن ابن لأخ لأب", "عم الشقيق", "عم لأب",
        "ابن عم الشقيق", "ابن عم الأب",
        "ابن ابن عم الشقيق", "ابن ابن عم الأب",
        "(شقيق الجد) عم الأب", "(أخ الجد للأب) عم الأب",
        "(الشقيق) ابن عم الأب", "(من الأب) ابن عم الأب"
    ];

    useEffect(() => {
        const spouseLabel = gender === "ذكر" ? "هل يوجد زوجة؟" : "هل يوجد زوج؟";
        const baseHeirs = [spouseLabel, ...booleanHeirs, ...numericHeirs];

        setHeirs(prevHeirs => {
            const newHeirs: Record<string, string | number> = {};
            baseHeirs.forEach(heir => {
                newHeirs[heir] = booleanHeirs.includes(heir) || heir === spouseLabel ? "لا" : "لا";
            });
            return newHeirs;
        });
    }, [gender]);

    const handleHeirChange = (heir: string, value: string | number) => {
        setHeirs(prev => {
            const newHeirs = { ...prev, [heir]: value };
            
            // Sauvegarder seulement les héritiers sélectionnés (différents de "لا")
            const selected = Object.fromEntries(
                Object.entries(newHeirs).filter(([_, val]) => val !== "لا")
            );
            localStorage.setItem("selectedHeirs", JSON.stringify(selected));
            
            return newHeirs;
        });
    };

    return (
        <GuestLayout>
            <div className="p-1 bg-yellow-100 shadow-md rounded-lg max-w-4xl mx-auto min-h-[500px]">
         
                <h1 className="text-2xl font-bold text-center mb-4">قائمة الورثة</h1>

                <div className="text-center mb-6">
                    <span className="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-lg font-semibold">
                        نوع المورث: {gender}
                    </span>
                </div>

                <div className="bg-gray-200 p-4 rounded-lg shadow-md grid grid-cols-2 gap-4">
                    {Object.entries(heirs).map(([heirKey, heirValue], index) => (
                        <div key={index} className="flex justify-between items-center bg-yellow-500 p-3 rounded-md">
                            <label className="text-white font-bold text-lg">{heirKey}</label>
                            {booleanHeirs.includes(heirKey) || heirKey.includes("زوج") ? (
                                <select
                                    value={heirValue as string}
                                    onChange={(e) => handleHeirChange(heirKey, e.target.value)}
                                    className="border-2 px-3 py-1 rounded-lg bg-white text-gray-800"
                                >
                                    <option value="لا">لا</option>
                                    <option value="نعم">نعم</option>
                                </select>
                            ) : (
                                <select
                                    value={heirValue as string}
                                    onChange={(e) => handleHeirChange(heirKey, e.target.value)}
                                    className="border-2 px-3 py-1 rounded-lg bg-white text-gray-800"
                                >
                                    <option value="لا">لا</option>
                                    {[...Array(50).keys()].map(i => (
                                        <option key={i + 1} value={i + 1}>{i + 1}</option>
                                    ))}
                                </select>
                            )}
                        </div>
                    ))}
                </div>

                <div className="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                    <Link
                        href="/cas-heritier"
                        className="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition-colors duration-200 text-center">
                        الحالات الخاصة
                    </Link>
                </div>
            </div>
        </GuestLayout>
    );
}
