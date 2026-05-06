<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class StaffProfileController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::guard('web')->user();
        $isAdmin = $user->role === 'admin';
        
        $rules = [
            'phone' => 'nullable|string|max:30',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        if ($isAdmin) {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email|unique:users,email,' . $user->id;
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = $request->file('photo')->store('profiles', 'public');
            $validated['photo'] = $path;
        }

        if ($request->filled('password')) {
            $request->validate([
                'current_password' => 'required',
                'password'         => 'required|string|min:6|confirmed',
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
            }

            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
