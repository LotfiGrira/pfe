import { useEffect, useState } from "react";
import GuestLayout from "@/Layouts/GuestLayout";
import { Link, router } from "@inertiajs/react";

export default function MafgodHeritier() {
    const [selectedHeirs, setSelectedHeirs] = useState<{ name: string, value: string | number }[]>([]);
    const [selectedHeir, setSelectedHeir] = useState<string>("");

    useEffect(() => {
        // Récupérer les héritiers sélectionnés depuis localStorage
        const savedHeirs = localStorage.getItem("selectedHeirs");
        
        if (savedHeirs) {
            const heirs = JSON.parse(savedHeirs);
            const heirsArray = Object.entries(heirs)
                .filter(([_, value]) => value !== "لا")
                .map(([name, value]) => ({
                    name,
                    value
                }));
            setSelectedHeirs(heirsArray);
        }
    }, []);

    const handleHeirSelection = (heirName: string) => {
        setSelectedHeir(heirName);
    };

    const handleSubmit = () => {
        if (!selectedHeir) {
            alert("يجب اختيار وريث مفقود");
            return;
        }

        // Sauvegarder la sélection
        localStorage.setItem("missingHeir", selectedHeir);
        router.visit("/tagsim-heritier");
    };

    return (
        <GuestLayout>
            <div className="min-h-screen flex flex-col items-center justify-center bg-yellow-200 p-4">
                <div className="bg-yellow-100 shadow-md rounded-lg p-6 w-full max-w-2xl">
                    <h2 className="text-center text-2xl font-bold mb-6">اختر الورثة المفقودين</h2>
                    
                    <div className="mb-6">
                        {selectedHeirs.length > 0 ? (
                            <div className="space-y-3">
                                {selectedHeirs.map((heir, index) => (
                                    <div 
                                        key={index} 
                                        className={`bg-white p-3 rounded-lg shadow-sm border-l-4 ${
                                            selectedHeir === heir.name ? "border-red-500" : "border-blue-500"
                                        }`}
                                    >
                                        <label className="flex items-center space-x-3 cursor-pointer">
                                            <input
                                                type="radio"
                                                name="missingHeir"
                                                value={heir.name}
                                                checked={selectedHeir === heir.name}
                                                onChange={() => handleHeirSelection(heir.name)}
                                                className="w-5 h-5 text-blue-600"
                                            />
                                            <div className="flex-1">
                                                <div className="font-semibold text-lg">
                                                    {heir.name.replace("؟", "")}
                                                </div>
                                                <div className="text-gray-600 mt-1">
                                                    {typeof heir.value === "number" 
                                                        ? `العدد: ${heir.value}`
                                                        : `الحالة: ${heir.value === "نعم" ? "موجود" : "غير موجود"}`}
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <div className="text-center py-4 bg-white rounded-lg">
                                <p className="text-gray-600">لا يوجد ورثة مختارون</p>
                            </div>
                        )}
                    </div>

                    <div className="mt-6 flex flex-col sm:flex-row justify-center gap-4">
                        <button
                            onClick={handleSubmit}
                            className="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-md transition-colors duration-200"
                        >
                            تأكيد الاختيار
                        </button>
                        <Link
                            href="/cas-heritier"
                            className="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow-md transition-colors duration-200 text-center">
                            العودة
                        </Link>
                    </div>
                </div>
            </div>
        </GuestLayout>
    );
}