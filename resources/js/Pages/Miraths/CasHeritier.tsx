import { useState, useEffect } from "react";
import { router } from "@inertiajs/react";
import GuestLayout from "@/Layouts/GuestLayout";

export default function CasHeritier() {
    const [selectedCases, setSelectedCases] = useState({
        heirDiedBeforeInheritance: false,
        hasPregnancy: false,
        haswasiya: false,
        hasmafgod: false,
        hasgatel: false,
        hasmotazamen: false,
        haskafer: false,
    });

    useEffect(() => {
        const savedCases = localStorage.getItem("specialCases");
        if (savedCases) {
            setSelectedCases(JSON.parse(savedCases));
        }
    }, []);

    const handleCheckboxChange = (event: React.ChangeEvent<HTMLInputElement>, key: string) => {
        const newSelectedCases = {
            ...selectedCases,
            [key]: event.target.checked,
        };
        setSelectedCases(newSelectedCases);
        localStorage.setItem("specialCases", JSON.stringify(newSelectedCases));
    };

    const handleCalculateInheritance = () => {
        if (selectedCases.heirDiedBeforeInheritance) {
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
            alert("Veuillez sélectionner un cas spécial.");
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
                        <div className="flex items-center space-x-3">
                            <input
                                type="checkbox"
                                className="w-5 h-5 text-blue-600 border-gray-300 rounded"
                                checked={selectedCases.heirDiedBeforeInheritance}
                                onChange={(e) => handleCheckboxChange(e, "heirDiedBeforeInheritance")}
                            />
                            <label className="text-lg text-gray-800">
                                هل توفي أحد الورثة قبل تقسيم التركة (المناسخات)؟
                            </label>
                        </div>
                        
                        <div className="flex items-center space-x-3">
                            <input
                                type="checkbox"
                                className="w-5 h-5 text-blue-600 border-gray-300 rounded"
                                checked={selectedCases.hasPregnancy}
                                onChange={(e) => handleCheckboxChange(e, "hasPregnancy")}
                            />
                            <label className="text-lg text-gray-800">
                                هل يوجد حمل؟
                            </label>
                        </div>

                        <div className="flex items-center space-x-3">
                            <input
                                type="checkbox"
                                className="w-5 h-5 text-blue-600 border-gray-300 rounded"
                                checked={selectedCases.haswasiya}
                                onChange={(e) => handleCheckboxChange(e, "haswasiya")}
                            />
                            <label className="text-lg text-gray-800">
                                هل يوجد أولاد لابن متوفى أو لبنت متوفية (وصية واجبة)؟
                            </label>
                        </div>

                        <div className="flex items-center space-x-3">
                            <input
                                type="checkbox"
                                className="w-5 h-5 text-blue-600 border-gray-300 rounded"
                                checked={selectedCases.hasmafgod}
                                onChange={(e) => handleCheckboxChange(e, "hasmafgod")}
                            />
                            <label className="text-lg text-gray-800">
                                هل يوجد مفقود فيمن اخترتهم؟
                            </label>
                        </div>

                        <div className="flex items-center space-x-3">
                            <input
                                type="checkbox"
                                className="w-5 h-5 text-blue-600 border-gray-300 rounded"
                                checked={selectedCases.hasgatel}
                                onChange={(e) => handleCheckboxChange(e, "hasgatel")}
                            />
                            <label className="text-lg text-gray-800">
                                هل يوجد من هو قاتل؟
                            </label>
                        </div>

                        <div className="flex items-center space-x-3">
                            <input
                                type="checkbox"
                                className="w-5 h-5 text-blue-600 border-gray-300 rounded"
                                checked={selectedCases.haskafer}
                                onChange={(e) => handleCheckboxChange(e, "haskafer")}
                            />
                            <label className="text-lg text-gray-800">
                                هل يوجد من هو على خلاف الدين؟
                            </label>
                        </div>
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
            </div>
        </GuestLayout>
    );
}