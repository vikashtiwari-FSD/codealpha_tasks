<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('attack_logs', function (Blueprint $table) {

        $table->string('request_method')->after('ip_address');

        $table->text('user_agent')->after('route');

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('attack_logs', function (Blueprint $table) {

        $table->dropColumn([
            'request_method',
            'user_agent',
        ]);

    });
}
};
