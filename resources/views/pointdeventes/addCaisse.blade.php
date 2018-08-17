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
    <h4 class="modal-title" id="myModalLabel">Ajouter une caisse </h4>
</div>
<div class="modal-body">

    <table class="table sample_3 table-bordered">
        <thead>
        <tr>
            <th class="no-sort">#</th>
            <th class="col-xs-5">Reference</th>
            <th class="col-xs-5">Nom</th>
            <th class="no-sort col-xs-2">Principal</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($datas as $data)

            <tr id="{{ $data->id }}" class="@if(in_array($data->id, $caisse_pos)) success @endif @if($data->PointDeVente()->where('id', '!=', $id)->count()) danger @endif">
                <td>
                    <input type="checkbox" name="caisse[]" value="{{ $data->id }}" class="checkbox-item checkbox_{{ $data->id }}" @if(in_array($data->id, $caisse_pos)) checked @endif @if($data->PointDeVente()->where('id', '!=', $id)->count()) disabled @endif>
                </td>
                <td>{{ $data->reference }}</td>
                <td>
                    {{ $data->name }}
                </td>
                <td><input type="checkbox" name="caisse_principal[]" value="{{ $data->id }}" class="checkbox-item-principal checkbox_principal_{{ $data->id }}" @if(in_array($data->id, $caisse_principal)) checked @endif @if($data->PointDeVente()->where('id', '!=', $id)->count() || $data->Users()->count()) disabled @endif></td>
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

    jQuery(document).ready(function() {


        $('body table.sample_3').on('click', '.checkbox-item', function(e){
            var $tr = $(this).parent().parent();
            var $id = $tr.attr('id');
            var $action;


            if($tr.hasClass('success')){
                $action = 'remove';
            }else{
                $action = 'add';
            }

            $.ajax({
                url: "<?= route('pos.checkCaisse', ['pos_id' => $id, 'type' => 'select']) ?>",
                type: 'GET',
                data: { id: $id, action: $action },
                success: function(data) {

                    if(data['success'].length > 0){
                        toastr["success"](data['success'], "Succès");
                    }

                    if(data['action'] === 'remove'){
                        $tr.removeClass('success').attr({'style':''});
                        $('.checkbox_'+$id).prop('checked', false);
                        $tr.find('input.checkbox-item-principal').prop('checked', false);
                        if(data['error'].length > 0){
                            toastr["error"](data['error'], "Utilisateur affecté");
                            $tr.addClass('success').attr({'style':'color:#fff'});
                            $('.checkbox_'+$id).prop('checked', true);
                        }
                    }else{
                        $tr.addClass('success').attr({'style':'color:#fff'});
                        $('.checkbox_'+$id).prop('checked', true);
                    }

                    if(data['success_principal'].length > 0 && oTable_3.$('input.checkbox-item-principal:checked').length === 0){
                        toastr["success"](data['success_principal'], "Caisse principale");
                        $tr.find('input.checkbox-item-principal').prop('checked', true);
                    }

                    if(data['error'].length > 0 && oTable_3.$('input.checkbox-item-principal:checked').length === 0){
                        toastr["error"](data['error'], "Caisse principale");
                    }
                }
            });

        });

        $('body table.sample_3').on('click', '.checkbox-item-principal', function(e){
            var $cur = $(this);
            var $tr = $(this).parent().parent();
            var $id = $tr.attr('id');
            var $action;


            if(!$cur.is(':checked')){
                $action = 'remove';
            }else{
                $action = 'add';
            }

            if(oTable_3.$('input.checkbox-item-principal:checked').length > 1){
                $('.checkbox_principal_'+$id).prop('checked', false);
                toastr["error"]('Il existe déja une caisse principale pour ce point de vente', "Erreur");
            }else{
                $.ajax({
                    url: "<?= route('pos.checkCaisse', ['pos_id' => $id, 'type' => 'principale']) ?>",
                    type: 'GET',
                    data: { id: $id, action: $action },
                    success: function(data) {

                        if(data['success'].length > 0){
                            toastr["success"](data['success'], "Caisse principale");

                            if(data['action'] === 'remove'){
                                $tr.find('input.checkbox-item-principal').prop('checked', false);
                            }else{
                                $tr.addClass('success').attr({'style':'color:#fff'});
                                $('.checkbox_'+$id).prop('checked', true);

                            }
                        }

                        if(data['error'].length > 0){
                            toastr["error"](data['error'], "Erreur");
                            if(oTable_3.$('input.checkbox-item-principal:checked').length === 0){
                                $('.checkbox_'+$id).prop('checked', true);
                            }
                        }
                    }
                });
            }

        });

        $('#submits').on('click', function (e) {
            e.preventDefault();

            if(oTable_3.$('input.checkbox-item:checked').length > 0 && oTable_3.$('input.checkbox-item-principal:checked').length > 0 ){

                save();

            }else{

                if(oTable_3.$('input.checkbox-item:checked').length === 0){
                    toastr["error"]('Aucune caisse selectionnée', "Enregistrement Impossible");
                }
                if(oTable_3.$('input.checkbox-item-principal:checked').length === 0){
                    toastr["error"]('Aucune caisse définie comme caisse principale de ce point de vente.', "Enregistrement Impossible");
                }
            }

        });

        function save(){
            $.ajax({
                url: "{{ route('pos.valideCaisse', $id) }}",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: oTable_3.$('input.checkbox-item:checked, input.checkbox-item-principal:checked').serialize(),
                success: function(data) {

                    if(data['success'].length > 0){
                        toastr["success"](data['success'], "Succès");
                    }

                    $.ajax({
                        url: "{{ route('pos.listingCaisse', $id) }}",
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