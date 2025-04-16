<?php

namespace BookStack\Entities;

use Illuminate\Database\Eloquent\Model;
use BookStack\Users\Models\User;
use Illuminate\Support\Str;

class Company extends Model
{
    // Agora incluindo 'slug' para que ele seja aceito no mass assignment
    protected $fillable = ['name', 'description', 'active', 'slug'];
    
    // Valor padrão para o campo active
    protected $attributes = [
        'active' => true,
    ];

    // Método boot para gerar automaticamente o slug a partir do nome
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($company) {
            if (empty($company->slug)) {
                $company->slug = Str::slug($company->name);
            }
        });

        static::updating(function ($company) {
            if ($company->isDirty('name') && !$company->isDirty('slug')) {
                $company->slug = Str::slug($company->name);
            }
        });
    }

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
