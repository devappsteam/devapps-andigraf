<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Award;
use App\Payment\PagSeguroCredentials;
use App\Payment\PagSeguroCheckout;
use App\Payment\PagSeguroPayment;
use Illuminate\Support\Facades\Log;

class EnrollmentController extends Controller
{
    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            $uuid = Str::uuid()->toString();
            $enrollment = new Enrollment();
            $enrollment->uuid = $uuid;
            $enrollment->award_id = $this->get_award_active_id();
            $enrollment->associate_id = $request->associate;
            $enrollment->payment_type = 'pagseguro';
            $enrollment->status = ($request->total == 0) ? 'approve' : 'pending';
            $enrollment->discount = $request->discount ?? 0;
            $enrollment->subtotal = $request->subtotal ?? 0;
            $enrollment->total = $request->total ?? 0;
            $enrollment->save();
            $enrollment->products()->sync($request->products);
            $enrollment->notes()->create(array(
                'uuid' => Str::uuid()->toString(),
                'note' => 'Nova Inscrição',
                'type' => 'system'
            ));

            DB::commit();

            $enrollment->transaction = (string) $this->payment($uuid, $request->total);
            $enrollment->save();

            return response()->json(array(
                'status' => true,
                'data' => $enrollment,
                'code' => $enrollment->transaction
            ));
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json(array(
                'status' => false,
                'message' => "Falha ao gerar inscrição",
                'error' => $ex->getMessage()
            ), 500);
        }
    }

    public function update(Request $request)
    {
        if ($request->notificationCode) {
            $emailPagSeguro = config('pagseguro.email');
            $tokenPagSeguro = config('pagseguro.token');

            $credentials = new PagSeguroCredentials($emailPagSeguro, $tokenPagSeguro);
            $payment = new PagSeguroPayment($credentials);
            $response = $payment->getStatusPayment($request->notificationCode);

            $xml = simplexml_load_string($response);

            $reference = $xml->reference;
            $status = $xml->status;

            if ($reference && $status) {
                $enrollment = Enrollment::where('uuid', (string) $reference)->first();
                if ($enrollment) {
                    switch ($status) {
                        case 1:
                        default:
                            $label = "Pagamento pendente";
                            $st = 'pending';
                            break;
                        case 2:
                            $label = "Em análise";
                            $st = 'on-hold';
                            break;
                        case 3:
                        case 4:
                            $label = "Aprovado";
                            $st = 'approve';
                            break;
                        case 6:
                            $label = "Devolvido";
                            $st = 'refunded';
                            break;
                        case 7:
                            $label = "Cancelado";
                            $st = 'cancelled';
                            break;
                    }

                    $enrollment->status = $st;
                    $enrollment->save();
                    $enrollment->notes()->create(array(
                        'uuid' => Str::uuid()->toString(),
                        'note' => 'Status de pagamento foi alterado para <b>' . $label . '</b> pelo PagSeguro.',
                        'type' => 'system'
                    ));
                }
            }
        }
    }

    private function payment($uuid, $total)
    {
        $emailPagSeguro = config('pagseguro.email');
        $tokenPagSeguro = config('pagseguro.token');

        $currency = "BRL";
        $items = array(
            array(
                'id' => $uuid,
                'description' => 'Inscrição JCC',
                'amount' => number_format($total, 2, '.', ''),
                'quantity' => 1
            )
        );
        $reference = $uuid;
        $redirectURL = config('pagseguro.redirect_to');

        // Criar instâncias das classes
        $credentials = new PagSeguroCredentials($emailPagSeguro, $tokenPagSeguro);
        $checkout = new PagSeguroCheckout($currency, $items, $reference, $redirectURL);
        $payment = new PagSeguroPayment($credentials);

        // Construir o XML de pagamento
        $xml = $checkout->buildXml();

        // Obter a URL de pagamento

        $xmlResponse = simplexml_load_string($payment->getPaymentUrl($xml));
        return $xmlResponse->code;
    }

    private function get_award_active_id()
    {
        $award = Award::where('status', 'enable')->first();
        return $award->id;
    }
}
