import { useState } from "react";
import GuestLayout from "@/Layouts/GuestLayout";

const options = [
    0,
    ...Array.from({ length: 20 }, (_, i) => (i + 1).toString()),
];

const categories = [
    {
        title: "(ب)أولاد الابن المتوفى",
        fields: [
            "ابنه (ابن ابن)",
            "بنته (بنت ابن)",
            "بنات ابنه أشقاء أيضاً (ابن ابن ابن)",
            "بنات ابنه أشقاء أيضاً (بنت ابن ابن)",
        ],
    },
    {
        title: "(ب)أولاد البنت المتوفية",
        fields: ["ابنها (ابن بنت)", "بنتها (بنت بنت)"],
    },
    {
        title: "أولاد الابن  المتوفى (أ)",
        fields: [
            "ابنه (ابن ابن)",
            "بنته (بنت ابن)",
            "بنات ابنه أشقاء أيضاً (ابن ابن ابن)",
            "بنات ابنه أشقاء أيضاً (بنت ابن ابن)",
        ],
    },
    {
        title: "(أ)أولاد البنت  المتوفية ",
        fields: ["ابنها (ابن بنت)", "بنتها (بنت بنت)"],
    },
];

export default function SelectionForm() {
    const [selections, setSelections] = useState<Record<string, string>>({});

    const handleChange = (field: string, value: string) => {
        setSelections((prev) => ({ ...prev, [field]: value }));
    };

    const handleSubmit = () => {
        // TODO: Ajoute ici la logique pour le calcul du mirath
        console.log("Calcul du mirath avec:", selections);
    };

    const handleNext = () => {
        // TODO: Ajoute ici la redirection ou logique des cas particuliers
        console.log("Navigation vers les cas spéciaux");
    };

    return (
        <GuestLayout>
            <div className="flex flex-col items-center bg-yellow-100 min-h-screen p-6 text-right">
                <h3 className="text-lg font-bold mb-6">
                    اختر أولاد الابن المتوفى أو البنت المتوفية:
                </h3>

                <div className="flex flex-wrap justify-center gap-6">
                    {categories.map((category, index) => (
                        <div
                            key={index}
                            className="bg-yellow-200 text-black p-4 rounded-lg w-64 shadow"
                        >
                            <h4 className="font-bold mb-2">{category.title}</h4>
                            {category.fields.map((field, idx) => (
                                <div key={idx} className="mb-2">
                                    <label className="block">{field}:</label>
                                    <select
                                        className="w-full p-1 text-black"
                                        value={selections[field] || "لا"}
                                        onChange={(e) =>
                                            handleChange(field, e.target.value)
                                        }
                                    >
                                        {options.map((option) => (
                                            <option key={option} value={option}>
                                                {option}
                                            </option>
                                        ))}
                                    </select>
                                </div>
                            ))}
                        </div>
                    ))}
                </div>

                <div className="mt-8 flex flex-col sm:flex-row justify-center gap-4">
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
                            className="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 ml-4"
                        >
                            الحالات الخاصة
                        </button>
                    </div>
                </div>
            </div>
        </GuestLayout>
    );
}
