import { Link } from "@inertiajs/react";
import React from "react";

const ListItem = ({
    NavLink,
    children,
}: {
    NavLink: string;
    children: React.ReactNode;
}) => (
    <li>
        <Link
            href={NavLink}
            className="text-sm text-gray-800 hover:text-primary font-medium transition-colors"
        >
            {children}
        </Link>
    </li>
);

export default ListItem;
