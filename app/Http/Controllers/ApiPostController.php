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

        $postes = new Postes();
        $postes->InsertPostes($data);

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
                'message' => 'Poste non trouvé'
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
        $poste = (new Postes())->updateById($id, $request->only(['titre', 'contenu']));

        if (!$poste) {
            return response()->json(['message' => 'Poste non trouvé'], 404);
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
            return response()->json(['message' => 'Poste non trouvé'], 404);
        }

        return response()->json(['message' => 'Poste effacé'], 200);
    }



}
