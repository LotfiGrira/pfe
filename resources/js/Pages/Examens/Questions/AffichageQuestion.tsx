import React from 'react';
import { Link } from '@inertiajs/react';

interface Question {
    id: number;
    titre: string;
}

interface Props {
    questions: Question[];
}

const AffichageQuestion: React.FC<Props> = ({ questions = [] }) => {
    if (questions.length === 0) {
        return (
            <div className="min-h-screen bg-gray-100 p-6">
                <div className="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-4">
                    <p className="text-center text-gray-600 font-mono">Aucune question trouvée.</p>
                </div>
            </div>
        );
    }
 
    return (
        <div className="min-h-screen bg-gray-100 p-6">
            <div className="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
                <h1 className="text-2xl font-bold mb-4 text-center">📋 Liste des Questions</h1>
                <ul className="space-y-3">
                {questions.map((question) => (
    <li
        key={question.id}
        className="p-3 border rounded hover:bg-gray-50 transition"
    >
        <Link
            href={`/questions/${question.id}`}
            className="text-lg font-medium text-blue-600 hover:underline font-mono"
        >
            {question.titre}
        </Link>
    </li>
))}
                </ul>
            </div>
        </div>
    );
};

export default AffichageQuestion;
