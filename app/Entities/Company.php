<?php

namespace BookStack\Entities;

use Illuminate\Database\Eloquent\Model;
use BookStack\Users\Models\User;

class Company extends Model
{
    protected $fillable = ['name', 'description', 'active'];
    
    // Valor padrão para o campo active
    protected $attributes = [
        'active' => true,
    ];

    // Escopo para consultar apenas empresas ativas
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_company');
    }

    public function pages()
    {
        return $this->belongsToMany(\BookStack\Entities\Models\Page::class, 'page_company_permissions');
    }
    
    // Helper para verificar se a empresa está ativa
    public function isActive()
    {
        return (bool) $this->active;
    }
}