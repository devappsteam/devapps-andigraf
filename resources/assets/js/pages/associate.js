"user strict";

(function ($) {

    const fields = [
        'corporate_name',
        'fantasy_name',
        'postcode',
        'address',
        'number',
        'district',
        'city',
        'state'
    ];

    const physical_fields = [
        'personal_document',
        'first_name',
        'last_name',
        'birth_date'
    ];


    function before_load_cnpj() {
        for (field of fields) {
            $(`#${field}`).val(null).prop('readonly', true);
        }
    }

    function after_load_cnpj() {
        for (field of fields) {
            $(`#${field}`).prop('readonly', false);
        }
    }

    $(function () {
        $('[name="type"]').on('change', function (e) {
            if ($(this).val() == 'physical') {
                $('.corporate').hide();
                $('.personal').show();
                personal_required(true);
                corporate_required(false);
            } else {
                $('.corporate').show();
                $('.personal').hide();
                personal_required(false);
                corporate_required(true);
            }
        });

        $('#find_cnpj').on('click', function (e) {
            find_cnpj($('#corporate_document').val().replace(/\D/g, ''));
        });

        var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
            spOptions = {
                onKeyPress: function (val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };

        $('#phone, #whatsapp, #responsible_phone').mask(SPMaskBehavior, spOptions);

        $('#postcode').on('keyup', delay(function (e) {
            if ($(this).val().length == 9) {
                find_postcode($(this).val().replace(/\D/g, ''));
            }
        }, 500));

        $('.delete').on('click', function(e){
            e.preventDefault();
            const button = $(this);
            Swal.fire({
                icon: 'question',
                title: 'Deseja realmente excluir este registro?',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: `Não`,
              }).then((result) => {
                if (result.isConfirmed) {
                    $('#form_delete').find('#associate_delete').val(button.data('delete'));
                    $('#form_delete').submit();
                }
              })
        });

        $('#btn_filter').on('click', function(e){
            e.preventDefault();
            $('#form_filter').slideToggle(300);
        });

    });



    function delay(callback, ms) {
        var timer = 0;
        return function () {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    }

    function personal_required(required = false) {
        $('#personal_document').prop('required', required).val(null);
        $('#first_name').prop('required', required).val(null);
        $('#last_name').prop('required', required).val(null);
        $('#birth_date').prop('required', required).val(null);
    }

    function corporate_required(required = false) {
        $('#corporate_document').prop('required', required).val(null);
        $('#corporate_name').prop('required', required).val(null);
        $('#fantasy_name').prop('required', required).val(null);
        $('#responsible_first_name').prop('required', required).val(null);
        $('#responsible_last_name').prop('required', required).val(null);
        $('#responsible_phone').prop('required', required).val(null);
        $('#responsible_email').prop('required', required).val(null);
        $('#responsible_job').prop('required', required).val(null);
    }

    function apply_data_by_cnpj(data) {
        $('#corporate_name').val(data.nome);
        $('#fantasy_name').val(data.fantasia);
        $('#phone').val(data.telefone);
        $('#email').val(data.email);
        $('#postcode').val(data.cep.replace('.', ''));
        $('#address').val(data.logradouro);
        $('#number').val(data.numero);
        $('#complement').val(data.complemento);
        $('#district').val(data.bairro);
        $('#city').val(data.municipio);
        $('#state').val(data.uf);
    }

    function find_cnpj(cnpj) {
        var validatecnpj = /^[0-9]{14}$/;
        if (validatecnpj.test(cnpj)) {
            if (validatecnpj.test(cnpj)) {

                $.ajax({
                    url: "https://www.receitaws.com.br/v1/cnpj/" + cnpj + "/?callback=?",
                    type: "GET",
                    dataType: "JSON",
                    beforeSend: function () {
                        before_load_cnpj();
                    },
                    success(response) {
                        if (response.status == "OK") {
                            apply_data_by_cnpj(response);
                        }
                    }
                }).done(function () {
                    after_load_cnpj();
                });
            }
        }
    }

    function postcode_clear() {
        $('#postcode').val(null);
        $('#address').val(null);
        $('#number').val(null);
        $('#complement').val(null);
        $('#district').val(null);
        $('#city').val(null);
        $('#state').val(null);
    }

    function find_postcode(postcode) {
        //Verifica se campo cep possui valor informado.
        if (postcode != "") {

            //Expressão regular para validar o CEP.
            var postcode_validate = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (postcode_validate.test(postcode)) {

                $('#address').val('...');
                $('#district').val('...');
                $('#city').val('...');
                $('#state').val('...');

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + postcode + "/json/?callback=?", function (dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.

                        $('#address').val(dados.logradouro);
                        $('#district').val(dados.bairro);
                        $('#city').val(dados.localidade);
                        $('#state').val(dados.uf);

                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        postcode_clear();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                postcode_clear();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            postcode_clear();
        }
    }

})(jQuery);
