@extends('layouts.default')

@section('content')
    <div class="da-page container py-5">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h3 class="da-page__title">Newsletter</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                @include('layouts.partials.alerts')
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                <div class="da-box">
                    <form action="{{ route('associate.newsletter.send') }}" method="post" class="w-100" id="form_send">
                        @csrf
                        @method('post')
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 form-group">
                                    <label for="associate" class="form-label da-required">Associado</label>
                                    <select class="form-control" name="associates[]" id="choices-button" multiple required>
                                        <option value="all" selected>Todos os Associados</option>
                                        @if (isset($associates) && count($associates) > 0)
                                            @foreach ($associates as $associate)
                                                <option value="{{ $associate->email }}">
                                                    @if ($associate->type == 'legal')
                                                        {{ ucwords($associate->corporate_name) }}
                                                    @else
                                                        {{ ucwords($associate->first_name) }}
                                                    @endif
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12" style="position: relative; display: grid;">
                                    <label for="content" class="form-label da-required">Mensagem</label>
                                    <textarea style="display: none" name="content" id="content"></textarea>
                                    <div id="editor" style="min-height: 600px"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary">Enviar Mensagem</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function(win, doc, $) {
            'use strict';
            if (document.getElementById('choices-button')) {
                var element = document.getElementById('choices-button');
                const associates = new Choices(element, {
                    removeItemButton: true,
                    loadingText: 'Carregando...',
                    noResultsText: 'Nenhum resultado encontrado.',
                    searchResultLimit: 5,
                    noChoicesText: 'Sem opções para escolher',
                    itemSelectText: 'Pressione para selecionar',
                    addItemText: (value) => {
                        return `Pressione ENTER para adicionar <b>"${value}"</b>`;
                    },
                    shouldSort: false,
                });
            }

            var toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'], // toggled buttons
                ['blockquote', 'code-block'],

                [{
                    'header': 1
                }, {
                    'header': 2
                }], // custom button values
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'script': 'sub'
                }, {
                    'script': 'super'
                }], // superscript/subscript
                [{
                    'indent': '-1'
                }, {
                    'indent': '+1'
                }], // outdent/indent
                [{
                    'direction': 'rtl'
                }], // text direction

                [{
                    'size': ['small', false, 'large', 'huge']
                }], // custom dropdown
                [{
                    'header': [1, 2, 3, 4, 5, 6, false]
                }],

                [{
                    'color': []
                }, {
                    'background': []
                }], // dropdown with defaults from theme
                [{
                    'font': []
                }],
                [{
                    'align': []
                }],

                ['clean'], // remove formatting button
                ['image']
            ];



            var editor = new Quill('#editor', {
                placeholder: 'Digite aqui o conteúdo do seu e-mail.',
                theme: 'snow',
                modules: {
                    toolbar: toolbarOptions
                }
            });

            editor.on('text-change', function(delta, oldDelta, source) {
                $('#content').val(editor.container.firstChild.innerHTML);
            });


        })(window, document, jQuery);
    </script>
@endpush
