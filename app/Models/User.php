<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'avatar_url',
        'is_active',
        'last_login_at',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    public function assignedLeads(): HasMany
    {
        return $this->hasMany(PartnershipLead::class, 'assigned_to');
    }

    public function blogPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }

    public function isAdmin(): bool
    {
        return $this->role?->slug === 'super-admin' || $this->role?->slug === 'admin';
    }

    public function hasRole(string|array $roles): bool
    {
        if (! $this->role) {
            return false;
        }

        if (is_array($roles)) {
            return in_array($this->role->slug, $roles, true);
        }

        return $this->role->slug === $roles;
    }

    public function hasPermission(string $permissionSlug): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (! $this->role) {
            return false;
        }

        return $this->role->permissions->contains('slug', $permissionSlug);
    }
}
