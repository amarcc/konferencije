<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'usernameoremail' => "required|string",
            'password' => "required|string"
        ]);
        
        $username_or_email = $request -> input('usernameoremail');
        
        $field = filter_var($username_or_email, FILTER_VALIDATE_EMAIL) ? 'email'
        : 'username';
        
        $remember = $request -> filled('remember');

        $check = Auth::attempt([
            $field => $username_or_email,
            'password' => $request -> input('password'),
            
        ], $remember);

        if($check){
            return redirect() -> route('konferencija.index') -> with('success', "Uspješno ste se prijavili");
        } else {
            return redirect() -> back() -> with('error', 'Invalid credentials');
        };

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::logout();
        request() -> session() -> invalidate();
        request() -> session() -> regenerateToken();

        return redirect('/');
    }
}
