<?php

namespace BookStack\Entities;

use Illuminate\Database\Eloquent\Model;
use BookStack\Users\Models\User;
use Illuminate\Support\Str;

class Company extends Model
{
    protected $fillable = ['name', 'description', 'active', 'slug'];
    
    // Valor padrão para o campo active
    protected $attributes = [
        'active' => true,
    ];

    /**
     * Boot do modelo para garantir que o slug seja preenchido
     */
    protected static function boot()
    {
        parent::boot();
        
        // Gera automaticamente um slug a partir do nome antes de salvar
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
    
    /**
     * Obtém o URL de registro para esta empresa
     */
    public function getRegistrationUrl()
    {
        return url('/empresas/' . $this->slug);
    }
}