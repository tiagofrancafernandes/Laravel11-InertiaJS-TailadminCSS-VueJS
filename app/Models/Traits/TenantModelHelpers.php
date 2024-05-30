<?php

namespace App\Models\Traits;

use App\Models\Tenant;

trait TenantModelHelpers
{
    public function initialize(): null|bool|Tenant
    {
        if (!is_a($this, Tenant::class)) {
            return false;
        }

        tenancy()->initialize($this);

        return tenant();
    }

    public function init(): null|bool|Tenant
    {
        $this->initialize();
    }

    public static function initialized()
    {
        return tenancy()->tenant;
    }

    public function initializedAsThis()
    {
        if (!is_a($this, Tenant::class)) {
            return false;
        }

        return (tenancy()->tenant?->id == $this->{'id'} ?? null);
    }

    public static function end()
    {
        tenancy()->end();
    }

    public static function initById(int|string $tenantId): null|bool|Tenant
    {
        return static::initializeById($tenantId);
    }

    public static function initializeById(int|string $tenantId): null|bool|Tenant
    {
        $tenant = static::where('id', $tenantId)->first();

        if (!$tenant) {
            return false;
        }

        tenancy()->initialize($tenant);

        return static::initialized();
    }
}
