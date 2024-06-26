@extends('layouts.default')

@section('content')
    <div class="da-page container-fluid py-5">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h3 class="da-page__title">Relatório - Votos de Fornecedores</h3>
                <div class="d-flex">
                    <button class="btn btn-primary" id="btn_filter">Filtrar</button>
                    <button type="submit" class="btn btn-primary ml-2" form="form_export">Exportar</button>
                </div>
            </div>
        </div>
        <div class="row" style="{{ !isset($_GET['associate']) ? "display:none;" : "" }}" id="form_filter">
            <div class="col-12 mt-3">
                <form method="get">
                    <div class="row">
                        <div class="col-12 col-md-3 form-group">
                            <label for="associate">Associado</label>
                            <select name="associate" class="form-control" id="associate">
                                <option value="">Selecione...</option>
                                @if (isset($associates))
                                    @foreach ($associates as $associate)
                                        <option value="{{ $associate->id }}" {{ (isset($_GET['associate']) && $_GET['associate'] == $associate->id) ? "selected" : "" }}>
                                            @if ($associate->type == "legal")
                                                {{ $associate->fantasy_name }}
                                            @else
                                                {{ $associate->first_name }}
                                            @endif
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                            <a href="{{ route('report.vote') }}" class="btn btn-secondary">Redefinir</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                <div class="da-box da-box--column table-responsive">
                    @if (isset($votes) && count($votes) > 0)
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Associado</th>
                                    <th>E-mail</th>
                                    <th>Fornecedor de adesivos</th>
                                    <th>Fornecedor de blanquetas</th>
                                    <th>Fornecedor de chapas para impressão</th>
                                    <th>Fornecedor de papel</th>
                                    <th>Fornecedor de tintas</th>
                                    <th>Fornecedor de impressão digital</th>
                                    <th>Fornecedor de impressão offset</th>
                                    <th>Fornecedor de softwares de gestão</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($votes as $vote)
                                    @php
                                        $suppliers = unserialize($vote->votes);
                                    @endphp
                                    <tr>
                                        <td>
                                            @if ($vote->type == "legal")
                                                <p class="text-truncate m-0">{{ ucwords($vote->corporate_name) }}</p>
                                            @else
                                                <p class="text-truncate m-0">{{ $vote->first_name }}</p>
                                            @endif
                                        </td>
                                        <td>{{ $vote->email }}</td>
                                        <td>{{ $suppliers['stickers'] ?? "--" }}</td>
                                        <td>{{ $suppliers['blankets'] ?? "--" }}</td>
                                        <td>{{ $suppliers['printing_plates'] ?? "--" }}</td>
                                        <td>{{ $suppliers['paper'] ?? "--" }}</td>
                                        <td>{{ $suppliers['inks'] ?? "--" }}</td>
                                        <td>{{ $suppliers['digital_print'] ?? "--" }}</td>
                                        <td>{{ $suppliers['offset_print'] ?? "--" }}</td>
                                        <td>{{ $suppliers['software'] ?? "--" }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="d-flex-align-items-center justify-content-center w-100 h-100 text-center py-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"
                                enable-background="new 0 0 512 512" viewBox="0 0 512 512" id="empty-folder">
                                <polygon fill="none" stroke="#4A486A" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-miterlimit="10" stroke-width="10"
                                    points="380.946 241.847 101.605 241.847 31.77 381.517 450.781 381.517"></polygon>
                                <rect width="419.011" height="113.483" x="31.77" y="381.517" fill="none"
                                    stroke="#4A486A" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"
                                    stroke-width="10"></rect>
                                <path fill="none" stroke="#4A486A" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-miterlimit="10" stroke-width="10"
                                    d="M348.607 438.258c0 10.981-8.896 19.877-19.877 19.877-6.501 0-12.271-3.118-15.901-7.951-2.49-3.321-3.976-7.455-3.976-11.926 0-4.47 1.485-8.604 3.976-11.927 3.631-4.832 9.4-7.95 15.901-7.95C339.712 418.381 348.607 427.277 348.607 438.258zM173.691 438.258c0 4.471-1.483 8.604-3.975 11.926-3.622 4.833-9.399 7.951-15.901 7.951-10.973 0-19.877-8.896-19.877-19.877 0-10.98 8.904-19.877 19.877-19.877 6.502 0 12.279 3.118 15.901 7.95C172.208 429.654 173.691 433.788 173.691 438.258z">
                                </path>
                                <path fill="none" stroke="#4A486A" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-miterlimit="10" stroke-width="10"
                                    d="
                            M308.854,438.258c0,4.471,1.485,8.604,3.976,11.926H169.716c2.491-3.321,3.975-7.455,3.975-11.926
                            c0-4.47-1.483-8.604-3.975-11.927h143.113C310.339,429.654,308.854,433.788,308.854,438.258z">
                                </path>
                                <polyline fill="none" stroke="#4A486A" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-miterlimit="10" stroke-width="10"
                                    points="257.13 241.847 101.605 241.847 101.605 328.034 379.925 328.034 379.925 241.847 356.956 241.847">
                                </polyline>
                                <polygon fill="none" stroke="#4A486A" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-miterlimit="10" stroke-width="10"
                                    points="379.086 328.034 240.345 328.034 101.605 328.034 83.98 381.517 240.345 381.517 396.71 381.517">
                                </polygon>
                                <line x1="83.843" x2="72.652" y1="213.182" y2="188.61" fill="none"
                                    stroke="#4A486A" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"
                                    stroke-width="10"></line>
                                <line x1="100.224" x2="106.915" y1="205.721" y2="187.84" fill="none"
                                    stroke="#4A486A" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-miterlimit="10" stroke-width="10"></line>
                                <line x1="67.462" x2="49.581" y1="220.643" y2="213.952" fill="none"
                                    stroke="#4A486A" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-miterlimit="10" stroke-width="10"></line>
                                <g>
                                    <path fill="#4A486A"
                                        d="M163.168,306.808c-0.08,0-0.161-0.002-0.242-0.006c-3.699-0.176-7.304-0.64-10.715-1.377
                        c-2.699-0.583-4.415-3.244-3.831-5.943s3.244-4.414,5.943-3.83c2.875,0.621,5.929,1.012,9.078,1.162
                        c2.758,0.131,4.888,2.474,4.756,5.232C168.031,304.723,165.82,306.808,163.168,306.808z M183.042,305.185
                        c-2.343,0-4.435-1.655-4.901-4.041c-0.531-2.71,1.236-5.337,3.946-5.867c3.007-0.588,6.135-1.347,9.295-2.254
                        c2.655-0.765,5.424,0.771,6.186,3.426c0.762,2.654-0.772,5.424-3.426,6.186c-3.437,0.986-6.846,1.813-10.134,2.457
                        C183.684,305.154,183.361,305.185,183.042,305.185z M135.075,297.599c-1.011,0-2.032-0.306-2.915-0.941
                        c-3.001-2.158-5.77-4.656-8.229-7.424c-1.834-2.064-1.647-5.225,0.417-7.06c2.064-1.834,5.225-1.646,7.059,0.417
                        c1.971,2.219,4.188,4.22,6.592,5.949c2.242,1.612,2.752,4.736,1.14,6.979C138.162,296.876,136.63,297.599,135.075,297.599z
                         M119.402,273.162c-2.489,0-4.645-1.857-4.956-4.391c-0.434-3.529-0.744-6.996-0.92-10.303c-0.147-2.758,1.969-5.112,4.727-5.259
                        c2.738-0.159,5.112,1.969,5.259,4.726c0.165,3.078,0.454,6.313,0.859,9.615c0.337,2.741-1.611,5.236-4.352,5.573
                        C119.812,273.149,119.605,273.162,119.402,273.162z M119.285,243.26c-0.243,0-0.489-0.018-0.737-0.054
                        c-2.732-0.403-4.619-2.945-4.216-5.677c0.542-3.669,1.318-7.188,2.307-10.46c0.798-2.643,3.59-4.141,6.232-3.34
                        c2.644,0.799,4.139,3.589,3.34,6.232c-0.848,2.805-1.516,5.842-1.986,9.029C123.858,241.474,121.723,243.26,119.285,243.26z
                         M311.729,232.481c-0.141,0-0.282-0.006-0.425-0.018c-3.22-0.271-6.698-0.723-10.338-1.344c-2.722-0.465-4.552-3.048-4.087-5.77
                        c0.465-2.722,3.041-4.556,5.771-4.087c3.36,0.574,6.554,0.99,9.492,1.237c2.752,0.231,4.795,2.649,4.563,5.401
                        C316.486,230.508,314.301,232.481,311.729,232.481z M331.588,231.292c-2.225,0-4.254-1.496-4.837-3.75
                        c-0.691-2.673,0.916-5.401,3.589-6.092c2.909-0.752,5.535-1.846,7.806-3.251c2.346-1.453,5.429-0.729,6.883,1.619
                        c1.454,2.348,0.729,5.43-1.619,6.883c-3.126,1.936-6.681,3.427-10.565,4.431C332.424,231.24,332.003,231.292,331.588,231.292z
                         M282.307,226.766c-0.433,0-0.872-0.057-1.311-0.175c-3.048-0.826-6.233-1.735-9.74-2.781c-2.646-0.789-4.151-3.574-3.363-6.22
                        c0.789-2.646,3.57-4.153,6.221-3.363c3.425,1.021,6.532,1.908,9.498,2.711c2.665,0.722,4.24,3.468,3.519,6.134
                        C286.526,225.299,284.509,226.766,282.307,226.766z M253.601,218.041c-0.509,0-1.026-0.078-1.536-0.243l-9.518-3.076
                        c-2.628-0.848-4.072-3.666-3.224-6.293c0.848-2.628,3.666-4.073,6.293-3.224l9.519,3.076c2.627,0.848,4.071,3.666,3.223,6.294
                        C257.676,216.692,255.713,218.041,253.601,218.041z M130.72,216.002c-1.149,0-2.303-0.394-3.245-1.198
                        c-2.1-1.794-2.348-4.95-0.554-7.049c2.411-2.822,5.169-5.364,8.199-7.556c2.236-1.618,5.363-1.118,6.981,1.12
                        c1.619,2.237,1.117,5.363-1.12,6.981c-2.388,1.728-4.561,3.729-6.457,5.949C133.536,215.407,132.132,216.002,130.72,216.002z
                         M353.156,212.197c-0.631,0-1.272-0.12-1.892-0.374c-1.383-0.566-2.375-1.679-2.83-2.987c-1.201-0.416-2.395-0.883-3.578-1.398
                        c-2.531-1.104-3.688-4.05-2.585-6.582c1.103-2.531,4.051-3.69,6.581-2.585c0.596,0.26,1.193,0.503,1.793,0.731
                        c0.259-0.88,0.501-1.748,0.726-2.599c0.706-2.67,3.439-4.265,6.112-3.556c2.67,0.706,4.262,3.442,3.556,6.112
                        c-0.296,1.118-0.617,2.26-0.963,3.417c1.02,1.108,1.53,2.662,1.248,4.26c-0.412,2.336-2.385,4.005-4.657,4.125
                        C355.733,211.678,354.468,212.197,353.156,212.197z M224.983,208.979c-0.475,0-0.957-0.068-1.435-0.211
                        c-3.391-1.014-6.5-1.909-9.507-2.736c-2.663-0.732-4.227-3.484-3.495-6.147c0.732-2.662,3.483-4.226,6.147-3.495
                        c3.078,0.847,6.257,1.762,9.72,2.797c2.646,0.792,4.149,3.578,3.358,6.223C229.123,207.578,227.135,208.979,224.983,208.979z
                         M375.883,208.257c-1.814,0-3.564-0.991-4.451-2.716c-1.262-2.456-0.294-5.47,2.162-6.732c2.377-1.221,4.542-2.9,6.436-4.991
                        c1.854-2.046,5.015-2.205,7.063-0.35c2.047,1.854,2.203,5.016,0.35,7.063c-2.705,2.986-5.826,5.399-9.277,7.173
                        C377.433,208.079,376.652,208.257,375.883,208.257z M195.954,201.382c-0.313,0-0.63-0.03-0.949-0.091
                        c-3.159-0.607-6.352-1.088-9.49-1.43c-2.745-0.299-4.728-2.767-4.429-5.512c0.3-2.745,2.769-4.724,5.512-4.429
                        c3.407,0.372,6.87,0.893,10.293,1.551c2.712,0.521,4.488,3.142,3.967,5.854C200.399,199.718,198.304,201.382,195.954,201.382z
                         M156.211,201.209c-2.264,0-4.315-1.547-4.86-3.846c-0.638-2.687,1.023-5.382,3.71-6.02c3.33-0.791,6.881-1.366,10.556-1.71
                        c2.736-0.265,5.187,1.762,5.444,4.512c0.258,2.749-1.762,5.187-4.512,5.444c-3.212,0.301-6.301,0.8-9.179,1.483
                        C156.982,201.166,156.593,201.209,156.211,201.209z M330.93,196.056c-1.456,0-2.899-0.633-3.888-1.852
                        c-2.649-3.27-4.527-6.686-5.581-10.154l-0.09-0.304c-0.778-2.649,0.738-5.428,3.388-6.207c2.65-0.778,5.429,0.74,6.206,3.388
                        l0.065,0.217c0.676,2.226,1.948,4.501,3.781,6.764c1.738,2.146,1.408,5.294-0.737,7.033
                        C333.148,195.691,332.035,196.056,330.93,196.056z M392.678,184.518c-0.423,0-0.854-0.054-1.282-0.168
                        c-2.67-0.707-4.261-3.443-3.555-6.113c0.743-2.808,1.326-5.886,1.732-9.149c0.342-2.74,2.851-4.68,5.579-4.344
                        c2.741,0.341,4.686,2.839,4.345,5.58c-0.462,3.708-1.131,7.231-1.988,10.473C396.915,183.036,394.892,184.518,392.678,184.518z
                         M358.655,182.918c-2.615,0-4.814-2.033-4.984-4.679c-0.199-3.093-0.806-5.745-1.804-7.882c-1.167-2.502-0.086-5.478,2.417-6.645
                        c2.501-1.167,5.478-0.086,6.646,2.417c1.525,3.27,2.441,7.129,2.72,11.469c0.178,2.756-1.913,5.133-4.668,5.311
                        C358.872,182.915,358.763,182.918,358.655,182.918z M331.177,169.108c-1.377,0-2.746-0.565-3.734-1.673
                        c-1.838-2.062-1.656-5.222,0.405-7.06c3.209-2.86,7.103-4.784,11.261-5.564c2.717-0.51,5.326,1.278,5.836,3.992
                        c0.51,2.714-1.277,5.327-3.992,5.836c-2.336,0.438-4.627,1.575-6.45,3.201C333.549,168.69,332.36,169.108,331.177,169.108z
                         M395.51,155.306c-2.184,0-3.43-1.001-4.183-2.328c-0.69-0.813-1.127-1.854-1.18-3.002c-0.026-0.551-0.055-1.107-0.088-1.669
                        c-0.003-0.045-0.006-0.09-0.008-0.135c-0.044-0.781-0.06-1.295-0.06-1.606c0-3.453,2.592-5.315,5.03-5.315
                        c4.496,0,5.049,4.42,5.257,6.083c0.093,0.742,0.248,2.097,0.248,2.843C400.527,153.388,397.977,155.306,395.51,155.306z">
                                    </path>
                                </g>
                                <g>
                                    <path fill="none" stroke="#4A486A" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-miterlimit="10" stroke-width="10"
                                        d="
                        M414.489,49.5l-1.78,12.45l-3.13,21.91l-4.09,28.64c0,0,0,13.5-13.5,13.5s-13.5-13.5-13.5-13.5l-4.09-28.64l-3.13-21.91
                        l-1.78-12.45c0,0,0-22.5,22.5-22.5S414.489,49.5,414.489,49.5z">
                                    </path>
                                    <path fill="none" stroke="#4A486A" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-miterlimit="10" stroke-width="10"
                                        d="M374.399 83.86c-6.82 5.42-21.55 15.14-39.53 15.14-24.925 0-31.158-24.92-31.158-24.92s6.233-24.93 31.158-24.93c15.59 0 28.74 7.31 36.4 12.8L374.399 83.86zM480.259 74.08c0 0-6.229 24.92-31.149 24.92-17.98 0-32.71-9.72-39.53-15.14l3.13-21.91c7.66-5.49 20.811-12.8 36.4-12.8C474.029 49.15 480.259 74.08 480.259 74.08z">
                                    </path>
                                    <line x1="400.989" x2="405.489" y1="28.482" y2="18" fill="none"
                                        stroke="#4A486A" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-miterlimit="10" stroke-width="10"></line>
                                    <line x1="382.989" x2="378.489" y1="28.482" y2="18" fill="none"
                                        stroke="#4A486A" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-miterlimit="10" stroke-width="10"></line>
                                    <line x1="406.499" x2="377.85" y1="105.43" y2="105.43" fill="none"
                                        stroke="#4A486A" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-miterlimit="10" stroke-width="10"></line>
                                    <line x1="408.978" x2="375.416" y1="88.07" y2="88.07" fill="none"
                                        stroke="#4A486A" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-miterlimit="10" stroke-width="10"></line>
                                </g>
                            </svg>
                            <h5 class="text-muted py-5">Nenhum resultado encontrado.</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <form id="form_export" method="post" action="{{ route('report.vote.export') }}">
        @csrf
        @method('post')
        <input type="hidden" name="associate" value="{{ isset($_GET['associate']) && !empty($_GET['associate']) ? $_GET['associate'] : "" }}">
    </form>
@endsection
@push('scripts')
<script>
    (function($){
        $(function(){
            $('#btn_filter').on('click', function(e){
                e.preventDefault();
                $('#form_filter').slideToggle(300);
            });

        });
    })(jQuery);
</script>
@endpush
