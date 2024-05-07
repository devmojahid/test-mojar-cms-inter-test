<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Core\Facades\Config;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configs');
    }
    
    /**
     * Create some configs.
    */

    private function _createConfigs(){
        Config::setConfig('app_name', 'Laravel');
        Config::setConfig('app_url', 'http://localhost');
        Config::setConfig('app_debug', true);
        Config::setConfig('app_timezone', 'UTC');
        Config::setConfig('app_locale', 'en');
        Config::setConfig('title', 'Mojar - ERP Software for Business and Enterprises');
        Config::setConfig('description', 'Mojar is a powerful and flexible ERP software for business and enterprises. It is a modern and responsive system that will help you to manage your business.');
        
    }
};