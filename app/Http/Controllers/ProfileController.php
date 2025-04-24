<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

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

        // Solo permitir cambiar el rol si no lo ha cambiado antes Y si el campo role viene en el request
        if ($user->role_changed && $request->has('role') && $user->getRoleNames()[0] !== $request->input('role')) {
            return redirect()->back()->with('error', 'Solo puedes cambiar tu rol una vez.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
            'role' => 'sometimes|in:bidder,seller', // Solo validar el rol si viene
        ], [
            'profile_photo.max' => 'La foto debe ser de máximo 5MB.',
            'profile_photo.mimes' => 'La foto debe ser JPG, JPEG, PNG o GIF.',
            'profile_photo.image' => 'El archivo debe ser una imagen.',
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

        // Solo cambiar el rol si es diferente, si no lo ha cambiado antes y si el campo viene en el request
        if (isset($validated['role']) && $user->getRoleNames()[0] !== $validated['role'] && !$user->role_changed) {
            $user->syncRoles([$validated['role']]);
            $updateData['role_changed'] = true;
        }

        $user->update($updateData);
        $user->refresh(); // <-- Forzar recarga del usuario

        // Redirigir a la vista móvil si la petición viene de móvil
        if ($request->is('mobile/*') || $request->routeIs('profile.mobile.update')) {
            return redirect()->route('profile.mobile.show')
                ->with('success', 'Perfil actualizado exitosamente')
                ->with('debug_file', $debugFile)
                ->with('debug_file_name', $debugFileName);
        }
        return redirect()->route('profile.show')
            ->with('success', 'Perfil actualizado exitosamente')
            ->with('debug_file', $debugFile)
            ->with('debug_file_name', $debugFileName);
    }
}
