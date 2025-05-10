import React from 'react';
import { Link, router } from '@inertiajs/react';
import Breadcrumbs from '@/Components/Breadcrumbs';
import GuestLayout from "@/Layouts/GuestLayout";

interface Examen {
  id: number;
  titre: string;
}

interface Props {
  examens: Examen[];
  isAdmin: boolean; // 👈 ajouter isAdmin ici
}

const ExamenIndex: React.FC<Props> = ({ examens, isAdmin }) => { // 👈 récupérer isAdmin ici
  const handleDelete = (id: number) => {
    if (confirm('Voulez-vous vraiment supprimer cet examen ?')) {
      router.delete(`/examens/${id}`);
    }
  };

  return (
    <GuestLayout>
    <div className="p-6">
      <div className="max-w-3xl mx-auto bg-white shadow rounded-lg p-4">
      <Breadcrumbs
  items={[
    { label: 'Accueil', href: '/dashboard' },
    { label: 'Examens' }
  ]}
/>
        <h1 className="text-2xl font-bold mb-4">📋 Liste des Examens</h1>

        {/* Affiche le bouton seulement si l'utilisateur est admin */}
        {isAdmin && (
          <Link
            href={route('examens.create')}
            className="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
          >
            ➕ Créer un examen
          </Link>
        )}

        <div>
          <ul className="divide-y">
            {examens.map((examen) => (
              <li key={examen.id} className="py-3 flex justify-between items-center">
             <Link
  href={route('question.affichage', { examen: examen.id })}
  className="text-blue-600 hover:underline font-medium"
>
  {examen.titre}
</Link>



                
                <div className="space-x-2">
                  <Link
                    href={`/examens/${examen.id}/edit`}
                    className="text-yellow-500 hover:underline"
                  >
                    Modifier
                  </Link>
                  <button
                    onClick={() => handleDelete(examen.id)}
                    className="text-red-500 hover:underline"
                  >
                    Supprimer
                  </button>
                </div>
              </li>
            ))}
          </ul>
        </div>
      </div>
    </div>
    </GuestLayout>
  );
};

export default ExamenIndex;
