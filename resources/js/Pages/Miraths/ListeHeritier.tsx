import { useState, useEffect } from "react";
import GuestLayout from "@/Layouts/GuestLayout";
import { Link } from "@inertiajs/react";
import type { MirathInput } from "./MirathInput";

export default function ListeHeritier() {
    const heirFields: {
        label: string;
        key: keyof MirathInput;
        type: "boolean" | "number";
    }[] = [
        { label: "هل يوجد زوج؟", key: "zawj", type: "boolean" },
        { label: "هل يوجد زوجة؟", key: "zawja", type: "boolean" },
        { label: "هل يوجد أب؟", key: "alab", type: "boolean" },
        { label: "هل يوجد أم؟", key: "alom", type: "boolean" },
        { label: "جد (أب الأب)؟", key: "aljad", type: "boolean" },
        { label: "جدة (أم الأب)؟", key: "aljadah_li_ab", type: "boolean" },
        { label: "جدة (أم الأم)؟", key: "aljadah_li_om", type: "boolean" },
        { label: "الابن", key: "alabna", type: "number" },
        { label: "البنت", key: "albanat", type: "number" },
        { label: "ابن الابن", key: "abna_alabna", type: "number" },
        { label: "بنت الابن", key: "banat_alabna", type: "number" },
        { label: "الأخ الشقيق", key: "alikhwa_alashika", type: "number" },
        { label: "الأخ لأب", key: "alikhwa_li_ab", type: "number" },
        { label: "الأخ لأم", key: "alikhwa_li_om", type: "number" },
        { label: "الأخت الشقيقة", key: "alakhawat_ashakikat", type: "number" },
        { label: "الأخت لأب", key: "alakhawat_li_ab", type: "number" },
        { label: "الأخت لأم", key: "alakhawat_li_om", type: "number" },
        {
            label: "ابن الأخ الشقيق",
            key: "abna_alikhwa_alashika",
            type: "number",
        },
        { label: "ابن الأخ لأب", key: "abna_alikhwa_li_ab", type: "number" },
        { label: "العم الشقيق", key: "ala3mam_alashika", type: "number" },
        { label: "العم لأب", key: "ala3mam_li_ab", type: "number" },
        {
            label: "ابن العم الشقيق",
            key: "abna_ala3mam_alashika",
            type: "number",
        },
        { label: "ابن العم لأب", key: "abna_ala3mam_li_ab", type: "number" },
    ];

    const [mirathInput, setMirathInput] = useState<MirathInput>(() => {
        const stored = localStorage.getItem("mirathInput");
        const parsed = (
            stored ? JSON.parse(stored) : {}
        ) as Partial<MirathInput>;

        return {
            ...parsed,
            ...(Object.fromEntries(
                heirFields.map(({ key, type }) => [
                    key,
                    parsed[key as keyof MirathInput] ??
                        (type === "boolean" ? false : 0),
                ])
            ) as unknown as MirathInput),
        };
    });

    const handleNext = () => {
        localStorage.setItem("mirathInput", JSON.stringify(mirathInput));
    };

    return (
        <GuestLayout>
            <div className="p-1 bg-yellow-100 shadow-md rounded-lg max-w-4xl mx-auto min-h-[500px]">
                <h1 className="text-2xl font-bold text-center mb-4">
                    قائمة الورثة
                </h1>

                <div className="text-center mb-6">
                    <span className="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-lg font-semibold">
                        نوع المورث: {mirathInput["gender"] || "غير محدد"}
                    </span>
                </div>

                <div className="bg-gray-200 p-4 rounded-lg shadow-md grid grid-cols-2 gap-4">
                    {heirFields
                        .filter(({ key }) => {
                            if (
                                mirathInput["gender"] === "ذكر" &&
                                key === "zawj"
                            )
                                return false;
                            if (
                                mirathInput["gender"] === "أنثى" &&
                                key === "zawja"
                            )
                                return false;
                            return true;
                        })
                        .map(({ label, key, type }, index) => (
                            <div
                                key={index}
                                className="flex justify-between items-center bg-yellow-500 p-3 rounded-md"
                            >
                                <label className="text-white font-bold text-lg">
                                    {label}
                                </label>
                                {type === "boolean" ? (
                                    <select
                                        value={mirathInput[key] ? "نعم" : "لا"}
                                        onChange={(e) =>
                                            setMirathInput((prev) => ({
                                                ...prev,
                                                [key]: e.target.value === "نعم",
                                            }))
                                        }
                                        className="border-2 px-3 py-1 rounded-lg bg-white text-gray-800"
                                    >
                                        <option value="لا">لا</option>
                                        <option value="نعم">نعم</option>
                                    </select>
                                ) : (
                                    <input
                                        className="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"
                                        type="number"
                                        onChange={(e) => {
                                            console.log({
                                                v: parseInt(e.target.value),
                                                key
                                            });
                                            setMirathInput((prev) => ({
                                                ...prev,
                                                [key]: parseInt(e.target.value),
                                            }));
                                        }}
                                    />
                                )}
                            </div>
                        ))}
                </div>

                <div className="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                    <Link
                        href="/cas-heritier"
                        className="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition-colors duration-200 text-center"
                    >
                        الحالات الخاصة
                    </Link>

                    <button
                        onClick={handleNext}
                        className="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-md transition-colors duration-200"
                    >
                        التالي
                    </button>
                </div>
            </div>
        </GuestLayout>
    );
}
