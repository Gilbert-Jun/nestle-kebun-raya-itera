<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Get paginated list of users
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 10);
        $perPage = min($perPage, 100); // Limit maximum per page
        
        $users = User::with('roles')
            ->select([
                'id',
                'name',
                'email',
                'avatar',
                'google_id'
            ])
            ->orderBy('name')
            ->paginate($perPage);
        
        // Transform the data to include can_access based on admin role
        $users->getCollection()->transform(function ($user) {
            $user->can_access = $user->hasRole('admin');
            return $user;
        });
        
        return response()->json($users);
    }

    /**
     * Toggle user access permission (admin role)
     */
    public function toggleAccess(Request $request, $id): JsonResponse
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        try {
            if ($user->hasRole('admin')) {
                // Remove admin role
                $user->removeRole('admin');
                $message = 'Admin access removed successfully';
            } else {
                // Add admin role
                $user->assignRole('admin');
                $message = 'Admin access granted successfully';
            }
            
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update access: ' . $e->getMessage()
            ], 500);
        }
    }
} 