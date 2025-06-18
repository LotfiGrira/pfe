import React from "react";
import { Link } from "@inertiajs/react";
import GuestLayout from "@/Layouts/GuestLayout";

interface Article {
    id: number;
    titre: string;
}

interface Props {
    articles: Article[];
}

const AffichageArticle: React.FC<Props> = ({ articles }) => {
    return (
        <GuestLayout>
            <div className="p-6">
                <div className="max-w-3xl mx-auto bg-white shadow rounded-lg p-4">
                    <h1 className="text-2xl font-bold mb-4">
                        📋 article disponibles
                    </h1>
                    <ul className="divide-y">
                        {articles.map((article: Article) => (
                            <li key={article.id} className="py-3"></li>
                        ))}
                    </ul>
                </div>
            </div>
        </GuestLayout>
    );
};

export default AffichageArticle;
