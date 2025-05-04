import React from 'react';
import { Link } from '@inertiajs/react';

interface BreadcrumbItem {
  label: string;
  href?: string;
}

interface Props {
  items: BreadcrumbItem[];
}

const Breadcrumbs: React.FC<Props> = ({ items }) => {
  return (
    <nav className="text-sm mb-4 text-gray-600" aria-label="Breadcrumb">
      <ol className="list-none p-0 inline-flex space-x-1">
        {items.map((item, index) => (
          <li key={index} className="flex items-center">
            {item.href ? (
              <Link href={item.href} className="hover:underline text-blue-600">
                {item.label}
              </Link>
            ) : (
              <span className="text-gray-500">{item.label}</span>
            )}
            {index < items.length - 1 && <span className="mx-2">/</span>}
          </li>
        ))}
      </ol>
    </nav>
  );
};

export default Breadcrumbs;
