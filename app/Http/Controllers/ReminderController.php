<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ordenar por próximos eventos (ignorando el año si es anual)
        // Para simplificar y hacerlo muy robusto, traemos todos y los ordenamos en PHP,
        // ya que la lógica de ignorar el año en SQL puede ser compleja dependiendo del motor.
        $reminders = Reminder::all()->map(function ($reminder) {
            $reminder->next_date = $this->calculateNextDate($reminder->reminder_date, $reminder->frequency);
            $reminder->days_left = now()->startOfDay()->diffInDays($reminder->next_date, false);
            return $reminder;
        })->filter(function ($reminder) {
            // Mostrar solo los que no han pasado este año, o si pasaron que muestre el del próximo año (ya calculado)
            return $reminder->days_left >= 0;
        })->sortBy('days_left')->values();

        return view('reminders.index', compact('reminders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reminders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'reminder_date' => 'required|date',
            'frequency' => 'required|in:unico,anual,mensual',
            'notes' => 'nullable|string'
        ]);

        Reminder::create($validated);

        return redirect()->route('reminders.index')->with('success', 'Recordatorio creado correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reminder $reminder)
    {
        return view('reminders.edit', compact('reminder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reminder $reminder)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'reminder_date' => 'required|date',
            'frequency' => 'required|in:unico,anual,mensual',
            'notes' => 'nullable|string'
        ]);

        $reminder->update($validated);

        return redirect()->route('reminders.index')->with('success', 'Recordatorio actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reminder $reminder)
    {
        $reminder->delete();
        return redirect()->route('reminders.index')->with('success', 'Recordatorio eliminado.');
    }

    /**
     * Helper to calculate the next occurrence of a date based on frequency.
     */
    public static function calculateNextDate($date, $frequency)
    {
        $now = now()->startOfDay();
        $eventDate = \Carbon\Carbon::parse($date)->startOfDay();

        if ($frequency === 'unico') {
            return $eventDate;
        }

        if ($frequency === 'anual') {
            $eventThisYear = $eventDate->copy()->year($now->year);
            if ($eventThisYear->isBefore($now)) {
                return $eventThisYear->addYear();
            }
            return $eventThisYear;
        }

        if ($frequency === 'mensual') {
            $eventThisMonth = $eventDate->copy()->year($now->year)->month($now->month);
            if ($eventThisMonth->isBefore($now)) {
                return $eventThisMonth->addMonth();
            }
            return $eventThisMonth;
        }

        return $eventDate;
    }
}
