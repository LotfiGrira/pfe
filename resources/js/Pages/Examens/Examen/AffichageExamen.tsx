import React from 'react';
import { Link } from '@inertiajs/react';
import GuestLayout from "@/Layouts/GuestLayout";

// ✅ Définir le type Examen
interface Examen {
  id: number;
  titre: string;
}

// ✅ Définir les props du composant
interface Props {
  examens: Examen[];
}

// ✅ Un seul export default
const AffichageExamen: React.FC<Props> = ({ examens }) => {
  return (
    <GuestLayout>
    <div className="p-6">
      <div className="max-w-3xl mx-auto bg-white shadow rounded-lg p-4">
        <h1 className="text-2xl font-bold mb-4">📋 Examens disponibles</h1>
        <ul className="divide-y">
          {examens.map((examen: Examen) => (
            <li key={examen.id} className="py-3">
              <Link
                href={route('examens.questions.liste', { examen: examen.id })}
                className="text-blue-600 hover:underline font-medium"
              >
                {examen.titre}
              </Link>
            </li>
          ))}
        </ul>
      </div>
    </div>
    </GuestLayout>
  );
};

export default AffichageExamen;
