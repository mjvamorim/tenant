<?php


namespace Amorim\Tenant\Models;

use \Amorim\Tenant\Models\BaseModelTenantMain;

class Company extends BaseModelTenantMain
{

    protected $fillable = [
        'id','name', 'postal_code', 'street','number',
         'complement', 'district', 'city',
        'state','country','email','mobile','phone',
        'db_host', 'db_database', 'db_username', 'db_password', ];
        
    protected $rules = [
        'name' => 'required|min:5|max:50',
        'email' => 'required|email',
    ];

    protected $showable = [
        ['name'=>'id',           'title'=>'Id',          'datatable'=>'false', 'form'=>'false', 'type'=>'id',   ],
        ['name'=>'name',         'title'=>'Nome',        'datatable'=>'true',  'form'=>'true',  'type'=>'text', ],
        ['name'=>'email',        'title'=>'Email',       'datatable'=>'true',  'form'=>'true',  'type'=>'text', ],
        ['name'=>'mobile',       'title'=>'Celular',     'datatable'=>'true',  'form'=>'true',  'type'=>'text', ], 
        ['name'=>'phone',        'title'=>'phone',       'datatable'=>'true',  'form'=>'true',  'type'=>'text', ],
        ['name'=>'postal_code',  'title'=>'Cep',         'datatable'=>'false', 'form'=>'true',  'type'=>'text', ],
        ['name'=>'street',       'title'=>'Street',      'datatable'=>'false', 'form'=>'true',  'type'=>'text', ],
        ['name'=>'number',       'title'=>'Number',      'datatable'=>'false', 'form'=>'true',  'type'=>'text', ],
        ['name'=>'complement',   'title'=>'Complement',  'datatable'=>'false', 'form'=>'true',  'type'=>'text', ],
        ['name'=>'district',     'title'=>'District',    'datatable'=>'false', 'form'=>'true',  'type'=>'text', ],
        ['name'=>'city',         'title'=>'City',        'datatable'=>'false', 'form'=>'true',  'type'=>'text', ],
        ['name'=>'state',        'title'=>'State',       'datatable'=>'false', 'form'=>'true',  'type'=>'text', ],
        ['name'=>'country',      'title'=>'Country',     'datatable'=>'false', 'form'=>'true',  'type'=>'text', ],
        ['name'=>'db_host',      'title'=>'Db_host',     'datatable'=>'false', 'form'=>'true',  'type'=>'text', ],
        ['name'=>'db_database',  'title'=>'Db_database', 'datatable'=>'false', 'form'=>'true',  'type'=>'text', ],
        ['name'=>'db_username',  'title'=>'Db_username', 'datatable'=>'false', 'form'=>'true',  'type'=>'text', ],
        ['name'=>'db_password',  'title'=>'Db_password', 'datatable'=>'false', 'form'=>'true',  'type'=>'text', ],
    ];



}
