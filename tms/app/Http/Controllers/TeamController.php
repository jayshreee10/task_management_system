<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // Store method for creating a new team
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'members' => 'required|array', // Make sure members is an array
            'members.*' => 'exists:users,id', // Ensure each member is a valid user ID
            'leads' => 'required|array',     // Make sure leads is an array
            'leads.*' => 'exists:users,id',  // Ensure each lead is a valid user ID
        ]);

        // Create the team and store the data, including the members and leads
        $team = Team::create([
            'name' => $request->name,
            'description' => $request->description,
            'members' => $request->members,  // Store the array of user IDs
            'leads' => $request->leads,      // Store the array of lead user IDs
        ]);

        // Redirect to the team index or another page
        return redirect()->route('teams.index');
    }
}
