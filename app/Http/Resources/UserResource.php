<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'cpf' => $this->maskCpf($this->cpf),
            'position' => $this->position,
            'is_active' => true,
            'email_verified_at' => null,
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }

    private function maskCpf($cpf)
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        return '***.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-**';
    }
}
