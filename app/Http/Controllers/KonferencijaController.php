<?php

namespace App\Http\Controllers;

use App\Mail\PredavacMail;
use App\Models\Konferencija;
use App\Models\Lokacija;
use App\Models\Predavaci;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


class KonferencijaController extends Controller
{
    use AuthorizesRequests;

    public function __construct(){
        $this -> authorizeResource(Konferencija::class, options: ['except' => ['create']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $konferencije = Konferencija::latest();

        $filter = $request -> filters;

        if($filter){
            if(auth() -> user()){
                if($filter === 'my'){
                    $konferencije = $konferencije -> where('kreator', '=', auth() -> user() -> id);
                }  else {
                    if(auth() -> user() -> toAdmin() -> exists()){
                        $konferencije = $konferencije -> where('status', '=',$filter);
                    } else {
                        $konferencije = $konferencije -> where('status', '=', 'odobreno');
                    }
                }

            } else {
                $konferencije = $konferencije -> where('status', '=', 'odobreno');
            }
        } else {
            $konferencije = $konferencije -> where('status', '=', 'odobreno');
        }

        $konferencije = $konferencije -> paginate(10);

        return view('konferencija.index', ['konferencije' => $konferencije]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Gate::allows('update', auth()->user())){
            return redirect() -> route('user.create') -> with('error', 'Napravite nalog ili se ulogujte da biste mogli kreirati konferenciju');
        } else{
            $locs = Lokacija::all();
            return view("konferencija.create", ['locs' => $locs]);
        }

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request -> validate([
            'ime' => 'required|string|min:3|max:150',
            'pocetak' => 'required|date',
            'lokacija' => 'required|integer|exists:lokacija,id',
            'professors' => 'required|array|min:1',
            'professors.*' => 'string|exists:users,username',
        ]);

        $request -> validate([
            'file' => 'required|file'
        ]);

        $path = $request -> file('file') -> store('documents', 'public');

        $loc = Lokacija::find($request -> input('lokacija'));
        $time = $request -> input('pocetak');

        $found = Konferencija::when(
            $time,
            fn($query, $time) => $query -> checkForTime($time, $loc -> id)
        ) -> get();

        if($found -> count() === 0){
            $kon = Konferencija::create([
                ...$validatedData,
                'kreator' => auth() -> user() -> id,
                'br_mjesta' => $loc -> br_mjesta,
                'link' => $path,
                'org_file' => $request -> file('file')->getClientOriginalName()
            ]);
            
            $predavaci = $request -> professors;

            foreach($predavaci as $predavac){
                $user = User::firstWhere('username', '=', $predavac);
                Predavaci::create([
                    'user_id' => $user -> id,
                    'konferencija_id' => $kon -> id
                ]);
                Mail::to($user->email)->queue(new PredavacMail($kon));
            }
        } else {
            return redirect() -> route('konferencija.create') -> with('error', 'To vrijeme je već zauzeto');
        }

        return redirect() -> route('konferencija.index') -> with('success', 'Kreirali ste konferenciju');
    }

    /**
     * Display the specified resource.
     */
    public function show(Konferencija $konferencija)
    {
        if(!auth() -> user() -> toAdmin() -> exists() and $konferencija -> status != 'odobreno'){
            return redirect() -> route('konferencija.index') -> with('error', 'Nije dozvoljeno');
        }
        $prijava = null;
        if(auth() -> user()){

            $prijava = auth() -> user() -> toPrijava -> firstWhere('konferencija_id', '=', $konferencija -> id);
        }

        return view('konferencija.show', ['konferencija' => $konferencija, 'predavaci' => $konferencija -> toPredavaci, 'prijava' => $prijava]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Konferencija $konferencija)
    {   
        $locs = Lokacija::all();
        $predavaci = $konferencija -> toPredavaci;
        return view('konferencija.edit', ['konferencija' => $konferencija, 'locs' => $locs, 'predavaci' => $predavaci], );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Konferencija $konferencija)
    {
        $validatedData = $request -> validate([
            'ime' => 'string|required|min:3|max:150',
            'pocetak' => 'date|required',
            'lokacija' => 'required|integer|exists:lokacija,id',
            'professors' => 'required|array|min:1',
            'professors.*' => 'string|exists:users,username'
        ]);

        $loc = Lokacija::find($request -> input('lokacija'));
        $time = $request -> input('pocetak');

        $found = Konferencija::when(
            $time,
            fn($query, $time) => $query -> checkForTime($time, $loc -> id, $konferencija -> id) -> notIncluding($konferencija -> id)
        ) -> get();

        if($found -> count() === 0){
            $konferencija -> update([
                ...$validatedData
            ]);
            
            $file = $request -> file('file');

            if($file){
                $request -> validate([
                    'file' => 'required|file'
                ]);

                Storage::disk('public') -> delete($konferencija -> link);

                $path = $file -> store('documents', 'public');
                $konferencija -> update([
                    'status' => 'ceka',
                    'link' => $path,
                    'org_file' => $file -> getClientOriginalName()
                ]);
            }


        } else {
            return redirect() -> route('konferencija.edit', $konferencija) -> with('error', 'To vrijeme je već zauzeto');
        }
        
        $predavaci = $request -> professors;
        
        $curr_pred = $konferencija -> toPredavaci -> values();
        
        $to_delete = [];
        $to_create = [];
        
        for($i = 0; $i < $curr_pred -> count(); $i++){
            $found = 0;
            foreach($predavaci as $predavac){
                if($curr_pred[$i] -> toUser -> username === $predavac){
                    $found = 1;
                }
            }
            if($found === 0){
                array_push($to_delete, $curr_pred[$i]);
            }
        }

        for($i = 0; $i < count($predavaci); $i++){
            $found = 0;
            foreach($curr_pred as $predavac){
                if($predavac -> toUser -> username === $predavaci[$i]){
                    $found = 1;
                }
            }
            if($found === 0){
                array_push($to_create, $predavaci[$i]);
            }
        }
        
        foreach($to_delete as $predavac){
            $predavac -> delete();
        }

        foreach($to_create as $predavac){
            $user = User::firstWhere('username', '=', $predavac);
            Predavaci::create([
                'user_id' => $user -> id,
                'konferencija_id' => $konferencija -> id
            ]);
            Mail::to($user->email)->queue(new PredavacMail($konferencija));
                

        }
        
        return redirect() -> route('konferencija.show', ['konferencija' => $konferencija]) -> with('success', 'Konferencija je promjenjena');
        
    }
    
    /**
     * Remove the specified resource from storage.
    */
    public function destroy(Konferencija $konferencija)
    {
        $konferencija -> delete();
        return redirect() -> route('konferencija.index') -> with('success', 'Konferencija je izbrisna');
        
    }
}
        