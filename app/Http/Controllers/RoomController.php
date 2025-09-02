<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rooms;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Rooms::withCount('examinations')->get();

        return view('rooms.index', compact('rooms'));
    }


    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|unique:rooms',
            'room_name' => 'required',
            'capacity' => 'required|integer',
            'location' => 'required'
        ]);

        $exists = Rooms::where('room_id', $request->room_id)->exists();
        if ($exists) {
            return redirect()->back()->withErrors(['room_id' => 'Room ID sudah digunakan.'])->withInput();
        }

        Rooms::create($request->all());
        return redirect()->route('rooms.index')->with('success', 'Data ruangan berhasil ditambahkan.');
    }

    public function edit(Rooms $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Rooms $room)
    {
        $request->validate([
            'room_id' => 'required|unique:rooms,room_id,' . $room->id,
            'room_name' => 'required',
            'capacity' => 'required|integer',
            'location' => 'required'
        ]);

        if ($room->room_id !== $request->room_id) {
            $exists = Rooms::where('room_id', $request->room_id)->exists();
            if ($exists) {
                return redirect()->back()->withErrors(['room_id' => 'Room ID sudah digunakan.'])->withInput();
            }
        }

        $currentPatients = $room->examinations()->count();
        $newCapacity = (int) $request->capacity;

        if ($newCapacity < $currentPatients) {
            return redirect()->back()->withErrors([
                'capacity' => 'Kapasitas tidak boleh kurang dari jumlah pemeriksaan yang sedang berlangsung.'
            ])->withInput();
        }

        $status = $room->status;
        if ($newCapacity > $currentPatients) {
            $status = 'available';
        } elseif ($newCapacity == $currentPatients) {
            $status = 'occupied';
        }

        $updateData = [
            'room_id' => $request->room_id,
            'room_name' => $request->room_name,
            'capacity' => $newCapacity,
            'location' => $request->location,
            'status' => $status,
        ];

        $room->update($updateData);

        return redirect()->route('rooms.index')->with('success', 'Data ruangan berhasil diperbarui.');
    }


    public function destroy(Rooms $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Data ruangan berhasil dihapus.');
    }
}
