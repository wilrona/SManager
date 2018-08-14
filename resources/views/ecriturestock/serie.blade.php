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
        @if($data->type_ecriture == 1)
            Expédition
        @else
            Reception
        @endif
        - Transfert <b>{{ $data->Transfert()->first()->reference }}</b>
    </h4>
    <h5 style="margin-top: 0;">{{ $data->created_at->format('d-m-Y') }}</h5>
</div>

<div class="modal-body">

    <table class="table sample_4 table-bordered">
        <thead>
        <tr>
            <th class="col-xs-5">No Serie</th>
            <th class="col-xs-5">No Lot</th>
            <th class="no-sort col-xs-2">Type</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($data->Series()->get() as $serie)

            <tr>
                <td>@if($serie->type == 0) {{ $serie->reference }} @else Aucun @endif</td>
                <td>
                    @if($serie->type == 1)
                        {{ $serie->reference }} <br>
		                <?php
		                $count = 0;
		                $serial = $serie->SeriesLots()->get();

		                ?>

                        @foreach($serial as $ser)
                            @if($ser->Transferts()->where('id', '=', $serie->id)->count())
				                <?php $count += 1 ?>
                            @endif
                        @endforeach
                        Qté du lot : {{ $count }}
                    @else
                        {{ $serie->lot_id ? $serie->Lot()->first()->reference : '' }}
                    @endif
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

    oTable_4.api().columns().every( function () {
        var column = this;
        if(column.index() === 2){
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


</script>