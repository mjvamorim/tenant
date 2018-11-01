<?php
namespace Amorim\Tenant;


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Amorim\Tenant\Models\Company;

class TenantConfigDB {

    public static function createCompany(array $data)
    {
        $company = Company::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'db_host' => Config::get('database.connections.main.host') , 
            'db_username' => Config::get('database.connections.main.username') , 
            'db_password' => Config::get('database.connections.main.password') 
        ]);
        $company->db_database = Config::get('database.connections.main.database').$company->id;
        $company->save();
        self::createDatabase($company);
        return($company);
    }

    public static function createDatabase(Company $company)
    {
        $sql = 'create database if not exists '.$company->db_database;
        DB::statement($sql);
    }

    public static function createTenantTables() {
        if(!Schema::connection('tenant')->hasTable('doctors')) {
            Schema::connection('tenant')->create('doctors', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('postal_code')->nullable();
                $table->string('street')->nullable();
                $table->string('number')->nullable();
                $table->string('complement')->nullable();
                $table->string('district')->nullable();
                $table->string('city')->nullable();
                $table->string('state')->default('RJ')->nullable();
                $table->string('country')->default('Brasil')->nullable();
                $table->string('email')->nullable();
                $table->string('mobile')->nullable();
                $table->string('phone')->nullable();
                $table->timestamps();
            });
        }
    }
    
}