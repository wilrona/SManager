

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
                <th>Client</th>
                <th>Etat</th>
                <th>Date</th>
                <th class="col-xs-1"></th>
            </tr>
            </thead>
            <tbody>

            @foreach ($datas as $data)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $data->reference }}</td>
                    <td>{{ $data->Client()->first()->display_name }}</td>

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
                    </td>
                    <td>{{ $data->pivot->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        <a href="{{ route('commande.commandePosDetail', $data->id) }}" data-toggle="modal" data-target="#myModal-hr-lg" data-backdrop="static">
                            <i class="fa fa-eye"></i>
                        </a>
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
</script>

						
						 
