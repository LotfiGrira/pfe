import  {useState} from "react";

import ListItem from "./ListItem";

const Navbar = ({menu}: any) => {
    const [open, setOpen] = useState(false);
  
    return (
      <header className={`flex w-full items-center bg-white dark:bg-dark`}>
        <div className="container">
          <div className=" flex items-center justify-between ">
            <div className="w-60 max-w-full px-4">
              <a href="/#" className="block w-full py-5">
                Mawarith
              </a>
            </div>
            <div className="flex w-full items-center justify-between px-4">
              <div>
                <button
                  onClick={() => setOpen(!open)}
                  id="navbarToggler"
                  className={` ${
                    open && "navbarTogglerActive"
                  } absolute right-4 top-1/2 block -translate-y-1/2 rounded-lg px-3 py-[6px] ring-primary focus:ring-2 lg:hidden`}
                >
                  <span className="relative my-[6px] block h-[2px] w-[30px] bg-body-color dark:bg-white"></span>
                  <span className="relative my-[6px] block h-[2px] w-[30px] bg-body-color dark:bg-white"></span>
                  <span className="relative my-[6px] block h-[2px] w-[30px] bg-body-color dark:bg-white"></span>
                </button>
                <nav
                  // :className="!navbarOpen && 'hidden' "
                  id="navbarCollapse"
                  className={`absolute right-4 top-full w-full max-w-[250px] rounded-lg bg-white px-6 py-5 shadow dark:bg-dark-2 lg:static lg:block lg:w-full lg:max-w-full lg:shadow-none lg:dark:bg-transparent ${
                    !open && "hidden"
                  } `}
                >
                  <ul className="block lg:flex">
                    {menu.map((item: any) => <ListItem key={item.text} NavLink={item.link}>{item.text}</ListItem>)}
                  </ul>
                </nav>
              </div>
              <div className="hidden justify-end pr-16 sm:flex lg:pr-0">
                <a
                  href="/register"
                  className="px-7 py-3 text-base font-medium text-dark hover:text-primary dark:text-white"
                >
                  Sign up
                </a>
  
                <a
                  href="/login"
                  className="px-7 py-3 text-base font-medium text-dark hover:text-primary dark:text-white"
                >
                  Sign in
                </a>
  
              </div>
            </div>
          </div>
        </div>
      </header>
    );
};

export default Navbar;