<?php

namespace App\Http\Controllers;

use App\Models\Associate;
use App\Models\Award;
use App\Models\Enrollment;
use App\Models\EnrollmentNote;
use App\Models\PrintProcess;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Traits\Award as TraitsAward;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\Enrollment as EnrollmentTrait;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;

class EnrollmentController extends Controller
{
    use TraitsAward;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $enrollments = Enrollment::with([
                'associate:id,first_name,fantasy_name,type',
                'award:id,name'
            ]);

            if (empty(Auth::user()->associate_id)) {
                if (isset($request->associate) && !empty($request->associate)) {
                    $enrollments = $enrollments->where('associate_id', $request->associate);
                }

                if (isset($request->search) && !empty($request->search)) {
                    $enrollments = $enrollments->where('id', $request->search);
                }
            } else {
                $enrollments = $enrollments->where('associate_id', Auth::user()->associate_id);
            }

            if (isset($request->award) && !empty($request->award)) {
                $enrollments = $enrollments->where('award_id', $request->award);
            } else {
                $enrollments = $enrollments->where('award_id', TraitsAward::active());
            }

            $enrollments = $enrollments->orderBy('created_at', 'DESC')->paginate(15);

            if (empty(Auth::user()->associate_id)) {
                $associates = Associate::distinct()->where('status', 'complete')->orderBy('first_name', 'ASC')->orderBy('corporate_name', 'ASC')->get();
            } else {
                $associates = [Associate::where('id', Auth::user()->associate_id)->first()];
            }

            $awards = Award::orderBy('name')->get();

