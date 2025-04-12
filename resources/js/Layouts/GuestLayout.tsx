import { PropsWithChildren } from 'react';
import Navbar from "@/Components/Navbar";

export default function Guest({ children }: PropsWithChildren) {
    const menu = [
        { text: "الرئيسة", link: "/" },
        { text: "حساب المواريث", link: "/calculator" },
        { text: "اختبارات", link: "/exercices/create" },
        { text: "مراجع", link: "/references" },
    ];

    return (
        <div dir="rtl" className="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0">
            <Navbar menu={menu} />

            <div className="mt-2 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg">
                {children}
            </div>
            
        </div>
    );
}