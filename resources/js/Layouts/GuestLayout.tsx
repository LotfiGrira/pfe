import { PropsWithChildren } from 'react';
import Navbar from "@/Components/Navbar";

export default function Guest({ children }: PropsWithChildren) {
    const menu = [{
        link: "/", text: "الرئيسة"
    }, {
        link:"/about", text: "حول"
        }, {
        link:"/about", text: "حساب المواربث"
        }, {
        link:"/about", text: "اختبارات"
        }, {
        link:"/about", text: "مراجع"
    }];

    return (
        <div dir="rtl" className="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0">
            <Navbar menu={menu} />

            <div className="mt-2 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg">
                {children}
            </div>
        </div>
    );
}