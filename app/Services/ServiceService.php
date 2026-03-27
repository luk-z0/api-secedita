<?php
namespace App\Services;

use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;

class ServiceService
{
    public function listServices(bool $adminView = false)
    {
        $query = Service::query();

        if (!$adminView) {
            $query->where('is_active', true);
        }

        return $query->orderBy('name', 'asc')->get();
    }

    public function createService(array $data)
    {
        return DB::transaction(function () use ($data) {

            $cleanDescription = isset($data['description'])
                ? Purifier::clean($data['description'])
                : null;

            return Service::create([
                'name'        => strip_tags($data['name']),
                'sector'      => strip_tags($data['sector']),
                'description' => $cleanDescription,
                'is_active'   => $data['is_active'] ?? true,
                'availability'=> $data['availability'] ?? null,
            ]);
        });
    }

    public function updateService(int $id, array $data)
    {
        $service = Service::findOrFail($id);

        if (isset($data['description'])) {
            $data['description'] = Purifier::clean($data['description']);
        }

        $service->update($data);
        return $service;
    }
}
