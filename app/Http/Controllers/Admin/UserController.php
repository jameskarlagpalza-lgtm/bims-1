<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'campus'])
            ->whereHas('roles', function ($query) {
                $query->where('name', 'campus');
            })
            ->get();

        $campuses = Campus::all();

        return view('admin.users.index', compact('users', 'campuses'));
    }


    public function assignCampus(Request $request, User $user)
    {
        $request->validate([
            'campus_id' => 'nullable|exists:campuses,id',
        ]);

        $user->campus_id = $request->campus_id;
        $user->save();

        return back()->with('success', 'Campus assigned successfully.');
    }

    public function bulkAssignCampus(Request $request)
    {
        $request->validate([
            'campus_id' => 'required|exists:campuses,id',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
        ]);

        $userIds = $request->user_ids;
        $campusId = $request->campus_id;

        User::whereIn('id', $userIds)->update(['campus_id' => $campusId]);

        $count = count($userIds);
        return back()->with('success', "Campus assigned successfully to {$count} user" . ($count > 1 ? 's' : '') . '.');
    }

    public function saveAllAssignments(Request $request)
    {
        $request->validate([
            'assignments' => 'required|array',
            'assignments.*' => 'nullable|exists:campuses,id',
        ]);

        $assignments = $request->assignments;
        $savedCount = 0;

        foreach ($assignments as $userId => $campusId) {
            $user = User::find($userId);
            if ($user) {
                $user->campus_id = $campusId;
                $user->save();
                $savedCount++;
            }
        }

        return back()->with('success', "All assignments saved successfully. {$savedCount} user" . ($savedCount !== 1 ? 's' : '') . ' updated.');
    }
}
