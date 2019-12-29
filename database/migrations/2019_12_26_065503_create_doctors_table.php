<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        Schema::create('doctors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('_key')->unique()->comment('key'); // Key is reserve keyword so we change the name as 'name'
            $table->text('value')->comment('value'); // address as value
            $table->datetime('TTL')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Remove the store of value after 5 min'); // Event schedular implements in the Mysql Engine 
            $table->timestamps();

            $this->upEvent(); // TTL 5 min
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('doctors');
        $this->dropEvent();
    }

    public function upEvent(){
        $event = "SET GLOBAL event_scheduler = ON; 
                      CREATE EVENT TTL_Schedular
                        ON SCHEDULE EVERY 300 SECOND STARTS '2019-12-26 16:00:00' ENABLE
                        DO 
                        DELETE FROM doctors WHERE TTL < NOW() - INTERVAL 300 SECOND";

        DB::unprepared($event);
    }

    public function dropEvent(){
        DB::unprepared("DROP EVENT IF EXISTS `TTL_Schedular` ");
    }
}
