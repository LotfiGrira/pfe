import { useEffect, useState } from "react";
import GuestLayout from "@/Layouts/GuestLayout";
import { router } from "@inertiajs/react";
import type { MirathInput } from "./MirathInput";

export default function ParenteSelection() {
    const [selectedOption, setSelectedOption] = useState("");
    const [mirathInput, setMirathInput] = useState<MirathInput | null>(null);

    const relations: string[] = [
        "ابن أو بنت",
        "ابن ابن أو بنت ابن",
        "ابن ابن ابن أو بنت ابن ابن",
        "أخ لأب أو أخ شقيق",
        "ابن أخ شقيق",
        "ابن أخ لأب",
        "ابن ابن أخ شقيق",
        "ابن ابن أخ لأب",
        "عم شقيق",
        "عم لأب",
        "ابن عم شقيق",
        "ابن عم لأب",
        "ابن ابن عم شقيق",
        "ابن ابن عم لأب",
        "عم الأب (شقيق الأب)",
        "عم الأب لأب (أخ الأب للأب)",
        "ابن عم الأب (الشقيق)",
        "ابن عم الأب (من الأب)",
    ];

    useEffect(() => {
        const stored = localStorage.getItem("mirathInput");
        if (stored) {
            setMirathInput(JSON.parse(stored));
        }
    }, []);

    const handleSubmit = () => {
        if (!selectedOption) {
            alert("يجب اختيار قرابة");
            return;
        }

        if (!mirathInput) {
            alert("لا توجد بيانات ورثة محفوظة.");
            return;
        }

        const updated = { ...mirathInput };
        updated["relation_hamel"] = selectedOption;

        localStorage.setItem("mirathInput", JSON.stringify(updated));
        router.visit("/tagsim-heritier");
    };

    return (
        <GuestLayout>
            <div className="min-h-screen flex items-center justify-center bg-yellow-200 p-4">
                <div className="bg-yellow-100 shadow-md rounded-lg p-6 max-w-md w-full">
                    <h2 className="text-center text-lg font-bold mb-4">
                        ما قرابة الجنين للمتوفى؟
                    </h2>
                    <div className="space-y-2">
                        {relations.map((relation, index) => (
                            <label
                                key={index}
                                className="flex items-center space-x-2"
                            >
                                <input
                                    type="radio"
                                    name="relation"
                                    value={relation}
                                    checked={selectedOption === relation}
                                    onChange={(e) =>
                                        setSelectedOption(e.target.value)
                                    }
                                    className="w-4 h-4 text-blue-600 border-gray-300"
                                />
                                <span className="text-gray-900">
                                    {relation}
                                </span>
                            </label>
                        ))}
                    </div>

                    <div className="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                        <button
                            onClick={handleSubmit}
                            className="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition-colors duration-200 text-center"
                        >
                            تقسيم الميراث
                        </button>
                    </div>
                </div>
            </div>
        </GuestLayout>
    );
}
