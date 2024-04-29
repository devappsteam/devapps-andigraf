<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = collect();
        $products = Product::with('categories', 'associate', 'award');

        if (isset($this->filters['associate']) && !empty($this->filters['associate'])) {
            $products = $products->where('associate_id', $this->filters['associate']);
        }

        if (isset($this->filters['search']) && !empty($this->filters['search'])) {
            $products = $products->where('name', "LIKE", "%{$this->filters['search']}%");
        }

        if (isset($this->filters['award']) && !empty($this->filters['award'])) {
            $products = $products->where('award_id', $this->filters['award']);
        }

        if (isset($this->filters['category']) && !empty($this->filters['category'])) {
            $products = $products->where('product_category_id', $this->filters['category']);
        }
        $products = $products->orderBy('id', 'ASC')->get();

        foreach ($products as $prod) {
            $item = array();

            if (in_array('number', $this->filters['columns'])) {
                $item['number'] = $prod->id;
            }

            if (in_array('award', $this->filters['columns'])) {
                $item['award'] = $prod->award->name;
            }

            if (in_array('associate', $this->filters['columns'])) {
                $item['associate'] = $prod->associate->type == "legal" ? $prod->associate->corporate_name : $prod->associate->first_name;
            }

            if (in_array('category', $this->filters['columns'])) {
                $item['category'] = $prod->categories->name ?? "--";
            }

            if (in_array('name', $this->filters['columns'])) {
                $item['name'] = $prod->name;
            }

            if (in_array('client', $this->filters['columns'])) {
                $item['client'] = $prod->client;
            }

            if (in_array('conclude', $this->filters['columns'])) {
                $item['conclude'] = $prod->conclude;
            }

            if (in_array('special_features', $this->filters['columns'])) {
                $item['special_features'] = $prod->special_features;
            }

            if (in_array('substrate', $this->filters['columns'])) {
                $item['substrate'] = $prod->substrate;
            }

            if (in_array('note', $this->filters['columns'])) {
                $item['note'] = $prod->note;
            }

            $data->push($item);
        }

        return $data;
    }


    public function headings(): array
    {

        $headers = array();

        if (in_array('number', $this->filters['columns'])) {
            array_push($headers, "Número");
        }

        if (in_array('award', $this->filters['columns'])) {
            array_push($headers, "Premiação");
        }

        if (in_array('associate', $this->filters['columns'])) {
            array_push($headers, "Associado");
        }

        if (in_array('category', $this->filters['columns'])) {
            array_push($headers, "Categoria");
        }

        if (in_array('name', $this->filters['columns'])) {
            array_push($headers, "Produto");
        }

        if (in_array('client', $this->filters['columns'])) {
            array_push($headers, "Cliente");
        }

        if (in_array('conclude', $this->filters['columns'])) {
            array_push($headers, "Conclusão");
        }

        if (in_array('special_features', $this->filters['columns'])) {
            array_push($headers, "Recursos Especiais");
        }

        if (in_array('substrate', $this->filters['columns'])) {
            array_push($headers, "Substrato");
        }

        if (in_array('note', $this->filters['columns'])) {
            array_push($headers, "Notas");
        }

        return $headers;
    }
}
