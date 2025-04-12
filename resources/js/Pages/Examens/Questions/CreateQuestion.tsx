import { useState } from "react";
import { useForm } from "@inertiajs/react";
import GuestLayout from "@/Layouts/GuestLayout";

export default function CreateQuestion() {
    const { data, setData, post, processing, errors } = useForm({
        titre: "",
        propositions: [
            { text: "", is_true: false }, // Proposition 1 par défaut
            { text: "", is_true: false }, // Proposition 2 par défaut
        ],
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post("/questions", {
            onSuccess: () => window.location.href = "/questions",
        });
    };

    const updateProposition = (index: number, field: string, value: any) => {
        const newPropositions = data.propositions.map((p, i) =>
            i === index ? { ...p, [field]: value } : p
        );
        setData("propositions", newPropositions);
    };

    const addProposition = () => {
        setData("propositions", [...data.propositions, { text: "", is_true: false }]);
    };

    const removeProposition = (index: number) => {
        if (data.propositions.length > 2) {
            setData("propositions", data.propositions.filter((_, i) => i !== index));
        }
    };
    const handleDelete = async () => {
        if (window.confirm('Êtes-vous sûr de vouloir supprimer cet question ?')) {
            try {
                const response = await fetch(`/question/${question.id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    },
                });
    
                console.log('Réponse de la suppression :', response); // Affiche la réponse dans la console du navigateur
    
                if (response.ok) {
                    window.location.href = '/question'; // Rediriger après suppression
                } else {
                    alert('Une erreur est survenue lors de la suppression.');
                }
            } catch (error) {
                console.error('Erreur:', error);
            }
        }
    };
    return (
        <GuestLayout>
            <div className="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
                <h2 className="text-2xl font-bold mb-4">Créer un Question</h2>
                <form onSubmit={handleSubmit} className="space-y-4">
                    {/* Champ Titre */}
                    <div>
                        <label className="block font-medium">Titre</label>
                        <input
                            type="text"
                            value={data.titre}
                            onChange={(e) => setData("titre", e.target.value)}
                            className="w-full p-2 border rounded"
                        />
                        {errors.titre && <p className="text-red-500">{errors.titre}</p>}
                    </div>

                    {/* Liste des Propositions */}
                    {data.propositions.map((proposition, index) => (
                        <div key={index} className="border p-4 rounded relative">
                            <label className="block font-medium">Proposition {index + 1}</label>
                            <textarea
                                value={proposition.text}
                                onChange={(e) => updateProposition(index, "text", e.target.value)}
                                className="w-full p-2 border rounded"
                            />
                            {errors[`propositions.${index}.text`] && (
                                <p className="text-red-500">{errors[`propositions.${index}.text`]}</p>
                            )}

                            {/* Case à cocher is_true */}
                            <div className="flex items-center mt-2">
                                <input
                                    type="checkbox"
                                    checked={proposition.is_true}
                                    onChange={(e) => updateProposition(index, "is_true", e.target.checked)}
                                    className="mr-2"
                                />
                                <label className="font-medium">Cette proposition est vraie ?</label>
                            </div>

                            {/* Bouton de suppression (désactivé si 2 propositions) */}
                            {data.propositions.length > 2 && (
                                <button
                                    type="button"
                                    onClick={() => removeProposition(index)}
                                    className="absolute top-0 right-0 bg-red-500 text-white px-2 py-1 text-xs rounded"
                                 >
                                    X
                                </button>
                            )}
                        </div>
                    ))}

                    {/* Bouton Ajouter Proposition */}
                    <button
                        type="button"
                        onClick={addProposition}
                        className="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mt-2"
                    >
                        Ajouter une proposition
                    </button>

                    {/* Bouton de soumission */}
                    <button
                        type="submit"
                        disabled={processing}
                        className="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 disabled:bg-gray-400 mt-4"
                    >
                        {processing ? "Création..." : "Créer Question"}
                    </button>
                </form>
            </div>
        </GuestLayout>
    );
}
