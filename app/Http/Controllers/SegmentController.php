<?php

namespace App\Http\Controllers;

use App\Services\SegmentService;
use Exception;
use Illuminate\Http\Request;

class SegmentController extends Controller
{

    protected $segment;

    public function __construct(SegmentService $segment)
    {
        $this->segment = $segment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->segment->list();
        return view('segment.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('segment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->segment->store($request->all())) {
            return redirect(route('segment.index'))->with('alert-success', 'Segmento cadastrado com sucesso!');
        }

        return redirect(route('segment.index'))->with('alert-danger', 'Falha ao processar sua solicitação, contate o administrador!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit(string $uuid)
    {
        $data = $this->segment->get($uuid);
        return view('segment.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        if ($this->segment->update($uuid, $request->all())) {
            return redirect(route('segment.index'))->with('alert-success', 'Segmento atualizado com sucesso!');
        }

        return redirect(route('segment.index'))->with('alert-danger', 'Falha ao processar sua solicitação, contate o administrador!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if ($this->segment->delete($request->category)) {
            return redirect(route('segment.index'))->with('alert-success', 'Registro removido com sucesso!');
        }

        return redirect(route('segment.index'))->with('alert-danger', 'Falha ao processar sua solicitação, contate o administrador!');
    }
}
