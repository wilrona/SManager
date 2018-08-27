

<div class="panel panel-white">
    <div class="panel-heading">
        <h4 class="panel-title">Reception de fond de la caisse</h4>
    </div>
    <div class="panel-body">
        <table class="table  sample_3">
            <thead>
            <tr>
                <th class="col-xs-1">#</th>
                <th>Ref</th>
                <th>Transfert de </th>
                <th>Montant</th>
                <th class="col-xs-1"></th>
            </tr>
            </thead>
            <tbody>

            @foreach ($datas as $data)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $data->reference }}</td>
                    <td>{{ $data->caisse_sender()->first()->name }}</td>
                    <td>{{ number_format($data->montant, 0, '.', ' ') }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('caisseManager.receivedTransfertFond', $data->id) }}" data-toggle="modal" data-target="#myModal" data-backdrop="static"> <i class="fa fa-download"></i> Reception</a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</div>

<script src="{{URL::asset('assets/js/app.js')}}"></script>
						
						 
