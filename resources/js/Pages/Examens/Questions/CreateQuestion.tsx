import React from 'react';
import { useForm, router } from '@inertiajs/react';
import Breadcrumbs from '@/Components/Breadcrumbs';

interface Props {
  examenId: number;
}

interface Proposition {
  propos: string;
  is_true: boolean;
}

export default function CreateQuestion({ examenId }: Props) {
  const { data, setData, post, processing, errors } = useForm({
    titre: '',
    examen_id: examenId,
    propositions: [
      { propos: '', is_true: false },
      { propos: '', is_true: false },
    ] as Proposition[],
  });

  const handlePropositionChange = (index: number, key: keyof Proposition, value: any) => {
    const newProps = [...data.propositions];
    newProps[index][key] = value;
    setData('propositions', newProps);
  };

  const ajouterProposition = () => {
    setData('propositions', [...data.propositions, { propos: '', is_true: false }]);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('examens.questions.store', examenId), {
      onSuccess: () => {
        router.visit(route('question.affichage', { examen: examenId }));
      }
    });
  };

  return (
    <div className="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
      <Breadcrumbs
            items={[
              { label: 'Accueil', href: '/dashboard' },
              { label: 'Examens', href: '/examens' },
              { label: 'Questions', href: '/examens/{examen}/questions/affichage' },
              { label: 'Creation Questions' },
            ]}
          />
      <h1 className="text-2xl font-bold mb-4 text-center">Créer un Exercice</h1>

      <form onSubmit={handleSubmit} className="space-y-4">
        <div>
          <label className="block text-sm font-medium">Titre</label>
          <input
            type="text"
            value={data.titre}
            onChange={(e) => setData('titre', e.target.value)}
            className="w-full border rounded px-3 py-2"
            required
          />
          {errors.titre && <p className="text-red-500 text-sm">{errors.titre}</p>}
        </div>

        {data.propositions.map((prop, index) => (
          <div key={index} className="border p-4 rounded relative">
            <label className="block text-sm font-medium mb-1">Proposition {index + 1}</label>
            <textarea
              value={prop.propos}
              onChange={(e) => handlePropositionChange(index, 'propos', e.target.value)}
              className="w-full border rounded px-3 py-2"
              required
            />
            <label className="flex items-center mt-2 text-sm">
              <input
                type="checkbox"
                className="mr-2"
                checked={prop.is_true}
                onChange={(e) => handlePropositionChange(index, 'is_true', e.target.checked)}
              />
              Réponse correcte
            </label>
            {data.propositions.length > 2 && (
              <button
                type="button"
                onClick={() => {
                  const newProps = [...data.propositions];
                  newProps.splice(index, 1);
                  setData('propositions', newProps);
                }}
                className="absolute top-2 right-2 text-red-500"
              >
                ×
              </button>
            )}
          </div>
        ))}

        <div className="flex gap-4">
          <button
            type="submit"
            disabled={processing}
            className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded disabled:bg-blue-400"
          >
            {processing ? 'Création...' : 'Créer Question'}
          </button>
          
          <button
            type="button"
            onClick={ajouterProposition}
            className="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded"
          >
            Ajouter une proposition
          </button>
        </div>
      </form>
    </div>
  );
}