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

        if(!Schema::connection('tenant')->hasTable('proprietarios')) {
            Schema::connection('tenant')->create('proprietarios', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nome')->nullable();
                $table->string('email')->nullable();
                $table->string('celular')->nullable();
                $table->string('fixo')->nullable();
                $table->string('cpf')->nullable();
                $table->string('cep',9)->nullable();
                $table->string('rua')->nullable();
                $table->string('numero')->nullable();
                $table->string('complemento')->nullable();
                $table->string('bairro')->nullable();
                $table->string('cidade')->nullable();
                $table->string('uf')->nullable();
                $table->string('pais')->nullable();
                $table->timestamps();
            });
        }
        if(!Schema::connection('tenant')->hasTable('unidades')) {
            Schema::connection('tenant')->create('unidades', function (Blueprint $table) {
                $table->increments('id');
                $table->string('descricao',30);
                $table->float('fator',8,5)->nullable()->default(1);
                $table->unsignedInteger('proprietario_id');
                $table->text('obs')->nullable();
                $table->string('boleto_impresso',1)->default('N');
                $table->timestamps();
                $table->foreign('proprietario_id')->references('id')->on('proprietarios');
            });
        }
        if(!Schema::connection('tenant')->hasTable('taxas')) {
            Schema::connection('tenant')->create('taxas', function (Blueprint $table) {
                $table->increments('id');
                $table->string('anomes');
                $table->date('dtvencto'); 
                $table->float('valor',8,2);
                $table->timestamps();
            });
        }
        if(!Schema::connection('tenant')->hasTable('acordos')) {
            Schema::connection('tenant')->create('acordos', function (Blueprint $table) {
                $table->increments('id');
                $table->date('data');
                $table->unsignedInteger('unidade_id');
                $table->string('termos')->nullable();
                $table->timestamps();
                $table->foreign('unidade_id')->references('id')->on('unidades');
            });
        }
        if(!Schema::connection('tenant')->hasTable('debitos')) {
            Schema::connection('tenant')->create('debitos', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('unidade_id');
                $table->enum('tipo', ['mensalidade', 'acordo', 'avulso', 'multa',])->default('mensalidade');
                $table->string('obs')->nullable();    
                $table->unsignedInteger('taxa_id')->nullable();
                $table->unsignedInteger('acordo_id')->nullable();
                $table->date('dtvencto');
                $table->float('valor',8,2);
                $table->date('dtpagto')->nullable();
                $table->float('valorpago',8,2)->nullable();
                $table->unsignedInteger('acordo_quitacao_id')->nullable();
                $table->timestamps();

                $table->foreign('unidade_id')->references('id')->on('unidades');
                $table->foreign('taxa_id')->references('id')->on('taxas');
                $table->foreign('acordo_id')->references('id')->on('acordos');
                $table->foreign('acordo_quitacao_id')->references('id')->on('acordos');
                
            });
        }

    }
    
}

// $table->increments('id');
// $table->unsignedInteger('user_id');
// $table->unsignedInteger('plan_id');
// $table->date('start_at');
// $table->date('end_at')->nullable();
// $table->integer('charge_day');
// $table->integer('trialdays')->default(0)->nullable();
// $table->enum('status', ['active', 'inactive', 'delayed', 'ontrial',])->default('inactive');
// $table->string('refnumber');
// $table->timestamps();
// $table->foreign('user_id')->references('id')->on('users');
// $table->foreign('plan_id')->references('id')->on('plans');