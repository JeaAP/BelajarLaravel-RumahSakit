<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Doctor;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::latest()->paginate(5);
        return view('doctors.index', compact('doctors'))->with('i', (request()->input('page', 1) - 1) * 5);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doctors.create')->with('message', 'Tambah data dokter');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_number' => 'required|string|unique:doctors',
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'specialization' => 'required|string|max:255',
            'practice_location' => 'required|string|max:255',
            'practice_hours' => 'required|string|max:255',
        ]);

        Doctor::create($request->all());

        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return view('doctors.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'))->with('message', 'Edit data dokter');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'id_number' => 'required|string',
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'specialization' => 'required|string|max:255',
            'practice_location' => 'required|string|max:255',
            'practice_hours' => 'required|string|max:255',
        ]);

        if($doctor->id_number !== $request->id_number) {
            $request->validate(['id_number' => 'unique:doctors']);
        }

        $doctor->update($request->all());

        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil dihapus.');
    }
}
