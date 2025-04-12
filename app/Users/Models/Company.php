<?php

namespace BookStack\Entities;

use BookStack\App\Model;
use BookStack\Users\Models\User;

class Company extends Model
{
    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_company');
    }

    public function pages()
    {
        return $this->belongsToMany(\BookStack\Entities\Models\Page::class, 'page_company_permissions');
    }
}