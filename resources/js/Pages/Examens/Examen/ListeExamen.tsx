import React from "react";
import { Link, router } from "@inertiajs/react";
import GuestLayout from "@/Layouts/GuestLayout";

interface Examen {
    id: number;
    titre: string;
}

interface Props {
    examens: Examen[];
    isAdmin: boolean;
}

const ListeExamen: React.FC<Props> = ({ examens, isAdmin }) => {
    const handleDelete = (id: number) => {
        if (confirm("Voulez-vous vraiment supprimer cet examen ?")) {
            router.delete(`/examens/${id}`);
        }
    };

    return (
        <GuestLayout>
            <div className="p-6">
                <div className="max-w-3xl mx-auto bg-white shadow rounded-lg p-4">
                    <h1 className="text-2xl font-bold mb-4 text-right">
                        📋 قائمة الاختبارات
                    </h1>

                    <p className="text-lg text-gray-800 leading-loose bg-gray-100 rounded-lg p-4 mb-6 text-right shadow-sm">
                        كل سؤال تجيب عليه بشكل صحيح = 1 درجة، 15 سؤال = 15 درجة،
                        سيتم تصحيح الأسئلة تلقائيا واعطائك درجتك بعد اختيار
                        إجاباتك والضغط على زر "النتيجة"، هذه الأسئلة موضوعة
                        بعناية لتغطى أسس حساب المواريث و تقسيم الميراث، و قياس
                        مدى إستيعابك لعلم المواريث، ومعظمها ألغاز وليست مجرد
                        أسئلة مباشرة، مستوى الأسئله فى هذا الإختبار فوق المتوسط.
                    </p>

                    <div>
                        <ul className="divide-y">
                            {examens.map((examen) => (
                                <li
                                    key={examen.id}
                                    className="py-3 flex justify-between items-center"
                                >
                                    <Link
                                        href={route("examens.questions.liste", {
                                            examen: examen.id,
                                        })}
                                        className="text-blue-600 hover:underline font-medium"
                                    >
                                        {examen.titre}
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </div>
                </div>
            </div>
        </GuestLayout>
    );
};

export default ListeExamen;
