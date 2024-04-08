<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    //  to create new migration file: php artisan make:migration create_users_table

        // to execute/create tables from the migrations : php artisan migrate

        // to empty all tables and re run the migrations: php artisan migrate:fresh
        

    public function up(): void
    {
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
