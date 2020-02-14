<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Amorim\Tenant\Models\Empresa;
use Amorim\Tenant\TenantModel;

class User extends Authenticatable
{
    use Notifiable;
    use TenantModel;

    protected $connection = 'main';

    protected $fillable = [
        'name', 'email', 'password','image','mobile','empresa_id',
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
    ];

    protected $showable = [
        ['name'=>'id',         'title'=>'Id',       'datatable'=>'false', 'form'=>'false','type'=>'id',   ],
        ['name'=>'name',       'title'=>'Nome',     'datatable'=>'true',  'form'=>'true', 'type'=>'text', ],
        ['name'=>'email',      'title'=>'Email',    'datatable'=>'true',  'form'=>'true', 'type'=>'text', ],
        ['name'=>'mobile',     'title'=>'Celular',  'datatable'=>'true',  'form'=>'true', 'type'=>'text', ], 
        ['name'=>'empresa_id', 'title'=>'Empresa',  'datatable'=>'false', 'form'=>'true', 'type'=>'fk', 'size'=>'8',
            'options'=> [
                'model'=>'empresa', 'value'=>'id','label'=>'nome',],
        ], 
         ['name'=>'image',      'title'=>'Foto',     'datatable'=>'false', 'form'=>'true', 'type'=>'image', ],
        
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function empresa()
    {
        return $this->belongsTo('Amorim\Tenant\Models\Empresa');
    }

    public function getImage() {
        if($this->image) {
            return '/img/users/'.$this->image;
        } 
        return '/img/users/0000-sem-foto.jpg';
    }

}
