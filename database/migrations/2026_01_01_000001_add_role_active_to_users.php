<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void{Schema::table('users',function(Blueprint $t){if(!Schema::hasColumn('users','role'))$t->string('role')->default('agent');if(!Schema::hasColumn('users','active'))$t->boolean('active')->default(true);});}
 public function down():void{Schema::table('users',function(Blueprint $t){if(Schema::hasColumn('users','active'))$t->dropColumn('active');if(Schema::hasColumn('users','role'))$t->dropColumn('role');});}
};
