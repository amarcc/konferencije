<?php

namespace App\Http\Controllers;

use App\Mail\StatusMail;
use App\Models\Konferencija;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;


class RadController extends Controller
{
    public function download(Konferencija $konferencija){
        return Storage::disk('public') -> download($konferencija -> link, $konferencija -> org_file);
    }

    public function ocjena(Konferencija $konferencija){
        return view('rad.ocjena', ['konferencija' => $konferencija]);
    }

    public function status(Request $request, Konferencija $konferencija){
        // $this->authorize('updateStatus', $konferencija);

        $request -> validate([
            'status' => 'required|string|in:odbijeno,odobreno'
        ]);

        $konferencija -> update([
            'status' => $request -> input('status')
        ]);

        Mail::to($konferencija -> toKreator->email)->queue(new StatusMail($konferencija));

        return redirect() -> route('konferencija.index') -> with('success', "Promijenili ste status konferencije");

    }
}
