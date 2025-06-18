import React from "react";
import { useForm, Link, router } from "@inertiajs/react";

interface Proposition {
    id?: number;
    propos: string;
    is_true: boolean;
}

interface Question {
    id: number;
    titre: string;
    propositions: Proposition[];
    examen_id: number;
}

interface Examen {
    id: number;
    titre: string;
}

interface Props {
    examen: Examen;
    question: Question;
}

const Show: React.FC<Props> = ({ examen, question }) => {
    const { data, setData, put, errors, processing } = useForm({
        titre: question.titre,
        propositions: question.propositions.map((prop) => ({
            id: prop.id,
            propos: prop.propos,
            is_true: prop.is_true,
        })),
    });

    const handleTitreChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setData("titre", e.target.value);
    };

    const handlePropositionChange = (
        index: number,
        field: keyof Proposition,
        value: any
    ) => {
        const updatedPropositions = [...data.propositions];
        updatedPropositions[index] = {
            ...updatedPropositions[index],
            [field]: value,
        };
        setData("propositions", updatedPropositions);
    };

    const addProposition = () => {
        setData("propositions", [
            ...data.propositions,
            { propos: "", is_true: false },
        ]);
    };

    const removeProposition = (index: number) => {
        const updatedPropositions = [...data.propositions];
        updatedPropositions.splice(index, 1);
        setData("propositions", updatedPropositions);
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(
            route("question.update", {
                examen: examen.id,
                id: question.id,
            }),
            {
                onSuccess: () => {
                    router.visit(
                        route("question.affichage", { examen: examen.id })
                    );
                },
            }
        );
    };

    return (
        <div className="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow">
            <div className="flex justify-between items-center mb-6">
                <h1 className="text-2xl font-bold">Éditer la Question</h1>
                <Link
                    href={route("question.affichage", { examen: examen.id })}
                    className="text-blue-600 hover:text-blue-800"
                >
                    Retour à la liste
                </Link>
            </div>

            <form onSubmit={handleSubmit} className="space-y-6">
                <div>
                    <label className="block font-medium text-gray-700 mb-1">
                        Titre de la question
                    </label>
                    <input
                        type="text"
                        value={data.titre}
                        onChange={handleTitreChange}
                        className="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                    {errors.titre && (
                        <p className="mt-1 text-red-500 text-sm">
                            {errors.titre}
                        </p>
                    )}
                </div>

                <div>
                    <div className="flex justify-between items-center mb-2">
                        <h2 className="text-lg font-semibold text-gray-700">
                            Propositions
                        </h2>
                        <button
                            type="button"
                            onClick={addProposition}
                            className="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600"
                        >
                            Ajouter une proposition
                        </button>
                    </div>

                    {errors.propositions && (
                        <p className="mb-2 text-red-500 text-sm">
                            {errors.propositions}
                        </p>
                    )}

                    {data.propositions.map((prop, index) => (
                        <div
                            key={index}
                            className="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200"
                        >
                            <div className="flex justify-between mb-2">
                                <span className="font-medium">
                                    Proposition {index + 1}
                                </span>
                                <button
                                    type="button"
                                    onClick={() => removeProposition(index)}
                                    className="text-red-500 hover:text-red-700"
                                >
                                    Supprimer
                                </button>
                            </div>

                            <input
                                type="text"
                                value={prop.propos}
                                onChange={(e) =>
                                    handlePropositionChange(
                                        index,
                                        "propos",
                                        e.target.value
                                    )
                                }
                                className="w-full px-3 py-2 mb-2 border rounded"
                                placeholder="Texte de la proposition"
                            />
                            {errors[`propositions.${index}.propos`] && (
                                <p className="text-red-500 text-sm mb-2">
                                    {errors[`propositions.${index}.propos`]}
                                </p>
                            )}

                            <label className="flex items-center space-x-2">
                                <input
                                    type="checkbox"
                                    checked={prop.is_true}
                                    onChange={(e) =>
                                        handlePropositionChange(
                                            index,
                                            "is_true",
                                            e.target.checked
                                        )
                                    }
                                    className="rounded text-blue-600 focus:ring-blue-500"
                                />
                                <span>Bonne réponse</span>
                            </label>
                        </div>
                    ))}
                </div>

                <div className="flex justify-end pt-4 border-t">
                    <button
                        type="submit"
                        disabled={processing}
                        className={`px-4 py-2 rounded text-white ${
                            processing
                                ? "bg-gray-400"
                                : "bg-green-600 hover:bg-green-700"
                        }`}
                    >
                        {processing
                            ? "Enregistrement..."
                            : "Enregistrer les modifications"}
                    </button>
                </div>
            </form>
        </div>
    );
};

export default Show;
