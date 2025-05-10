// resources/js/Components/Footer.tsx

export default function Footer() {
    return (
      <footer className="bg-gray-800 text-white py-6 mt-12">
        <div className="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
          <p className="text-sm">&copy; {new Date().getFullYear()} الموارث. جميع الحقوق محفوظة.</p>
          <div className="flex space-x-4 mt-4 md:mt-0">
            <a href="#" className="hover:underline">من نحن</a>
            <a href="#" className="hover:underline">المساعدة</a>
            <a href="#" className="hover:underline">تواصل معنا</a>
          </div>
        </div>
      </footer>
    );
  }
  