

<div class="panel panel-white">
    <div class="panel-heading">
        <h4 class="panel-title">Transfert de fond de la caisse</h4>
    </div>
    <div class="panel-body">
        <table class="table  sample_3">
            <thead>
            <tr>
                <th class="col-xs-1">#</th>
                <th>Ref</th>
                <th>Transfert à </th>
                <th>Montant</th>
                <th>Etat</th>
                <th class="col-xs-1"></th>
            </tr>
            </thead>
            <tbody>

            @foreach ($datas as $data)
                <?php
                        $transfert = $data->TransfertFond()->first()
                ?>
                <tr @if($transfert->etat == 1) class="success" @endif @if($transfert->etat == 2) class="danger" @endif>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $transfert->reference }}</td>
                    <td>{{ $transfert->caisse_receive()->first()->name }}</td>
                    <td>{{ $transfert->montant }}</td>
                    <td>
                        @if($transfert->etat == 0)
                            En expédition
                        @elseif($transfert->etat == 1)
                            Receptionné
                        @else
                            Annulé
                        @endif
                    </td>
                    <td>

                        <div class="btn-group">
                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true"> <i class="fa fa-bars"></i> </a>
                            <ul role="menu" class="dropdown-menu dropdown-light pull-right">
                                <li>
                                    <a href="" data-toggle="modal" data-target="#myModal-lg" data-backdrop="static"> Consultation</a>
                                </li>
                                @if($transfert->etat == 0)
                                <li>
                                    <a href="{{ route('caisseManager.cancelTransfertFond', $transfert->id) }}" data-toggle="modal" data-target="#myModal" data-backdrop="static"> Annulation</a>
                                </li>
                                @endif
                            </ul>
                        </div>

                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</div>

<script src="{{URL::asset('assets/js/app.js')}}"></script>

						
						 
