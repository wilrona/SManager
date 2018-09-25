

<div class="panel panel-white">
    <div class="panel-heading border-light">
        <h4 class="panel-title">Magasins</h4>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label for="exampleInputEmail1"> Recherche commande payée </label>
            <input type="text" class="form-control" placeholder="Recherche" id="search_commande" autocomplete="false">
        </div>
        <div class="col-md-4">
            <div class="panel panel-white" id="panel4">
                <div class="panel-body">
                    <h3 class="text-center">Articles sortis</h3>
                    <p class="text-center h2" >
                        <span id="value_encaissement_effectue">{{ $produit_sortie }}</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-white" id="panel4">
                <div class="panel-body">
                    <h3 class="text-center">Articles restant</h3>
                    <p class="text-center h2">
                        {{ $produit_restant }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-white" id="panel4">
                <div class="panel-body">
                    <h3 class="text-center">Articles en magasin</h3>
                    <p class="text-center h2">
                        <span id="value_montant_caisse">{{ $produit_mag }}</span>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="panel panel-white">

    <div class="panel-heading border-light">
        <h4 class="panel-title">Liste des commandes payées</h4>
    </div>
    <div class="panel-body">

        <table class="table  sample_6">
            <thead>
            <tr>
                <th class="col-xs-3">Reference</th>
                <th class="col-xs-3">Client</th>
                <th class="col-xs-3">Total</th>
                <th class="col-xs-3">Date</th>
                <th class="col-xs-1 no-sort"></th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>
</div>

<script src="{{URL::asset('assets/js/app.js')}}"></script>