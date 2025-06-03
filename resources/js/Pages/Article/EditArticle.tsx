import React from 'react';
import { useForm } from '@inertiajs/react';
import Breadcrumbs from '@/Components/Breadcrumbs';
import GuestLayout from "@/Layouts/GuestLayout";

interface Props {
  article: {
    id: number;
    titre: string;
    contenu: string;
  };
}

export default function Edit({ article }: Props) {
  const { data, setData, put, processing, errors } = useForm({
    titre: article.titre,
    contenu: article.contenu,
  });


  

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    put(`/articles/${article.id}`, {
      replace: true, // 👈 recharge la page après redirection
    });
  };

  return (
        <GuestLayout>
    <div className="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
      <Breadcrumbs
  items={[
    { label: 'Accueil', href: '/dashboard' },
    { label: 'Articles', href: '/articles' },
    { label: 'Modifier' }
  ]}
/>
      <h1 className="text-2xl font-bold mb-4 text-center">✏️ تغيير المرجع</h1>

      <form onSubmit={handleSubmit} className="space-y-4">
        <div>
          <label className="block text-sm font-medium">العنوان</label>
          <input
            type="text"
            value={data.titre}
            onChange={(e) => setData('titre', e.target.value)}
            className="w-full border rounded px-3 py-2"
          />
          {errors.titre && <p className="text-red-500 text-sm mt-1">{errors.titre}</p>}
        </div>

        <div>
          <label className="block text-sm font-medium">المحتوى</label>
          <textarea
            value={data.contenu}
            onChange={(e) => setData('contenu', e.target.value)}
            rows={10}
            className="w-full border rounded px-3 py-2"
          />
          {errors.contenu && <p className="text-red-500 text-sm mt-1">{errors.contenu}</p>}
        </div>

        <button
          type="submit"
          disabled={processing}
          className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
        >
تنشيط     
   </button>
        
      </form>
    </div>
        </GuestLayout>
  );
}
