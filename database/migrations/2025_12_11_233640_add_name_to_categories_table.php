<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * create_categories_table already adds `name`, so on a fresh database this column
     * exists and adding it again fails. Only add it to databases created before that.
     */
    public function up(): void
    {
        if (Schema::hasColumn('categories', 'name')) {
            return;
        }

        Schema::table('categories', function (Blueprint $table) {
            $table->string('name')->unique();
        });
    }

    public function down(): void
    {
        // `name` belongs to create_categories_table; dropping the table there removes it.
    }
};
