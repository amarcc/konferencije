<?php

namespace App\Http\Controllers;

use App\Models\Lokacija;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LokacijaController extends Controller
{
    use AuthorizesRequests;

    public function __construct(){
        $this -> authorizeResource(Lokacija::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locs = Lokacija::latest() -> get();

        return view('lokacija.index', ['locs' => $locs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lokacija.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request -> validate([
            'ime' => 'string|min:3|max:150|required',
            'adresa' => 'string|min:3|max:150|required',
            'br_mjesta' => 'integer|required'
        ]);

        Lokacija::create([
            ...$validated
        ]);

        return redirect() -> route('lokacija.index') -> with('success', 'Lokacija je kreirana');
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
        //
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
    public function destroy(Lokacija $lokacija)
    {   
        $lokacija -> delete();
        return redirect() -> route('lokacija.index') -> with('success', 'Lokacija je izbrisna');
    }
}
