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
  isAdmin: boolean;
}

const ExamenIndex: React.FC<Props> = ({ examens, isAdmin }) => {
  const handleDelete = (id: number) => {
if (confirm('هل أنت متأكد من أنك تريد حذف هذا الاختبار؟')) {
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
          <h1 className="text-2xl font-bold mb-4">📋 قائمة الاختبارات </h1>

          {isAdmin && (
            <Link
              href={route('examens.create')}
              className="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
            >
              ➕ إنشاء اختبار
            </Link>
          )}

          <ul className="divide-y">
            {examens.map((examen) => (
              <li key={examen.id} className="py-3 flex justify-between items-center">
                <Link
                  href={route('question.affichage', { examen: examen.id })}
                  className="text-blue-600 hover:underline font-medium"
                >
                  {examen.titre}
                </Link>

                {/* Cadre clair autour des boutons */}
              <div className="flex space-x-3 bg-gray-50 border border-gray-200 rounded-md p-1">
  <Link
    href={`/examens/${examen.id}/edit`}
    className="inline-block px-4 py-1 bg-yellow-300 text-yellow-900 font-semibold rounded-md shadow-sm hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition"
  >
    تغيير
  </Link>
  <button
    type="button"
    onClick={() => handleDelete(examen.id)}
    className="inline-block px-4 py-1 bg-red-600 text-white font-semibold rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition"
  >
    فسخ
  </button>
</div>

              </li>
            ))}
          </ul>
        </div>
      </div>
    </GuestLayout>
  );
};

export default ExamenIndex;
