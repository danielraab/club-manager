<?php

use App\Models\Member;
use App\Models\MemberGroup;
use App\Models\User;
use App\Models\UserPermission;
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
        Schema::create('member_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();

            $table->foreignId('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('member_groups')->onDelete('set null');

            $table->smallInteger("sort_order")->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('title_pre')->nullable();
            $table->string('title_post')->nullable();
            $table->boolean('paused')->default(false);
            $table->date('birthday')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('street')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->date('entrance_date');
            $table->date('leaving_date')->nullable();

            $table->foreignIdFor(User::class, 'creator_id')->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');

            $table->foreignIdFor(User::class, 'last_updater_id')->nullable();
            $table->foreign('last_updater_id')->references('id')->on('users')->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('member_member_group', function (Blueprint $table) {
            $table->foreignIdFor(Member::class, 'member_id');
            $table->foreignIdFor(MemberGroup::class, 'member_group_id');
            $table->foreign('member_id')->references('id')
                ->on('members')->onDelete('cascade');
            $table->foreign('member_group_id')->references('id')
                ->on('member_groups')->onDelete('cascade');
        });

        UserPermission::create([
            'id' => Member::MEMBER_SHOW_PERMISSION,
            'label' => 'Show members and member groups',
            'is_default' => false,
        ]);
        UserPermission::create([
            'id' => Member::MEMBER_EDIT_PERMISSION,
            'label' => 'Create, edit and delete members and member groups',
            'is_default' => false,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member');
        Schema::dropIfExists('member_groups');
        Schema::dropIfExists('member_member_group');
        UserPermission::find(Member::MEMBER_SHOW_PERMISSION)?->delete();
        UserPermission::find(Member::MEMBER_EDIT_PERMISSION)?->delete();
    }
};
