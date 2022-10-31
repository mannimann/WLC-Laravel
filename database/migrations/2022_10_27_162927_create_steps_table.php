<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("steps", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("vorname");
            $table->string("klasse");
            $table->string("zeitraum"); // später noch ändern: Zeitraum in andere Tabelle auslagern -> von/bis
            $table->integer("schritte");
            // später hinzufügen: Schule / Schul-id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("steps");
    }
};
