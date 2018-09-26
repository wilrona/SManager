<?php
/**
 * Created by IntelliJ IDEA.
 * User: online2
 * Date: 28/06/2018
 * Time: 12:02
 */
?>

<style>
    .dataTables_filter{
        display: none !important;
    }
</style>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Ouverture de caisse</h4>
</div>


<script>
    $('.modal-header .close').trigger('click');

    @if(!$open_session)

    swal({
        title: "Ouverture de la session",
        text: 'Vous etes sur le point d\'ouvrir une session pour la gestion des sorties de stock liée a la vente. \n Etes-vous sur de le faire ?',
        type: "warning",
        showCancelButton: true,
        cancelButtonText: 'Annuler',
        confirmButtonColor: "#58748B",
        confirmButtonText: "Confirmer",
        closeOnConfirm: false
    }, function() {

        window.location.replace("{{ route('magasinManager.open', ['magasin_id' => $magasin_id]) }}");


    });


    @else:


        swal({
            title: "Ooooops!!!!",
            text: "Vous ne pouvez pas ouvrir plus de deux sessions de magasin.",
            type: "warning",
            confirmButtonColor: "#007AFF"
        });

    @endif
</script>