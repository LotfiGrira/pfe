import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Dashboard() {
    const user = usePage().props.auth.user;
    const roles = user?.roles || [];
    const isAdmin = roles.includes('admin');

    return (
        <AuthenticatedLayout
            header={
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div className="flex flex-wrap gap-3">
                        <Link
                            href={route('examens.create')}
                            className="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow"
                        >
                            ➕ Créer Examen
                        </Link>
                        <Link
                            href={route('examens.index')}
                            className="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow"
                        >
                            📋 Liste des Examens
                        </Link>
                        <Link
                            href={route('examens.affichage')}
                            className="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow"
                        >
                            👀 Affichage Examens
                        </Link>
                    </div>
                </div>
            }
        >
            <Head title="Dashboard" />

            <div className="py-10">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

                    {/* Bloc d'accueil */}
                    <div className="bg-white shadow rounded-lg p-6">
                        <h3 className="text-lg font-semibold text-gray-700 mb-2">
                            Bonjour, {user.name} 👋
                        </h3>
                        <p className="text-gray-600">
                            Bienvenue sur votre tableau de bord.
                        </p>
                    </div>

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
