<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 13/05/2015
 * Time: 19:55
 */

namespace Helpers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class ScoutManMigration extends Migration {

    public function addAddress(Blueprint $table){
        $table->string('address_line1');
        $table->string('address_line2')->nullable();
        $table->string('address_line3')->nullable();
        $table->string('address_line4')->nullable();
        $table->string('postal_town');
        $table->string('postal_county')->nullable();
        $table->string('postal_code');
    }
}