<?php

namespace App\Http\Controllers;

use App\Models\Associate;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = $this->user->list();
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
            return view('user.create');
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
            if ($this->user->store($request->all())) {
                return redirect(route('user.index'))->with('alert-success', 'Registro inserido com sucesso!');
            }
            return redirect()->back()->with('alert-danger', 'Ops! Não foi possivel processar sua solicitação, contate o administrador.');
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
                return redirect()->back()->with('alert-danger', 'Código inválido ou não enviado.');
            }

            if (!$user = $this->user->get($uuid)) {
                return redirect()->back()->with('alert-danger', 'Registro inválido ou inexistente.');
            }

            return view('user.edit', compact('user'));
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                return redirect()->back()->with('alert-danger', 'Código inválido ou inexistente.');
            }
            if (!$this->user->update($uuid, $request->all())) {
                return redirect()->back()->with('alert-danger', 'Registro inválido ou inexistente.');
            }
            return redirect()->back()->with('alert-success', 'Registro atualizado com sucesso!');
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
                return redirect()->back()->with('alert-danger', 'Código inválido ou inexistente.');
            }
            if (!$this->user->delete($request->user)) {
                return redirect()->back()->with('alert-danger', 'Usuário inválido ou inexistente.');
            };
            return redirect()->route('user.index')->with('alert-success', 'Registro removido com sucesso.');
        } catch (Exception $ex) {
            return redirect()->back()->with('alert-danger', 'Falha ao deletar, tente mais tarde.');
        }
    }
}
