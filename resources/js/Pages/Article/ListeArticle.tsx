import React from 'react';
import { Link, router } from '@inertiajs/react';
import GuestLayout from "@/Layouts/GuestLayout";

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
    <GuestLayout>
      <div className="p-6">
        <div className="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">
          <h1 className="text-2xl font-bold mb-6 text-center">📋 قائمة المراجع</h1>

          <ul>
            {articles.map((article, index) => (
              <li
                key={article.id}
                className={`py-3 flex justify-between items-center ${
                  index !== articles.length - 1 ? 'border-b border-gray-300' : ''
                }`}
              >
                <Link
                  href={route('articles.detail', { article: article.id })}
                  className="text-blue-600 hover:underline font-medium"
                >
                  {article.titre}
                </Link>
              </li>
            ))}
          </ul>

          <div className="border-t border-gray-300 mt-6 pt-6 text-right">
  <a
    href="https://wrcati.cawtar.org/preview.php?type=law&ID=10"
    target="_blank"
    rel="noopener noreferrer"
    className="text-blue-600 hover:underline font-medium"
  >
    مجلة الأحوال الشخصية
  </a>
</div>

        </div>
      </div>
    </GuestLayout>
  );
};

export default ArticleIndex;
