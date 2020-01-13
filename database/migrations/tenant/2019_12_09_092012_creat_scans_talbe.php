<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatScansTalbe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scans', function (Blueprint $table) {
            $table->increments('id');

            $table->string('app_id');

            $table->string('openid')->comment('粉丝ID');

            $table->string('key')->nullable();  //场景关联关键字

            $table->string('ticket')->comment('二维码票');

            $table->json('menus')->comment('菜单');

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
        Schema::drop('scans');
    }
}
