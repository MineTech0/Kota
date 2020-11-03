<?php

namespace Tests;

use Illuminate\Support\Facades\DB;

trait RefreshTable {


    public function RefreshTable($table) : void
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table($table)->truncate();
        DB::statement("SET foreign_key_checks=1");
    }
}
