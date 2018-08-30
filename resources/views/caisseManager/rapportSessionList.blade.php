
<div class="panel panel-white">
    <div class="panel-heading">
        <h4 class="panel-title">Rapport des sessions</h4>
    </div>
    <div class="panel-body">

        <table class="table sample_5">
            <thead>
            <tr>
                <th class="col-xs-1">#</th>
                <th>Ref</th>
                <th>Montant ouverture</th>
                <th>Montant fermeture</th>
                <th>Date ouverture</th>
                <th>Date fermeture</th>
                <th class="col-xs-1"></th>
            </tr>
            </thead>
            <tbody>

            @foreach($datas as $data)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>session_{{ $data->id }}</td>
                    <td>{{ number_format($data->montant_ouverture, 0, '.', ' ')  }}</td>
                    <td>{{ number_format($data->montant_fermeture, 0, '.', ' ')  }}</td>
                    <td>{{ $data->created_at->format('d-m-Y H:i') }}</td>
                    <td>@if($data->created_at != $data->updated_at) {{ $data->updated_at->format('d-m-Y H:i') }} @else Ouvert @endif</td>
                    <td>
                        <a href="{{ route('caisseManager.storyTransfertFond', $data->caisse_id) }}" id="rapportSession" data-session="{{ $data->id }}"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</div>

<script src="{{URL::asset('assets/js/app.js')}}"></script>

