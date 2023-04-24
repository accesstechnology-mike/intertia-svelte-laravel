<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateASPTable extends Migration
{
    public function up()
    {
        Schema::create('asps', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->length(3);
            $table->integer('user_id')->length(3);
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['Standard', 'DWB']);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asps');
    }
}
