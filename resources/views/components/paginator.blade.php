<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between">
            <div>{{ 'Mostrando de ' . $data->firstItem() . ' a ' . $data->lastItem() . ' de ' . $data->total() }}</div>
            <div>{{ $data->links() }}</div>
        </div>
    </div>
</div>
