<?php

namespace App\Http\Controllers;

use App\Services\ProductCategoryService;
use App\Services\SegmentService;
use Exception;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{

    protected $productCategory;
    protected $segments;

    public function __construct(ProductCategoryService $productCategory, SegmentService $segments)
    {
        $this->productCategory = $productCategory;
        $this->segments = $segments;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->productCategory->list();
        return view('product-category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $segments = $this->segments->all();
        return view('product-category.create', compact('segments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->productCategory->store($request->all())) {
            return redirect(route('product.category.index'))->with('alert-success', 'Categoria cadastrada com sucesso!');
        }

        return redirect(route('product.category.index'))->with('alert-danger', 'Falha ao processar sua solicitação, contate o administrador!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit(string $uuid)
    {
        $segments = $this->segments->all();
        $data = $this->productCategory->get($uuid);
        return view('product-category.edit', compact('data', 'segments'));
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
        if ($this->productCategory->update($uuid, $request->all())) {
            return redirect(route('product.category.index'))->with('alert-success', 'Categoria atualizada com sucesso!');
        }

        return redirect(route('product.category.index'))->with('alert-danger', 'Falha ao processar sua solicitação, contate o administrador!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if ($this->productCategory->delete($request->category)) {
            return redirect(route('product.category.index'))->with('alert-success', 'Registro removido com sucesso!');
        }

        return redirect(route('product.category.index'))->with('alert-danger', 'Falha ao processar sua solicitação, contate o administrador!');
    }
}
