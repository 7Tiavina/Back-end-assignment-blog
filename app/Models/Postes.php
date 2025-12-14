<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Postes extends Model
{
    protected $fillable = ['titre', 'contenu'];


    public function InsertPostes(array $data)
    {
        return DB::insert(
            'INSERT INTO postes (titre, contenu, created_at, updated_at)
            VALUES (?, ?, ?, ?)',
            [$data['titre'], $data['contenu'], now(), now()]
        );
    }

    public function getById(int $id)
    {
        return DB::selectOne(
            'SELECT id, titre, contenu, created_at, updated_at
            FROM postes
            WHERE id = ?',
            [$id]
        );
    }

    public function updateById(int $id, array $data)
    {
        $updated = DB::update(
            'UPDATE postes SET titre = ?, contenu = ?, updated_at = NOW() WHERE id = ?',
            [$data['titre'], $data['contenu'], $id]
        );

        if ($updated) {
            return $this->getById($id);
        }

        return null;
    }

    public function deleteById(int $id)
    {
        $deleted = DB::delete(
            'DELETE FROM postes
            WHERE id = ?',[$id]
        );

        return $deleted;
    }

}

