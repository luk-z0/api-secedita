<?php

namespace App\Services;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use App\Models\{Role, User};
use App\Enums\RoleEnum;
use App\Http\Requests\Auth\RegisteredUserRequest;
use App\Http\Requests\User\{PaginationRequest, StoreUserRequest};
use App\Http\Resources\{RoleResource, UserResource};
use Illuminate\Database\Eloquent\Collection;
use Exception;

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

    public function getAll(PaginationRequest $request): array
    {
        $perPage = $request->perPage ?? config('pagination.defaults.per_page');

        $users = User::query()
        ->with(['roles'])
        ->latest()
        ->paginate($perPage);

        return [
            'data' => UserResource::collection($users),
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage(),
            'per_page' => $users->perPage(),
            'total' => $users->total(),
            'next_page_url' => $users->nextPageUrl(),
            'prev_page_url' => $users->previousPageUrl(),
        ];
    }

    public function getById(User $user): UserResource
    {
        return new UserResource($user);
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

    public function updateRole(User $user, array $data): User
    {
        $roleName = $data['role'] ?? null;
        $enumValue = RoleEnum::tryFrom($roleName);

        if (!$enumValue) {
            abort(422, "The provided role '{$roleName}' is invalid.");
        }

        $role = Role::where('name', $enumValue->value)->first();

        if (!$role) {
          abort(404, "Role record not found in the database.");
        }

        $user->roles()->sync([$role->id]);

        return $user->load('roles');
    }
}
