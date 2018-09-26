

<div class="panel panel-white">
    <div class="panel-heading">
        <h4 class="panel-title">Historique des mouvements</h4>
    </div>
    <div class="panel-body">
        <table class="table  sample_5">
            <thead>
            <tr>
                <th class="col-xs-1">#</th>
                <th>Ref Commande</th>
                <th>Produit</th>
                <th>Quantité</th>
                <th class="col-xs-1"></th>
            </tr>
            </thead>
            <tbody>

            @foreach ($datas as $data)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $data->Commande()->first()->reference }}</td>
                    <td>{{ $data->Produit()->first()->name }}</td>
                    <td>
                        {{ $data->quantite }}
                    </td>
                    <td>
                        <a href="{{ route('caisseManager.detailEcritureEtTransfert', ['ecriture_id' => $data->id, 'magasin_id' => $magasin_id]) }}" data-toggle="modal" data-target="#myModal-hr" data-backdrop="static"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</div>

<script src="{{URL::asset('assets/js/app.js')}}"></script>
<script>
    jQuery(document).ready(function() {
        TableData.init();
        FormElements.init();
    });

    oTable_5.api().columns().every( function () {
        var column = this;
        if(column.index() === 2){
            var name = null;
            name = 'Produit';

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

						
						 
