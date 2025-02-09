<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user.
     */
    public function index()
    {
        try {
            $users = User::all();
            return view('admin.user', compact('users'));
        } catch (\Exception $e) {
            \Log::error('Error fetching users: ' . $e->getMessage());
            // Anda dapat mengalihkan kembali ke halaman sebelumnya atau menampilkan view error
            return redirect()->back()->with('error', 'Failed to fetch users.');
        }
    }

    /**
     * Menyimpan user baru.
     */
    public function store(Request $request)
    {
        // Validasi input menggunakan Validator agar bisa menangkap error secara custom
        $validator = Validator::make($request->all(), [
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'phone'                 => 'required|string|max:20',
            'address'               => 'required|string',
            'role'                  => 'required|in:user,admin',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'address'  => $request->address,
                'role'     => $request->role,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User added successfully.',
                'user'    => $user,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error adding user: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to add user.',
            ]);
        }
    }

    /**
     * Memperbarui data user yang ada.
     */
    public function update(Request $request, User $user)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone'   => 'required|string|max:20',
            'address' => 'required|string',
            'role'    => 'required|in:user,admin',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        try {
            $user->update($request->only(['name', 'email', 'phone', 'address', 'role']));
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully.',
                'user'    => $user,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating user: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user.',
            ]);
        }
    }

    /**
     * Menghapus user.
     */
    public function destroy(User $user)
    {
        if (auth()->id() == $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete yourself.'
            ]);
        }
        
        try {
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting user: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user.',
            ]);
        }
    }
}
