<?php

namespace App\Http\Controllers;

use App\Models\Associate;
use App\Models\Award;
use App\Models\Enrollment;
use App\Models\EnrollmentProduct;
use App\Models\PrintProcess;
use App\Models\Product;
use App\Models\ProductCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Proner\PhpPimaco\Pimaco;
use Proner\PhpPimaco\Tag;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $products = Product::with([
                'associate:id,first_name,fantasy_name,type',
                'award:id,name'
            ]);

            if (empty(Auth::user()->associate_id)) {
                if (isset($request->associate) && !empty($request->associate)) {
                    $products = $products->where('associate_id', $request->associate);
                }

                if (isset($request->search) && !empty($request->search)) {
                    $products = $products->where('name', "LIKE", "%{$request->search}%");
                }
            } else {
                $products = $products->where('associate_id', Auth::user()->associate_id);
            }

            if (isset($request->award) && !empty($request->award)) {
                $products = $products->where('award_id', $request->award);
            }

            if (isset($request->category) && !empty($request->category)) {
                $products = $products->where('product_category_id', $request->category);
            }

            $products = $products->orderBy('created_at', 'DESC')->paginate(15);

            if (empty(Auth::user()->associate_id)) {
                $associates = Associate::distinct()->where('status', 'complete')->orderBy('first_name', 'ASC')->orderBy('corporate_name', 'ASC')->get();
            } else {
                $associates = [Associate::where('id', Auth::user()->associate_id)->first()];
            }

            $categories = ProductCategory::orderBy('name')->get();
            $awards = Award::orderBy('name')->get();
            return view('product.index', compact('products', 'associates', 'awards', 'categories'));
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
            $print_processes = PrintProcess::orderBy('name')->get();
            if (empty(Auth::user()->associate_id)) {
                $associates = Associate::distinct()->where('status', 'complete')->orderBy('first_name', 'ASC')->orderBy('corporate_name', 'ASC')->get();
            } else {
                $associates = [Associate::where('id', Auth::user()->associate_id)->first()];
            }
            $awards = Award::orderBy('name')->get();
            $categories = ProductCategory::orderBy('name')->get();
            return view('product.create', compact('print_processes', 'associates', 'awards', 'categories'));
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
        try {
            if (!empty(Auth::user()->associate_id)) {
                $associate = Auth::user()->associate_id;
            } else {
                $associate = $request->associate;
            }

            $product = new Product();
            $product->uuid = Str::uuid()->toString();
            $product->award_id = $request->award;
            $product->associate_id = $associate;
            $product->product_category_id = $request->category;
            $product->name = $request->name;
            $product->client = $request->client;
            $product->conclude = $request->conclude;
            $product->special_features = $request->special_features;
            $product->substrate = $request->substrate;
            $product->note = $request->note;
            $product->save();
            $product->print_processes()->sync($request->print_process);

            return redirect(route('product.index'))->with('alert-success', 'Produto cadastrado com sucesso!');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(string $uuid)
    {
        try {
            if (!Str::isUuid($uuid)) {
                return redirect()->back()->with('alert-error', 'Produto inválido ou inexistente.');
            }
            $product = Product::with('print_processes')->where('uuid', $uuid)->first();
            if (!$product) {
                return redirect()->back()->with('alert-error', 'Produto inválido ou inexistente.');
            }

            $print_processes = PrintProcess::orderBy('name')->get();
            if (empty(Auth::user()->associate_id)) {
                $associates = Associate::distinct()->where('status', 'complete')->orderBy('first_name', 'ASC')->orderBy('corporate_name', 'ASC')->get();
            } else {
                $associates = [Associate::where('id', Auth::user()->associate_id)->first()];
            }
            $awards = Award::orderBy('name')->get();
            $categories = ProductCategory::orderBy('name')->get();

            return view('product.edit', compact('product', 'print_processes', 'associates', 'awards', 'categories'));
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
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

            if (!empty(Auth::user()->associate_id)) {
                $associate = Auth::user()->associate_id;
            } else {
                $associate = $request->associate;
            }

            $product->award_id = $request->award;
            $product->associate_id = $associate;
            $product->product_category_id = $request->category;
            $product->name = $request->name;
            $product->client = $request->client;
            $product->conclude = $request->conclude;
            $product->special_features = $request->special_features;
            $product->substrate = $request->substrate;
            $product->note = $request->note;
            $product->save();
            $product->print_processes()->sync($request->print_process);
            return redirect()->back()->with('alert-success', 'Produto atualizado com sucesso!');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        try {
            if (!Str::isUuid($request->product)) {
                return redirect()->back()->with('alert-error', 'Produto inválido ou inexistente.');
            }
            $product = Product::where('uuid', $request->product)->first();
            if (!$product) {
                return redirect()->back()->with('alert-error', 'Produto inválido ou inexistente.');
            }
            $product->delete();
            return redirect()->back()->with('alert-success', 'Produto deletado com sucesso!');
        } catch (Exception $ex) {
            return redirect()->back()->with('alert-danger', 'Falha ao deletar produto, tente mais tarde.');
        }
    }

    public function find_by_associate(Request $request)
    {
        try {
            if (!isset($request->associate) || empty($request->associate) || !is_numeric($request->associate)) {
                return response()->json(array(
                    'status' => false,
                    'message' => "Associado inválido ou inexistente."
                ));
            }

            $products = Product::select('id', 'name', 'client', 'conclude')->whereNotIn('id', Enrollment::select('enrollment_product.product_id')
                ->join('enrollment_product', 'enrollments.id', 'enrollment_product.enrollment_id')
                ->where('enrollments.associate_id', $request->associate))->where('associate_id', $request->associate)->get();

            return response()->json(array(
                'status' => true,
                'data' => $products
            ));
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function export(Request $request)
    {
        try {
            $products = Product::with([
                'associate:id,first_name,fantasy_name,type',
                'award:id,name'
            ]);

            if (isset($request->associate) && !empty($request->associate)) {
                $products = $products->where('associate_id', $request->associate);
            }

            if (isset($request->search) && !empty($request->search)) {
                $products = $products->where('name', 'LIKE', "%{$request->search}%");
            }

            if (isset($request->category) && !empty($request->category)) {
                $products = $products->where('product_category_id', $request->category);
            }

            if (isset($request->award) && !empty($request->award)) {
                $products = $products->where('award_id', $request->award);
            }

            $products = $products->orderBy('associate_id', 'ASC')->get();

            $fileName = 'produtos_' . date("Ymd") . ".csv";

            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );

            $columns = array('Produto', 'Associado', 'Data de Conclusão');

            $callback = function () use ($products, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($products as $product) {
                    if ($product->associate->type == "legal") {
                        $associate = $product->associate->fantasy_name;
                    } else {
                        $associate = $product->associate->first_name;
                    }
                    $row['Produto']  = $product->name;
                    $row['Associado']    = $associate;
                    $row['Data de Conclusão']    = date("d/m/Y", strtotime($product->conclude));

                    fputcsv($file, array($row['Produto'], $row['Associado'], $row['Data de Conclusão']));
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function ticket(Request $request)
    {
        try {
            $products = Product::select('id', 'name');

            if (isset($request->associate) && !empty($request->associate)) {
                $products = $products->where('associate_id', $request->associate);
            }

            if (isset($request->search) && !empty($request->search)) {
                $products = $products->where('name', 'LIKE', "%{$request->search}%");
            }

            if (isset($request->category) && !empty($request->category)) {
                $products = $products->where('product_category_id', $request->category);
            }

            if (isset($request->award) && !empty($request->award)) {
                $products = $products->where('award_id', $request->award);
            }

            $products = $products->orderBy('id', 'ASC')->get();
            $pimaco = new Pimaco('6187');

            if (!empty($products)) {
                foreach ($products as $product) {
                    $tag = new Tag();
                    $tag->setPadding(1.5);
                    $tag->p(str_pad($product->id, 4, 0, STR_PAD_LEFT))->b()->setSize(7);
                    $tag->align = "center";
                    $pimaco->addTag($tag);
                }
            }
            $pimaco->output();
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
}
