
<div class="panel panel-white">
    <div class="panel-heading border-light">
        <h4 class="panel-title">Liste des commandes payées à la livraison</h4>
    </div>
    <div class="panel-body">
        <table class="table  sample_5">
            <thead>
            <tr>
                <th class="col-xs-1">#</th>
                <th>Reference</th>
                <th>Client</th>
                <th>Montant</th>
                <th>Etat</th>
                <th>Date creation</th>
                <th class="col-xs-1"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($datas as $data)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $data->reference }}</td>
                    <td>{{ $data->client()->first()->display_name }}</td>
                    <td>{{ number_format($data->total, 0, '.', ' ') }}</td>
                    <td>
                        @if($data->etat == 0)
                            Enregistré
                        @endif
                        @if($data->etat == 1)
                            Payé
                        @endif
                        @if($data->etat == 2)
                            Produit Traité partiellement
                        @endif
                        @if($data->etat == 3)
                            Produit Traité
                        @endif
                        @if($data->etat == 4)
                            Livré partiellement
                        @endif
                        @if($data->etat == 5)
                            Livré
                        @endif
                        @if($data->etat == 6)
                            Annulé
                        @endif
                    </td>
                    <td>{{ $data->created_at->format('d-m-Y H:i') }}</td>

                    <td>
                        <a href="{{ route('commande.encaissementCommande', $data->id) }}" data-toggle="modal" data-target="#myModal-vt" data-backdrop="static">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>


    </div>
</div>

