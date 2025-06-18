import React, { useState } from "react";
import axios from "axios";

interface MirathInput {
    hal: "male" | "female";
    alab?: number;
    albanat?: number;
    alom?: number;
    alab_om?: number;
    azawj?: number;
    azawjat?: number;
    akhowat_achaqiq?: number;
    akhowat_l2ab?: number;
    akhowat_lom?: number;
}

export default function CalculMirath() {
    const [formData, setFormData] = useState<MirathInput>({
        hal: "male",
    });

    const [result, setResult] = useState<any>(null);

    const handleChange = (
        e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>
    ) => {
        const { name, value } = e.target;
        setFormData((prev) => ({
            ...prev,
            [name]: name === "hal" ? value : parseInt(value) || 0,
        }));
    };

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        try {
            const response = await axios.post("/api/mirath/calcul", formData);
            setResult(response.data);
        } catch (error: any) {
            console.error(error);
            alert("Erreur lors du calcul.");
        }
    };

    return (
        <div className="max-w-xl mx-auto p-4 bg-white rounded shadow">
            <h2 className="text-xl font-bold mb-4">Calcul du Mirath</h2>
            <form onSubmit={handleSubmit} className="space-y-4">
                <div>
                    <label className="block font-medium">Sexe du défunt</label>
                    <select
                        name="hal"
                        value={formData.hal}
                        onChange={handleChange}
                        className="w-full border p-2 rounded"
                    >
                        <option value="male">Homme</option>
                        <option value="female">Femme</option>
                    </select>
                </div>

                <button
                    type="submit"
                    className="bg-blue-600 text-white px-4 py-2 rounded"
                >
                    Calculer
                </button>
            </form>

            {result && (
                <div className="mt-6 p-4 bg-green-100 border rounded">
                    <h3 className="font-semibold mb-2">Résultat :</h3>
                    <pre className="text-sm">
                        {JSON.stringify(result, null, 2)}
                    </pre>
                </div>
            )}
        </div>
    );
}
