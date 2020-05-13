<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdFieldLinkTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->integer('user_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::hasColumn('links', 'user_id')) {
            Schema::table('links', function (Blueprint $table) {
                $table->dropColumn('user_id');
            });
        }
    }
}
