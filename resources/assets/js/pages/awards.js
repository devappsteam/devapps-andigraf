"use strict";

(function($){
    $(function(){
        $('.btn-status').on('click', function(e){
            e.preventDefault();
            let uuid = $(this).data('uuid');
            let status = $(this).data('status');
            let title = status == "enable" ? "Ativar" : "Desativar";

            Swal.fire({
                title: `${title} Premiação`,
                text: `Deseja ${title.toLowerCase()} está premiação?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não'
              }).then((result) => {

              })

        });
    });
})(jQuery);