            return view('enrollment.index', compact('enrollments', 'associates', 'awards'));
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
            if (empty(Auth::user()->associate_id)) {
                $awards = Award::orderBy('name')->get();
                $associates = Associate::distinct()->where('status', 'complete')->orderBy('first_name', 'ASC')->orderBy('corporate_name', 'ASC')->get();
                return view('enrollment.create', compact('associates', 'awards'));
            } else {
                $award = TraitsAward::active();
                $enrollment = new Enrollment();
                $enrollment->uuid = Str::uuid()->toString();
                $enrollment->award_id = $award;
                $enrollment->associate_id = Auth::user()->associate_id;
                $enrollment->status = 'draft';
                $enrollment->save();
                return redirect()->route('enrollment.edit', ['uuid' => $enrollment->uuid]);
            }
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
        DB::beginTransaction();
        try {

            if (!empty(Auth::user()->associate_id)) {
                $associate = Auth::user()->associate_id;
            } else {
                $associate = $request->associate;
            }

            $enrollment = new Enrollment();
            $enrollment->uuid = Str::uuid()->toString();
            $enrollment->award_id = $request->award;
            $enrollment->associate_id = $associate;
            $enrollment->payment_type = $request->payment_type ?? 'credit_card';
            $enrollment->status = $request->status;
            $enrollment->discount = 0;
            $enrollment->subtotal = 0;
            $enrollment->save();
            $enrollment->products()->sync($request->products);
            $enrollment->notes()->create(array(
                'uuid' => Str::uuid()->toString(),
                'note' => $request->note,
                'type' => $request->note_type
            ));
            DB::commit();

            return redirect()->route('enrollment.edit', ['uuid' => $enrollment->uuid])->with('alert-success', 'Inscrição cadastrada com sucesso!');
        } catch (Exception $ex) {
            DB::rollBack();
            dd($ex->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function edit(string $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                return redirect()->back()->with('alert-error', 'Inscrição inválida ou inexistente.');
            }
            $enrollment = Enrollment::with([
                'products',
                'notes'
            ])->where('uuid', $uuid)->first();

            if (!$enrollment) {
                return redirect()->back()->with('alert-error', 'Inscrição inválida ou inexistente.');
            }

            if (empty(Auth::user()->associate_id)) {
                $associates = Associate::distinct()->orderBy('first_name', 'ASC')->orderBy('corporate_name', 'ASC')->get();
                $awards = Award::orderBy('name')->get();
                return view('enrollment.edit', compact('enrollment', 'associates', 'awards'));
            } else {
                $print_processes = PrintProcess::orderBy('name')->get();
                $categories = ProductCategory::orderBy('name')->get();
                return view('enrollment.associate', compact('enrollment', 'print_processes', 'categories'));
            }
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function product(Request $request)
    {
        DB::beginTransaction();
        try {
            $product = new Product();
            $product->uuid = Str::uuid()->toString();
            $product->award_id = $request->award;
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

            $enrollment = Enrollment::where('id', $request->enrollment)->first();
            $enrollment->products()->attach($product->id);
            DB::commit();
            return redirect()->back()->with('alert-success', 'Seu produto foi adicionado com sucesso! Continue adicionando mais produtos, se desejar.');
        } catch (Exception $ex) {
            DB::rollBack();
            dd($ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $uuid)
    {
        DB::beginTransaction();
        try {
            if (!Str::isUuid($uuid)) {
                return redirect()->back()->with('alert-error', 'Inscrição inválida ou inexistente.');
            }
            $enrollment = Enrollment::where('uuid', $uuid)->first();
            if (!$enrollment) {
                return redirect()->back()->with('alert-error', 'Inscrição inválida ou inexistente.');
            }

            $enrollment->payment_type = $request->payment_type ?? 'credit_card';
            $enrollment->status = $request->status;
            $enrollment->save();
            if(!$request->checkout){
                $enrollment->products()->sync($request->products);
                $enrollment->notes()->create(array(
                    'uuid' => Str::uuid()->toString(),
                    'note' => "Inscrição atualizada por " . Auth::user()->name,
                    'type' => "manual"
                ));
            }else{
                $enrollment->notes()->create(array(
                    'uuid' => Str::uuid()->toString(),
                    'note' => $request->note,
                    'type' => "system"
                ));
            }
            DB::commit();

            if ($request->checkout) {
                return redirect()->route('enrollment.checkout', ['uuid' => $enrollment->uuid]);
            }

            return redirect()->back()->with('alert-success', 'Inscrição atualizada com sucesso!');
        } catch (Exception $ex) {
            DB::rollBack();
            dd($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function view(string $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                return redirect()->back()->with('alert-error', 'Inscrição inválida ou inexistente.');
            }
            $enrollment = Enrollment::with('products', 'associate', 'notes')->where('uuid', $uuid)->first();
            if (!$enrollment) {
                return redirect()->back()->with('alert-error', 'Inscrição inválida ou inexistente.');
            }
            return view('enrollment.view', compact('enrollment'));
        } catch (Exception $ex) {
            return redirect()->back()->with('alert-danger', 'Falha ao deletar, tente mais tarde.');
        }
    }


    /**
     * Print the specified resource from storage.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function registers(string $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                return redirect()->back()->with('alert-error', 'Inscrição inválida ou inexistente.');
            }
            $enrollment = Enrollment::with('products')->where('uuid', $uuid)->first();
            if (!$enrollment) {
                return redirect()->back()->with('alert-error', 'Inscrição inválida ou inexistente.');
            }

            $categories = ProductCategory::get();
            $print_processes = PrintProcess::orderBy('name')->get();
            return view('enrollment.registers', compact('enrollment', 'categories', 'print_processes'));
        } catch (Exception $ex) {
            return redirect()->back()->with('alert-danger', 'Falha ao deletar, tente mais tarde.');
        }
    }

    /**
     * Print the specified resource from storage.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function print(string $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                return redirect()->back()->with('alert-error', 'Inscrição inválida ou inexistente.');
            }
            $enrollment = Enrollment::with('products', 'associate', 'notes')->where('uuid', $uuid)->first();
            if (!$enrollment) {
                return redirect()->back()->with('alert-error', 'Inscrição inválida ou inexistente.');
            }
            return view('enrollment.print', compact('enrollment'));
        } catch (Exception $ex) {
            return redirect()->back()->with('alert-danger', 'Falha ao deletar, tente mais tarde.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        try {
            if (!Str::isUuid($request->enrollment)) {
                return redirect()->back()->with('alert-error', 'Inscrição inválida ou inexistente.');
            }
            $enrollment = Enrollment::where('uuid', $request->enrollment)->first();
            if (!$enrollment) {
                return redirect()->back()->with('alert-error', 'Inscrição inválida ou inexistente.');
            }
            $enrollment->delete();
            return redirect()->back()->with('alert-success', 'Inscrição deletada com sucesso!');
        } catch (Exception $ex) {
            return redirect()->back()->with('alert-danger', 'Falha ao deletar, tente mais tarde.');
        }
    }

    public function checkout(string $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                return redirect()->back()->with('alert-error', 'Inscrição inválida ou inexistente.');
            }
            $enrollment = Enrollment::with([
                'associate', 'award.rates'
            ])->withCount('products')->where('uuid', $uuid)->first();
            if (!$enrollment || $enrollment->associate_id != Auth::user()->associate_id) {
                return redirect()->back()->with('alert-error', 'Inscrição inválida ou inexistente.');
            }

            return view('enrollment.checkout', compact('enrollment'));
        } catch (Exception $ex) {
        }
    }


    public function update_temp(string $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                return redirect()->back()->with('alert-error', 'Inscrição inválida ou inexistente.');
            }
            $enrollment = Enrollment::where('uuid', $uuid)->first();
            if (!$enrollment || $enrollment->associate_id != Auth::user()->associate_id) {
                return redirect()->back()->with('alert-error', 'Inscrição inválida ou inexistente.');
            }
            $enrollment->status = 'approve';
            $enrollment->save();
            return redirect()->route('enrollment.index')->with('alert-success', 'Pagamento processado com sucesso. Inscrição aprovada.');
        } catch (Exception $ex) {
        }
    }

    public function payment(Request $request, string $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                return redirect()->back()->with('alert-error', 'Inscrição inválida ou inexistente.');
            }
            $enrollment = Enrollment::where('uuid', $uuid)->first();
            if (!$enrollment || $enrollment->associate_id != Auth::user()->associate_id) {
                return redirect()->back()->with('alert-error', 'Inscrição inválida ou inexistente.');
            }

            MercadoPagoConfig::setAccessToken(config('payment.mercado_pago.access_token'));
            $client = new PaymentClient();
            $request_options = new RequestOptions();
            $request_options->setCustomHeaders(["X-Idempotency-Key: $enrollment->uuid"]);


            $data = $this->getDataByPaymentType($request);;
            $payment = $client->create($data);

            $this->validate_payment_result($payment);

            $enrollment->transaction = $payment->id;
            switch ($payment->status) {
                case 'pending':
                    $enrollment->status = 'pending';
                    break;
                case 'approved':
                    $enrollment->status = 'approve';
                    break;
                case 'inprocess':
                case 'inmediation':
                    $enrollment->status = 'on-hold';
                    break;
                case 'rejected':
                    $enrollment->status = 'failed';
                    break;
                case 'refunded':
                case 'chargedback':
                    $enrollment->status = 'refunded';
                    break;
                case 'cancelled':
                    $enrollment->status = 'cancelled';
                    break;
            }
            $enrollment->save();

            $response_fields = array(
                'id' => $payment->id,
                'status' => $payment->status,
                'detail' => $payment->status_detail
            );
            return response()->json($payment);
        } catch (MPApiException $ex) {
            $response_fields = array('error_message' => $ex->getApiResponse());
            return response()->json($response_fields);
            //dd($ex->getApiResponse());
        }
    }

    private function getDataByPaymentType($request)
    {
        switch ($request->payment_method_id) {
            case 'pix':
            case 'bolbradesco':
            case 'pec':
                return [
                    "transaction_amount" => (float) $request->transaction_amount,
                    "description" => $request->description ?? "",
                    "payment_method_id" => $request->payment_method_id,
                    "payer" => [
                        "email" => $request->payer['email'],
                    ]
                ];
                break;
            default:
                return [
                    "description" => $request->description ?? "",
                    "token" => $request->token,
                    "issuer_id" => $request->issuer_id,
                    "payment_method_id" => $request->payment_method_id,
                    "transaction_amount" => (float) $request->transaction_amount,
                    "installments" => $request->installments,
                    "payer" => [
                        "email" => $request->payer['email'],
                        "identification" => [
                            "type" => $request->payer['identification']['type'],
                            "number" => $request->payer['identification']['number'],
                        ]
                    ]
                ];
                break;
        }
    }

    function validate_payment_result($payment)
    {
        if ($payment->id === null) {
            $error_message = 'Unknown error cause';

            if ($payment->error !== null) {
                $sdk_error_message = $payment->error->message;
                $error_message = $sdk_error_message !== null ? $sdk_error_message : $error_message;
            }

            throw new Exception($error_message);
        }
    }
}
