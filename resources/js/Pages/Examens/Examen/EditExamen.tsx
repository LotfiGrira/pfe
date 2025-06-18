import React, { useState } from "react";
import { useForm } from "@inertiajs/react";
import { Link } from "@inertiajs/react";
import Breadcrumbs from "@/Components/Breadcrumbs";
import GuestLayout from "@/Layouts/GuestLayout";

interface Props {
    examen: {
        id: number;
        titre: string;
    };
}

export default function Edit({ examen }: Props) {
    const { data, setData, put, processing, errors } = useForm({
        titre: examen.titre,
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(`/examens/${examen.id}`);
    };

    return (
        <GuestLayout>
            <div className="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
                <Breadcrumbs
                    items={[
                        { label: "Accueil", href: "/dashboard" },
                        { label: "Examens", href: "/examens" },
                        { label: "Modifier" },
                    ]}
                />

                <h1 className="text-2xl font-bold mb-4 text-center">
                    ✏️ تغيير تسمية الاختبار
                </h1>
                <Link
                    href={`/examens/${examen.id}/questions/create`}
                    className="text-blue-600 hover:underline font-semibold"
                >
                    {examen.titre}
                </Link>
                <form onSubmit={handleSubmit} className="space-y-4">
                    <div>
                        <label className="block text-sm font-medium">
                            تسمية الاختبار
                        </label>
                        <input
                            type="text"
                            value={data.titre}
                            onChange={(e) => setData("titre", e.target.value)}
                            className="w-full border rounded px-3 py-2"
                        />
                        {errors.titre && (
                            <p className="text-red-500 text-sm mt-1">
                                {errors.titre}
                            </p>
                        )}
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
                    >
                        تنشيط
                    </button>
                </form>
            </div>
        </GuestLayout>
    );
}
