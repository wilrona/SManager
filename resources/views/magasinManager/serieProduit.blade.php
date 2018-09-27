<style>

    .no_filter_7 .dataTables_filter{
        display: none !important;
    }


    .input-group-addon {
        min-width: 115px;
        text-align: center;
        font-size: 20px;
        letter-spacing: 3px;
    }
</style>


<div class="panel">
    <div class="panel-body">
        <div class="col-md-12">
            <div class="input-group">
                <input type="text" placeholder="Recherche numéro de serie" class="form-control input-lg" id="form-field-search">
                <span class="input-group-addon"><span class="qte_current">0</span>/<span class="qte_dmd">{{ $ligne->pivot->qte }}</span></span>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-white">
    <div class="panel-body no_filter_7">

        <table class="table sample_7">
            <thead>
            <tr>
                <th class="no-sort col-xs-1">#</th>
                <th >Reference</th>
                <th >Produit</th>
                <th >Lot</th>
            </tr>
            </thead>
            <tbody>

                @foreach($exist_prod as $serie)

                    <tr id="{{ $serie->id }}" class="">
                        <td>
                            <input type="checkbox" name="produit[]" value="{{ $serie->id }}" class="checkbox-item checkbox_{{ $serie->id }}">
                        </td>
                        <td>{{ $serie->reference }}</td>
                        <td>{{ $serie->produit->name }}</td>
                        <td>@if($serie->lot_id) {{ $serie->lot->reference }} @endif</td>

                    </tr>

                @endforeach

            </tbody>
        </table>

    </div>

</div>
<script src="{{URL::asset('assets/js/app.js')}}"></script>
<script>

    $('#form-field-search').on('keyup', function(){
        oTable_7.fnFilter($(this).val());
    });

    $('.sample_7').on('click', 'tbody > tr', function(e){
        var $tr = $(this);
        var $id = $tr.attr('id');
        var $action;
        var $count = $('.qte_current').html();
        var $totalcount = $('.qte_dmd').html();

        if($tr.hasClass('success')){
            $action = 'remove';
        }else{
            $action = 'add';
        }

        $.ajax({
            url: "{{ route('magasinManager.serieProduitCheck') }}",
            type: 'GET',
            data: { id: $id, action: $action, count: $count, totalCount : $totalcount },
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

                $('.qte_current').html(data['count']);

                console.log(data['content']);
            }
        });


    });
</script>