import { PropsWithChildren } from "react";
import Navbar from "@/Components/Navbar";
import { usePage } from "@inertiajs/react";

export default function Guest({ children }: PropsWithChildren) {
    const user = usePage().props?.auth?.user;
    const roles = user?.roles || [];
    const isAdmin = roles.includes("admin");

    const menu = [
        { text: "الرئيسة", link: "/" },
        { text: "حساب المواريث", link: "/calculator" },
        { text: "مراجع", link: "/articles/liste" },
        {
            text: "اختبارات",
            link: user ? "/examens/liste" : "/login",
        },
    ];

    // Ajoute des liens admin si l'utilisateur est admin
    if (isAdmin) {
        menu.push(
            { text: "📋 Liste des Articles", link: "/articles" },
            { text: "📋 Liste des Examens", link: "/examens" }
        );
    }

    return (
        <div
            dir="rtl"
            className="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0"
        >
            <Navbar menu={menu} />

            <div className="mt-2 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-2xl sm:rounded-lg">
                {children}
            </div>
        </div>
    );
}
