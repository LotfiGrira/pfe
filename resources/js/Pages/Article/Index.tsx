import React from 'react';
import { Link, router } from '@inertiajs/react';

interface Article {
  id: number;
  titre: string;
}

interface Props {
  articles: Article[];
  isAdmin: boolean; // 👈 ajouter isAdmin ici
}

const ArticleIndex: React.FC<Props> = ({ articles, isAdmin }) => { // 👈 récupérer isAdmin ici
  const handleDelete = (id: number) => {
    if (confirm('Voulez-vous vraiment supprimer cet article ?')) {
      router.delete(`/articles/${id}`);
    }
  };

  return (
    <div className="p-6">
      <div className="max-w-3xl mx-auto bg-white shadow rounded-lg p-4">
        <h1 className="text-2xl font-bold mb-4">📋 Liste des article</h1>

        {/* Affiche le bouton seulement si l'utilisateur est admin */}
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

               <div
              >
                {article.titre}
              </div>

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
              </li>
            ))}
          </ul>
        </div>
      </div>
    </div>
  );
};

export default ArticleIndex;
