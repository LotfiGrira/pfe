// resources/js/Pages/Dashboard.tsx

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Dashboard() {
    const user = usePage().props.auth.user;
    const roles = user?.roles || [];
    const isAdmin = roles.includes('admin');
  console.log(isAdmin);
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Dashboard
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">

                    {/* ✅ Si ADMIN => afficher les 4 boutons ici */}
                    {isAdmin && (
                        <div className="mb-8 flex flex-wrap justify-center gap-4">
                            <Link
                                href={route('examens.create')}
                                className="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            >
                                ➕ Créer Examen
                            </Link>
                            <Link
                                href={route('examens.index')}
                                className="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                            >
                                📋 Liste Examens
                            </Link>
                           
                        </div>
                    )}

                    {/* ✅ Bloc de bienvenue */}
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            You're logged in!
                        </div>
                    </div>

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
