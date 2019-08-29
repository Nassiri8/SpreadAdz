<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class UserDatabase
{
    function getAll()
    {
        $users = DB::table('users')->get();
        return $users;
    }
}
