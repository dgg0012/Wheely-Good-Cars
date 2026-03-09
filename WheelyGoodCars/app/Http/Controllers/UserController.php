<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()->paginate(15)->withQueryString();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        if (Auth::id() != $user->id && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        if(Auth::id() != $user->id && !Auth::user()->is_admin){
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }
        $user->update($validated);
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        if(Auth::id() != $user->id && !Auth::user()->is_admin){
            abort(403, 'Unauthorized action.');
        }
        $user->forceDelete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Disable the specified resource.
     */
    public function disable(string $id){
        $user = User::findOrFail($id);
        if(Auth::id() != $user->id && !Auth::user()->is_admin){
            abort(403, 'Unauthorized action.');
        }
        
        $user->delete();
        $restoreUrl = URL::signedRoute('users.restore', ['id' => $user->id]);
        Mail::to($user->email)->send(new \App\Mail\UserDisabledMail($user, $restoreUrl));
        return redirect()->route('users.index')->with('success', 'User disabled successfully.');
    }

    /**
     * Restore the specified resource.
     */
    public function restore(string $id){
        $user = User::withTrashed()->findOrFail($id);
        if(!$user->trashed()){
            return redirect()->route('users.index')->with('info', 'User is not disabled.');
        }

        if($user->deleted_at < now()->subDays(30)){
            try{
                return redirect()->route('users.index')->with('error', 'Restore link has expired.');
            }
            catch(\Exception $e){
                return redirect()->route('users.index')->with('error', 'Invalid restore link.');
            }
        }
        
        $user->restore();
        return redirect()->route('users.index')->with('success', 'User restored successfully.');
    }
}
