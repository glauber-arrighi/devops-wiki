<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('bio')->nullable()->after('avatar');
            $table->string('job_title')->nullable()->after('bio');
            $table->string('phone')->nullable()->after('job_title');
            $table->string('location')->nullable()->after('phone');
            $table->json('preferences')->nullable()->after('location');
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bio','job_title','phone','location','preferences']);
        });
    }
};
