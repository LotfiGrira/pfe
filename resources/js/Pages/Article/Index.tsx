import React from "react";
import { Link, router } from "@inertiajs/react";
import Breadcrumbs from "@/Components/Breadcrumbs";
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
        if (confirm("هل أنت متأكد من أنك تريد حذف هذا المرجع؟")) {
            router.delete(`/articles/${id}`);
        }
    };

    return (
        <GuestLayout>
            <div className="p-6">
                <div className="max-w-3xl mx-auto bg-white shadow rounded-lg p-4">
                    <Breadcrumbs
                        items={[
                            { label: "Accueil", href: "/dashboard" },
                            { label: "Articles" },
                        ]}
                    />
                    <h1 className="text-2xl font-bold mb-4">
                        📋 قائمة المراجع
                    </h1>

                    {isAdmin && (
                        <Link
                            href={route("articles.create")}
                            className="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                        >
                            ➕ إظافة مراجع
                        </Link>
                    )}

                    <div>
                        <ul className="divide-y">
                            {articles.map((article) => (
                                <li
                                    key={article.id}
                                    className="py-3 flex justify-between items-center"
                                >
                                    <Link
                                        href={route("articles.detail", {
                                            article: article.id,
                                        })}
                                        className="text-blue-600 hover:underline font-medium"
                                    >
                                        {article.titre}
                                    </Link>

                                    {isAdmin && (
                                        <div className="flex space-x-3 bg-gray-50 border border-gray-200 rounded-md p-1">
                                            <Link
                                                href={`/articles/${article.id}/edit`}
                                                className="inline-block px-4 py-1 bg-yellow-300 text-yellow-900 font-semibold rounded-md shadow-sm hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition"
                                            >
                                                تغيير
                                            </Link>
                                            <button
                                                type="button"
                                                onClick={() =>
                                                    handleDelete(article.id)
                                                }
                                                className="inline-block px-4 py-1 bg-red-600 text-white font-semibold rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition"
                                            >
                                                حذف
                                            </button>
                                        </div>
                                    )}
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
