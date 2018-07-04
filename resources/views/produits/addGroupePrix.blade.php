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
    <h4 class="modal-title" id="myModalLabel">Ajouter @if($type == 0) un client @else une famille client @endif </h4>
</div>
{!! Form::open(['id'=> 'submitFormulaire']) !!}
<div class="modal-body">
    @if($type == 0)
    <div class="form-group {!! $errors->has('client_id') ? 'has-error' : '' !!} " id="client_id">
        <label for="exampleInputEmail1" class="text-bold"> Client : </label>

        {!! Form::select('client_id', $client, null, ['class' => 'form-control', 'placeholder' => 'Selectionnez un client...']) !!}


        <span class="help-block hidden client_id">
                    <i class="ti-alert text-primary"></i>
                    <span class="text-danger">

                    </span>
                </span>
    </div>
    @else
        <div class="form-group {!! $errors->has('famille_id') ? 'has-error' : '' !!} " id="famille_id">
            <label for="exampleInputEmail1" class="text-bold"> Famille de client : </label>

            {!! Form::select('famille_id', $client, null, ['class' => 'form-control', 'placeholder' => 'Selectionnez une famille...']) !!}


            <span class="help-block hidden famille_id">
                    <i class="ti-alert text-primary"></i>
                    <span class="text-danger">

                    </span>
                </span>
        </div>
    @endif

    {!! Form::hidden('type_client', $type) !!}
    {!! Form::hidden('produit_id', $id) !!}

    <div class="form-group {!! $errors->has('prix') ? 'has-error' : '' !!}" id="prix">
        <label for="exampleInputEmail1" class="text-bold"> Prix : </label>
        {!! Form::number('prix', 0, ['class' => 'form-control', 'placeholder' => 'Prix', 'id' => 'prix', 'value' => 0, 'min' => 0]) !!}
        <span class="help-block hidden prix">
            <i class="ti-alert text-primary"></i>
            <span class="text-danger">

            </span>
        </span>
    </div>

    <div class="form-group {!! $errors->has('type_remise') ? 'has-error' : '' !!}" id="type_prix">
        <label for="exampleInputEmail1" class="text-bold"> Type de remise : </label>
        {!! Form::select('type_remise', $type_prix, null, ['class' => 'form-control', 'placeholder' => 'Selectionnez un type de valeur...']) !!}
        <span class="help-block hidden type_prix">
                    <i class="ti-alert text-primary"></i>
                    <span class="text-danger">

                    </span>
                </span>
    </div>

    <div class="form-group {!! $errors->has('remise') ? 'has-error' : '' !!}" id="remise">
        <label for="exampleInputEmail1" class="text-bold"> Valeur de la remise : </label>
        {!! Form::number('remise', 0, ['class' => 'form-control', 'placeholder' => 'Prix', 'id' => 'remise', 'value' => 0, 'min' => 0]) !!}
        <span class="help-block hidden remise">
                <i class="ti-alert text-primary"></i>
                <span class="text-danger">

                </span>
            </span>
    </div>

    <div class="form-group {!! $errors->has('quantite_min') ? 'has-error' : '' !!}" id="quantite_min">
        <label for="exampleInputEmail1" class="text-bold"> Quantité minimum: </label>
        {!! Form::number('quantite_min', 1, ['class' => 'form-control', 'placeholder' => 'Quantité minimum', 'id' => 'quantite', 'value' => 0, 'min' => 0]) !!}
        <span class="help-block hidden quantite_min">
                    <i class="ti-alert text-primary"></i>
                    <span class="text-danger">

                    </span>
                </span>
    </div>

        <div class="form-group {!! $errors->has('date_debut') ? 'has-error' : '' !!}" id="date_debut">
            <label for="exampleInputEmail1" class="text-bold"> Date de début: </label>
            {!! Form::date('date_debut',null, ['class' => 'form-control', 'placeholder' => 'Date de début']) !!}
            <span class="help-block hidden date_debut">
                    <i class="ti-alert text-primary"></i>
                    <span class="text-danger">

                    </span>
                </span>
        </div>

        <div class="form-group {!! $errors->has('date_fin') ? 'has-error' : '' !!}" id="date_fin">
            <label for="exampleInputEmail1" class="text-bold"> Date de début: </label>
            {!! Form::date('date_fin',null, ['class' => 'form-control', 'placeholder' => 'Date de fin']) !!}
            <span class="help-block hidden date_fin">
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
            url: "<?= route('produit.valideGroupePrix', $id) ?>",
            data: $('#submitFormulaire').serialize(),
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(data) {
                $.ajax({
                    url: "<?= route('produit.listingGroupePrix') ?>",
                    type: 'GET',
                    success : function(list){
                        $('#loading_GroupPrix').html(list);
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