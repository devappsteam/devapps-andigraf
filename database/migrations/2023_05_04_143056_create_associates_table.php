<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associates', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('document', 20);

            //Personal
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('birth_date', 20)->nullable();

            // Corporate
            $table->string('corporate_name')->nullable();
            $table->string('fantasy_name')->nullable();
            $table->string('state_registration', 20)->nullable();
            $table->string('municipal_registration', 20)->nullable();
            $table->string('responsible_first_name')->nullable();
            $table->string('responsible_last_name')->nullable();
            $table->string('responsible_email')->nullable();
            $table->string('responsible_phone', 20)->nullable();
            $table->string('responsible_job')->nullable();

            $table->string('phone', 20);
            $table->string('email');
            $table->string('whatsapp', 20)->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_twitter')->nullable();
            $table->string('social_youtube')->nullable();
            $table->string('postcode', 10);
            $table->string('address');
            $table->string('number', 5)->nullable();
            $table->string('complement', 100)->nullable();
            $table->string('district');
            $table->string('city');
            $table->string('state', 2);
            $table->string('country', 2)->nullable()->default('BR');
            $table->enum('type', array('legal','physical'))->default('legal');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('associates');
    }
}
