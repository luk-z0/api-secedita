<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\{CreateAppointmentRequest,AppointmentRequest};
use App\Services\AppointmentService;
use App\Models\Appointment;

class AppointmentController extends Controller
{

    public function __construct(protected AppointmentService $service) {}
    public function index()
    {
        $this->authorize("view", Appointment::class);
        $appointments = $this->service->listAllAppointments();

        return response()->json($appointments);
    }

    public function store(CreateAppointmentRequest $request)
    {
        $this->authorize("create", Appointment::class);
        return response()->json(
            $this->service->createAppointment($request->validated()),
            201
        );
    }

    public function updateStatus(AppointmentRequest $request, Appointment $appointment)
    {
        $this->authorize("update", Appointment::class);
        $updated = $this->service->updateStatus($appointment, $request->status);
        return response()->json($updated);
    }

    public function restore(Appointment $appointment)
    {
        $this->authorize('restore', $appointment);
        return response()->json($this->service->restoreAppointment($appointment));
    }
}
