import { useEffect, useState } from "react";
import GuestLayout from "@/Layouts/GuestLayout";
import { Link, router } from "@inertiajs/react";

const heirFields = [
    { name: "ابن", key: "ibn" },
    { name: "بنت", key: "bint" },
    { name: "أب", key: "ab" },
    { name: "أم", key: "omm" },
    { name: "زوج", key: "zawj" },
    { name: "زوجة", key: "zawja" },
    { name: "أخ", key: "akh" },
    { name: "أخت", key: "oukht" },
    { name: "جد", key: "jadd" },
    { name: "جدة", key: "jadda" },
    // Ajoute d'autres champs si besoin
];

export default function MafgodHeritier() {
    const [mirathInputData, setMirathInputData] = useState<Record<string, string | number | boolean>>({});
    const [selectedHeirsNames, setSelectedHeirsNames] = useState<string[]>([]);
    const [missingCounts, setMissingCounts] = useState<Record<string, number>>({});

    useEffect(() => {
        const mirathRaw = localStorage.getItem("mirathInput");
        if (mirathRaw) {
            const data = JSON.parse(mirathRaw);
            setMirathInputData(data);
        }
    }, []);

    const handleHeirSelection = (heirKey: string) => {
        setSelectedHeirsNames((prevSelected) => {
            if (prevSelected.includes(heirKey)) {
                const updated = prevSelected.filter((name) => name !== heirKey);
                const { [heirKey]: _, ...rest } = missingCounts;
                setMissingCounts(rest);
                return updated;
            }
            return [...prevSelected, heirKey];
        });
    };

    const handleMissingCountChange = (heirKey: string, value: string, max: number) => {
        const parsed = parseInt(value);
        if (!isNaN(parsed) && parsed >= 1 && parsed <= max) {
            setMissingCounts((prev) => ({
                ...prev,
                [heirKey]: parsed,
            }));
        }
    };

    const handleSubmit = () => {
        if (selectedHeirsNames.length === 0) {
            alert("يجب اختيار وريث مفقود");
            return;
        }

        const dataToSave = selectedHeirsNames.map((key) => ({
            name: key,
            count: missingCounts[key] || 1,
        }));

        console.log("✅ Données sauvegardées :", dataToSave);
        localStorage.setItem("missingHeirs", JSON.stringify(dataToSave));
        router.visit("/tagsim-heritier");
    };

    return (
        <GuestLayout>
            <div className="min-h-screen flex flex-col items-center justify-center bg-yellow-200 p-4">
                <div className="bg-yellow-100 shadow-md rounded-lg p-6 w-full max-w-3xl">
                    <h2 className="text-center text-2xl font-bold mb-6">اختر الورثة المفقودين</h2>

                    <div className="mb-6 space-y-4">
                        {heirFields.map(({ name, key }) => {
                            const value = mirathInputData[key];
                            const isSelected = selectedHeirsNames.includes(key);
                            const isBoolean = typeof value === "boolean";
                            const isNumber = typeof value === "number";
                            const maxValue = isNumber ? value : undefined;

                            return (
                                <div
                                    key={key}
                                    className={`bg-white p-3 rounded-lg shadow-sm border-l-4 ${isSelected ? "border-red-500" : "border-blue-500"}`}
                                >
                                    <label className="flex items-center space-x-3 cursor-pointer">
                                        <input
                                            type="checkbox"
                                            checked={isSelected}
                                            onChange={() => handleHeirSelection(key)}
                                            className="w-5 h-5 text-blue-600"
                                        />
                                        <div className="flex-1">
                                            <div className="font-semibold text-lg">{name}</div>
                                            <div className="text-gray-600 mt-1">
                                                {value === undefined
                                                    ? "غير محدد"
                                                    : isNumber
                                                    ? `العدد: ${value}`
                                                    : isBoolean
                                                    ? value
                                                        ? "موجود"
                                                        : "غير موجود"
                                                    : String(value)}
                                            </div>
                                        </div>
                                    </label>

                                    {isSelected && isNumber && (
                                        <div className="mt-2">
                                            <input
                                                type="number"
                                                min={1}
                                                max={maxValue}
                                                value={missingCounts[key] || ""}
                                                onChange={(e) =>
                                                    handleMissingCountChange(key, e.target.value, maxValue!)
                                                }
                                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm"
                                                placeholder={`أدخل عدد المفقودين (بين 1 و ${maxValue})`}
                                            />
                                            {missingCounts[key] > 1 && (
                                                <div className="mt-1 text-sm text-gray-700 font-medium">
                                                    عدد المفقودين: {missingCounts[key]}
                                                </div>
                                            )}
                                        </div>
                                    )}
                                </div>
                            );
                        })}
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
                            className="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow-md transition-colors duration-200 text-center"
                        >
                            العودة
                        </Link>
                    </div>
                </div>
            </div>
        </GuestLayout>
    );
}
