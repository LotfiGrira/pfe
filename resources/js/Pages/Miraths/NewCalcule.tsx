import { useState } from "react";
import { Link } from "@inertiajs/react";
import GuestLayout from "@/Layouts/GuestLayout";

export default function NewCalcule() {
    const [gender, setGender] = useState(() => {
        return localStorage.getItem("deceasedGender") || "ذكر";
    });

    const [estate, setEstate] = useState("");
    const [debts, setDebts] = useState("");
    const [wills, setWills] = useState("");
    const [checkboxes, setCheckboxes] = useState({
        deathBeforeDivision: false,
        illegitimateChild: false,
        missingPerson: false,
        fetus: false,
        prisoner: false
    });

    const handleCheckboxChange = (key: string) => {
        setCheckboxes({ ...checkboxes, [key]: !checkboxes[key] });
    };

    const handleGenderChange = (value: string) => {
        setGender(value);
        localStorage.setItem("deceasedGender", value);
    };

    return (
        <GuestLayout>
            <div className="p-6 bg-yellow-100 shadow-md rounded-lg max-w-3xl mx-auto">
                <h1 className="text-2xl font-bold text-center mb-4">
                    حاسبة تقسيم الميراث و حساب المواريث
                </h1>
                <p className="text-gray-700 text-center mb-6">
                    هذه الحاسبة هى الإبتكار الوحيد فى العالم لحل كافة أشكال قضايا الميراث المعقدة، وبمختلف المذاهب والقوانين، وبدقة مائة بالمائة، ومجاناً.
                </p>

                {/* Type du مورث */}
                <div className="mb-4">
                    <label className="block text-gray-700 font-bold mb-2">نوع المورث ؟</label>
                    <div className="flex space-x-4">
                        <label>
                            <input
                                type="radio"
                                value="ذكر"
                                checked={gender === "ذكر"}
                                onChange={(e) => handleGenderChange(e.target.value)}
                                className="mr-2"
                            />
                            ذكر
                        </label>
                        <label>
                            <input
                                type="radio"
                                value="أنثى"
                                checked={gender === "أنثى"}
                                onChange={(e) => handleGenderChange(e.target.value)}
                                className="mr-2"
                            />
                            أنثى
                        </label>
                    </div>
                </div>

                {/* Montant de l'héritage */}
                <div className="mb-4">
                    <label className="block text-gray-700 font-bold mb-2">مقدار التركة ؟</label>
                    <input
                        type="number"
                        value={estate}
                        onChange={(e) => setEstate(e.target.value)}
                        className="w-full px-4 py-2 border rounded-lg"
                        placeholder="أدخل المبلغ الإجمالي"
                    />
                </div>

                {/* Dettes */}
                <div className="mb-4">
                    <label className="block text-gray-700 font-bold mb-2">ديون ؟</label>
                    <input
                        type="number"
                        value={debts}
                        onChange={(e) => setDebts(e.target.value)}
                        className="w-full px-4 py-2 border rounded-lg"
                        placeholder="أدخل قيمة الديون"
                    />
                </div>

                {/* وصية */}
                <div className="mb-4">
                    <label className="block text-gray-700 font-bold mb-2">هل يوجد وصية ؟</label>
                    <input
                        type="number"
                        value={wills}
                        onChange={(e) => setWills(e.target.value)}
                        className="w-full px-4 py-2 border rounded-lg"
                        placeholder="أدخل قيمة الوصية (لا تتجاوز الثلث)"
                    />
                </div>

                {/* Navigation vers ListeHeritier */}
                <Link
                    href="/liste-heritier"
                    className="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition block text-center mt-4"
                >
                    قائمة الورثة
                </Link>
            </div>
        </GuestLayout>
    );
}
