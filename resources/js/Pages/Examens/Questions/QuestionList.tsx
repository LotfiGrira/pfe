import React, { useState } from 'react';
import GuestLayout from "@/Layouts/GuestLayout";

interface Proposition {
    id: number;
    propos: string;
    is_true: boolean;
}

interface Question {
    id: number;
    titre: string;
    propositions: Proposition[];
}

interface QuestionListProps {
    questions: Question[];
}

const QuestionList: React.FC<QuestionListProps> = ({ questions = [], examenTitre }) => {
    const [selectedPropositions, setSelectedPropositions] = useState<{ [key: number]: number | null }>({});
    const [resultsVisible, setResultsVisible] = useState(false);
    const [score, setScore] = useState<number | null>(null);

    const handleRadioChange = (questionId: number, propositionId: number) => {
        setSelectedPropositions((prev) => ({
            ...prev,
            [questionId]: propositionId,
        }));
    };
    const handleResultClick = () => {
        let correctAnswers = 0;
        questions.forEach((question) => {
            const selectedId = selectedPropositions[question.id];
            const correctProposition = question.propositions.find((prop) => prop.is_true);
            if (correctProposition && selectedId === correctProposition.id) {
                correctAnswers++;
            }
        });

        setScore(correctAnswers);
        setResultsVisible(true);
    };

    const handlePrint = () => {
        window.print();
    };

    const getRemark = (score: number, total: number) => {
        const percentage = (score / total) * 100;
        if (percentage >= 80) return "🌟 Excellent travail !";
        if (percentage >= 60) return "👍 Bon effort, continue ainsi.";
        if (percentage >= 40) return "⚠️ Il y a encore des progrès à faire.";
        return "❌ Besoin de révisions !";
    };

    if (questions.length === 0) {
        return (
            
            <div className="min-h-screen bg-gray-100 p-6">
                <div className="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
                    <h1 className="text-3xl font-bold text-center text-gray-800 font-mono mb-6">
                        📜 Examen : {examenTitre}
                    </h1>
                    <p className="text-center text-gray-600 font-mono">Aucune question disponible.</p>
                </div>
            </div>
        );
    }

    return (
        <GuestLayout>
        <div className="min-h-screen bg-gray-100 p-6">
            <div className="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
                <h1 className="text-3xl font-bold text-center text-gray-800 font-mono mb-6">
                    📜 Examen : {examenTitre}
                </h1>
                <ul className="space-y-4">
                    {questions.map((question) => (
                        <li key={question.id} className="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-200">
                            <div>
                                <h2 className="text-xl font-semibold text-gray-700 font-mono">
                                    Question {question.id}: {question.titre}
                                </h2>
                                <div className="mt-2">
                                    {question.propositions.map((proposition) => {
                                        const isSelected = selectedPropositions[question.id] === proposition.id;
                                        const isCorrect = proposition.is_true;

                                        return (
                                            <div key={proposition.id} className="flex items-center">
                                                <input
                                                    type="radio"
                                                    id={`question-${question.id}-proposition-${proposition.id}`}
                                                    name={`question-${question.id}`}
                                                    value={proposition.id}
                                                    checked={isSelected}
                                                    onChange={() => handleRadioChange(question.id, proposition.id)}
                                                    className="mr-2"
                                                    disabled={resultsVisible}
                                                />
                                                <label
                                                    htmlFor={`question-${question.id}-proposition-${proposition.id}`}
                                                    className={`font-mono ${
                                                        resultsVisible
                                                            ? isSelected
                                                                ? isCorrect
                                                                    ? "text-green-500 font-bold"
                                                                    : "text-red-500 font-bold"
                                                                : "text-gray-700"
                                                            : "text-gray-700"
                                                    }`}
                                                >
                                                    {proposition.propos}
                                                    {resultsVisible && isSelected && (isCorrect ? " ✅" : " ❌")}
                                                </label>
                                            </div>
                                        );
                                    })}
                                </div>
                            </div>
                        </li>
                    ))}
                </ul>

                <div className="mt-8 text-center">
                    {!resultsVisible ? (
                        <button
                            onClick={handleResultClick}
                            className="inline-block px-6 py-2 bg-green-600 text-white font-mono font-semibold rounded-lg hover:bg-green-700 transition duration-200"
                        >
                            Résultat
                        </button>
                    ) : (
                        <>
                            <div className="mt-6 p-4 bg-gray-900 text-green-400 font-mono rounded-lg shadow-md">
                                <h2 className="text-xl font-bold">
                                    Score : {score} / {questions.length}
                                </h2>
                                <p className="mt-2 text-lg">{getRemark(score || 0, questions.length)}</p>
                            </div>
                            <button
                                onClick={handlePrint}
                                className="mt-4 px-6 py-2 bg-blue-600 text-white font-mono font-semibold rounded-lg hover:bg-blue-700 transition duration-200"
                            >
                                🖨️ Imprimer l'examen
                            </button>
                        </>
                    )}
                </div>
            </div>
        </div>
        </GuestLayout>
    );
};

export default QuestionList;
