<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->text('en_title')->nullable();
            $table->text('es_title')->nullable();
            $table->longText('en_body')->nullable();
            $table->longText('es_body')->nullable();
            $table->integer('category_id')->unsigned()->index('category_id');
            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade');
            $table->integer('domain_id')->unsigned()->index('domain_id');
            $table->foreign('domain_id')->references('id')->on('domains')
                ->onDelete('cascade');
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->tinyInteger('is_published')->default(0);
            $table->date('published_date')->nullable();
            $table->tinyInteger('allow_comments')->default(0);
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
        Schema::dropIfExists('articles');
    }
}
