<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            $product = new Product();
            $product->uuid = Str::uuid()->toString();
            $product->award_id = $this->get_award_active_id();
            $product->associate_id = $request->associate;
            $product->product_category_id = $request->category;
            $product->name = $request->name;
            $product->client = $request->client;
            $product->conclude = $request->conclude;
            $product->special_features = $request->special_features;
            $product->substrate = $request->substrate;
            $product->note = $request->note;
            $product->save();
            $product->print_processes()->sync($request->print_process);

            return response()->json(array(
                'status' => true,
                'data' => $product
            ));
        } catch (Exception $ex) {
            return response()->json(array(
                'status' => false,
                'message' => "Falha ao cadastrar produto."
            ), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                return response()->json(array(
                    'status' => false,
                    'message' => "Produto inválido ou inexistente."
                ), 404);
            }
            $product = Product::where('uuid', $uuid)->first();
            if (!$product) {
                return response()->json(array(
                    'status' => false,
                    'message' => "Produto inválido ou inexistente."
                ), 404);
            }
            return response()->json(array(
                'status' => true,
                'data' => $product
            ));
        } catch (Exception $ex) {
            return response()->json(array(
                'status' => false,
                'message' => "Falha ao buscar produto."
            ), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                return redirect()->back()->with('alert-error', 'Produto inválido ou inexistente.');
            }
            $product = Product::where('uuid', $uuid)->first();
            if (!$product) {
                return redirect()->back()->with('alert-error', 'Produto inválido ou inexistente.');
            }

            $product->award_id = $this->get_award_active_id();
            $product->associate_id = $request->associate;
            $product->product_category_id = $request->category;
            $product->name = $request->name;
            $product->client = $request->client;
            $product->conclude = $request->conclude;
            $product->special_features = $request->special_features;
            $product->substrate = $request->substrate;
            $product->note = $request->note;
            $product->save();
            $product->print_processes()->sync($request->print_process);
            return response()->json(array(
                'status' => true,
                'data' => $product
            ));
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        try {
            if (!isset($request->product) || empty($request->product)) {
                return response()->json(array(
                    'status' => false,
                    'error' => "Produto inválido ou inexistente."
                ));
            }
            $product = Product::where('id', $request->product)->first();
            if (!$product) {
                return response()->json(array(
                    'status' => false,
                    'error' => "Produto inválido ou inexistente."
                ));
            }

            $product->delete();
            return response()->json(array(
                'status' => true,
            ));
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }


    private function get_award_active_id(){
        $award = Award::where('status', 'enable')->first();
        return $award->id;
    }
}
