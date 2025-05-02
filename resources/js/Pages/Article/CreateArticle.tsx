import React, { useState } from 'react';
import { router, useForm } from '@inertiajs/react';

export default function CreateArticle() {
  const { data, setData, post, processing, errors } = useForm({
    titre: '',
    contenu: '',
    langue: 'fr',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('articles.store'));
  };

  return (
    <div className="max-w-3xl mx-auto p-6 bg-white rounded shadow">
      <h1 className="text-2xl font-bold mb-6">Créer un article</h1>
      <form onSubmit={handleSubmit} className="space-y-4">
        <div>
          <label htmlFor="titre" className="block font-medium">Titre</label>
          <input
            id="titre"
            type="text"
            value={data.titre}
            onChange={e => setData('titre', e.target.value)}
            className="w-full border rounded p-2"
          />
          {errors.titre && <div className="text-red-500 text-sm">{errors.titre}</div>}
        </div>

        <div>
          <label htmlFor="contenu" className="block font-medium">Contenu</label>
          <textarea
            id="contenu"
            value={data.contenu}
            onChange={e => setData('contenu', e.target.value)}
            className="w-full border rounded p-2 h-64 resize-y"
            placeholder="Tapez ici le contenu détaillé de l’article..."
          />
          {errors.contenu && <div className="text-red-500 text-sm">{errors.contenu}</div>}
        </div>

        <div>
          <label htmlFor="langue" className="block font-medium">Langue</label>
          <select
            id="langue"
            value={data.langue}
            onChange={e => setData('langue', e.target.value)}
            className="w-full border rounded p-2"
          >
            <option value="fr">Français</option>
            <option value="ar">Arabe</option>
          </select>
          {errors.langue && <div className="text-red-500 text-sm">{errors.langue}</div>}
        </div>

        <button
          type="submit"
          disabled={processing}
          className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
          Enregistrer
        </button>
      </form>
    </div>
  );
}
