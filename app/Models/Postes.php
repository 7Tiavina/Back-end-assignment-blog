<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Postes extends Model
{
    protected $fillable = ['titre', 'contenu'];


    public function InsertPostes(array $data)
    {
        try {
            return DB::insert(
                'INSERT INTO postes (titre, contenu, created_at, updated_at) VALUES (?, ?, ?, ?)',
                [$data['titre'], $data['contenu'], now(), now()]
            );
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function getById(int $id)
    {
        try {
            return DB::selectOne(
                'SELECT id, titre, contenu, created_at, updated_at
                FROM postes
                WHERE id = ?',
                [$id]
            );
        } catch (\Exception $e) {
            return null;        
        }
    }    

    public function getAllPostes()
    {
        try {
            return DB::select(
                'SELECT id, titre, contenu, created_at, updated_at FROM postes'
            );
        } catch (\Exception $e) {
            return [];    
        }
    }    


    public function updateById(int $id, array $data)
    {
        try {
            $updated = DB::update(
            'UPDATE postes SET titre = ?, contenu = ?, updated_at = NOW() WHERE id = ?',
            [$data['titre'], $data['contenu'], $id]
        );

        if ($updated) {
            return $this->getById($id);
        }

        return null;
        
        } catch (\Exception $e) {
            return null;        
        }
    }

    public function deleteById(int $id)
    {
        try {
            $deleted = DB::delete(
                'DELETE FROM postes WHERE id = ?',
                [$id]
            );
            return $deleted;
        } catch (\Exception $e) {
            return false;
        }
    }




}

