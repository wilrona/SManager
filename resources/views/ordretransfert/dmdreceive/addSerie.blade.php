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
    <h4 class="modal-title" id="myModalLabel">Ajout des series/lots</h4>
</div>

<div class="modal-body">
    <fieldset>
        <legend>
            Information de la ligne de la demande
        </legend>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label> Magasin d'approvisionnement </label>
                    <input type="text" value="{{ $demande->magasin_appro()->first()->name }}" class="form-control" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"> Produit de la ligne </label>
                    <input type="text" value="{{ $ligne->produit()->first()->name }}" class="form-control" disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="block"> Recherche d'un N° Serie/Lot </label>
                    <div class="input-group">
                        <input type="text" id="form-field-search" class="form-control" name="search_produit" placeholder="Entrer un numéro de serie/lot">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary submit_search">
                                <i class="fa fa-search"></i>
                                Go!
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> Quantité à expédier / Quantité demandée</label>
                    <div class="input-group">
                        <input type="number" class="form-control text-right qte_dmd" value="{{ $ligne->qte_a_exp }}" disabled>
                        <span class="input-group-addon"> / {{ $ligne->qte_dmd - $ligne->qte_exp }} </span>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <table class="table sample_3 table-bordered">
        <thead>
        <tr>
            <th class="no-sort">#</th>
            <th class="col-xs-5">No Serie</th>
            <th class="col-xs-5">No Lot</th>
            <th class="no-sort col-xs-2">Type</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($series as $data)
            <tr id="{{ $data->id }}" class="@if($data->pivot->mouvement == 1 && in_array($data->id, $current_serie)) success @endif">
                <td>
                    <input type="checkbox" name="produit[]" value="{{ $data->id }}" @if($data->pivot->mouvement == 1 && in_array($data->id, $current_serie)) checked @endif class="checkbox-item checkbox_{{ $data->id }}">
                </td>
                <td>@if($data->type == 0) {{ $data->reference }} @else Aucun @endif</td>
                <td>
                    @if($data->type == 1)
                        {{ $data->reference }} <br>
                        <?php
		                    $count = $data->SeriesLots()->whereHas('Magasins', function($q) use ($demande, $data)
                            {
	                            $q->whereIn('id', [$demande->mag_appro_id])->where('mouvement', '=', $data->pivot->mouvement);
                            })->count();

                        ?>
                        Qté du lot : {{ $count }}
                    @else
                        {{ $data->lot_id ? $data->Lot()->first()->reference : '' }}
                    @endif
                </td>
                <td>@if($data->type == 1) Lot @else Série @endif</td>
            </tr>
        @endforeach


        </tbody>
    </table>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Fermer</button>
    <input type="button"  id="submits" class="btn btn-primary btn-sm" value="Valider"/>
</div>

<script src="{{URL::asset('assets/js/app.js')}}"></script>
<script>
    jQuery(document).ready(function() {
        TableData.init();
        FormElements.init();
    });

    oTable_3.api().columns().every( function () {
        var column = this;
        if(column.index() === 3){
            var name = null;
            name = 'Type';

            var select = $('<select class="form-control" style="width: 100%"><option value="">'+name+'</option></select>')
                .appendTo( $(column.header()).empty() )
                .on( 'change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column.search( val ? '^'+val+'$' : '', true, false ).draw();
                } );

            column.data().unique().sort().each( function ( d, j ) {
                select.append( '<option value="'+d+'">'+d+'</option>' )
            } );
        }

    } );

    jQuery(document).ready(function() {

        $('#form-field-search').on('keyup', function(){
            oTable_3.fnFilter($(this).val());
            if($(this).val().length > 0){
                if(oTable_3.fnSettings().fnRecordsDisplay() === 1){
                    if(!oTable_3.$('tbody > tr').hasClass('success')){
                        oTable_3.$('tbody > tr').trigger('click');
                    }

                }
            }
        });

        $('body table.sample_3').on('click', 'tbody > tr', function(e){
            var $tr = $(this);
            var $id = $tr.attr('id');
            var $action;
            var $count = $('.qte_dmd').val();

            if($tr.hasClass('success')){
                $action = 'remove';
            }else{
                $action = 'add';
            }

            $.ajax({
                url: "<?= route('receive.checkSerie', $ligne->id) ?>",
                type: 'GET',
                data: { id: $id, action: $action, count: $count },
                success: function(data) {

                    if(data['success'].length > 0){
                        toastr["success"](data['success'], "Succès");
                    }

                    if(data['action'] === 'remove'){
                        $tr.removeClass('success').attr({'style':''});
                        $('.checkbox_'+$id).prop('checked', false);
                    }else{
                        $tr.addClass('success').attr({'style':'color:#fff'});
                        $('.checkbox_'+$id).prop('checked', true);
                    }

                    if(data['error'].length > 0){
                        toastr["error"](data['error'], "Erreur");
                        $tr.removeClass('success').attr({'style':''});
                        $('.checkbox_'+$id).prop('checked', false);
                    }

                    $('.qte_dmd').val(data['count']);
                    $count = data['count'];
                }
            });

        });

        $('#submits').on('click', function (e) {
            e.preventDefault();

            var $qte_a_exp = "<?= $ligne->qte_a_exp ?>";

            if(oTable_3.$('input.checkbox-item:checked').length > 0 ){

                save();

            }else{

                if(parseInt($qte_a_exp) > 0){
                    save()
                }else{
                    toastr["error"]('Aucun numéro de serie selectionné', "Erreur");
                }
            }

        });

        function save(){
            $.ajax({
                url: "<?= route('receive.validSerie', $ligne->id)?>",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: oTable_3.$('input.checkbox-item:checked').serialize(),
                success: function(data) {

                    if(data['success'].length > 0){
                        toastr["success"](data['success'], "Succès");
                    }

                    $.ajax({
                        url: "<?= route('receive.listing', $ligne->ordre_transfert_id)?>",
                        type: 'GET',
                        success : function(list){
                            $('#loading').html(list);
                            $('.close').trigger('click');
                        }
                    });

                }
            });
        }

    });


</script>