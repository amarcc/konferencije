<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function __construct(){
        $this -> authorizeResource(User::class);
    }
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
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request -> validate([
            'ime' => 'required|min:3',
            'prezime' => 'required|min:3',
            'email' => 'unique:users|email|required',
            'datum_rodjenja' => 'date|required',
            'username' => 'unique:users|required|min:3'
        ]);
        
        $request -> validate([
            'password' => 'required|min:8',
            'rep_password' => 'required|min:8',
        ]);
        
        if($request -> input('password') !== $request -> input('rep_password')){
            return redirect() -> back() -> with('error', 'Passwordi nijesu isti');
        }

        $newpass = Hash::make($request -> input('password'));

        $user = User::create([
            ...$validatedData,
            'password' => $newpass
        ]);


        Auth::login($user, $request -> filled('remember'));

        return redirect() -> intended("/");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('user.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request -> validate([
            'ime' => 'required|min:3',
            'prezime' => 'required|min:3',
            'email' => 'email|required|unique:users,email,' . $user -> id,
            'datum_rodjenja' => 'date|required',
            'username' => 'required|min:3|unique:users,username,' . $user -> id
        ]);
        
        $password = $request -> input('password');
        
        if($password !== null){
            $request -> validate([
                'password' => 'required|min:8',
                'rep_password' => 'required|min:8',
            ]);
            if($password !== $request -> input('rep_password')){
                return redirect() -> back() -> with('error', 'Passwordi nijesu isti');
            }
            $newpass = Hash::make($request -> input('password'));
            $user -> update([
                ...$validatedData,
                'password' => $newpass
            ]);
        } else {
            $user -> update([
                ...$validatedData
            ]);
        }

        Auth::login($user, Auth::viaRemember());

        return redirect() -> route(route: "konferencija.index") -> with('success', 'Uspješno ste promijenili podatke');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
