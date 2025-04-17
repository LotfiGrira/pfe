import React, { useState } from 'react';
import { router } from '@inertiajs/react';

const CreateExamen = () => {
  const [titre, setTitre] = useState('');
  const [errors, setErrors] = useState<{ titre?: string }>({});

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    router.post('/examens', { titre }, {
      onError: (err) => setErrors(err),
    });
  };

  return (
    <div className="min-h-screen bg-gray-100 p-6">
      <div className="max-w-md mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 className="text-2xl font-bold mb-4 text-center">➕ Créer un nouvel examen</h2>
        <form onSubmit={handleSubmit} className="space-y-4">
          <div>
            <label className="block mb-1 font-medium text-gray-700">Titre de l'examen</label>
            <input
              type="text"
              value={titre}
              onChange={(e) => setTitre(e.target.value)}
              className="w-full border px-3 py-2 rounded"
            />
            {errors.titre && <p className="text-red-500 text-sm">{errors.titre}</p>}
          </div>
          <button
            type="submit"
            className="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition"
          >
            Enregistrer
          </button>
        </form>
      </div>
    </div>
  );
};

export default CreateExamen;
