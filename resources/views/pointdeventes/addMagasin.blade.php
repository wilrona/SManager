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
<div class="modal-body">

        <table class="table sample_5 table-bordered">
            <thead>
            <tr>
                <th class="no-sort">#</th>
                <th class="col-xs-5">Reference</th>
                <th class="col-xs-5">Nom</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($datas as $data)

                <tr id="{{ $data->id }}" class="@if(in_array($data->id, $magasin_pos)) success @endif @if($data->pos_id != $id) danger @endif">
                    <td>
                        <input type="checkbox" name="magasin[]" value="{{ $data->id }}" class="checkbox-item checkbox_{{ $data->id }}" @if(in_array($data->id, $magasin_pos)) checked @endif @if($data->pos_id != $id) disabled @endif>
                    </td>
                    <td>{{ $data->reference }}</td>
                    <td>
                        {{ $data->name }}
                    </td>
                </tr>

            @endforeach


            </tbody>
        </table>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Fermer</button>
    <input type="button"  id="submits" class="btn btn-primary btn-sm" value="Valider"/>
</div>

<script src="{{ URL::asset('assets/js/app.js')}}"></script>

<script>
    jQuery(document).ready(function() {
        TableData.init();
        FormElements.init();
    });

    jQuery(document).ready(function() {


        $('body table.sample_5').on('click', '.checkbox-item', function(e){
            var $tr = $(this).parent().parent();
            var $id = $tr.attr('id');
            var $action;


            if($tr.hasClass('success')){
                $action = 'remove';
            }else{
                $action = 'add';
            }

            $.ajax({
                url: "<?= route('pos.checkMagasin', ['pos_id' => $id]) ?>",
                type: 'GET',
                data: { id: $id, action: $action },
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
                        $tr.addClass('success').attr({'style':'color:#fff'});
                        $('.checkbox_'+$id).prop('checked', true);
                    }
                }
            });

        });

        $('#submits').on('click', function (e) {
            e.preventDefault();

            if(oTable_5.$('input.checkbox-item:checked').length > 0){

                save();

            }else{

                toastr["error"]('Aucun magasin selectionné', "Enregistrement Impossible");

            }

        });

        function save(){
            $.ajax({
                url: "{{ route('pos.valideMagasin', $id) }}",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: oTable_5.$('input.checkbox-item:checked').serialize(),
                success: function(data) {

                    if(data['success'].length > 0){
                        toastr["success"](data['success'], "Succès");
                    }

                    $.ajax({
                        url: "{{ route('pos.listingMagasin', $id) }}",
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