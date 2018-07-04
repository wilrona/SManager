<?php
/**
 * Created by IntelliJ IDEA.
 * User: online2
 * Date: 30/05/2018
 * Time: 12:28
 */
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="mService1"> <i class="fa fa-plus"></i> Choisir un produit </h4>
</div>
<div class="modal-body">
    <div class="mian-popup-body">
        <p id="resultlogin"></p>
        {!! Form::open(['id'=> 'submitFormulaire']) !!}

            <div class="form-group {!! $errors->has('produit_id') ? 'has-error' : '' !!}" id="produit_id">
                <label for="exampleInputEmail1" class="text-bold"> Produit : </label>
                {!! Form::select('produit_id', $select, null, ['class' => 'form-control', 'placeholder' => 'Selectionnez un produit...']) !!}
                <span class="help-block hidden produit_id">
                    <i class="ti-alert text-primary"></i>
                    <span class="text-danger">

                    </span>
                </span>
            </div>
            <div class="form-group {!! $errors->has('qte') ? 'has-error' : '' !!}" id="qte">
                <label for="exampleInputEmail1" class="text-bold"> Quantité : </label>
                {!! Form::number('qte', null, ['class' => 'form-control', 'placeholder' => 'Quantité', 'id' => 'montantverse', 'value' => 0]) !!}
                <span class="help-block hidden qte">
                    <i class="ti-alert text-primary"></i>
                    <span class="text-danger">

                    </span>
                </span>
            </div>
            <div class="form-actions " style="margin-top: 15PX; ">
                <input type="hidden"  class="form-control" name="libelle" id="libelle">
                <input type="button"  id="submits" class="btn btn-primary btn-block" value="Ajouter"/>
            </div>
        {!! Form::close() !!}
    </div>
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
            url: "<?= url('provisions/addStore') ?>",
            data: $('#submitFormulaire').serialize(),
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(data) {
                $.ajax({
                    url: "<?= url('provisions/listing') ?>",
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