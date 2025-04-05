import { useEffect, useState } from "react";
import GuestLayout from "@/Layouts/GuestLayout";
import { Link, router } from "@inertiajs/react";

export default function Monasa5atHeritier() {
    const [selectedHeirs, setSelectedHeirs] = useState<{name: string, value: string | number}[]>([]);
    const [deceasedHeir, setDeceasedHeir] = useState<string>("");

    useEffect(() => {
        // Récupérer les héritiers sélectionnés
        const savedHeirs = localStorage.getItem("selectedHeirs");
        const savedDeceased = localStorage.getItem("deceasedHeir");
        
        if (savedHeirs) {
            const heirs = JSON.parse(savedHeirs);
            const heirsArray = Object.entries(heirs).map(([name, value]) => ({ 
                name, 
                value
            }));
            setSelectedHeirs(heirsArray);
        }

        if (savedDeceased) {
            setDeceasedHeir(savedDeceased);
        }
    }, []);

    const handleDeceasedChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        const selected = e.target.value;
        
        // Mettre à jour le statut de l'héritier sélectionné
        setSelectedHeirs(prevHeirs => {
            return prevHeirs.map(heir => {
                if (heir.name === selected) {
                    // Changer "نعم" à "متوفي" pour les héritiers booléens
                    const newValue = heir.value === "نعم" ? "متوفي" : heir.value;
                    return { ...heir, value: newValue };
                }
                return heir;
            });
        });

        setDeceasedHeir(selected);
        localStorage.setItem("deceasedHeir", selected);
    };

    const handleSubmit = () => {
        if (!deceasedHeir) {
            alert("يجب اختيار الوريث المتوفى قبل المتابعة");
            return;
        }
        
        // Préparer les données pour la sauvegarde
        const heirsData = selectedHeirs.reduce((acc, heir) => {
            acc[heir.name] = heir.value;
            return acc;
        }, {} as Record<string, string | number>);

        // Sauvegarder les données finales avant la redistribution
        localStorage.setItem("inheritanceData", JSON.stringify({
            heirs: heirsData,
            deceased: deceasedHeir
        }));
        
        router.visit("/tagsim-heritier");
    };

    return (
        <GuestLayout>
            <div className="min-h-screen flex flex-col items-center justify-center bg-yellow-200 p-4">
                <div className="bg-yellow-100 shadow-md rounded-lg p-6 w-full max-w-2xl">
                    <h2 className="text-center text-2xl font-bold mb-6">الورثة المختارون (المناسخات)</h2>
                    
                    <div className="mb-6 bg-white p-4 rounded-lg shadow-sm">
                        <label className="block text-lg font-semibold mb-2">
                            اختر الوريث المتوفى قبل تقسيم التركة:
                        </label>
                        <select
                            value={deceasedHeir}
                            onChange={handleDeceasedChange}
                            className="w-full p-2 border rounded-lg"
                            required
                        >
                            <option value="">-- اختر وريثا --</option>
                            {selectedHeirs.map((heir, index) => (
                                <option key={index} value={heir.name}>
                                    {heir.name.replace("؟", "")} - 
                                    {typeof heir.value === "number" 
                                        ? ` (${heir.value})` 
                                        : ` (${heir.value === "نعم" || heir.value === "متوفي" ? heir.value : "غير موجود"})`}
                                </option>
                            ))}
                        </select>
                    </div>

                    <div className="mb-6">
                        <h3 className="text-xl font-semibold mb-3">الورثة الحاليون:</h3>
                        {selectedHeirs.length > 0 ? (
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-3">
                                {selectedHeirs.map((heir, index) => (
                                    <div 
                                        key={index} 
                                        className={`bg-white p-3 rounded-lg shadow-sm border-l-4 ${
                                            deceasedHeir === heir.name ? "border-red-500" : "border-blue-500"
                                        }`}
                                    >
                                        <div className="font-semibold text-lg">
                                            {heir.name.replace("؟", "")}
                                            {deceasedHeir === heir.name && (
                                                <span className="ml-2 text-red-600">(متوفى)</span>
                                            )}
                                        </div>
                                        <div className="text-gray-600 mt-1">
                                            {typeof heir.value === "number" 
                                                ? `العدد: ${heir.value}`
                                                : `الحالة: ${heir.value === "نعم" ? "موجود" : heir.value === "متوفي" ? "متوفي" : "غير موجود"}`}
                                        </div>
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
                        
                          <Link
                            href="/liste-monasa5at"
                            className="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow-md transition-colors duration-200 text-center">
                         من هم اقارب المتوفى                   
                         </Link>
                    </div>
                </div>
            </div>
        </GuestLayout>
    );
}