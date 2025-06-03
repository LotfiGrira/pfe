import React from "react";
import { PageProps } from "@/types";
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
import { AmiriFontRegular } from "./AmiriFontRegular";
import { AmiriFontBold } from "./AmiriFontBold";
import GuestLayout from "@/Layouts/GuestLayout";
import Footer from "@/Components/Footer";

// Register the fonts for pdfMake
(pdfFonts as any)["AmiriRegular"] = AmiriFontRegular;
(pdfFonts as any)["AmiriBold"] = AmiriFontBold;
pdfMake.vfs = {
    ...pdfFonts.vfs,
    AmiriRegular: AmiriFontRegular,
    AmiriBold: AmiriFontBold,
};
pdfMake.fonts = {
    Amiri: {
        normal: "AmiriRegular",
        bold: "AmiriBold",
    },
};

function decodeUnicode(str: string): string {
    try {
        return JSON.parse(
            `"${str.replace(/\\/g, "\\\\").replace(/"/g, '\\"')}"`
        );
    } catch {
        return str;
    }
}

function reverseWordsInLine(line: string): string {
    return line.split(" ").reverse().join(" ");
}

export default function CasHeritierResult({
    result,
}: PageProps<{ result: any }>) {
    const generatePdf = () => {
        const rapportLines = (result.rapport || "")
            .split("\n")
            .map((line) => reverseWordsInLine(decodeUnicode(line)));

        const safiTarika = result.safiTarika || 1;

        const docDefinition: any = {
            content: [
                {
                    text: reverseWordsInLine("نتيجة حساب الميراث"),
                    style: "header",
                    alignment: "right",
                    font: "Amiri",
                },
                {
                    text: [
                        {
                            text: reverseWordsInLine("صافي التركة") + "\n",
                            bold: true,
                        },
`${safiTarika.toFixed(3)} دينار`
                    ],
                    style: "rapport",
                    font: "Amiri",
                    margin: [0, 20, 0, 10],
                },
                {
                    text: [
                        {
                            text: reverseWordsInLine("التقرير") + ":\n",
                            bold: false,
                        },
                        ...rapportLines.map((line: string) => ({
                            text: line + "\n",
                            alignment: "right",
                        })),
                    ],
                    style: "rapport",
                    font: "Amiri",
                    margin: [0, 20, 0, 10],
                },
                {
                    text: reverseWordsInLine("تفصيل الأنصبة:"),
                    style: "subheader",
                    alignment: "right",
                    font: "Amiri",
                    margin: [0, 10, 0, 10],
                },
                {
                    table: {
                        headerRows: 1,
                        widths: ["*", "*", "*", "*"],
                        body: [
                            [
                                {
                                    text: reverseWordsInLine("المبلغ بالدينار"),
                                    style: "tableHeader",
                                    alignment: "center",
                                    font: "Amiri",
                                },
                                {
                                    text: reverseWordsInLine("نصيب الفرد "),
                                    style: "tableHeader",
                                    alignment: "center",
                                    font: "Amiri",
                                },
                                {
                                    text: reverseWordsInLine("النسبة %"),
                                    style: "tableHeader",
                                    alignment: "center",
                                    font: "Amiri",
                                },
                                {
                                    text: reverseWordsInLine("الوارث"),
                                    style: "tableHeader",
                                    alignment: "center",
                                    font: "Amiri",
                                },
                            ],
                            ...result.parts.map((item: any, index: number) => {
                                const count = item.count || 1;
                                const montant = item.part;
                                const individualMontant = montant / count;
                                const pourcentage = (
                                    (montant / result.safiTarika) *
                                    100
                                ).toFixed(2);
                                const denominator = result.commonDenominator;
                                const numerator = Math.round(
                                    montant / (result.safiTarika / denominator)
                                );

                                const montantAffiche =
    count > 1
        ? `${montant.toFixed(3)} دينار (${count} x ${individualMontant.toFixed(3)} دينار)`
        : `${individualMontant.toFixed(3)} دينار`;

                                return [
                                    {
                                        text: montantAffiche,
                                        alignment: "center",
                                        font: "Amiri",
                                    },
                                    {
                                        text: `${numerator} / ${denominator}`,
                                        alignment: "center",
                                        font: "Amiri",
                                    },
                                    {
                                        text: `${pourcentage}%`,
                                        alignment: "center",
                                        font: "Amiri",
                                    },
                                    {
                                        text: item.type,
                                        alignment: "center",
                                        font: "Amiri",
                                    },
                                ];
                            }),
                        ],
                    },
                    layout: "lightHorizontalLines",
                },
            ],
            defaultStyle: {
                font: "Amiri",
                alignment: "right",
                rtl: true,
            },
            styles: {
                header: {
                    fontSize: 20,
                },
                subheader: {
                    fontSize: 16,
                },
                rapport: {
                    fontSize: 14,
                },
                tableHeader: {
                    bold: true,
                    fontSize: 13,
                    color: "black",
                },
            },
        };

        pdfMake.createPdf(docDefinition).open();
    };

    return (
        <GuestLayout>
            <div className="p-6 space-y-6">
                <h1 className="text-2xl font-bold">
                    🧮 نتيجةحساب الميراث 

                </h1>

                <h2 className="text-xl">
                    صافي التركة: {result.safiTarika} دينار
                </h2>

                

                <div>
                    <h2 className="text-xl font-semibold">📋 التقرير :</h2>
                    <pre
                        dir="rtl"
                        className="bg-gray-100 p-4 rounded whitespace-pre-wrap"
                    >
                        {decodeUnicode(result.rapport)}
                    </pre>
                </div>

                <div>
                    <h2 className="text-lg font-semibold">
                        📊 تقسيم تفصيلي :
                    </h2>
                    <table className="min-w-full border border-gray-300">
                        <thead>
                            <tr className="bg-gray-200 text-center">
                                <th className="border px-4 py-2">الوارث</th>
                                <th className="border px-4 py-2">النسبة %</th>
                                <th className="border px-4 py-2">
                                    نصيب الفرد{" "}
                                </th>
                                <th className="border px-4 py-2">
                                    {" "}
                                    نصيب الفرد بالدينار
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {result.parts?.map((item: any, index: number) => {
                                const count = item.count || 1;
                                const montant = item.part;
                                const individualMontant = montant / count;
                                const pourcentage = (
                                    (montant / result.safiTarika) *
                                    100
                                ).toFixed(2);
                                const denominator = result.commonDenominator;
                                const numerator = Math.round(
                                    montant / (result.safiTarika / denominator)
                                );

                             const montantAffiche =
    count > 1
        ? `${montant.toFixed(3)} دينار = (${count} x ${individualMontant.toFixed(3)} دينار)`
        : `${individualMontant.toFixed(3)} دينار`;



                                return (
                                    <tr key={index} className="text-center">
                                        <td className="border px-4 py-2">
                                            {item.type}{" "}
                                        </td>
                                        <td className="border px-4 py-2">
                                            {pourcentage}%{" "}
                                        </td>
                                        <td className="border px-4 py-2 whitespace-pre-line">
                                            {numerator}
                                            <br />
                                            ـــــــــــــ
                                            <br />
                                            {denominator}
                                        </td>
                                        <td className="border px-4 py-2">
                                            {montantAffiche}
                                        </td>
                                    </tr>
                                );
                            })}
                        </tbody>
                    </table>
                </div>

                <div>
                    <button
                        onClick={generatePdf}
                        className="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                    >
                        تحميل على صيغة PDF
                    </button>
                </div>
                {/* Footer */}
                <Footer />
            </div>
        </GuestLayout>
    );
}
