"use strict";

(function ($) {
    $(function () {
        $('#associate').on('change', function (e) {
            $.ajax({
                url: "/produto/buscar",
                type: "GET",
                dataType: "JSON",
                data: {
                    associate: $('#associate').val()
                },
                beforeSend: function () {
                    $('#product').html('<option value="">Selecione...</option>');
                    $('#product').prop('disabled', true);
                    //$('#table_product tbody').find('tr').not('#empty').remove();
                    //$('#table_product tbody').find('#empty').show();
                    $('#loading').show();
                },
                success: function (response) {
                    if (response.status) {
                        $(response.data).each(function (index, item) {
                            $('#product').append(`<option data-id="${item.id}" data-name="${item.name}" data-client="${item.client}" data-conclude="${item.conclude}">${item.name}</option>`);
                        });
                    }
                    $('#product').prop('disabled', false);
                    $('#loading').hide();

                    if($('#table_product').find('tbody tr').not('#empty').length > 0 || response.data.length > 0){
                        $('#conclude_btn').show();
                    }


                }
            });
        });

        $('#btn_add').on('click', function(){
            if($('#product').children('option:selected').val() != ""){
                const product = $('#product').children('option:selected').data();
                $('#product').children('option:selected').remove();

                $('#table_product tbody').find('#empty').hide();

                $('#table_product tbody').append(`
                    <tr id="item_${product.id}">
                        <input type="hidden" name="products[]" value="${product.id}">
                        <td class="text-truncate">${product.id.toString().padStart(8, 0)}</td>
                        <td class="text-truncate">${product.name}</td>
                        <td>${product.conclude}</td>
                        <td class="text-truncate">${product.client}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn_remove" data-id="${product.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                `);
            }
        });


        $(document).on('click', '.btn_remove', function(e){
            e.preventDefault();

            $(`#item_${$(this).data('id')}`).remove();

            if($('#table_product tbody').find('tr').not('#empty').length == 0){
                $('#table_product tbody').find('#empty').show();
            }
        });
    });
})(jQuery);
