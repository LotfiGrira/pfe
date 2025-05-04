import React from "react";
import { Link, router } from "@inertiajs/react";
import GuestLayout from "@/Layouts/GuestLayout";

interface Examen {
    id: number;
    titre: string;
}

interface Props {
    examens: Examen[];
    isAdmin: boolean; // 👈 ajouter isAdmin ici
}

const ListeExamen: React.FC<Props> = ({ examens, isAdmin }) => {
    // 👈 récupérer isAdmin ici
    const handleDelete = (id: number) => {
        if (confirm("Voulez-vous vraiment supprimer cet examen ?")) {
            router.delete(`/examens/${id}`);
        }
    };

    return (
        <GuestLayout>
            <div className="p-6">
                <div className="max-w-3xl mx-auto bg-white shadow rounded-lg p-4">
                    <h1 className="text-2xl font-bold mb-4">
                        📋 Liste des Examens
                    </h1>

                    <div>
                        <ul className="divide-y">
                            {examens.map((examen) => (
                                <li
                                    key={examen.id}
                                    className="py-3 flex justify-between items-center"
                                >
                                    <Link
                                        href={route("examens.questions.liste", {
                                            examen: examen.id,
                                        })}
                                        className="text-blue-600 hover:underline font-medium"
                                    >
                                        {examen.titre}
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

export default ListeExamen;
