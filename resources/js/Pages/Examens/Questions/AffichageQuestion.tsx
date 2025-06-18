import React from "react";
import { Link, router } from "@inertiajs/react";
import Breadcrumbs from "@/Components/Breadcrumbs";
import GuestLayout from "@/Layouts/GuestLayout";

interface Proposition {
    id: number;
    propos: string;
    is_true: boolean;
}

interface Question {
    id: number;
    titre: string;
    propositions: Proposition[];
}

interface Props {
    questions: Question[];
    examenId: number;
}

const AffichageQuestion: React.FC<Props> = ({ questions = [], examenId }) => {
    const handleDelete = (questionId: number) => {
        if (confirm("هل أنت متأكد من أنك تريد حذف هذا السؤال؟")) {
            router.delete(
                route("examens.questions.destroy", {
                    examen: examenId,
                    id: questionId,
                })
            );
        }
    };

    const handleEdit = (questionId: number) => {
        router.visit(
            route("questions.edit", {
                examen: examenId,
                id: questionId,
            })
        );
    };

    return (
        <GuestLayout>
            <div className="min-h-screen bg-gray-100 p-6">
                <div className="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
                    <div className="flex justify-between items-center mb-6">
                        <Breadcrumbs
                            items={[
                                { label: "Accueil", href: "/dashboard" },
                                { label: "Examens", href: "/examens" },
                            ]}
                        />

                        <h1 className="text-2xl font-bold">📋 قائمة الاسئلة</h1>

                        <Link
                            href={route("questions.create", {
                                examen: examenId,
                            })}
                            className="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm"
                        >
                            ➕ إظافة سؤال
                        </Link>
                    </div>

                    {questions.length === 0 ? (
                        <p className="text-center text-gray-600 font-mono">
                            Aucune question trouvée.
                        </p>
                    ) : (
                        <ul className="space-y-4">
                            {questions.map((question) => (
                                <li
                                    key={question.id}
                                    className="p-4 border rounded-lg bg-gray-50 hover:bg-gray-100"
                                >
                                    <div className="flex justify-between items-start mb-2">
                                        <h2 className="text-lg font-semibold">
                                            {question.titre}
                                        </h2>
                                        <div className="space-x-2">
                                            <button
                                                onClick={() =>
                                                    handleEdit(question.id)
                                                }
                                                className="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm"
                                            >
                                                تغيير
                                            </button>
                                            <button
                                                onClick={() =>
                                                    handleDelete(question.id)
                                                }
                                                className="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm"
                                            >
                                                حذف
                                            </button>
                                        </div>
                                    </div>
                                    <ul className="ml-4 space-y-1">
                                        {question.propositions.map((prop) => (
                                            <li
                                                key={prop.id}
                                                className={
                                                    prop.is_true
                                                        ? "text-green-600"
                                                        : "text-gray-700"
                                                }
                                            >
                                                • {prop.propos}{" "}
                                                {prop.is_true
                                                    ? "(✓ Bonne réponse)"
                                                    : ""}
                                            </li>
                                        ))}
                                    </ul>
                                </li>
                            ))}
                        </ul>
                    )}
                </div>
            </div>
        </GuestLayout>
    );
};

export default AffichageQuestion;
