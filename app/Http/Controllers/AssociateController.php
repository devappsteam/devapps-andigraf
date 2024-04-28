<?php

namespace App\Http\Controllers;

use App\Mail\Newsletter;
use App\Models\Associate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AssociateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $associates = Associate::query();

            if(isset($request->search) && !empty($request->search)){
                $associates->where('document', 'LIKE', "%{$request->search}%")
                ->orWhere('corporate_name', 'LIKE', "%{$request->search}%")
                ->orWhere('fantasy_name', 'LIKE', "%{$request->search}%")
                ->orWhere('first_name', 'LIKE', "%{$request->search}%")
                ->orWhere('email', 'LIKE', "%{$request->search}%");
            }

            if(isset($request->status) && !empty($request->status)) {
                $associates->where('status', $request->status);
            }

            if(isset($request->origin) && !empty($request->origin)) {
                $associates->where('origin', $request->origin);
            }

            $associates = $associates->orderBy('created_at', 'DESC')->paginate(15);
            return view('associate.index', compact('associates'));
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            return view('associate.create');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function public_create()
    {
        try {
            return view('associate.public');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $associate = new Associate();
            $associate->uuid = Str::uuid()->toString();

            $associate->document = ($request->type == "legal") ? preg_replace("/\D/", "", $request->corporate_document) : preg_replace("/\D/", "", $request->personal_document);

            //Personal
            $associate->first_name = $request->first_name;
            $associate->last_name = $request->last_name;
            $associate->birth_date = $request->birth_date;

            // Corporate
            $associate->corporate_name = ucwords(strtolower($request->corporate_name));
            $associate->fantasy_name = ucwords(strtolower($request->fantasy_name));
            $associate->state_registration = $request->state_registration;
            $associate->municipal_registration = $request->municipal_registration;
            $associate->responsible_first_name = $request->responsible_first_name;
            $associate->responsible_last_name = $request->responsible_last_name;
            $associate->responsible_email = $request->responsible_email;
            $associate->responsible_phone = $request->responsible_phone;
            $associate->responsible_job = $request->responsible_job;

            $associate->phone = $request->phone;
            $associate->email = $request->email;
            $associate->whatsapp = $request->whatsapp;
            $associate->social_facebook = $request->social_facebook;
            $associate->social_instagram = $request->social_instagram;
            $associate->social_twitter = $request->social_twitter;
            $associate->social_youtube = $request->social_youtube;
            $associate->postcode = $request->postcode;
            $associate->address = $request->address;
            $associate->number = $request->number;
            $associate->complement = $request->complement;
            $associate->district = $request->district;
            $associate->city = $request->city;
            $associate->state = $request->state;
            $associate->country = $request->country;
            $associate->type = $request->type;
            $associate->origin = "manual";
            $associate->status = "complete";
            $associate->save();
            return redirect(route('associate.index'))->with('alert-success', 'Associado cadastrado com sucesso!');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Associate  $associate
     * @return \Illuminate\Http\Response
     */
    public function edit(String $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                return redirect()->back()->with('alert-error', 'Associado inválido ou inexistente.');
            }
            $associate = Associate::where('uuid', $uuid)->first();
            if (!$associate) {
                return redirect()->back()->with('alert-error', 'Associado inválido ou inexistente.');
            }
            return view('associate.edit', compact('associate'));
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function profile(){
        $associate = Associate::where('id', Auth::user()->associate_id)->first();
        return view('associate.edit', compact('associate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Associate  $associate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                return redirect()->back()->with('alert-error', 'Associado inválido ou inexistente.');
            }
            $associate = Associate::where('uuid', $uuid)->first();
            if (!$associate) {
                return redirect()->back()->with('alert-error', 'Associado inválido ou inexistente.');
            }

            $associate->document = ($request->type == "legal") ? preg_replace("/\D/", "", $request->corporate_document) : preg_replace("/\D/", "", $request->personal_document);

            //Personal
            $associate->first_name = $request->first_name;
            $associate->last_name = $request->last_name;
            $associate->birth_date = $request->birth_date;

            // Corporate
            $associate->corporate_name = ucwords(strtolower($request->corporate_name));
            $associate->fantasy_name = ucwords(strtolower($request->fantasy_name));
            $associate->state_registration = $request->state_registration;
            $associate->municipal_registration = $request->municipal_registration;
            $associate->responsible_first_name = $request->responsible_first_name;
            $associate->responsible_last_name = $request->responsible_last_name;
            $associate->responsible_email = $request->responsible_email;
            $associate->responsible_phone = $request->responsible_phone;
            $associate->responsible_job = $request->responsible_job;

            $associate->phone = $request->phone;
            $associate->email = $request->email;
            $associate->whatsapp = $request->whatsapp;
            $associate->social_facebook = $request->social_facebook;
            $associate->social_instagram = $request->social_instagram;
            $associate->social_twitter = $request->social_twitter;
            $associate->social_youtube = $request->social_youtube;
            $associate->postcode = $request->postcode;
            $associate->address = $request->address;
            $associate->number = $request->number;
            $associate->complement = $request->complement;
            $associate->district = $request->district;
            $associate->city = $request->city;
            $associate->state = $request->state;
            $associate->country = $request->country;
            $associate->type = $request->type;
            $associate->status = "complete";
            $associate->save();
            return redirect()->back()->with('alert-success', 'Associado atualizado com sucesso!');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Associate  $associate
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        try {
            if (!Str::isUuid($request->associate)) {
                return redirect()->back()->with('alert-error', 'Associado inválido ou inexistente.');
            }
            $associate = Associate::where('uuid', $request->associate)->first();
            if (!$associate) {
                return redirect()->back()->with('alert-error', 'Associado inválido ou inexistente.');
            }
            $associate->delete();
            return redirect()->back()->with('alert-success', 'Associado deletado com sucesso!');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function public_store(Request $request)
    {
        try {
            $associate = new Associate();
            $associate->uuid = Str::uuid()->toString();

            $associate->document = ($request->type == "legal") ? preg_replace("/\D/", "", $request->corporate_document) : preg_replace("/\D/", "", $request->personal_document);

            //Personal
            $associate->first_name = $request->first_name;
            $associate->last_name = $request->last_name;
            $associate->birth_date = $request->birth_date;

            // Corporate
            $associate->corporate_name = ucwords(strtolower($request->corporate_name));
            $associate->fantasy_name = ucwords(strtolower($request->fantasy_name));
            $associate->state_registration = $request->state_registration;
            $associate->municipal_registration = $request->municipal_registration;
            $associate->responsible_first_name = $request->responsible_first_name;
            $associate->responsible_last_name = $request->responsible_last_name;
            $associate->responsible_email = $request->responsible_email;
            $associate->responsible_phone = $request->responsible_phone;
            $associate->responsible_job = $request->responsible_job;

            $associate->phone = $request->phone;
            $associate->email = $request->email;
            $associate->whatsapp = $request->whatsapp;
            $associate->social_facebook = $request->social_facebook;
            $associate->social_instagram = $request->social_instagram;
            $associate->social_twitter = $request->social_twitter;
            $associate->social_youtube = $request->social_youtube;
            $associate->postcode = $request->postcode;
            $associate->address = $request->address;
            $associate->number = $request->number;
            $associate->complement = $request->complement;
            $associate->district = $request->district;
            $associate->city = $request->city;
            $associate->state = $request->state;
            $associate->country = $request->country;
            $associate->type = $request->type;
            $associate->origin = "site";
            $associate->status = "complete";
            $associate->save();
            return redirect()->back()->with('alert-success', 'Associado cadastrado com sucesso!');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
    
    
    public function newsletter()
    {
        try {
            $associates = Associate::distinct()->where('status', 'complete')->orderBy('first_name', 'ASC')->orderBy('corporate_name', 'ASC')->get();
            return view('associate.newsletter', compact('associates'));
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function send_mail(Request $request)
    {
        try {
            if (isset($request->associates) && !empty($request->associates)) {
                if (in_array("all", $request->associates)) {
                    $associates = Associate::distinct()->where('status', 'complete')->pluck('email');
                } else {
                    $associates = $request->associates;
                }

                foreach ($associates as $associate) {
                    if (filter_var($associate, FILTER_VALIDATE_EMAIL)) {
                        Mail::to($associate)->send(new Newsletter($request->content));
                    }
                }
            }
            return redirect()->back()->with('alert-success', 'E-mail enviado com sucesso!');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
}
