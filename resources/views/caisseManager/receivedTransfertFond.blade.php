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
    <h4 class="modal-title" id="myModalLabel">Reception du transfert de fond : <b>{{ $transfert->code_transfert }}</b></h4>
</div>

{!! Form::open(['id'=> 'submitFormulaire']) !!}
<div class="modal-body">

    <div class="form-group {!! $errors->has('code') ? 'has-error' : '' !!}" id="code">
        <label for="exampleInputEmail1" class="text-bold"> Code du tranfert : </label>
        {!! Form::text('code', null, ['class' => 'form-control', 'placeholder' => 'Code du transfert ...']) !!}
        <span class="help-block hidden code">
            <i class="ti-alert text-primary"></i>
            <span class="text-danger">

            </span>
        </span>
    </div>

    <div class="form-group {!! $errors->has('montant') ? 'has-error' : '' !!}" id="montant">
        <label for="exampleInputEmail1" class="text-bold"> Montant du transfert : </label>
        {!! Form::number('montant', null, ['class' => 'form-control', 'placeholder' => 'Montant du transfert ...']) !!}
        <span class="help-block hidden montant">
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
            url: "{{ route('caisseManager.receivedTransfertFondPost', $transfert->id) }}",
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
                    toastr["success"](data['success'], "Reception de fond réussi");
                    $('.modal-header .close').trigger('click');
                    swal({
                        title: "Reception de fond réussi",
                        text: data['success'],
                        type: "success",
                        showCancelButton: false,
                        confirmButtonColor: "#58748B",
                        confirmButtonText: "OK",
                        closeOnConfirm: true
                    }, function() {
                        var $url = $('#ReceiveFond').attr('href');
                        $.ajax({
                            url: $url,
                            type: 'get',
                            success: function(data_r) {
                                $('.caisseManager').html('');
                                $('.panel-fond').html(data_r);
                                $('#badge_receiveFond').text(data['count'])
                            }
                        });
                    });
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