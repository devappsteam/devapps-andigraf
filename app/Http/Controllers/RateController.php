<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Rate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rates = Rate::join('awards', 'awards.id', 'rates.award_id')->where('awards.uuid', $request->award)->paginate(20);
        return view('rate.index', compact('rates', 'request'));
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
            if (!isset($request->award) || !Str::isUuid($request->award)) {
                return redirect()->back()->with('alert-danger', 'Premiação obrigatória.');
            }

            $award = Award::where('uuid', $request->award)->first();

            if (!$award) {
                return redirect()->back()->with('alert-danger', 'Premiação inválida ou inexistente.');
            }

            $rate = new Rate();
            $rate->uuid = Str::uuid()->toString();
            $rate->award_id = intval($award->id);
            $rate->quantity = intval($request->quantity);
            $rate->price = $this->convert_string_to_decimal($request->price);
            $rate->save();
            return redirect()->back()->with('alert-success', 'Taxa cadastrada com sucesso.');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $uuid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function delete(string $uuid)
    {
        //
    }

    private function convert_string_to_decimal(string $string)
    {
        return floatval(str_replace(',', '.', str_replace('.', '', $string)));
    }
}
