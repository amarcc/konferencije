<?php

namespace App\Http\Controllers;

use App\Models\Konferencija;
use App\Models\Prijava;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class PrijavaController extends Controller
{

    public function __construct(){
        
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Konferencija $konferencija)
    {
        $kon = Konferencija::firstWhere('id', '=', (int) $request -> input('konferencija_id'));
        $found = Prijava::where('user_id', '=', auth() -> user() -> id) -> where('konferencija_id', '=', $kon -> id);
        if($found -> count() === 0){
            
            if($kon -> br_mjesta != 0) {
                Prijava::create([
                    'user_id' => auth() -> user() -> id,
                    'konferencija_id' => $kon -> id
                ]);
                $kon -> update([
                    'br_mjesta' => $kon -> br_mjesta - 1
                ]); 
                return redirect() -> route('konferencija.show', $kon) -> with('success', 'Prijavili ste se za konferenciju');
            } else {

                return redirect() -> route('konferencija.show', $kon) -> with('error', 'Nema slobodnih mjesta');
            }
        } else {
            return redirect() -> route('konferencija.show', $kon) -> with('error', 'Već ste prijavljeni za konferenciju');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Prijava $prijava)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prijava $prijava)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prijava $prijava)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Konferencija $konferencija, Prijava $prijava)
    {
        $found = Prijava::where('user_id', '=', auth() -> user() -> id) -> where('konferencija_id', '=', $konferencija -> id);

        if($found -> count() != 0) {
            $prijava -> delete();
    
            $konferencija -> update([
                'br_mjesta' => $konferencija -> br_mjesta + 1
            ]); 

            return redirect() -> route('konferencija.show', $konferencija) -> with('error', 'Prijava je poništena');
        } else {
            return redirect() -> route('konferencija.show', $konferencija) -> with('error', 'Nijeste se prijavili za konferenciju');
        }
    }
}
