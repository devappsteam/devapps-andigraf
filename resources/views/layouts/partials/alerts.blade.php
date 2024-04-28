@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if (Session::has('alert-' . $msg))
        <div class="alert alert-{{ $msg }} fade show w-100" role="alert">
            {{ Session::get('alert-' . $msg) }}
        </div>
    @endif
@endforeach

@if (isset($errors) && count($errors) > 0)

    <div class="alert alert-danger w-100" role="alert">
        <strong>Ooops!&nbsp;Alguns erros foram entrados.</strong>
        <ul class="mt-3">
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
@endif
