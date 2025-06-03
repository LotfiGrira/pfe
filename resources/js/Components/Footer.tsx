// resources/js/Components/Footer.tsx
import React, { useEffect, useState } from "react";

export default function Footer() {
  const [legalText, setLegalText] = useState<string>("");

  useEffect(() => {
    // Appel API fictif : remplacer l'URL par une vraie si disponible
    fetch("/api/legal-info")
      .then((res) => res.json())
      .then((data) => {
        setLegalText(data.text || "© 2025 موقع المواريث. جميع الحقوق محفوظة.");
      })
      .catch(() => {
        setLegalText("© 2025 موقع المواريث. جميع الحقوق محفوظة.");
      });
  }, []);

  return (
    <footer className="mt-10 border-t border-[#a67c52] pt-6 text-center text-xs text-gray-600 select-none">
      <p>{legalText}</p>
      <p>
        للمزيد من المعلومات، يمكنك زيارة{" "}
        <a
          href="https://wrcati.cawtar.org/preview.php?type=law&ID=10"
          target="_blank"
          rel="noopener noreferrer"
          className="text-blue-700 underline"
        >
          مجلة الأحوال الشخصية التونسية
        </a>
        .
      </p>
    </footer>
  );
}
