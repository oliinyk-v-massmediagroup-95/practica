<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPathFieldFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->string('path')->default('');
            $table->string('original_name')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('files', 'path')) {
            Schema::table('files', function (Blueprint $table) {
                $table->dropColumn('path');
            });
        }

        if (Schema::hasColumn('files', 'original_name')) {
            Schema::table('files', function (Blueprint $table) {
                $table->dropColumn('original_name');
            });
        }
    }
}
