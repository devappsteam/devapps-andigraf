<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Associate;
use App\Models\Award;
use App\Models\Product;
use App\Models\Enrollment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AssociateController extends Controller
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
            $associate = new Associate();
            $associate->uuid = Str::uuid()->toString();

            $associate->document = $associate->document = ($request->type == "legal") ? preg_replace("/\D/", "", $request->corporate_document) : preg_replace("/\D/", "", $request->personal_document);

            //Personal
            $associate->first_name = $request->first_name;
            $associate->last_name = $request->last_name;
            $associate->birth_date = $request->birth_date;

            // Corporate
            $associate->corporate_name = $request->corporate_name;
            $associate->fantasy_name = $request->fantasy_name;
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
            $associate->origin = "award";
            $associate->status = "complete";
            $associate->save();

            return response()->json(array(
                'status' => true,
                'data' => $associate
            ));
        } catch (Exception $ex) {
            return response()->json(array(
                'status' => false,
                'message' => "Falha ao cadastrar associado."
            ), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                return response()->json(array(
                    'status' => false,
                    'message' => "Associado inválido ou inexistente."
                ), 404);
            }
            $associate = Associate::where('uuid', $uuid)->first();
            if (!$associate) {
                return response()->json(array(
                    'status' => false,
                    'message' => "Associado inválido ou inexistente."
                ), 404);
            }
            return response()->json(array(
                'status' => true,
                'data' => $associate
            ));
        } catch (Exception $ex) {
            return response()->json(array(
                'status' => false,
                'message' => "Falha ao buscar associado."
            ), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find(string $document)
    {
        try {
            $award = $this->get_award_active();

            $associate = Associate::where('document', $document)->first();
            
            $enrollments = Enrollment::join('enrollment_product', 'enrollment_product.enrollment_id', 'enrollments.id')
            ->where('enrollments.associate_id', $associate->id)->where('enrollments.award_id', $award->id)->pluck('product_id');
            
            $products = Product::where('associate_id', $associate->id)
            ->where('award_id', $award->id)
            ->whereNotIn('id', $enrollments)->get();
            
            $associate->product = $products;
            $associate->product_count = count($enrollments);
            $associate->remaining_free = max(($award->discount - count($enrollments)), 0);
            
            $associate->category = unserialize($associate->category);
            $associate->votes = unserialize($associate->votes);
            
            if (!$associate) {
                return response()->json(array(
                    'status' => false,
                    'message' => "Associado inválido ou inexistente."
                ), 404);
            }
            return response()->json(array(
                'status' => true,
                'data' => $associate
            ));
        } catch (Exception $ex) {
            return response()->json(array(
                'status' => false,
                'message' => "Falha ao buscar associado.",
                'error' => $ex->getMessage()
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
                return response()->json(array(
                    'status' => false,
                    'message' => "Associado inválido ou inexistente."
                ), 404);
            }
            $associate = Associate::where('uuid', $uuid)->first();
            if (!$associate) {
                return response()->json(array(
                    'status' => false,
                    'message' => "Associado inválido ou inexistente."
                ), 404);
            }

            $associate->document = $associate->document = ($request->type == "legal") ? preg_replace("/\D/", "", $request->corporate_document) : preg_replace("/\D/", "", $request->personal_document);

            //Personal
            $associate->first_name = $request->first_name;
            $associate->last_name = $request->last_name;
            $associate->birth_date = $request->birth_date;

            // Corporate
            $associate->corporate_name = $request->corporate_name;
            $associate->fantasy_name = $request->fantasy_name;
            $associate->state_registration = $request->state_registration;
            $associate->municipal_registration = $request->municipal_registration;
            $associate->responsible_first_name = $request->responsible_first_name;
            $associate->responsible_last_name = $request->responsible_last_name;
            $associate->responsible_email = $request->responsible_email;
            $associate->responsible_phone = $request->responsible_phone;
            $associate->responsible_job = $request->responsible_job;
            $associate->category = serialize($request->categories);
            $associate->votes = serialize($request->favorities);
            
            
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

            return response()->json(array(
                'status' => true,
                'data' => $associate
            ));
        } catch (Exception $ex) {
            return response()->json(array(
                'status' => false,
                'message' => "Falha ao buscar associado."
            ), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function get_award_active()
    {
        $award = Award::where('status', 'enable')->first();
        return $award;
    }
}
