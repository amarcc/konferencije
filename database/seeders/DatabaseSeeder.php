<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Konferencija;
use App\Models\Administracija;
use App\Models\Lokacija;
use App\Models\Predavaci;
use App\Models\Prijava;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
    */
    public function run(): void
    {
        if (app()->environment('local')) {
            User::factory(600)->create();
            Lokacija::factory(20) -> create();
            
            $users = User::all() -> shuffle();
            $lokacije = Lokacija::all() -> shuffle();

            for($i=0; $i < 60; $i++) {
                $user_id = $users -> random() -> id;
                $lok_id = $lokacije -> random() -> id;
                $broj = $lokacije -> random() -> br_mjesta;
                Konferencija::factory() -> create([
                    "kreator" => $user_id,
                    "lokacija" => $lok_id,
                    "br_mjesta" => $broj
                ]);
            }
        
            $kons = Konferencija::all() -> shuffle() -> values();

            for($i=0; $i < 40; $i++){
                $kon_id = $kons[$i] -> id;
                for($j=0; $j<rand(1, 4); $j++){
                    $user_id = $users -> random() -> id;
                    Predavaci::factory() -> create([
                        'user_id' => $user_id,
                        'konferencija_id' => $kon_id
                    ]);
                }
            } 

            foreach($kons as $kon){
                $kon_id = $kon -> id;
                $limit = rand(1, $kon -> br_mjesta - 1);
                $users = $users -> shuffle() -> values();
                for($i=0; $i < $limit; $i++){
                    $user_id = $users[$i] -> id;
                    Prijava::factory() -> create([
                        'user_id' => $user_id,
                        'konferencija_id' => $kon_id
                    ]);
                }

                $kon -> update([
                    'br_mjesta' => $kon -> br_mjesta - $limit
                ]);
            }

            $users = $users -> shuffle() -> values();
            for($i=0; $i < 20; $i++){
                $user_id = $users[$i] -> id;
                Administracija::factory() -> create([
                    'user_id' => $user_id
                ]);
            }
        }

        
        $user = User::factory() -> create([
            'username' => 'amarhunter01',
            'email' => 'amarcirgic2017@gmail.com',
            'ime' => 'Amar',
            'prezime' => 'Cirgic'
        ]);
    
        Administracija::factory() -> create([
            'user_id' => $user -> id
        ]);
    
        $kon = Konferencija::factory() -> create([
            'ime' => "Upravljanje udaljenim IT timovima",
            'kreator' => $user -> id,
            'pocetak' => now(),
            'status' => 'odobreno',
            'link' => 'documents/seminarski-final.pdf',
            'org_file' => 'documents/seminarski-final.pdf'
        ]);

        Predavaci::factory() -> create([
            'user_id' => $user->id,
            'konferencija_id' => $kon -> id
        ]);
    
        $user = User::factory() -> create([
            'username' => 'admin',
            'email' => 'amarhunter01@gmail.com',
            'ime' => 'Amar',
            'prezime' => 'Cirgic'
        ]);
    
        Administracija::factory() -> create([
            'user_id' => $user -> id
        ]);
    
        $user = User::factory() -> create([
            'username' => 'nijeadmin',
            'email' => 'amarcirgic360@gmail.com',
            'ime' => 'Amar',
            'prezime' => 'Cirgic'
        ]);

    }
}
