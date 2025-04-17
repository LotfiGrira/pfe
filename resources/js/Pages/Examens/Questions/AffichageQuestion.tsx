import React from 'react';
import { Link, router } from '@inertiajs/react';

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
  examenId: number; // 👈 Important pour la route de création
}

const AffichageQuestion: React.FC<Props> = ({ questions = [], examenId }) => {
    const handleDelete = (questionId: number) => {
        if (confirm('Voulez-vous vraiment supprimer cette question ?')) {
          router.delete(route('examens.questions.destroy', {
            examen: examenId,
            question: questionId
          }));
        }
      };

      const handleEdit = (questionId: number) => {
        router.visit(route('question.edit', {
          examen: examenId,
          id: questionId, // ⚠️ Bien mettre "id" ici, car ta route utilise {id}
        }));
      };

  return (
    <div className="min-h-screen bg-gray-100 p-6">
      <div className="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
        
        {/* Bouton Ajouter une question */}
        <div className="flex justify-between items-center mb-6">
          <h1 className="text-2xl font-bold">📋 Liste des Questions</h1>
          <Link
            href={route('questions.create', { examen: examenId })}
            className="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm"
          >
            ➕ Ajouter une question
          </Link>
        </div>

        {questions.length === 0 ? (
          <p className="text-center text-gray-600 font-mono">Aucune question trouvée.</p>
        ) : (
          <ul className="space-y-4">
            {questions.map((question) => (
              <li key={question.id} className="p-4 border rounded-lg bg-gray-50 hover:bg-gray-100">
                <div className="flex justify-between items-start mb-2">
                  <h2 className="text-lg font-semibold">{question.titre}</h2>
                  <div className="space-x-2">
                  <button
  onClick={() => handleEdit(question.id)}
  className="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm"
>
  Modifier
</button>
                    <button
  onClick={() => handleDelete(question.id)}
  className="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm"
>
  Supprimer
</button>
                  </div>
                </div>
                <ul className="ml-4 space-y-1">
                  {question.propositions.map((prop) => (
                    <li key={prop.id} className={prop.is_true ? 'text-green-600' : 'text-gray-700'}>
                      • {prop.propos} {prop.is_true && '(✓ Bonne réponse)'}
                    </li>
                  ))}
                </ul>
              </li>
            ))}
          </ul>
        )}
      </div>
    </div>
  );
};

export default AffichageQuestion;
