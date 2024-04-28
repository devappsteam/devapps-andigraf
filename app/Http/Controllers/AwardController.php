<?php

namespace App\Http\Controllers;

use App\Models\Award;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AwardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $awards = Award::orderBy('created_at', 'DESC')->paginate(15);
            return view('award.index', compact('awards'));
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
            return view('award.create');
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
            $this->disable_all();
            $award = new Award();
            $award->user_id = Auth::user()->id;
            $award->uuid = Str::uuid()->toString();
            $award->name = $request->name;
            $award->start = $request->start;
            $award->end = $request->end;
            $award->discount = $request->discount;
            $award->description = $request->description;
            $award->save();
            return redirect(route('award.index'))->with('alert-success', 'Premiação cadastrada com sucesso!');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function edit(String $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                return redirect()->back()->with('alert-error', 'Premiação inválida ou inexistente.');
            }
            $award = Award::where('uuid', $uuid)->first();
            if (!$award) {
                return redirect()->back()->with('alert-error', 'Premiação inválida ou inexistente.');
            }
            return view('award.edit', compact('award'));
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                return redirect()->back()->with('alert-error', 'Premiação inválida ou inexistente.');
            }
            $award = Award::where('uuid', $uuid)->first();
            if (!$award) {
                return redirect()->back()->with('alert-error', 'Premiação inválida ou inexistente.');
            }

            $award->name = $request->name;
            $award->start = $request->start;
            $award->end = $request->end;
            $award->discount = $request->discount;
            $award->description = $request->description;
            $award->save();
            return redirect()->back()->with('alert-success', 'Premiação atualizada com sucesso!');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        try {
            if (!Str::isUuid($request->award)) {
                return redirect()->back()->with('alert-error', 'Premiação inválida ou inexistente.');
            }
            $award = Award::where('uuid', $request->award)->first();
            if (!$award) {
                return redirect()->back()->with('alert-error', 'Premiação inválida ou inexistente.');
            }
            $award->delete();
            return redirect()->back()->with('alert-success', 'Premiação deletada com sucesso!');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    private function disable_all()
    {
        try {
            Award::query()->update(['status' => 'disable']);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
}
