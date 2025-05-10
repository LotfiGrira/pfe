import React from 'react';
import { useForm, router } from '@inertiajs/react';
import Breadcrumbs from '@/Components/Breadcrumbs';
import GuestLayout from '@/Layouts/GuestLayout';

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
  examenId: number;
  question: Question;
}

const Edit: React.FC<Props> = ({ examenId, question }) => {
  const { data, setData, put, processing, errors } = useForm({
    titre: question.titre,
    propositions: question.propositions.map((p) => ({
      id: p.id,
      propos: p.propos,
      is_true: p.is_true,
    })),
  });

  const handleChangeProposition = (index: number, field: keyof Proposition, value: any) => {
    const updated = [...data.propositions];
    updated[index] = { ...updated[index], [field]: value };
    setData('propositions', updated);
  };

  const handleAddProposition = () => {
    const newProp: Proposition = {
      id: Date.now(), // ID temporaire pour React
      propos: '',
      is_true: false,
    };
    setData('propositions', [...data.propositions, newProp]);
  };

  const handleRemoveProposition = (index: number) => {
    const updated = [...data.propositions];
    updated.splice(index, 1);
    setData('propositions', updated);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    put(route('questions.update', {
      examen: examenId,
      id: question.id,
    }), {
      onSuccess: () => {
        // ✅ Redirige vers la liste des questions de cet examen
        router.visit(route('examens.questions.index', { examen: examenId }));
      }
    });
  };

  return (
            <GuestLayout>
    <div className="min-h-screen bg-gray-100 p-6">
      <div className="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
      <Breadcrumbs
            items={[
              { label: 'Accueil', href: '/dashboard' },
              { label: 'Examens', href: '/examens' },
              { label: 'Questions', href: '/examens/{examen}/questions/affichage' },
              { label: 'Modification Questions' },
            ]}
          />
          
        <h1 className="text-2xl font-bold mb-4">✏️ Modifier la Question</h1>

        <form onSubmit={handleSubmit} className="space-y-6">
          <div>
            <label className="block font-semibold mb-1">Titre de la question</label>
            <input
              type="text"
              value={data.titre}
              onChange={(e) => setData('titre', e.target.value)}
              className="w-full border rounded p-2"
            />
            {errors.titre && <div className="text-red-500 text-sm mt-1">{errors.titre}</div>}
          </div>

          <div>
            <label className="block font-semibold mb-2">Propositions</label>
            {data.propositions.map((prop, index) => (
              <div key={prop.id} className="flex items-center space-x-4 mb-2">
                <input
                  type="text"
                  value={prop.propos}
                  onChange={(e) => handleChangeProposition(index, 'propos', e.target.value)}
                  className="flex-1 border rounded p-2"
                />
                <label className="flex items-center space-x-1 text-sm">
                  <input
                    type="checkbox"
                    checked={prop.is_true}
                    onChange={(e) => handleChangeProposition(index, 'is_true', e.target.checked)}
                  />
                  <span>Bonne réponse</span>
                </label>
                <button
                  type="button"
                  onClick={() => handleRemoveProposition(index)}
                  className="text-red-500 text-sm hover:underline"
                >
                  Supprimer
                </button>
              </div>
            ))}
            {errors.propositions && (
              <div className="text-red-500 text-sm mt-1">{errors.propositions}</div>
            )}
            <button
              type="button"
              onClick={handleAddProposition}
              className="mt-2 text-sm text-green-600 hover:underline"
            >
              ➕ Ajouter une proposition
            </button>
          </div>

          <div className="flex justify-between">
            <button
              type="submit"
              disabled={processing}
              className="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
            >
              Enregistrer les modifications
            </button>

            <a
              href={route('examens.questions.index', { examen: examenId })}
              className="text-blue-600 hover:underline text-sm"
            >
              ← Retour aux questions
            </a>
          </div>
        </form>
      </div>
    </div>
            </GuestLayout>
    
  );
};

export default Edit;
