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
    <h4 class="modal-title" id="myModalLabel">
        Numero de serie du magasin - <b>{{ $data->name }}</b>
    </h4>
</div>

<div class="modal-body">

    <table class="table sample_5">
        <thead>
        <tr>
            <th class="">#</th>
            <th class="col-xs-4">No Serie</th>
            <th class="col-xs-4">No Lot</th>
            <th class="col-xs-3">Produit</th>
            <th class="col-xs-1 no-sort">Type</th>
        </tr>
        </thead>
        <tbody>

        <?php
        $series = $data->Stock()->has('magasins', '=', 1)->get();
        $id = $data->id;
        ?>
        @foreach($series as $serie)

            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>@if($serie->type == 0) {{ $serie->reference }} @else Aucun @endif</td>
                <td>
                    @if($serie->type == 1)
                        {{ $serie->reference }} <br>
                        Qté du lot : {{ $serie->SeriesLots()->whereHas('Magasins', function($q) use ($id)
                                                        {
                                                                $q->where('id','=', $id);
                                                        })->count() }}
                    @else
                        {{ $serie->lot_id ? $serie->Lot()->first()->reference : '' }}
                    @endif
                </td>
                <td>
                    {{ $serie->Produit()->first()->name }}
                </td>
                <td>@if($serie->type == 1) Lot @else Série @endif</td>
            </tr>
        @endforeach


        </tbody>
    </table>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Fermer</button>
</div>

<script src="{{URL::asset('assets/js/app.js')}}"></script>

<script>
    jQuery(document).ready(function() {
        TableData.init();
        FormElements.init();
    });

</script>