<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class AnnonceDatabase
{
    public function getAll()
    {
        $annonces = DB::table('annonces')
        ->join('users', 'annonces.id', '=', 'users.id')
        ->select('users.username', 'annonces.categorie', 'annonces.titre', 'annonces.description', 'annonces.prix', 'annonces.phone', 'annonces.date')
        ->orderBy('date', 'DESC')
        ->get();
        return $annonces;
    }

    public function getAnnonceById($id)
    {
        $annonces = DB::table('annonces')
        ->join('users', 'annonces.id', '=', 'users.id')
        ->where('annonces.id', '=' ,$id)
        ->select('users.username', 'annonces.categorie', 'annonces.titre', 'annonces.description', 'annonces.prix', 'annonces.phone', 'annonces.date')
        ->orderBy('date', 'DESC')
        ->get();
        return $annonces;
    }

    public function getAnnonceByUserId($id)
    {
        $annonces = DB::table('annonces')
        ->join('users', 'annonces.id', '=', 'users.id')
        ->where('annonces.user_id', '=' ,$id)
        ->select('users.username', 'annonces.categorie', 'annonces.titre', 'annonces.description', 'annonces.prix', 'annonces.phone', 'annonces.date')
        ->orderBy('date', 'DESC')
        ->get();
        return $annonces;
    }
}
