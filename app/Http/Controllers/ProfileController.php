<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show(Request $request)
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile form for mobile.
     */
    public function showMobile(Request $request)
    {
        return view('profile.mobile.show', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile edit form.
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Preparar los datos a actualizar
        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        // Solo actualizar la contraseña si se proporcionó una nueva
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        // Debug: ¿Llega el archivo?
        $debugFile = $request->hasFile('profile_photo') ? 'sí' : 'no';
        $debugFileName = $request->hasFile('profile_photo') ? $request->file('profile_photo')->getClientOriginalName() : '';

        // Procesar la foto de perfil si se subió
        if ($request->hasFile('profile_photo')) {
            // Eliminar la foto anterior si existe
            if ($user->profile_photo && \Storage::disk('public')->exists($user->profile_photo)) {
                \Storage::disk('public')->delete($user->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $updateData['profile_photo'] = $path;
        }

        $user->update($updateData);
        $user->refresh(); // <-- Forzar recarga del usuario

        return redirect()->route('profile.show')
            ->with('success', 'Perfil actualizado exitosamente')
            ->with('debug_file', $debugFile)
            ->with('debug_file_name', $debugFileName);
    }
}
