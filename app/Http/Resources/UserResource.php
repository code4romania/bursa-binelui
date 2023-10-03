<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;

class UserResource extends Resource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'is_admin' => $this->isOrganizationAdmin(),
            'role' => $this->isOrganizationAdmin()
                ? __('user.roles.admin')
                : __('user.roles.manager'),
        ];
    }
}
