<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username', 300);
			$table->string('steamid64');
			$table->text('avatar', 65535);
			$table->timestamps();
			$table->string('steamid');
			$table->text('remember_token', 65535);
			$table->integer('partner')->unsigned();
			$table->float('money', 10, 0)->default(500000);
			$table->text('trade_link', 65535);
			$table->text('accessToken', 65535);
			$table->integer('is_admin');
			$table->string('language', 40);
			$table->integer('support');
			$table->integer('banchat');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
