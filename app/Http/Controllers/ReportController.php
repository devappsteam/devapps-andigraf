<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Models\Associate;
use App\Models\Award;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Traits\Award as TraitsAward;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    use TraitsAward;

    public function associates()
    {
        $associates = Associate::orderBy('first_name')->orderby('corporate_name')->get();
        return view('report.associate', compact('associates'));
    }

    public function associate_export()
    {
        $associates = Associate::orderBy('first_name')->orderby('corporate_name')->get();

        $fileName = 'associados_' . date("Ymd") . ".csv";

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function () use ($associates) {
            $file = fopen('php://output', 'w');
            $data = array();

            foreach ($associates as $associate) {
                switch ($associate->origin) {
                    case "manual":
                    default:
                        $origin = "Manual";
                        break;
                    case "site":
                        $origin = "Site";
                        break;
                    case "award":
                        $origin = "Inscrição";
                        break;
                }
                array_push(
                    $data,
                    array(
                        'CPF|CPNJ' => $associate->document,
                        'Razao Social' => $associate->corporate_name,
                        'Nome Fantazia' => $associate->fantazy_name,
                        'Inscrição Estadual' => $associate->state_registration,
                        'Inscrição Municipal' => $associate->municipal_registration,
                        'Nome Completo'       => $associate->first_name . " " . $associate->last_name,
                        'Data de Nascimento'  =>  $associate->birth_date ? date("d/m/Y", strtotime($associate->birth_date)) : null,
                        'Telefone' => $associate->phone,
                        'E-mail' => $associate->email,
                        'WhatsApp' => $associate->whatsapp,
                        'Responsável' => $associate->responsible_first_name . " " . $associate->responsible_last_name,
                        'Reponsável Telefone' => $associate->responsible_phone,
                        'Responsável E-mail' => $associate->responsible_email,
                        'Responsável Cargo' => $associate->responsible_job,
                        'Facebook' => $associate->social_facebook,
                        'Instagram' => $associate->social_instagram,
                        'Twitter' => $associate->social_twitter,
                        'YouTube' => $associate->social_youtube,
                        'CEP' => $associate->postcode,
                        'Endereço' => $associate->address,
                        'Número' => $associate->number,
                        'Complemento' => $associate->complement,
                        'Bairro' => $associate->district,
                        'Cidade' => $associate->city,
                        'Estado' => $associate->state,
                        'Cadastro' => ($associate->status == "complete") ? "Completo" : "Incompleto",
                        'Origem' => $origin
                    )
                );
            }

            fputcsv($file, array_keys(reset($data)));

            foreach ($data as $values) :
                fputcsv($file, $values);
            endforeach;

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function products(Request $request)
    {
        $products = Product::with('associate', 'award');

        if (isset($request->associate) && !empty($request->associate)) {
            $products = $products->where('associate_id', $request->associate);
        }

        if (isset($request->search) && !empty($request->search)) {
            $products = $products->where('name', "LIKE", "%{$request->search}%");
        }

        if (isset($request->award) && !empty($request->award)) {
            $products = $products->where('award_id', $request->award);
        } else {
            $products = $products->where('award_id', TraitsAward::active());
        }

        if (isset($request->category) && !empty($request->category)) {
            $products = $products->where('product_category_id', $request->category);
        }

        $products = $products->orderBy('id', 'ASC')->get();

        $categories = ProductCategory::orderBy('name')->get();
        $awards = Award::orderBy('name')->get();
        $associates = Associate::distinct()->where('status', 'complete')->orderBy('first_name', 'ASC')->orderBy('corporate_name', 'ASC')->get();
        return view('report.product', compact('products', 'associates', 'awards', 'categories'));
    }

    public function product_export(Request $request)
    {
        if($request->format == 'pdf'){
            $fileName = 'produtos_' . date("Ymd") . ".pdf";
            return Excel::download(new ProductExport($request->all()), $fileName, \Maatwebsite\Excel\Excel::DOMPDF);
        }
        $fileName = 'produtos_' . date("Ymd") . ".xlsx";
        return Excel::download(new ProductExport($request->all()), $fileName);

        /*

        $fileName = 'productos_' . date("Ymd") . ".csv";

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');
            $data = array();

            foreach ($products as $product) {
                array_push(
                    $data,
                    array(
                        'Nome' => $product->name,
                        'Categoria' => $product->categories->name ?? "--",
                        'Cliente' => $product->client,
                        'Data de Conclusão' => date("d/m/Y", strtotime($product->conclude)),
                        'Premio' => $product->award->name,
                        'Associado' => $product->associate->type == "legal" ? $product->associate->corporate_name : $product->associate->first_name,
                    )
                );
            }

            fputcsv($file, array_keys(reset($data)));

            foreach ($data as $values) :
                fputcsv($file, $values);
            endforeach;

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
        */
    }

    public function votes(Request $request)
    {
        $votes = Associate::select('first_name', 'last_name', 'corporate_name', 'email', 'type', 'votes');
        if (isset($request->associate) && !empty($request->associate)) {
            $votes = $votes->where('id', $request->associate);
        }

        $votes = $votes->whereNotNull('votes')->orderBy('first_name')->orderby('corporate_name')->get();
        $associates = Associate::distinct()->where('status', 'complete')->orderBy('first_name', 'ASC')->orderBy('corporate_name', 'ASC')->get();
        return view('report.vote', compact('votes', 'associates'));
    }

    public function vote_export(Request $request)
    {
        $votes = Associate::select('first_name', 'last_name', 'corporate_name', 'email', 'type', 'votes');
        if (isset($request->associate) && !empty($request->associate)) {
            $votes = $votes->where('id', $request->associate);
        }

        $votes = $votes->whereNotNull('votes')->orderBy('first_name')->orderby('corporate_name')->get();

        $fileName = 'associados_votos_' . date("Ymd") . ".csv";

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function () use ($votes) {
            $file = fopen('php://output', 'w');
            $data = array();

            foreach ($votes as $vote) {
                $suppliers = unserialize($vote->votes);
                array_push(
                    $data,
                    array(
                        'Associado' => $vote->type == "legal" ? ucwords($vote->corporate_name) : ucwords($vote->first_name),
                        'E-mail' => $vote->email ?? "--",
                        'Fornecedor de adesivos' => $suppliers['stickers'] ?? "--",
                        'Fornecedor de blanquetas' => $suppliers['blankets'] ?? "--",
                        'Fornecedor de chapas para impressão' => $suppliers['printing_plates'] ?? "--",
                        'Fornecedor de papel' => $suppliers['paper'] ?? "--",
                        'Fornecedor de tintas' => $suppliers['inks'] ?? "--",
                        'Fornecedor de impressão digital' => $suppliers['digital_print'] ?? "--",
                        'Fornecedor de impressão offset' => $suppliers['offset_print'] ?? "--",
                        'Fornecedor de softwares de gestão' => $suppliers['software'] ?? "--",
                    )
                );
            }

            fputcsv($file, array_keys(reset($data)));

            foreach ($data as $values) :
                fputcsv($file, $values);
            endforeach;

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
