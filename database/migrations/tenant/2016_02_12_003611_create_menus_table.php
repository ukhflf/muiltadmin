<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenusTable extends Migration
{
    /**
     * 备注防止忘记 :.
     *
     * 设计中所有的 media_id 将被替换为事件
     */

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->unsigned()->comment('所属公众号');
            $table->tinyInteger('sort')->nullable()->default(0)->comment('排序');
            $table->json('menus')->nullable()->comment('菜单');
            $table->timestamps();
            // 外键
            $table->foreign('account_id')->references('id')->on('accounts')->unUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
