

<div class="panel panel-white">
    <div class="panel-heading border-light">
        <h4 class="panel-title">Caisse</h4>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label for="exampleInputEmail1"> Recherche commande à encaisser </label>
            <input type="text" class="form-control" placeholder="Recherche">
        </div>
        <div class="col-md-4">
            <div class="panel panel-white" id="panel4">
                <div class="panel-body">
                    <h3 class="text-center">Encaissement effectué</h3>
                    <p class="text-center h2">
                        {{ number_format($montant_encaisse, 0, '.', ' ') }} XAF
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-white" id="panel4">
                <div class="panel-body">
                    <h3 class="text-center">Fond de caisse</h3>
                    <p class="text-center h2">
                        {{ number_format($exist_session->first()->montant_ouverture, 0, '.', ' ')  }} XAF
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-white" id="panel4">
                <div class="panel-body">
                    <h3 class="text-center">Montant en caisse</h3>
                    <p class="text-center h2">
                        {{ number_format($montant_caisse, 0, '.', ' ') }} XAF
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="panel panel-white">

    <style>
        .dataTables_filter{
            display: none !important;
        }

        .inbox{
            height: auto !important;
        }
    </style>

    <div class="panel-heading border-light">
        <h4 class="panel-title">Liste des commandes en attente d'encaissement</h4>
    </div>
    <div class="panel-body">

        <table class="table  sample_5">
            <thead>
            <tr>
                <th class="col-xs-1">#</th>
                <th>Caisse</th>
                <th class="col-xs-1"></th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>
</div>

<script src="{{URL::asset('assets/js/app.js')}}"></script>