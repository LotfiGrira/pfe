import React from "react";
import GuestLayout from "@/Layouts/GuestLayout";

interface Props {
    article: {
        id: number;
        titre: string;
        contenu: string;
    };
}

const ShowArticle: React.FC<Props> = ({ article }) => {
    return (
        <GuestLayout>
            <div className="p-6 max-w-3xl mx-auto bg-white shadow rounded-lg">
                <h1 className="text-3xl font-bold mb-4">{article.titre}</h1>
                <p className="text-gray-700 whitespace-pre-line">
                    {article.contenu}
                </p>
            </div>
        </GuestLayout>
    );
};

export default ShowArticle;
