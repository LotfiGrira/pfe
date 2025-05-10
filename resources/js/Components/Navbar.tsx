import { Fragment, useState } from "react";
import { usePage, Link } from "@inertiajs/react";
import ListItem from "./ListItem";

type MenuItem = {
    text: string;
    link: string;
};

type NavbarProps = {
    menu: MenuItem[];
};

const Navbar = ({ menu }: NavbarProps) => {
    const user = usePage().props.auth?.user;
    const [open, setOpen] = useState(false);

    return (
        <header className="fixed top-0 z-50 w-full bg-white shadow-md dark:bg-dark">
            <div className="container mx-auto px-4">
                <div className="flex items-center justify-between h-16">
                    {/* Logo */}
                    <div className="w-auto">
                        <Link href="/" className="text-xl font-bold text-primary">
                            الموارث
                        </Link>
                    </div>

                    {/* Toggle button (mobile) */}
                    <div className="lg:hidden">
                        <button
                            onClick={() => setOpen(!open)}
                            className="flex flex-col justify-center items-center w-8 h-8 border border-gray-300 rounded"
                        >
                            <span className="block w-5 h-0.5 bg-gray-800 mb-1"></span>
                            <span className="block w-5 h-0.5 bg-gray-800 mb-1"></span>
                            <span className="block w-5 h-0.5 bg-gray-800"></span>
                        </button>
                    </div>

                    {/* Navigation */}
                    <nav
                        className={`${
                            open ? "block" : "hidden"
                        } absolute top-full left-0 w-full bg-white shadow-md px-6 py-4 lg:relative lg:top-0 lg:flex lg:items-center lg:justify-between lg:bg-transparent lg:shadow-none lg:p-0`}
                    >
                        <ul className="flex flex-col gap-4 lg:flex-row lg:gap-8">
                            {menu.map((item) => (
                                <ListItem key={item.text} NavLink={item.link}>
                                    {item.text}
                                </ListItem>
                            ))}
                        </ul>

                        {/* Right: User actions */}
                        <div className="mt-4 lg:mt-0 lg:ml-auto flex items-center gap-4">
                            {user ? (
                                <Fragment>
                                    <span className="text-sm text-gray-700 dark:text-white">
                                        👤 {user.name}
                                    </span>
                                    <Link
                                        href="/dashboard"
                                        className="text-sm text-blue-600 hover:underline"
                                    >
                                        Dashboard
                                    </Link>
                                    <Link
                                        href={route("profile.edit")}
                                        className="text-sm text-blue-600 hover:underline"
                                    >
                                        Profile
                                    </Link>
                                    <Link
                                        href={route("logout")}
                                        method="post"
                                        as="button"
                                        className="text-sm text-red-600 hover:underline"
                                    >
                                        Log Out
                                    </Link>
                                </Fragment>
                            ) : (
                                <Fragment>
                                    <Link
                                        href="/register"
                                        className="text-sm text-gray-700 hover:text-blue-600"
                                    >
                                        Sign Up
                                    </Link>
                                    <Link
                                        href="/login"
                                        className="text-sm text-gray-700 hover:text-blue-600"
                                    >
                                        Sign In
                                    </Link>
                                </Fragment>
                            )}
                        </div>
                    </nav>
                </div>
            </div>
        </header>
    );
};

export default Navbar;

  