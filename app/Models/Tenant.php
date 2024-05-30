<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use App\Models\Traits\TenantModelHelpers;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasFactory;
    // use HasUuids;
    use HasDatabase;
    use HasDomains;
    use TenantModelHelpers;

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'plan',
        ];
    }
}
