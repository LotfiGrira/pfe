import { useState } from "react";
import { router } from "@inertiajs/react";
import GuestLayout from "@/Layouts/GuestLayout";
import type { MirathInput } from "@/types/MirathInput";
import Footer from "@/Components/Footer";

export default function NewCalcule() {
    const [formData, setFormData] = useState<MirathInput>({
        gender:
            (localStorage.getItem("deceasedGender") as "ذكر" | "أنثى") || "ذكر",
        tarika: "",
        doyon: "",
        wasiya: "",
        gatel: {},
        maf9oud: {},
    });

    const handleGenderChange = (value: "ذكر" | "أنثى") => {
        setFormData({ ...formData, gender: value });
        localStorage.setItem("deceasedGender", value);
    };

    const handleChange = (field: keyof MirathInput, value: string) => {
        setFormData({ ...formData, [field]: value });
    };

    const handleNextClick = () => {
        const tarika = parseFloat(formData.tarika);
        const wasiya = parseFloat(formData.wasiya);

        if (isNaN(tarika) || isNaN(wasiya)) {
            alert("يرجى إدخال أرقام صحيحة في التركة والوصية.");
            return;
        }

        const maxWasiya = tarika / 3;

        if (wasiya > maxWasiya) {
            alert(
                `قيمة الوصية لا يجب أن تتجاوز ثلث التركة (${maxWasiya.toFixed(
                    2
                )}).`
            );
            return;
        }

        // Enregistrement dans le localStorage
        localStorage.setItem("mirathInput", JSON.stringify(formData));

        // Redirection automatique
        router.visit("/liste-heritier");
    };

    return (
        <GuestLayout>
            <div className="p-6 bg-yellow-100 shadow-md rounded-lg max-w-3xl mx-auto">
                <h1 className="text-2xl font-bold text-center mb-4">
                    حاسبة تقسيم الميراث
                </h1>
                <p className="text-gray-700 text-center mb-6">
                    هذه الحاسبة تعطيك نتيجةحساب بدقة مائة بالمائة، ومجاناً، قم
                    باختيار أقارب المتوفى من جدول الأقارب مثل الزوجة والبنات و
                    البنين وسيتم حساب المواريث إلكترونيا و قسمة التركة، موقع
                    المواريث هو برنامج تقسيم الميراث وفق القانون التونسي
                    المستوحى من مجلة الأحوال الشخصية و يمكنك تحميل نتيجة تقسيم
                    المبراث و هو تطوير برمجى لفكرة جدول تقسيم الميراث و بمثابة
                    حاسبة خاصة لتوزيع و تقسيم .الورث وعرض خطوات الحساب بالتفصيل،
                    وهي أسهل طريقة للتقسيم ( عن الحاسبة | المراجع | مبادىء)
                    تنويه: ليس ضرورياً الإجابة عن كل الأسئلة ، وتحديدك لجهة
                    القرابة يكون منسوباً للمتوفى مثل [الزوجة] هى زوجة المتوفى
                    و[أب] هو أب المتوفى و [أخ] هو أخ للمتوفى وهكذا.{" "}
                </p>
                <div className="border-red-400 text-red-800 px-4 py-3 rounded mb-6 text-right">
                    ⚠️ الرجاء إدخال الأشخاص الأحياء فقط.
                    <br />
                    كل وريث لم يقع إدخاله **لن يُحسب** في تقسيم الميراث.
                </div>
                {/* نوع المورث */}
                <div className="mb-4">
                    <label className="block text-gray-700 font-bold mb-2">
                        نوع المورث ؟
                    </label>
                    <div className="flex space-x-4">
                        {["ذكر", "أنثى"].map((g) => (
                            <label key={g}>
                                <input
                                    type="radio"
                                    value={g}
                                    checked={formData.gender === g}
                                    onChange={() =>
                                        handleGenderChange(g as "ذكر" | "أنثى")
                                    }
                                    className="mr-2"
                                />
                                {g}
                            </label>
                        ))}
                    </div>
                </div>

                {/* مقدار التركة */}
                <div className="mb-4">
                    <label className="block text-gray-700 font-bold mb-2">
                        مقدار التركة ؟
                    </label>
                    <input
                        type="number"
                        value={formData.tarika}
                        onChange={(e) => handleChange("tarika", e.target.value)}
                        className="w-full px-4 py-2 border rounded-lg"
                        placeholder="أدخل المبلغ الإجمالي"
                    />
                </div>

                {/* الديون */}
                <div className="mb-4">
                    <label className="block text-gray-700 font-bold mb-2">
                        الديون ؟
                    </label>
                    <input
                        type="number"
                        value={formData.doyon}
                        onChange={(e) => handleChange("doyon", e.target.value)}
                        className="w-full px-4 py-2 border rounded-lg"
                        placeholder="أدخل قيمة الديون"
                    />
                </div>

                {/* الوصية */}
                <div className="mb-4">
                    <label className="block text-gray-700 font-bold mb-2">
                        الوصية ؟
                    </label>
                    <input
                        type="number"
                        value={formData.wasiya}
                        onChange={(e) => handleChange("wasiya", e.target.value)}
                        className="w-full px-4 py-2 border rounded-lg"
                        placeholder="أدخل قيمة الوصية (لا تتجاوز الثلث)"
                    />
                </div>

                {/* Bouton Suivant */}
                <button
                    onClick={handleNextClick}
                    className="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition block text-center mt-4"
                >
                    التالي
                </button>
                {/* Footer */}
                <Footer />
            </div>
        </GuestLayout>
    );
}
