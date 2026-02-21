<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display the specified user details
     */
    public function show(User $user)
    {
        $user->load(['role', 'campaigns']);
        
        $stats = [
            'total_campaigns' => $user->campaigns()->count(),
            'active_campaigns' => $user->campaigns()->where('status', 'active')->count(),
            'pending_campaigns' => $user->campaigns()->where('approval_status', 'pending')->count(),
            'approved_campaigns' => $user->campaigns()->where('approval_status', 'approved')->count(),
        ];
        
        return view('admin.users.show', compact('user', 'stats'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'organization' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'organization' => $request->organization,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!',
            'redirect' => route('dashboard')
        ]);
    }

    /**
     * Remove the specified user from storage
     */
    public function destroy(User $user)
    {
        // Prevent deletion of admin users
        if ($user->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'Admin users cannot be deleted.');
        }

        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return redirect()->route('dashboard')
                ->with('error', 'You cannot delete your own account.');
        }

        $userName = $user->name;
        
        // Handle related records before deletion
        // Option 1: Set foreign keys to null (soft reference)
        $user->campaigns()->update(['created_by' => null]);
        $user->approvedCampaigns()->update(['approved_by' => null]);
        
        // Option 2: You could also delete campaigns if needed
        // $user->campaigns()->delete();
        
        $user->delete();

        return redirect()->route('dashboard')
            ->with('success', "User '{$userName}' has been deleted successfully.");
    }
} 