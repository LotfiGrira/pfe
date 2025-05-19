import React from 'react';
import { PageProps } from '@/types';
import pdfMake from 'pdfmake/build/pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';
import { AmiriFontRegular } from './AmiriFontRegular';
import { AmiriFontBold } from './AmiriFontBold';
// Register the fonts for pdfMake
(pdfFonts as any)['AmiriRegular'] = AmiriFontRegular;
(pdfFonts as any)['AmiriBold'] = AmiriFontBold;
pdfMake.vfs = {
  ...pdfFonts.vfs,
  'AmiriRegular': AmiriFontRegular,
  'AmiriBold': AmiriFontBold,
};
pdfMake.fonts = {
  Amiri: {
    normal: 'AmiriRegular',
    Bold: 'AmiriBold',
  }
};
function decodeUnicode(str: string): string {
  // Safely decode unicode escape sequences like \u0627
  try {
    return JSON.parse(`"${str.replace(/\\/g, '\\\\').replace(/"/g, '\\"')}"`);
  } catch {
    return str; // fallback if parsing fails
  }
}

function reverseWordsInLine(line: string): string {
  return line.split(' ').reverse().join(' ');
}

export default function CasHeritierResult({ result }: PageProps<{ result: any }>) {
  const generatePdf = () => {
    // Split rapport by lines and decode each line
    const rapportLines = (result.rapport || '')
    .split('\n')
    .map(line => reverseWordsInLine(decodeUnicode(line)));

  const docDefinition: any = {
  content: [    
    {
      text: [
        { text: 'tarika:\n', bold: false },
        result.tarika,
      ],
      style: 'rapport',
      font: 'Amiri',
      margin: [0, 20, 0, 10],
    },
    {
      text: reverseWordsInLine('نتيجة حساب الميراث'), // devient "الميراث حساب نتيجة"
      style: 'header',
      alignment: 'right',
      font: 'Amiri',
    },
    {
      text: [
        { text: 'التقرير:\n', bold: false },
        ...rapportLines.map((line: string) => ({ text: line + '\n', alignment: 'right' })),
      ],
      style: 'rapport',
      font: 'Amiri',
      margin: [0, 20, 0, 10],
    },
    {
      text: reverseWordsInLine('تفصيل الأنصبة:'), // pour inverser aussi ce titre si tu veux (devient "الأنصبة: تفصيل")
      style: 'subheader',
      alignment: 'right',
      font: 'Amiri',
      margin: [0, 10, 0, 10],
    },
    {
      table: {
        headerRows: 1,
        widths: ['*', '*'],
        body: [
          [
            { text: "الوارث", style: 'tableHeader', alignment: 'center', font: 'Amiri' },
            { text: "النصيب", style: 'tableHeader', alignment: 'center', font: 'Amiri' }
          ],
          ...result.parts.map((item: any) => [
            { text: item.type, alignment: 'center', font: 'Amiri' },
            { text: item.part.toString(), alignment: 'center', font: 'Amiri' },
          ])
        ]
      },
      layout: 'lightHorizontalLines',
    },
  ],
  defaultStyle: {
    font: 'Amiri',
    alignment: 'right',
    rtl: true,
  },
  styles: {
    header: {
      fontSize: 20,
      bold: false,
    },
    subheader: {
      fontSize: 16,
      bold: false,
    },
    rapport: {
      fontSize: 14,
      italics: false,
    },
    tableHeader: {
      bold: false,
      fontSize: 13,
      color: 'black',
    },
  },
};

    pdfMake.createPdf(docDefinition).open();
  };

  return (
    <div className="p-6 space-y-6">
      <h1 className="text-2xl font-bold">Résultat du Calcul de l’Héritage</h1>

      <div>
        <h2 className="text-xl font-semibold">🧮 Tarika (Total): {result.tarika} unités</h2>
      </div>

      <div>
        <h2 className="text-xl font-semibold">🧮 Rapport :</h2>
        <pre dir="rtl" className="bg-gray-100 p-4 rounded whitespace-pre-wrap">{decodeUnicode(result.rapport)}</pre>
      </div>

      <div>
        <h2 className="text-lg font-semibold">📊 Détail des parts :</h2>
        <table className="min-w-full border border-gray-300">
          <thead>
            <tr className="bg-gray-200">
              <th className="border px-4 py-2">Type d'héritier</th>
              <th className="border px-4 py-2">Part</th>
            </tr>
          </thead>
          <tbody>
            {result.parts?.map((item: any, index: number) => (
              <tr key={index}>
                <td className="border px-4 py-2">{item.type}</td>
                <td className="border px-4 py-2">{item.part}</td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>

      <div>
        <button
          onClick={generatePdf}
          className="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
          Télécharger le PDF
        </button>
      </div>
    </div>
  );
}
