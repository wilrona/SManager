<?php
/**
 * Created by IntelliJ IDEA.
 * User: online2
 * Date: 28/06/2018
 * Time: 12:02
 */
?>

<style>
    .table-no-search .dataTables_filter{
        display: none !important;
    }
</style>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Reception du produit <b>{{ $datas->produit()->first()->name }}</b></h4>
</div>

<div class="modal-body">
    <fieldset>
        <legend>
            Information sur la reception du produit
        </legend>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="block"> Recherche d'un N° Serie/Lot </label>
                    <div class="input-group">
                        <input type="text" id="form-field-search" class="form-control" name="search_produit" placeholder="Entrer un numéro de serie/lot" autocomplete="">
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
                    <label> Quantité reçue / Quantité expédiée</label>
                    <div class="input-group">
                        <input type="number" class="form-control text-right qte_dmd" value="{{ $datas->qte_a_recu }}" disabled>
                        <span class="input-group-addon"> / {{ $datas->qte_exp - $datas->qte_recu }} </span>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <div class="table-no-search">
        <table class="table sample_5 table-bordered">
            <thead>
            <tr>
                <th class="no-sort">#</th>
                <th class="col-xs-4">No Serie</th>
                <th class="col-xs-4">No Lot</th>
                <th class="col-xs-4">Ref. Reception</th>
                <th class="no-sort col-xs-4">Type</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($series as $data)
                    @if($data->transferts()->where([['ordre_transfert_id', '=', $ordre_transfert], ['ok', '=', 0]])->count())
                        <tr class="@if(in_array($data->id, $selected)) success @endif" id="{{ $data->id }}">
                            <td>
                                <input type="checkbox" name="produit[]" value="{{ $data->id }}" @if(in_array($data->id, $selected)) checked @endif class="checkbox-item checkbox_{{ $data->id }}">
                            </td>
                            <td>@if($data->type == 0) {{ $data->reference }} @else Aucun @endif</td>
                            <td>
                                @if($data->type == 1)
                                    {{ $data->reference }} <br>
                                    Qté du lot : {{ $data->SeriesLots()->whereHas('transferts', function($q) use($ordre_transfert){
                                        $q->where([['ordre_transfert_id', '=', $ordre_transfert], ['ok', '=', 0]]);
                                    })->count() }}
                                @else
                                    {{ $data->lot_id ? $data->Lot()->first()->reference : '' }}
                                @endif
                            </td>
                            <td>
                                {{ $data->transferts()->where('ordre_transfert_id', '=', $ordre_transfert)->first()->reference }}
                            </td>
                            <td>@if($data->type == 1) Lot @else Série @endif</td>
                        </tr>

                        @if($data->type == 1)

                            @foreach($data->SeriesLots()->get() as $item)
                                @if($item->transferts()->where('ordre_transfert_id', '=', $ordre_transfert)->count())
                                    <tr class="@if(in_array($item->id, $selected)) success @endif" id="{{ $item->id }}">
                                        <td>
                                            <input type="checkbox" name="produit[]" value="{{ $item->id }}" @if(in_array($item->id, $selected)) checked @endif class="checkbox-item checkbox_{{ $item->id }}">
                                        </td>
                                        <td>@if($item->type == 0) {{ $item->reference }} @else Aucun @endif</td>
                                        <td>
                                                {{ $item->lot_id ? $item->Lot()->first()->reference : '' }}
                                        </td>
                                        <td>
                                            {{ $item->transferts()->where('ordre_transfert_id', '=', $ordre_transfert)->first()->reference }}
                                        </td>
                                        <td>@if($item->type == 1) Lot @else Série @endif</td>
                                    </tr>
                                @endif
                            @endforeach

                        @endif
                    @endif
                @endforeach

            </tbody>
        </table>
    </div>



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

    oTable_5.api().columns().every( function () {
        var column = this;
        if(column.index() === 4){
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
            oTable_5.fnFilter($(this).val());
            if($(this).val().length > 0){
                if(oTable_5.fnSettings().fnRecordsDisplay() === 1){
                    if(!oTable_5.$('tbody > tr').hasClass('success')){
                        oTable_5.$('tbody > tr').trigger('click');
                    }

                }
            }
        });

        $('body table.sample_5').on('click', 'tbody > tr', function(e){
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
                url: "<?= route('dmd.checkSerieProduitReception', $datas->id)?>",
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

            var $qte_a_exp = "<?= $datas->qte_a_recu ?>";

            if(oTable_5.$('input.checkbox-item:checked').length > 0 ){
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
                url: "<?= route('dmd.validSerieProduitReception', $datas->id)?>",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: oTable_5.$('input.checkbox-item:checked').serialize(),
                success: function(data) {

                    if(data['success'].length > 0){
                        toastr["success"](data['success'], "Succès");
                    }

                    $.ajax({
                        url: "<?= route('dmd.listdmdProduitReception', $datas->ordre_transfert_id)?>",
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