import React from 'react';
import { Link, router } from '@inertiajs/react';
import GuestLayout from "@/Layouts/GuestLayout";


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
    <GuestLayout>
    <div className="p-6">
      <div className="max-w-3xl mx-auto bg-white shadow rounded-lg p-4">
        <h1 className="text-2xl font-bold mb-4">📋 Liste des article</h1>

        {/* Affiche le bouton seulement si l'utilisateur est admin */}
        

        <div>
          <ul className="divide-y">
            {articles.map((article) => (
              <li key={article.id} className="py-3 flex justify-between items-center">      

               <Link
                 href={route('articles.detail', { article: article.id })}
                 className="text-blue-600 hover:underline font-medium"
               >
                 {article.titre}
               </Link>

                
              </li>
            ))}
          </ul>
        </div>
      </div>
    </div>
    </GuestLayout>
  );
};

export default ArticleIndex;
