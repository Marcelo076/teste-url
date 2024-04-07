<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedirectLogsTable extends Migration
{
    public function up()
    {
        Schema::create('redirect_logs', function (Blueprint $table) {
            $table->foreignId('redirect_id')->constrained()->onDelete('cascade');
            $table->string('ip');
            $table->text('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->json('query_params')->nullable();
            $table->timestamp('accessed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('redirect_logs');
    }
}

