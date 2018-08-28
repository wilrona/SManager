

<div class="panel panel-white">
    <div class="panel-heading">
        <h4 class="panel-title">Historique des transactions</h4>
    </div>
    <div class="panel-body">
        <table class="table  sample_5">
            <thead>
            <tr>
                <th class="col-xs-1">#</th>
                <th>Libelle</th>
                <th>Montant</th>
                <th>Paiement</th>
                <th>Type transaction</th>
                <th>Date/heure</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($datas as $data)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $data->libelle }}</td>
                    <td>{{ $data->montant }} {{ $data->devise }}</td>
                    <td>
                        {{ $data->type_paiement }}
                    </td>
                    <td>
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
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</div>

<script src="{{URL::asset('assets/js/app.js')}}"></script>

						
						 
