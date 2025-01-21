<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Folder;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('session_id');
            $table->foreignIdFor(User::class)->refrecnes('id')->on('users')->default(1);
            $table->foreignIdFor(Folder::class)->refrecnes('id')->on('folders')->default(1);;
            $table->timestamp('created_at')->useCurrent();  
            $table->timestamp('updated_at')->useCurrent(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('photos');
    }
};
