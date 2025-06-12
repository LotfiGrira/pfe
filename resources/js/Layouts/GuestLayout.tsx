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
            text: "اختبارات",link: user ? "/examens/liste" : "/login",
        },
    ];

    if (isAdmin) {
        menu.push(
            { text: "📋 قائمة  المراجع", link: "/articles" },
            { text: "📋 قائمة الاختبارات", link: "/examens" }
        );
    }

    return (
        <div
            dir="rtl"
            className="pt-20 min-h-screen bg-arabesque bg-repeat font-amiri text-right text-lg leading-relaxed text-black"
        >
            <Navbar menu={menu} />

<div className="mt-2 w-full overflow-hidden bg-white bg-opacity-90 px-6 py-4 shadow-md sm:max-w-4xl sm:rounded-lg mx-auto">
                {children}
            </div>
        </div>
    );
}
