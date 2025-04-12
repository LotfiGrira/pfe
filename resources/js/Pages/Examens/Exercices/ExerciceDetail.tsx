import React, { useState } from 'react';

interface Proposition {
    propos: string;
    is_true: boolean;
}

interface Exercice {
    id: number;
    titre: string;
    propositions: Proposition[];
}

interface ExerciceDetailProps {
    exercice?: Exercice;
    onDelete?: (id: number) => void; // Permet de supprimer sans recharger la page
}

const ExerciceDetail: React.FC<ExerciceDetailProps> = ({ exercice = { id: 0, titre: '', propositions: [] }, onDelete }) => {
    const [isDeleting, setIsDeleting] = useState(false);

    const handleDelete = async () => {
        if (window.confirm('Êtes-vous sûr de vouloir supprimer cet exercice ?')) {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
                const response = await fetch(`/exercices/${exercice.id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken, 
                    },
                });
    
                if (response.ok) {
                    alert('Exercice supprimé avec succès !'); // ✅ Affiche une alerte après suppression
                    window.location.href = '/exercices'; // ✅ Redirige après l'alerte
                } else {
                    const errorText = await response.text();
                    console.error("Erreur serveur:", errorText);
                    alert(`Une erreur est survenue : ${errorText}`);
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Impossible de supprimer cet exercice.');
            }
        }
    };
    
    
    
    return (
        <div className="min-h-screen bg-gray-100 p-6">
            <div className="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
                <h1 className="text-3xl font-bold text-center text-gray-800 mb-6">{exercice.titre}</h1>

                <h3 className="text-xl font-semibold text-gray-700 mb-4">Propositions :</h3>
                <ul className="space-y-4">
                    {exercice.propositions.map((proposition, index) => (
                        <li key={index} className="bg-gray-50 p-4 rounded-lg">
                            <p className="text-gray-700">{proposition.propos}</p>
                            <p className={`mt-2 text-sm font-medium ${proposition.is_true ? 'text-green-600' : 'text-red-600'}`}>
                                {proposition.is_true ? 'Correct' : 'Incorrect'}
                            </p>
                        </li>
                    ))}
                </ul>

                <div className="mt-8 flex justify-center space-x-4">
                    <a
                        href={`/exercices/${exercice.id}/edit`}
                        className="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition duration-200"
                    >
                        Modifier l'exercice
                    </a>
                    <button
                        onClick={handleDelete}
                        className={`bg-red-500 text-white px-6 py-2 rounded-md transition duration-200 ${
                            isDeleting ? 'opacity-50 cursor-not-allowed' : 'hover:bg-red-600'
                        }`}
                        disabled={isDeleting}
                    >
                        {isDeleting ? 'Suppression...' : 'Supprimer'}
                    </button>
                </div>
            </div>
        </div>
    );
};

export default ExerciceDetail;
