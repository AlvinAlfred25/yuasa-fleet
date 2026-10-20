<?php
use Illuminate\Database\Migrations\Migration;use Illuminate\Database\Schema\Blueprint;use Illuminate\Support\Facades\Schema;
return new class extends Migration {public function up():void{Schema::create('customers',function(Blueprint $t){$t->id();$t->string('name');$t->string('phone')->unique();$t->string('email')->nullable()->index();$t->string('customer_type')->default('individual');$t->string('address')->nullable();$t->string('national_id_reference')->nullable();$t->text('notes')->nullable();$t->timestamps();});}public function down():void{Schema::dropIfExists('customers');}};
