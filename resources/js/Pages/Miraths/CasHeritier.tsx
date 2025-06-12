import { useEffect, useState } from "react";
import { router } from "@inertiajs/react";
import GuestLayout from "@/Layouts/GuestLayout";
import type { MirathInput } from "./MirathInput";
import Footer from "@/Components/Footer";

export default function CasHeritier() {
    const [selectedCase, setSelectedCase] = useState<string>("none");

    useEffect(() => {
        const mirathInputRaw = localStorage.getItem("mirathInput");
        if (mirathInputRaw) {
            const mirathInput = JSON.parse(mirathInputRaw) as Partial<MirathInput>;

            const caseKey =
                mirathInput.heirDiedBeforeInheritance ? "heirDiedBeforeInheritance" :
                mirathInput.hasPregnancy ? "hasPregnancy" :
                mirathInput.haswasiya ? "haswasiya" :
                mirathInput.hasmafgod ? "hasmafgod" :
                mirathInput.hasgatel ? "hasgatel" :
                mirathInput.haskafer ? "haskafer" :
                "none";

            setSelectedCase(caseKey);
        }
    }, []);

    const saveToLocalStorage = (key: string): MirathInput => {
        const flags = {
            heirDiedBeforeInheritance: false,
            hasPregnancy: false,
            haswasiya: false,
            hasmafgod: false,
            hasgatel: false,
            haskafer: false,
            noSpecialCases: false,
        };

        if (key !== "none") {
            flags[key as keyof typeof flags] = true;
        } else {
            flags.noSpecialCases = true;
        }

        const mirathInputRaw = localStorage.getItem("mirathInput");
        const mirathInputOld = mirathInputRaw ? JSON.parse(mirathInputRaw) : {};
        const mirathInput = {
            ...mirathInputOld,
            ...flags,
        };

        localStorage.setItem("mirathInput", JSON.stringify(mirathInput));
        return mirathInput;
    };

    const handleChange = (value: string) => {
        setSelectedCase(value);
        const mirathInput = saveToLocalStorage(value);

        if (value === "none") return;

        const routeMap: Record<string, string> = {
            heirDiedBeforeInheritance: "/Monasa5atHeritier",
            hasPregnancy: "/HamelHeritier",
            haswasiya: "/WasiyaHeritier",
            hasmafgod: "/MafgodHeritier",
            hasgatel: "/GatelHeritier",
            haskafer: "/KaferHeritier",
        };

        if (routeMap[value]) {
            router.visit(routeMap[value]);
        }
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        const mirathInput = saveToLocalStorage("none");
        router.post("/cas-heritier", { mirathInput });
    };

    return (
        <GuestLayout>
            <div className="p-1 bg-yellow-100 shadow-md rounded-lg max-w-4xl mx-auto min-h-[600px] py-4">
                <div className="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-lg">
                    <h1 className="text-2xl font-bold text-gray-900 mb-4 text-center">
                        الحالات الخاصة
                    </h1>
                    <fieldset className="space-y-4 border border-gray-200 p-4 rounded-md">
                        <legend className="text-lg font-semibold text-gray-700 mb-2">
                            اختر حالة واحدة فقط
                        </legend>
                        {radioOption("none", "لا توجد حالات خاصة", selectedCase, handleChange)}
                        {radioOption("heirDiedBeforeInheritance", "هل توفي أحد الورثة قبل تقسيم التركة (المناسخات)؟", selectedCase, handleChange)}
                        {radioOption("hasPregnancy", "هل يوجد حمل؟", selectedCase, handleChange)}
                        {radioOption("haswasiya", "هل يوجد أولاد لابن متوفى أو لبنت متوفية (وصية واجبة)؟", selectedCase, handleChange)}
                        {radioOption("hasmafgod", "هل يوجد مفقود فيمن اخترتهم؟", selectedCase, handleChange)}
                        {radioOption("hasgatel", "هل يوجد من هو قاتل؟", selectedCase, handleChange)}
                        {radioOption("haskafer", "هل يوجد من هو على خلاف الدين؟", selectedCase, handleChange)}
                    </fieldset>
                </div>

                {selectedCase === "none" && (
                    <div className="mt-8 flex justify-center">
                        <button
                            onClick={handleSubmit}
                            className="px-6 py-3 text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg shadow-md transition-colors duration-200"
                        >
                            حساب الميراث
                        </button>
                    </div>
                )}

                <Footer />
            </div>
        </GuestLayout>
    );
}

function radioOption(
    value: string,
    label: string,
    selectedValue: string,
    onChange: (value: string) => void
) {
    return (
        <div className="flex items-center space-x-3">
            <input
                type="radio"
                name="specialCase"
                value={value}
                checked={selectedValue === value}
                onChange={() => onChange(value)}
                className="w-5 h-5 text-blue-600 border-gray-300"
            />
            <label className="text-lg text-gray-800">{label}</label>
        </div>
    );
}
