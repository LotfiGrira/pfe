import GuestLayout from "@/Layouts/GuestLayout";
import { PageProps } from "@/types";
import { Link } from "@inertiajs/react";
import Footer from "@/Components/Footer";
import { useState } from "react";

type Props = {
  text: string;
};

function ScrollBox({ title, items }: { title: string; items: string[] }) {
  return (
    <div
      className="bg-[url('/images/parchment.png')] bg-no-repeat bg-cover bg-center p-6 text-[#3e2f1c] font-[Arial] leading-relaxed shadow-md"
      style={{ minHeight: "320px", backgroundSize: "100% 100%" }}
    >
      <h2 className="text-center text-xl font-bold mb-4 border-b border-[#a67c52] pb-2">
        {title}
      </h2>
      <ul className="list-disc list-inside space-y-2 text-right text-sm">
        {items.map((item, i) => (
          <li key={i}>{item}</li>
        ))}
      </ul>
    </div>
  );
}

export default function About({ text }: PageProps<Props>) {
  const [nom, setNom] = useState("");
  const [commentaire, setCommentaire] = useState("");
  const [commentaires, setCommentaires] = useState<
    { nom: string; commentaire: string }[]
  >([]);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (nom && commentaire) {
      setCommentaires([...commentaires, { nom, commentaire }]);
      setNom("");
      setCommentaire("");
    }
  };

  const references = [
    "📚 أهم الكتب في المواريث على القانون التونسي",
    "1. \"شرح مجلة الأحوال الشخصية التونسية\" – عبد العزيز العشّ\nمن أشهر الكتب التي شرحت قوانين المواريث وفق المجلة.\n\nيتناول الوصية الواجبة، الحجب، والأنصبة بتفصيل دقيق.",
    "2. \"المواريث في القانون التونسي\" – د. فرج القصير\nكتاب جامعي ومرجعي يُقارن بين فقه المواريث الإسلامي والتطبيق التونسي.\n\nيشرح كيفية التوفيق بين الشريعة والمجلة.",
    "3. \"الشرح النظري والعملي لمجلة الأحوال الشخصية\" – محمود عبد الجليل\nيضم أمثلة تطبيقية حول تقسيم التركة حسب القوانين التونسية.\n\nمهم لفهم الجانب العملي في تطبيق المواريث.",
    "4. \"الوصية الواجبة في القانون التونسي\" – دراسة أكاديمية / رسائل ماجستير\nبعض الجامعات التونسية نشرت بحوثًا متخصصة في هذا المجال.\n\nيمكن الرجوع إليها كمصادر فقهية وقانونية.",
    "5. \"الوصية الواجبة في التشريع التونسي والمقارن\" – دراسات مقارنة\nيناقش الفرق بين القانون التونسي وغيره من القوانين العربية كالمصري والمغربي.",
    "⚖️ مصادر أخرى هامة:",
    "📄 مجلة الأحوال الشخصية التونسية (1956) – قانون رسمي\nالمرجع الأساسي لتقسيم الإرث في تونس.",
    "📑 أحكام محكمة التعقيب التونسية في المواريث – قضاء\nتحتوي على سوابق قضائية هامة في مسائل الميراث.",
    "🎓 محاضرات في فقه المواريث – كلية الحقوق بتونس\nتشمل التطبيق القانوني والفقهي للميراث."
  ];

  return (
    <GuestLayout>
      <div className="bg-[url('/pattern.png')] bg-repeat min-h-screen text-right text-[#3e2f1c] font-[Arial]">
        <div className="max-w-6xl mx-auto px-6 py-12 space-y-10 bg-[#fdf7e3] shadow-lg border border-[#a67c52]">
          {/* En-tête */}
          <h1 className="text-3xl font-bold text-center text-[#4b3e28] mb-6">
            موقع المواريث
          </h1>

          {/* 3 colonnes explicatives */}
          <div className="grid md:grid-cols-3 gap-6 text-sm">
            <div className="bg-[#f8f1d4] border border-[#c2a76e] p-4 rounded shadow-sm">
              <h2 className="text-lg font-bold mb-2 text-center">حاسبة الميراث</h2>
              <p>
                هذا الموقع متخصص في حلّ مسائل الميراث إلكترونيًا بدقة وسرعة.
                يعتمد على قواعد الفقه الإسلامي، مع الالتزام بمجلة الأحوال الشخصية
                التونسية...
              </p>
              <Link
                href="/calculator"
                className="mt-4 w-full inline-block text-center bg-[#a45e2d] text-white py-2 rounded hover:bg-[#874b1f]"
              >
                حساب مسألة ميراث
              </Link>
            </div>

            <div className="bg-[#f8f1d4] border border-[#c2a76e] p-4 rounded shadow-sm">
              <h2 className="text-lg font-bold mb-2 text-center">
                أعقد مسائل المواريث
              </h2>
              <p>
                يتمتع الموقع بقدرة عالية على معالجة أعقد مسائل الميراث بكل دقة
                ووضوح...
              </p>
              <Link
                href="/examens/liste"
                className="mt-4 w-full inline-block text-center bg-[#a45e2d] text-white py-2 rounded hover:bg-[#874b1f]"
              >
                اختبر نفسك
              </Link>
            </div>

            <div className="bg-[#f8f1d4] border border-[#c2a76e] p-4 rounded shadow-sm">
              <h2 className="text-lg font-bold mb-2 text-center">تسهيل التعلم</h2>
              <p>
                يوفر النظام إمكانية الاطلاع على المراجع القانونية المعتمدة
                المتعلقة بفقه المواريث...
              </p>
              <button className="mt-4 w-full bg-[#a45e2d] text-white py-2 rounded hover:bg-[#874b1f]">
                مراجع قانونية
              </button>
            </div>
          </div>

          {/* Parchemin Section */}
          <div className="grid md:grid-cols-2 gap-6 mt-10">
            <ScrollBox
              title="آخر المسائل المحلولة"
              items={[
                "مات وترك: ابن (2) و ابن ابن و بنت و بنت ابن و أخ شقيق (2) و أخت شقيقة",
                "مات وترك: أولاد ابن متعدّدين (3) ابن – توفي ابنه في حياة الميت – و أولاد بنات متوفاة",
                "مات وترك: زوجة و ابن (4) و بنت (3) و أولاد ابن متعدّدين",
              ]}
            />
            <ScrollBox
              title="جديد الموقع"
              items={[
                "الوصية الواجبة و استثناؤها بالقانون",
                "دراسة تقييم برنامج حساب المواريث",
                "مسائل الميراث المعقّدة و الخاصة و كيفية حلّها",
                "أهم مسائل المواريث مع الحلول",
              ]}
            />
          </div>

          {/* Références */}
          <div className="mt-10">
            <ScrollBox
              title="أهم المراجع المُعتمد عليها فى حاسبة المواريث"
              items={references}
            />
          </div>

          {/* Statistiques */}
          <div className="bg-[#fffce9] border border-[#d4c39d] p-6 rounded shadow-sm">
            <p className="leading-loose text-md">
              موقع المواريث هو الابتكار الوحيد القادر على حل كافة أشكال قضايا
              المواريث المعقدة إلكترونيًا...
              <br />
              قام الموقع بحل وتقسيم <strong>5391</strong> مسألة ميراث خلال العامين الماضيين.
              <br />
              يقبل الموقع الملاحظات وطلبات التحسين باستمرار من أجل تطويره.
            </p>
          </div>

          {/* Formulaire de commentaire */}
          <div className="bg-[#f8f1d4] border border-[#c2a76e] p-6 rounded shadow-sm mt-10">
            <h2 className="text-xl font-bold mb-4 text-center">💬 شاركنا رأيك</h2>
            <form onSubmit={handleSubmit} className="space-y-4">
              <div>
                <label className="block text-sm mb-1">الاسم:</label>
                <input
                  type="text"
                  value={nom}
                  onChange={(e) => setNom(e.target.value)}
                  className="w-full border border-[#c2a76e] rounded px-3 py-2"
                  required
                />
              </div>
              <div>
                <label className="block text-sm mb-1">التعليق:</label>
                <textarea
                  value={commentaire}
                  onChange={(e) => setCommentaire(e.target.value)}
                  className="w-full border border-[#c2a76e] rounded px-3 py-2"
                  rows={3}
                  required
                />
              </div>
              <button
                type="submit"
                className="bg-[#a45e2d] text-white py-2 px-6 rounded hover:bg-[#874b1f]"
              >
                إرسال التعليق
              </button>
            </form>

            {/* Affichage des commentaires */}
            <div className="mt-6 space-y-4">
              {commentaires.map((c, i) => (
                <div key={i} className="border-t pt-2 text-right">
                  <p className="font-bold">{c.nom}</p>
                  <p>{c.commentaire}</p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
      <Footer />
    </GuestLayout>
  );
}
