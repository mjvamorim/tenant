<?php

namespace Amorim\Tenant\Database\Seeds;

use Illuminate\Database\Seeder;
use App\User;
use Amorim\Tenant\Models\Company;
use Illuminate\Support\Facades\Config;

class TenantSeeder extends Seeder
{
    public function run()
    {
        Company::create([
            'name'      => 'Pegasus Sistemas',
            'db_host' => Config::get('tenant.connections.main.host'),
            'db_database' => Config::get('tenant.connections.main.database').'1',
            'db_username' => Config::get('tenant.connections.main.username'),
            'db_password' => Config::get('tenant.connections.main.password'),  
        ]);
       
        User::create([
            'name'      => 'Mauricio Amorim',
            'email'     => 'mjvamorim@gmail.com',
            'password'  => bcrypt('123456'),
            'type'      => 'Admin',
            'company_id'=> '1',
        ]);
    }
}
