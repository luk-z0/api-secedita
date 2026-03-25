<?php

namespace App\Services;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use App\Models\{Role, User};
use App\Enums\RoleEnum;
use App\Http\Requests\Auth\RegisteredUserRequest;
use App\Http\Requests\User\{PaginationRequest, StoreUserRequest};
use App\Http\Resources\RoleResource;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    /**
     * Create a new class instance.
     */

    public function register(RegisteredUserRequest $request): User
    {
        $request->validated();

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'cpf'        => $request->cpf,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);

        $user->roles()->attach(RoleEnum::USER->id());

        event(new Registered($user));

        return $user;
    }

    public function getAll(PaginationRequest $request)
    {
        $perPage = $request->perPage ?? config('pagination.defaults.per_page');

        return User::query()
            ->latest()
            ->paginate($perPage);
    }

    public function getById(User $user): User
    {
        return $user;
    }

    public function create(StoreUserRequest $request): User
    {
        $request->validated();

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'cpf'        => $request->cpf,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);

        $user->roles()->attach(RoleEnum::USER->id());

        return $user;
    }

    public function update(User $user, array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        return $user;
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function forceDelete(User $user): bool
    {
        return $user->forceDelete();
    }

    public function restore(User $user): User
    {
        $user = User::withTrashed()->findOrFail($user->id);

        if (!$user->trashed()) {
            throw new Exception('User is not deleted');
        }

        $user->restore();
        return $user;
    }

    public function toggleStatus(User $user, array $data): User
    {
        $user->is_active = $data['is_active'];
        $user->save();
        return $user;
    }
    public function roles(): Collection
    {

        return Role::get();
    }

    public function updateRole(User $user, Role $role): User
    {
        $user->roles()->sync([$role->id]);

        return $user->load('roles');
    }
}
