<?php
/**
 * Created by IntelliJ IDEA.
 * User: online2
 * Date: 28/06/2018
 * Time: 12:02
 */
?>



<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Ajouter un produit à demander</h4>
</div>
{!! Form::open(['id'=> 'submitFormulaire']) !!}
<div class="modal-body">
    <div class="form-group {!! $errors->has('produit_id') ? 'has-error' : '' !!}" id="produit_id">
        <label for="exampleInputEmail1" class="text-bold"> Produit : </label>
        @if($produits_data)
            {!! Form::select('produit_id', $produits, $produits_data['produit_id'], ['class' => 'form-control']) !!}
        @else
            {!! Form::select('produit_id', $produits, null, ['class' => 'form-control', 'placeholder' => 'Selectionnez un produit...']) !!}
        @endif
        <span class="help-block hidden produit_id">
                    <i class="ti-alert text-primary"></i>
                    <span class="text-danger">

                    </span>
                </span>
    </div>
    <div class="form-group {!! $errors->has('quantite') ? 'has-error' : '' !!}" id="qte">
        <label for="exampleInputEmail1" class="text-bold"> Quantité : </label>
        @if($produits_data)
            {!! Form::number('quantite', $produits_data['quantite'], ['class' => 'form-control', 'placeholder' => 'Quantité', 'id' => 'quantite', 'value' => 0, 'min' => 0]) !!}
        @else
            {!! Form::number('quantite', 1, ['class' => 'form-control', 'placeholder' => 'Quantité', 'id' => 'quantite', 'value' => 0, 'min' => 0]) !!}
        @endif

        <span class="help-block hidden quantite">
                    <i class="ti-alert text-primary"></i>
                    <span class="text-danger">

                    </span>
                </span>
    </div>

</div>
{!! Form::close() !!}
<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Fermer</button>
    <input type="button"  id="submits" class="btn btn-primary btn-sm" value="Valider"/>
</div>
<script>
    jQuery(document).ready(function() {
        FormElements.init();
    });

    $('#submits').on('click', function(e){
        e.preventDefault();

        $.each($('.help-block'), function(key, value){
            $(this).addClass('hidden');
        });
        $.each($('.form-group'), function(key, value){
            $(this).removeClass('has-error');
        });

        $.ajax({
            url: "<?= route('dmd.valideProduit', $id) ?>",
            data: $('#submitFormulaire').serialize(),
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(data) {
                $.ajax({
                    url: "<?= route('dmd.listingProduit', $id) ?>",
                    type: 'GET',
                    success : function(list){
                        $('#loading').html(list);
                        $('.close').trigger('click');
                    }
                });
            },
            error: function (request, status, error) {

                json = $.parseJSON(request.responseText);

                $.each(json.errors, function(key, value){
                    $('.'+key).removeClass('hidden').find('.text-danger').html('<p>'+value+'</p>');
                    $('#'+key).addClass('has-error');
                });
            }
        });
    });
</script>