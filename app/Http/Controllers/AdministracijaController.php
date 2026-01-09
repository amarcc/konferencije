<?php

namespace App\Http\Controllers;

use App\Models\Administracija;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class AdministracijaController extends Controller
{

    use AuthorizesRequests;

    public function __construct(){
        $this -> authorizeResource(Administracija::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('administracija.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $username = $request -> input('username');

        if($username){
            $found = User::where('username', $username) -> get();
        }
        
        if(!$username or $found -> count() === 0){
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
        } else {
            $user = $found -> first();
        } 
        

        if($user -> toAdmin() -> exists()){
            return redirect() -> route('administracija.create') -> with('error', 'Nalog je već administator');
        } else {
            Administracija::create([
                'user_id' => $user -> id,
                'datum_zaposljenja' => now()
            ]);
            return redirect() -> route("konferencija.index") -> with('success', 'Admin nalog je napravljen');
        }
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
    public function edit(Administracija $administracija)
    {
        return view('administracija.edit');
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
    public function destroy(Request $request, Administracija $administracija)
    {   
        $username = $request -> input('username');
        if($username != auth() -> user() -> username) {
            $found = User::where('username', $username) -> get();
            if($found -> count() > 0){
                $admin = $found -> first() -> toAdmin();
                if($admin){
                    $admin -> delete();
                    return redirect() -> route('konferencija.index') -> with('success', 'Administrator je obrisan');
                } else {
                    return redirect() -> route('administracija.edit') -> with('error', 'Nalog nije adminstrator');
                }
            } else {
                return redirect() -> route('administracija.edit') -> with('error', 'Nalog ne postoji');
            }
        } else {
            return redirect() -> route('administracija.edit') -> with('error', 'Ne možete obrisati sebe kao administatora');

        }
    }
}
