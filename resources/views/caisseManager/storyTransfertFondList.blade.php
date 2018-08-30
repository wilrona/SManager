<div class="panel panel-white">
    <div class="panel-heading">
        <h4 class="panel-title">Rapport des activités @if(isset($request['session'])) de la <b>session_{{ $session->id }}</b> @endif</h4>
        @if(isset($request['session']))
        <ul class="panel-heading-tabs border-light">
            <li class="middle-center">
                <a href="{{ route('caisseManager.rapportSession', $caisse_id) }}" class="btn btn-o btn-sm btn-default" id="retourSession">Retour</a>
            </li>

        </ul>
        @endif
    </div>
    <div class="panel-body">
        <table class="table  sample_5">
            <thead>
            <tr>
                <th class="col-xs-1">#</th>
                <th>Libelle</th>
                <th>Montant</th>
                <th>Paiement</th>
                <th class="no-sort">Type transaction</th>
                <th>Date/heure</th>
                <th class="col-xs-1"></th>
            </tr>
            </thead>
            <tbody>

            @foreach ($datas as $data)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $data->libelle }}</td>
                    <td>{{ number_format($data->montant, 0, '.', ' ')  }} {{ $data->devise }}</td>
                    <td>
                        {{ $data->type_paiement }}
                    </td>
                    <td>
                        @if($data->type_ecriture == 0)
                            Fermeture session
                        @endif
                        @if($data->type_ecriture == 1)
                            Ouverture session
                        @endif

                        @if($data->type_ecriture == 2)
                            Approvisionnement
                        @endif

                        @if($data->type_ecriture == 3)
                            Encaissement
                        @endif

                        @if($data->type_ecriture == 4)
                            Sortie de fond
                        @endif
                    </td>
                    <td>
                        {{ $data->created_at->format('d-m-Y H:i') }}
                    </td>
                    <td>
                        <a href="{{ route('caisseManager.detailEcritureEtTransfert', ['ecriture_id' => $data->id, 'caisse_id' => $caisse_id]) }}" data-toggle="modal" data-target="#myModal-hr" data-backdrop="static"><i class="fa fa-eye"></i></a>
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
        if(column.index() === 4){
            var name = null;
            name = 'Type transaction';

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

						
						 
