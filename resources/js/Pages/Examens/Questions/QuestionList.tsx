import React, { useEffect, useState } from "react";
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
    examenTitre: string;
}

const QuestionList: React.FC<QuestionListProps> = ({
    questions = [],
    examenTitre,
}) => {
    const [currentId, setCurrentId] = useState<number | null>(null);

    const [selectedPropositions, setSelectedPropositions] = useState<{
        [key: number]: number | null;
    }>({});
    const [resultsVisible, setResultsVisible] = useState(false);
    const [score, setScore] = useState<number | null>(0);

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
            const correctProposition = question.propositions.find(
                (prop) => prop.is_true
            );
            if (correctProposition && selectedId === correctProposition.id) {
                correctAnswers++;
            }
        });

        setScore(correctAnswers);
        setResultsVisible(true);
    };

    const handleRetry = () => {
        setSelectedPropositions({});
        setScore(null);
        setResultsVisible(false);
    };

    const handleForward = () => {
        if (currentId !== null) {
            const nextId = currentId + 1;
            window.location.href = `http://localhost:8000/examens/${nextId}/liste`;
        }
    };

    const handlePrint = () => {
        window.print();
    };

    const getRemark = (score: number, total: number) => {
        const percentage = (score / total) * 100;

        if (percentage >= 80) return "🌟 عمل ممتاز!";
        if (percentage >= 60) return "👍 جهد جيد، واصل التقدم.";
        if (percentage >= 40) return "⚠️ لا يزال هناك مجال للتحسن.";
        return "❌ تحتاج إلى مراجعة أكثر!";
    };

    if (questions.length === 0) {
        return (
            <div className="min-h-screen bg-gray-100 p-6">
                <div className="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
                    <h1 className="text-3xl font-bold text-center text-gray-800 font-mono mb-6">
                        📜 : {examenTitre}
                    </h1>
                    <p className="text-center text-gray-600 font-mono">
                        Aucune question disponible.
                    </p>
                </div>
            </div>
        );
    }
    useEffect(() => {
        const match = window.location.pathname.match(/\/examens\/(\d+)\/liste/);
        if (match) {
            setCurrentId(parseInt(match[1], 10));
        }
    }, []);

    return (
        <GuestLayout>
            <div className="min-h-screen bg-gray-100 p-6">
                <div className="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
                    <h1 className="text-3xl font-bold text-center text-gray-800 font-mono mb-6">
                        📜 {examenTitre}
                    </h1>
                    <ul className="space-y-4">
                        {questions.map((question, index) => (
                            <li
                                key={question.id}
                                className="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-200"
                            >
                                <div>
                                    <h2 className="text-xl font-semibold text-gray-700 font-mono">
                                        السؤال {index + 1}: {question.titre}
                                    </h2>
                                    <div className="mt-2">
                                        {question.propositions.map(
                                            (proposition) => {
                                                const isSelected =
                                                    selectedPropositions[
                                                        question.id
                                                    ] === proposition.id;
                                                const isCorrect =
                                                    proposition.is_true;

                                                const displayText =
                                                    resultsVisible &&
                                                    !isCorrect &&
                                                    !isSelected
                                                        ? proposition.propos.replace(
                                                              /0$/,
                                                              ""
                                                          )
                                                        : proposition.propos;

                                                return (
                                                    <div
                                                        key={proposition.id}
                                                        className="flex items-center"
                                                    >
                                                        <input
                                                            type="radio"
                                                            id={`question-${question.id}-proposition-${proposition.id}`}
                                                            name={`question-${question.id}`}
                                                            value={
                                                                proposition.id
                                                            }
                                                            checked={isSelected}
                                                            onChange={() =>
                                                                handleRadioChange(
                                                                    question.id,
                                                                    proposition.id
                                                                )
                                                            }
                                                            className="mr-2"
                                                            disabled={
                                                                resultsVisible
                                                            }
                                                        />
                                                        <label
                                                            htmlFor={`question-${question.id}-proposition-${proposition.id}`}
                                                            className={`font-mono ${
                                                                resultsVisible
                                                                    ? isSelected
                                                                        ? isCorrect
                                                                            ? "text-green-500 font-bold"
                                                                            : "text-red-500 font-bold"
                                                                        : isCorrect
                                                                        ? "text-green-500 font-bold"
                                                                        : "text-gray-700"
                                                                    : "text-gray-700"
                                                            }`}
                                                        >
                                                            {displayText}

                                                            {resultsVisible && (
                                                                <>
                                                                    {isSelected &&
                                                                    isCorrect
                                                                        ? " ✅"
                                                                        : ""}
                                                                    {isSelected &&
                                                                    !isCorrect
                                                                        ? " ❌"
                                                                        : ""}
                                                                    {!isSelected &&
                                                                    isCorrect ? (
                                                                        <span className="ml-2">
                                                                            ✅
                                                                            الإجابة
                                                                            الصحيحة
                                                                        </span>
                                                                    ) : (
                                                                        ""
                                                                    )}
                                                                </>
                                                            )}
                                                        </label>
                                                    </div>
                                                );
                                            }
                                        )}
                                    </div>
                                </div>
                            </li>
                        ))}
                    </ul>

                    <div className="mt-8 text-center">
                        {!resultsVisible ? (
                            <button
                                onClick={handleResultClick}
                                className="inline-block px-8 py-3 bg-green-600 text-white font-mono font-semibold rounded-xl shadow-md hover:bg-green-700 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
                            >
                                النتيجة
                            </button>
                        ) : (
                            <>
                                <div className="mt-6 p-5 bg-gray-900 text-green-400 font-mono rounded-xl shadow-lg">
                                    <h2 className="text-2xl font-bold">
                                        Score : {score} / {questions.length}
                                    </h2>
                                    <p className="mt-3 text-lg">
                                        {getRemark(
                                            score || 0,
                                            questions.length
                                        )}
                                    </p>
                                </div>
                                <div className="mt-6 flex flex-wrap justify-center gap-4">
                                    <button
                                        onClick={handlePrint}
                                        className="flex items-center justify-center gap-2 px-8 py-3 bg-blue-600 text-white font-mono font-semibold rounded-xl shadow-md hover:bg-blue-700 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                                    >
                                        🖨️ <span>طباعة الأختبار</span>
                                    </button>
                                    {score < 15 ? (
                                        <button
                                            onClick={handleRetry}
                                            className="flex items-center justify-center gap-2 px-8 py-3 bg-yellow-600 text-white font-mono font-semibold rounded-xl shadow-md hover:bg-yellow-700 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50"
                                        >
                                            🔁 <span>محاولة أخرى</span>
                                        </button>
                                    ) : (
                                        <button
                                            onClick={handleForward}
                                            className="flex items-center justify-center gap-2 px-8 py-3 bg-yellow-600 text-white font-mono font-semibold rounded-xl shadow-md hover:bg-yellow-700 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50"
                                        >
                                            <span>الاختبار التالي</span>
                                        </button>
                                    )}
                                </div>
                            </>
                        )}
                    </div>
                </div>
            </div>
        </GuestLayout>
    );
};

export default QuestionList;
