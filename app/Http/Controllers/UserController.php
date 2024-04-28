<?php

namespace App\Http\Controllers;

use App\Models\Associate;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::orderBy('name', 'DESC')->paginate(15);
            return view('user.index', compact('users'));
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $associates = Associate::distinct()->where('status', 'complete')->orderBy('first_name', 'ASC')->orderBy('corporate_name', 'ASC')->get();
            return view('user.create', compact('associates'));
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = new User();
            $user->uuid = Str::uuid()->toString();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->associate_id = (isset($request->associate) && !empty($request->associate)) ? $request->associate : null;
            $user->save();

            return redirect(route('user.index'))->with('alert-success', 'Usuário cadastrado com sucesso!');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                return redirect()->back()->with('alert-error', 'Usuário inválido ou inexistente.');
            }
            $user = User::where('uuid', $uuid)->first();
            if (!$user) {
                return redirect()->back()->with('alert-error', 'Usuário inválido ou inexistente.');
            }
            $associates = Associate::distinct()->where('status', 'complete')->orderBy('first_name', 'ASC')->orderBy('corporate_name', 'ASC')->get();
            return view('user.edit', compact('user', 'associates'));
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                return redirect()->back()->with('alert-error', 'Usuário inválido ou inexistente.');
            }
            $user = User::where('uuid', $uuid)->first();
            if (!$user) {
                return redirect()->back()->with('alert-error', 'Usuário inválido ou inexistente.');
            }
            $user->name = $request->name;
            $user->email = $request->email;
            $user->associate_id = (isset($request->associate) && !empty($request->associate)) ? $request->associate : null;

            if (isset($request->password) && !empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            return redirect()->back()->with('alert-success', 'Usuário atualizado com sucesso!');
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
            if (!Str::isUuid($request->user)) {
                return redirect()->back()->with('alert-error', 'Usuário inválido ou inexistente.');
            }
            $user = User::where('uuid', $request->user)->first();
            if (!$user) {
                return redirect()->back()->with('alert-error', 'Usuário inválido ou inexistente.');
            }
            $user->delete();
            return redirect()->back()->with('alert-success', 'Usuário deletado com sucesso!');
        } catch (Exception $ex) {
            return redirect()->back()->with('alert-danger', 'Falha ao deletar, tente mais tarde.');
        }
    }
}
