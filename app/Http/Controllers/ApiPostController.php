<?php

namespace App\Http\Controllers;

use App\Models\Postes;
use Illuminate\Http\Request;

class ApiPostController extends Controller
{
    public function AllPostes()
    {
        return response()->json(Postes::all());
    }

    public function savePostes(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
        ]);

        $poste = (new Postes())->InsertPostes($data);

        if (!$poste) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur, insretion a échoué'
            ], 500);
        }

        return response()->json(
            ['message' => 'Poste inserré'],
            201
        );
    }

    public function getPosteById(int $id)
    {
        $poste = (new Postes())->getById($id);

        if (!$poste) {
            return response()->json([
                'message' => 'Erreur,Poste introuvable'
            ], 404);
        }

        return response()->json([
            'id' => $poste->id,
            'title' => $poste->titre,
            'content' => $poste->contenu,
            'created_at' => $poste->created_at,
            'updated_at' => $poste->updated_at
        ]);
    }

    public function updatePostes(int $id, Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|min:3|max:255',
            'contenu' => 'required|string|min:10',
        ]);

        $poste = (new Postes())->updateById($id, $data);

        if (!$poste) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur, Poste introuvable'
            ], 404);
        }

        return response()->json([
            'id' => $poste->id,
            'title' => $poste->titre,
            'content' => $poste->contenu,
            'created_at' => $poste->created_at,
            'updated_at' => $poste->updated_at
        ]);
    }

    public function deletePostes(int $id)
    {
        $deleted = (new Postes())->deleteById($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Poste non trouvé , impossible de supprimer'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Poste effacé'
        ], 200);
    }



}
