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
        Schema::table('users', function (Blueprint $table) {
            //Drop the name column, will be replaced by first and last name
            $table->dropColumn('name');

            //Add fields
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->string('phone_number')->nullable()->after('password');
            $table->enum('role', ['customer', 'admin'])->default('customer')->after('phone_number');
            $table->boolean('password_changed')->default(false)->after('password');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //Drop the added columns and add back 'name'  column
            $table->dropColumn(['first_name', 'last_name', 'phone_number', 'role', 'password_changed']);
            $table->string('name')->after('id');
        });
    }
};
