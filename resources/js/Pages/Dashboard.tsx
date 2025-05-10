import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, usePage } from "@inertiajs/react";
import GuestLayout from '@/Layouts/GuestLayout';

export default function Dashboard() {
    const user = usePage().props?.auth?.user;
    const roles = user?.roles || [];
    const isAdmin = roles.includes("admin");

    return (
        <GuestLayout>
           
                header={
                    <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div className="flex flex-wrap gap-3">
                            
                            
                           
                           
                        </div>
                    </div>
                }
            
                <Head title="Dashboard" />

                <div className="py-10 bg-amber-50 min-h-screen">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
                        {/* Bloc d'accueil */}
                        <div className="bg-white shadow-lg border border-amber-200 rounded-xl p-6">
                            <h3 className="text-xl font-bold text-yellow-900 mb-2">
                                Bonjour, {user?.name} 👋
                            </h3>
                            <p className="text-gray-700">
                                Bienvenue sur votre tableau de bord.
                            </p>
                        </div>
                    </div>
                </div>
        </GuestLayout>
    );
}
