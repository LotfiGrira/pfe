import { useState, useEffect } from "react";
import { router } from "@inertiajs/react";
import GuestLayout from "@/Layouts/GuestLayout";
import type { MirathInput } from "./MirathInput";
import Footer from "@/Components/Footer";

export default function CasHeritier() {
    const [selectedCases, setSelectedCases] = useState({
        heirDiedBeforeInheritance: false,
        hasPregnancy: false,
        haswasiya: false,
        hasmafgod: false,
        hasgatel: false,
        haskafer: false,
        noSpecialCases: false,
    });

    useEffect(() => {
        const mirathInputRaw = localStorage.getItem("mirathInput");
        let mirathInput = {} as Partial<MirathInput>;
        if (mirathInputRaw) {
            mirathInput = JSON.parse(mirathInputRaw) as Partial<MirathInput>;

            setSelectedCases({
                heirDiedBeforeInheritance: mirathInput.heirDiedBeforeInheritance || false,
                hasPregnancy: mirathInput.hasPregnancy || false,
                haswasiya: mirathInput.haswasiya || false,
                hasmafgod: mirathInput.hasmafgod || false,
                hasgatel: mirathInput.hasgatel || false,
                haskafer: mirathInput.haskafer || false,
                noSpecialCases: mirathInput.noSpecialCases || false,
            });
        }
    }, []);

    const handleCheckboxChange = (e: React.ChangeEvent<HTMLInputElement>, key: keyof typeof selectedCases) => {
        const isChecked = e.target.checked;

        let updatedCases = {
            ...selectedCases,
            [key]: isChecked,
        };

        // Si "noSpecialCases" est coché, décocher les autres
        if (key === "noSpecialCases" && isChecked) {
            updatedCases = {
                heirDiedBeforeInheritance: false,
                hasPregnancy: false,
                haswasiya: false,
                hasmafgod: false,
                hasgatel: false,
                haskafer: false,
                noSpecialCases: true,
            };

            const oldInput = localStorage.getItem("mirathInput");
            const parsedInput = oldInput ? JSON.parse(oldInput) : {};
            const mergedInput: MirathInput = {
                ...parsedInput,
                ...updatedCases,
            };
            localStorage.setItem("mirathInput", JSON.stringify(mergedInput));

            router.post('/cas-heritier', { mirathInput: mergedInput }, {
                onError: (err: any) => alert(err),
            });

            return; // Stop execution to avoid setting state after redirect
        }

        // Si on coche un autre champ, on décoche "noSpecialCases"
        if (key !== "noSpecialCases" && isChecked) {
            updatedCases.noSpecialCases = false;
        }

        setSelectedCases(updatedCases);

        // Fusionner avec mirathInput existant et sauvegarder
        const oldInput = localStorage.getItem("mirathInput");
        const parsedInput = oldInput ? JSON.parse(oldInput) : {};
        const mergedInput: MirathInput = {
            ...parsedInput,
            ...updatedCases,
        };

        localStorage.setItem("mirathInput", JSON.stringify(mergedInput));
    };

    const handleCalculateInheritance = (e: any) => {
        if (selectedCases.noSpecialCases) {
            e.preventDefault();
            const mirathInput = JSON.parse(localStorage.getItem("mirathInput") || "{}");
            router.post('/cas-heritier', { mirathInput }, {
                onError: (err: any) => alert(err),
            });
        } else if (selectedCases.heirDiedBeforeInheritance) {
            router.visit("/Monasa5atHeritier");
        } else if (selectedCases.hasPregnancy) {
            router.visit("/HamelHeritier");
        } else if (selectedCases.haswasiya) {
            router.visit("/WasiyaHeritier");
        } else if (selectedCases.hasmafgod) {
            router.visit("/MafgodHeritier");
        } else if (selectedCases.hasgatel) {
            router.visit("/GatelHeritier");
        } else if (selectedCases.haskafer) {
            router.visit("/KaferHeritier");
        } else {
            alert("يرجى اختيار حالة خاصة.");
        }
    };

    return (
        <GuestLayout>
            <div className="p-1 bg-yellow-100 shadow-md rounded-lg max-w-4xl mx-auto min-h-[600px] py-4">
                <div className="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-lg">
                    <h1 className="text-2xl font-bold text-gray-900 mb-4 text-center">
                        الحالات الخاصة
                    </h1>
                    <div className="space-y-4">
                        <Checkbox
                            label="لا توجد حالات خاصة"
                            checked={selectedCases.noSpecialCases}
                            onChange={(e) => handleCheckboxChange(e, "noSpecialCases")}
                        />
                        <Checkbox
                            label="هل توفي أحد الورثة قبل تقسيم التركة (المناسخات)؟"
                            checked={selectedCases.heirDiedBeforeInheritance}
                            onChange={(e) => handleCheckboxChange(e, "heirDiedBeforeInheritance")}
                        />
                        <Checkbox
                            label="هل يوجد حمل؟"
                            checked={selectedCases.hasPregnancy}
                            onChange={(e) => handleCheckboxChange(e, "hasPregnancy")}
                        />
                        <Checkbox
                            label="هل يوجد أولاد لابن متوفى أو لبنت متوفية (وصية واجبة)؟"
                            checked={selectedCases.haswasiya}
                            onChange={(e) => handleCheckboxChange(e, "haswasiya")}
                        />
                        <Checkbox
                            label="هل يوجد مفقود فيمن اخترتهم؟"
                            checked={selectedCases.hasmafgod}
                            onChange={(e) => handleCheckboxChange(e, "hasmafgod")}
                        />
                        <Checkbox
                            label="هل يوجد من هو قاتل؟"
                            checked={selectedCases.hasgatel}
                            onChange={(e) => handleCheckboxChange(e, "hasgatel")}
                        />
                        <Checkbox
                            label="هل يوجد من هو على خلاف الدين؟"
                            checked={selectedCases.haskafer}
                            onChange={(e) => handleCheckboxChange(e, "haskafer")}
                        />
                    </div>
                </div>

                <div className="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                    <button
                        onClick={handleCalculateInheritance}
                        className="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-md transition-colors duration-200"
                    >
                        حساب الميراث
                    </button>
                </div>
                {/* Footer */}
                                      <Footer />
            </div>
        </GuestLayout>
    );
}

function Checkbox({
    label,
    checked,
    onChange,
}: {
    label: string;
    checked: boolean;
    onChange: (e: React.ChangeEvent<HTMLInputElement>) => void;
}) {
    return (
        <div className="flex items-center space-x-3">
            <input
                type="checkbox"
                className="w-5 h-5 text-blue-600 border-gray-300 rounded"
                checked={checked}
                onChange={onChange}
            />
            <label className="text-lg text-gray-800">{label}</label>
        </div>
    );
}
