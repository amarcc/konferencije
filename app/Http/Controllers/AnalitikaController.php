<?php

namespace App\Http\Controllers;

use App\Models\Konferencija;
use DB;
use Illuminate\Http\Request;

class AnalitikaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $count_kon = DB::table('Konferencija')->count();
        $count_prijave = DB::table('prijava')->count();
        $count_users = DB::table('users')->count();
        $count_kon_allowed = Konferencija::where('status', '=', 'odobreno')->count();
        $count_kon_rejected = Konferencija::where('status', '=', 'odbijeno')->count();

        return view('analitika.index', ['kon' => $count_kon, 'prijave' => $count_prijave, 'users' => $count_users, 'allowed' => $count_kon_allowed, 'rejected' => $count_kon_rejected]);
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
    public function store(Request $request)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
