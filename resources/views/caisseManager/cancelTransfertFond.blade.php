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
    <h4 class="modal-title" id="myModalLabel">Annulation du transfert de fond</h4>
</div>

{!! Form::open(['id'=> 'submitFormulaire']) !!}
<div class="modal-body">

    <div class="form-group">
        <label for="exampleInputEmail1" class="text-bold"> Reference du transfert : </label>
        {!! Form::text('reference', $data->reference, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1" class="text-bold"> Transfert à : </label>
        {!! Form::text('caisse', $data->caisse_receive()->first()->name, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
    </div>

    <div class="form-group {!! $errors->has('motif') ? 'has-error' : '' !!}" id="motif">
        <label for="exampleInputEmail1" class="text-bold"> Motif de l'annulation du transfert : </label>
        {!! Form::textarea('motif', null, ['class' => 'form-control', 'placeholder' => 'Motif de l\'annulation du transfert ...']) !!}
        <span class="help-block hidden motif">
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

<script src="{{URL::asset('assets/js/app.js')}}"></script>
<script>
    jQuery(document).ready(function() {
        FormElements.init();
    });

    $('#submits').on('click', function(e){
        e.preventDefault();

        $.ajax({
            url: "{{ route('caisseManager.cancelTransfertFondPost', $data->id) }}",
            data: $('#submitFormulaire').serialize(),
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(data) {

                $('.help-block').addClass('hidden');

                if(data['error_field'].length > 0){
                    toastr["error"](data['error_field'], "Saisie Incorrecte");
                    $('.'+data['field']).removeClass('hidden').find('span').text(data['error_field'])
                }

                if(data['success'].length > 0){
                    toastr["success"](data['success'], "Enregistrement");
                    $('.modal-header .close').trigger('click');
                }
            },
            error: function (request, status, error) {

                json = $.parseJSON(request.responseText);

                $.each(json.errors, function(key, value){
                    toastr["error"](value, "Saisie incorrecte");
                });
            }
        });
    });

</script>