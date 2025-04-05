import { useState } from "react";
import { router } from "@inertiajs/react";
import GuestLayout from "@/Layouts/GuestLayout";

export default function CasHeritier() {
    // État pour stocker quelles cases sont cochées
    const [selectedCases, setSelectedCases] = useState({
        heirDiedBeforeInheritance: false, // هل توفي أحد الورثة قبل تقسيم التركة؟
        hasPregnancy: false, // هل يوجد حمل؟
        hasmafgod: false,
        hasgatel: false,
        hasmotazamen: false,
        haskafer: false,
    });

    // Gérer le changement d'état des cases à cocher
    const handleCheckboxChange = (event: React.ChangeEvent<HTMLInputElement>, key: string) => {
        setSelectedCases(prevState => ({
            ...prevState,
            [key]: event.target.checked,
        }));
    };

    // Gérer le clic sur "حساب الميراث"
    const handleCalculateInheritance = () => {
        if (selectedCases.heirDiedBeforeInheritance) {
            router.visit("/Monasa5atHeritier");
        } else if (selectedCases.hasPregnancy) {
            router.visit("/HamelHeritier");
        }else if (selectedCases.hasmafgod) {
            router.visit("/MafgodHeritier");
        }else if (selectedCases.hasgatel) {
            router.visit("/GatelHeritier");
        }else if (selectedCases.haskafer) {
            router.visit("/KaferHeritier");
        }else {
            alert("Veuillez sélectionner un cas spécial.");
        }
    };

    return (
        <GuestLayout>
<div className="p-1 bg-yellow-100 shadow-md rounded-lg max-w-4xl mx-auto min-h-[600px] py-4">
                

                <div className="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                    <button
                        onClick={handleCalculateInheritance}
                        className="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-md transition-colors duration-200"
                    >
                        حل المسالة
                    </button>
                </div>        
            </div>
        </GuestLayout>
    );
}
