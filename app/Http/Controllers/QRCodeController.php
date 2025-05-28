<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absence;
use App\Models\Etudiant;
use App\Models\Enseignant;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    public function generate($id, $type)
    {
        $url = route('qrcode.scan') . "?id=$id&type=$type";
        return QrCode::size(200)->generate($url);
    }

    public function scan(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|in:etudiant,enseignant'
        ]);

        $date = now()->format('Y-m-d');

        if ($request->type === 'etudiant') {
            $etudiant = Etudiant::findOrFail($request->id);

            Absence::create([
                'etudiant_id' => $etudiant->id,
                'date_absence' => $date,
                'justifie' => false,
                'module_id' => null // À adapter selon vos besoins
            ]);

            return response()->json(['message' => 'Absence enregistrée pour l\'étudiant']);
        } else {
            $enseignant = Enseignant::findOrFail($request->id);

            Absence::create([
                'enseignant_id' => $enseignant->id,
                'date_absence' => $date,
                'justifie' => false,
                'module_id' => null // À adapter selon vos besoins
            ]);

            return response()->json(['message' => 'Absence enregistrée pour l\'enseignant']);
        }
    }
}
