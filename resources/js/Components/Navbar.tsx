import { Fragment, useState } from "react";
import { usePage, Link } from "@inertiajs/react";

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
    <header className="bg-white shadow-md fixed top-0 w-full z-50">
      <div className="container mx-auto px-4 py-3 flex justify-between items-center">
        {/* Logo */}
        <Link
          href="/"
          className="text-2xl font-extrabold text-yellow-800 hover:text-yellow-600 transition-colors"
        >
          المواريث
        </Link>

        {/* Hamburger mobile */}
        <button
          onClick={() => setOpen(!open)}
          className="lg:hidden text-yellow-800 focus:outline-none focus:ring-2 focus:ring-yellow-500 rounded"
          aria-label="Toggle menu"
          aria-expanded={open}
        >
          <svg
            className="w-6 h-6"
            fill="none"
            stroke="currentColor"
            strokeWidth="2"
            viewBox="0 0 24 24"
            aria-hidden="true"
          >
            {open ? (
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="M6 18L18 6M6 6l12 12"
              />
            ) : (
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="M4 6h16M4 12h16M4 18h16"
              />
            )}
          </svg>
        </button>

        {/* Menu */}
        <nav
          className={`${
            open ? "block" : "hidden"
          } lg:flex lg:items-center w-full lg:w-auto mt-4 lg:mt-0`}
        >
          <ul className="flex flex-col lg:flex-row lg:gap-8 gap-4 text-lg text-yellow-900">
            {menu.map((item) => (
              <li key={item.text}>
                <Link
                  href={item.link}
                  className="hover:text-yellow-600 transition-colors block px-2 py-1 rounded"
                >
                  {item.text}
                </Link>
              </li>
            ))}
          </ul>

          {/* User actions */}
          <div className="mt-6 lg:mt-0 lg:ml-10 flex flex-col lg:flex-row items-center gap-4 text-sm">
            {user ? (
              <Fragment>
                <span className="text-gray-700 flex items-center gap-1">
  <svg
    xmlns="http://www.w3.org/2000/svg"
    className="h-5 w-5 text-yellow-700"
    fill="currentColor"
    viewBox="0 0 24 24"
  >
    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" />
    <path fillRule="evenodd" clipRule="evenodd" d="M4 20c0-2.21 3.58-4 8-4s8 1.79 8 4v1H4v-1z" />
  </svg>
  {user.name}
</span>

                <Link
                  href="/dashboard"
                  className="px-3 py-1 bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200 transition"
                >
                  لوحة التحكم
                </Link>
                <Link
                  href={route("profile.edit")}
                  className="px-3 py-1 bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200 transition"
                >
                  الملف الشخصي
                </Link>
                <Link
                  method="post"
                  href={route("logout")}
                  as="button"
                  className="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition"
                >
                  تسجيل الخروج
                </Link>
              </Fragment>
            ) : (
              <Fragment>
                <Link
                  href="/register"
                  className="px-3 py-1 text-yellow-700 border border-yellow-700 rounded hover:bg-yellow-700 hover:text-white transition"
                >
                  تسجيل
                </Link>
                <Link
                  href="/login"
                  className="px-3 py-1 bg-yellow-700 text-white rounded hover:bg-yellow-800 transition"
                >
                  تسجيل الدخول
                </Link>
              </Fragment>
            )}
          </div>
        </nav>
      </div>
    </header>
  );
};

export default Navbar;
