import React, { useState } from 'react';
import { useForm } from '@inertiajs/react';

interface Exercice {
    id: number;
    titre: string;
    propositions: { propos: string; is_true: boolean }[];
}

interface EditExerciceProps {
    exercice: Exercice;
}

const EditExercice: React.FC<EditExerciceProps> = ({ exercice }) => {
    const { data, setData, put, processing, errors } = useForm({
        titre: exercice.titre,
        propositions: [...exercice.propositions],
    });

    const handleAddProposition = () => {
        setData('propositions', [...data.propositions, { propos: '', is_true: false }]);
    };

    const handleRemoveProposition = (index: number) => {
        const newPropositions = data.propositions.filter((_, i) => i !== index);
        setData('propositions', newPropositions);
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(`/exercice/${exercice.id}`);
    };

    return (
        <div className="min-h-screen bg-gray-100 p-6">
            <div className="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
                <h1 className="text-3xl font-bold text-center text-gray-800 mb-6">
                    Éditer l'exercice
                </h1>

                <form onSubmit={handleSubmit} className="space-y-6">
                    {/* Champ Titre */}
                    <div>
                        <label htmlFor="titre" className="block text-sm font-medium text-gray-700">
                            Titre
                        </label>
                        <input
                            type="text"
                            id="titre"
                            value={data.titre}
                            onChange={(e) => setData('titre', e.target.value)}
                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        />
                        {errors.titre && (
                            <p className="mt-2 text-sm text-red-500">{errors.titre}</p>
                        )}
                    </div>

                    {/* Liste des Propositions */}
                    <div>
                        <h3 className="text-xl font-semibold text-gray-800 mb-4">Propositions</h3>
                        {data.propositions.map((proposition, index) => (
                            <div key={index} className="bg-gray-50 p-4 rounded-lg mb-4 relative">
                                {/* Champ Texte de la Proposition */}
                                <div className="mb-4">
                                    <label
                                        htmlFor={`proposition-${index}`}
                                        className="block text-sm font-medium text-gray-700"
                                    >
                                        Proposition {index + 1}
                                    </label>
                                    <input
                                        type="text"
                                        id={`proposition-${index}`}
                                        value={proposition.propos}
                                        onChange={(e) =>
                                            setData(
                                                'propositions',
                                                data.propositions.map((p, i) =>
                                                    i === index ? { ...p, propos: e.target.value } : p
                                                )
                                            )
                                        }
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Entrez une proposition"
                                        required
                                    />
                                </div>

                                {/* Case à cocher "Correct" */}
                                <div className="flex items-center mb-4">
                                    <input
                                        type="checkbox"
                                        checked={proposition.is_true}
                                        onChange={(e) =>
                                            setData(
                                                'propositions',
                                                data.propositions.map((p, i) =>
                                                    i === index ? { ...p, is_true: e.target.checked } : p
                                                )
                                            )
                                        }
                                        className="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                    />
                                    <label className="ml-2 text-sm text-gray-700">
                                        Cette proposition est correcte
                                    </label>
                                </div>

                                {/* Bouton Supprimer */}
                                {data.propositions.length > 1 && (
                                    <button
                                        type="button"
                                        onClick={() => handleRemoveProposition(index)}
                                        className="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs hover:bg-red-600"
                                    >
                                        X
                                    </button>
                                )}
                            </div>
                        ))}

                        {/* Bouton Ajouter une Proposition */}
                        <button
                            type="button"
                            onClick={handleAddProposition}
                            className="w-full bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600"
                        >
                            Ajouter une proposition
                        </button>
                    </div>

                    {/* Bouton de Soumission */}
                    <div className="text-center">
                        <button
                            type="submit"
                            disabled={processing}
                            className="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 disabled:bg-gray-400"
                        >
                            {processing ? 'En cours...' : 'Mettre à jour'}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default EditExercice;