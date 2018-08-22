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

{!! Form::open(['id'=> 'submitFormulaire']) !!}
<div class="modal-body">

    <fieldset>
        <legend>
            <strong>Ouverture de la caisse</strong> : {{ $data->name }}
        </legend>
        <div class="row">
            <div class="col-md-12">
                @if(!$devise || empty($devise->value))
                    <div class="alert alert-danger alert-dismissible">
                        Aucune dévise défini dans les paramatres de l'application. Veuillez contacter l'administrateur.
                    </div>
                @endif
                <div class="form-group" id="caisse_montant">

                    <label> Montant en caisse </label>
                    <div class="input-group">
                        @if($devise && !empty($devise->value))
                            {!! Form::number('caisse_montant', null, ['class' => 'form-control']) !!}
                        @else
                            {!! Form::number('caisse_montant', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                        @endif
                        <span class="input-group-addon">@if($devise && !empty($devise->value)) {{ $devise->value }} @endif</span>
                    </div>

                </div>
            </div>
        </div>
    </fieldset>

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
            url: "{{ route('caisseManager.preopencheck', $data->id) }}",
            data: $('#submitFormulaire').serialize(),
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(data) {
                if(data['error'].length > 0){
                    toastr["error"](data['error'], "Montant incorrect");
                }

                if(data['success'].length > 0){
                    toastr["success"](data['success'], "Saissie correct");
                    setTimeout(function () {
                        window.location.href = "{{ route('caisseManager.open', $data->id) }}"; //will redirect to your blog page (an ex: blog.html)
                    }, 2000); //will call the function after 2 secs.
                }
            },
            error: function (request, status, error) {

                json = $.parseJSON(request.responseText);

                $.each(json.errors, function(key, value){
                    toastr["error"](value, "Saisie incorrect");
                });
            }
        });
    });

</script>