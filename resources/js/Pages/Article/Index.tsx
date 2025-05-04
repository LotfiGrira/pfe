import React from 'react';
import { Link, router } from '@inertiajs/react';
import Breadcrumbs from '@/Components/Breadcrumbs';

interface Article {
  id: number;
  titre: string;
}

interface Props {
  articles: Article[];
  isAdmin: boolean;
}

const ArticleIndex: React.FC<Props> = ({ articles, isAdmin }) => {
  const handleDelete = (id: number) => {
    if (confirm('Voulez-vous vraiment supprimer cet article ?')) {
      router.delete(`/articles/${id}`);
    }
  };

  return (
    <div className="p-6">
      <div className="max-w-3xl mx-auto bg-white shadow rounded-lg p-4">
      <Breadcrumbs
  items={[
    { label: 'Accueil', href: '/dashboard' },
    { label: 'Articles' }
  ]}
/>
        <h1 className="text-2xl font-bold mb-4">📋 Liste des articles</h1>

        {isAdmin && (
          <Link
            href={route('articles.create')}
            className="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
          >
            ➕ Créer un article
          </Link>
        )}

        <div>
          <ul className="divide-y">
            {articles.map((article) => (
              <li key={article.id} className="py-3 flex justify-between items-center">
                {/* Lien vers la page de détail */}
                <Link
                  href={route('articles.detail', { article: article.id })}
                  className="text-blue-600 hover:underline font-medium"
                >
                  {article.titre}
                </Link>

                {/* Actions pour l'admin */}
                {isAdmin && (
                  <div className="space-x-2">
                    <Link
                      href={`/articles/${article.id}/edit`}
                      className="text-yellow-500 hover:underline"
                    >
                      Modifier
                    </Link>
                    <button
                      onClick={() => handleDelete(article.id)}
                      className="text-red-500 hover:underline"
                    >
                      Supprimer
                    </button>
                  </div>
                )}
              </li>
            ))}
          </ul>
        </div>
      </div>
    </div>
  );
};

export default ArticleIndex;
