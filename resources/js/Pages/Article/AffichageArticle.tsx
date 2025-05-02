import React from 'react';
import { Link } from '@inertiajs/react';

// ✅ Définir le type article
interface Article {
  id: number;
  titre: string;
}

// ✅ Définir les props du composant
interface Props {
  articles: Article[];
}

// ✅ Un seul export default
const AffichageArticle: React.FC<Props> = ({ articles }) => {
  return (
    <div className="p-6">
      <div className="max-w-3xl mx-auto bg-white shadow rounded-lg p-4">
        <h1 className="text-2xl font-bold mb-4">📋 article disponibles</h1>
        <ul className="divide-y">
          {articles.map((article: Article) => (
            <li key={article.id} className="py-3">
              
            </li>
          ))}
        </ul>
      </div>
    </div>
  );
};

export default AffichageArticle;
