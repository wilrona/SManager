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
    <h4 class="modal-title" id="myModalLabel">Ajouter un magasin </h4>
</div>
{!! Form::open(['id'=> 'submitFormulaire']) !!}
<div class="modal-body">
    <div class="form-group {!! $errors->has('magasin_id') ? 'has-error' : '' !!}" id="magasin_id">
        <label for="exampleInputEmail1" class="text-bold"> Caisse : </label>
        {!! Form::select('magasin_id', $produits, null, ['class' => 'form-control', 'placeholder' => 'Selectionnez un magasin...']) !!}
        <span class="help-block hidden magasin_id">
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
            url: "<?= route('pos.valideMagasin', $id) ?>",
            data: $('#submitFormulaire').serialize(),
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(data) {
                $.ajax({
                    url: "<?= route('pos.listingMagasin') ?>",
                    type: 'GET',
                    success : function(list){
                        $('#loading_magasin').html(list);
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