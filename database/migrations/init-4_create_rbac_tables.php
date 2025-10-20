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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // admin, manager, user, etc.
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->boolean('is_system')->default(false); // Không cho xóa/sửa
            $table->timestamps();

            $table->index('name');
        });
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // users.create, posts.delete, etc.
            $table->string('display_name');
            $table->string('group')->nullable(); // users, posts, settings
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('name');
            $table->index('group');
        });

        // Bảng trung gian: user - role (nhiều-nhiều)
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'role_id']);
            $table->index('user_id');
            $table->index('role_id');
        });

        // Bảng trung gian: role - permission (nhiều-nhiều)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['role_id', 'permission_id']);
            $table->index('role_id');
            $table->index('permission_id');
        });

        // Bảng quyền trực tiếp cho user (override role)
        Schema::create('permission_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->boolean('is_granted')->default(true); // true=grant, false=revoke
            $table->timestamps();

            $table->unique(['user_id', 'permission_id']);
            $table->index('user_id');
            $table->index('permission_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
