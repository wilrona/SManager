@extends('layouts.master')

@section('title', 'Welcome YooMee POS')

@section('sidebar')
    @parent

    <!--p>This is appended to the master sidebar.</p-->
@stop

@section('content')
    <div class="wrap-content container" id="container">
        <!-- start: BREADCRUMB -->
		<div class="breadcrumb-wrapper">
			<h4 class="mainTitle no-margin">Caisses</h4>
			<span class="mainDescription">Gestion des caisses </span>
			<ul class="pull-right breadcrumb">
			<li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>Caisses</li>
			<li>Managers</li>
			</ul>
		</div>
		<!-- end: BREADCRUMB -->


        <div class="container-fluid container-fullw padding-bottom-10">
            <div class="row">
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-2">
                            <div class="inbox">
                                <div class="email-options perfect-scrollbar ps-container ps-theme-default" data-ps-id="7b9d5958-3c09-4662-e8ec-65eb1956edd1">
                                    <div class="padding-15">

                                        <a href="{{ route('caisseManager.index') }}" class="btn btn-default btn-block margin-bottom-30">
                                            Retour aux caisses
                                        </a>
                                        <div class="panel panel-white">
                                            <div class="panel-heading border-light">
                                                <h3 class="text-center">Caisse ouverte</h3>
                                                <h4 class="panel-title text-center">{{ $caisse->name }}</h4>
                                            </div>
                                        </div>
                                        <a href="{{ route('commande.index', ['caisse_id' => $caisse->id]) }}" class="btn btn-primary btn-block margin-bottom-30" data-toggle="modal" data-target="#myModal-vt" data-backdrop="static">
                                            Creer une commande
                                        </a>
                                        <a href="{{ route('caisseManager.createTransfertFond', $caisse->id) }}" class="btn btn-primary btn-block margin-bottom-30" data-toggle="modal" data-target="#myModal" data-backdrop="static">
                                            Creer un transfert de fond
                                        </a>

                                        <p class="email-options-title no-margin">
                                            NAVIGATION
                                        </p>
                                        <ul class="main-options padding-15">
                                            <li>
                                                <a href="{{ route('caisseManager.openReload', $caisse->id) }}" class="UrlCaisse"> <span class="title"><i class="ti-shopping-cart"></i> Caisse Manager </span> </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('caisseManager.receiveTransfertFond', $caisse->id) }}" class="UrlCaisse"> <span class="title"><i class="ti-credit-card"></i> Reception de fond</span>  @if($exist_receiveFond) <span class="badge pull-right " id="badge_receiveFond">{{ $exist_receiveFond }}</span> @endif </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('caisseManager.indexTransfertFond', $caisse->id) }}" class="UrlCaisse"> <span class="title"><i class="ti-folder"></i> Tranfert de fond </span>  </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('caisseManager.storyTransfertFond', $caisse->id) }}" class="UrlCaisse"> <span class="title"><i class="ti-receipt"></i> Historique </span>  </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('caisseManager.commandeUser', $caisse->id) }}" class="UrlCaisse"> <span class="title"><i class="ti-receipt"></i> Commande Effectuée </span>  </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('caisseManager.commandePayeLivraison', $caisse->id) }}" class="UrlCaisse"> <span class="title"><i class="ti-receipt"></i> Payée a la livraison </span>  </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('caisseManager.commandePayeMagasin', $caisse->id) }}" class="UrlCaisse"> <span class="title"><i class="ti-receipt"></i> Retrait en magasin </span>  </a>
                                            </li>
                                        </ul>

                                        <a href="#" class="btn btn-danger btn-block margin-bottom-30" id="clotureCaisse">
                                            Cloturer la caisse
                                        </a>
                                    </div>
                                    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;">
                                        <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                    </div>
                                    <div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;">
                                        <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="col-md-12">

                                <style>
                                    .dataTables_filter{
                                        display: none !important;
                                    }

                                    .inbox{
                                        height: auto !important;
                                    }

                                    .inbox .email-options{
                                        border: none;
                                        width: 230px !important;
                                    }
                                </style>

                                <div class="panel-fond"></div>

                                <div class="caisseManager">
                                    <div class="panel panel-white">
                                        <div class="panel-heading border-light">
                                            <h4 class="panel-title">Caisse</h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> Recherche commande à encaisser </label>
                                                <input type="text" class="form-control" placeholder="Recherche" id="search_commande" autocomplete="false">
                                            </div>
                                            <div class="col-md-4">
                                                <div class="panel panel-white" id="panel4">
                                                    <div class="panel-body">
                                                        <h3 class="text-center">Encaissement effectué</h3>
                                                        <p class="text-center h2" >
                                                            <span id="value_encaissement_effectue">{{ number_format($montant_encaisse, 0, '.', ' ') }}</span> XAF
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
                                                            <span id="value_montant_caisse">{{ number_format($montant_caisse, 0, '.', ' ') }}</span> XAF
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="panel panel-white">

                                        <div class="panel-heading border-light">
                                            <h4 class="panel-title">Liste des commandes en attente d'encaissement</h4>
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
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
						
						
						 
    </div>

    <div class="modal fade" id="modal_expire" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h4>Votre session expire dans  <span id="middle_close"></span> seconde(s)</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <div class="hidden" id="myCount"></div>
@stop

@section('footer')
    @parent


    <script>

        $('body').on('keyup', '#search_commande',  function(e){

            e.preventDefault();

            var $url = '{{ route('caisseManager.searchCommande') }}';

            $.ajax({
                url: $url,
                type: 'get',
                data: { q: $(this).val() },
                success: function(data) {

                    oTable_6.fnClearTable();

                    $.each(data['data'], function (index, value) {

                        oTable_6.fnAddData( [
                            value['reference'],
                            value['client'],
                            value['total'],
                            value['date'],
                            '<a href="{{ route('commande.encaissementCommande') }}/'+value['id']+'?caisse_id={{ $caisse->id }}" class="btn btn-primary" data-toggle="modal" data-target="#myModal-vt" data-backdrop="static"><i class="fa fa-credit-card"></i></a>'
                        ] );

                    });

                }
            });
        });

        $('#CaisseManager').on('click', function (e) {
            e.preventDefault();

            var $url = $(this).attr('href');

            $.ajax({
                url: $url,
                type: 'get',
                success: function(data) {
                    $('.caisseManager').html(data);
                    $('.panel-fond').html('');
                }
            });


        });

        $('.UrlCaisse').on('click', function (e) {
            e.preventDefault();
            var $url = $(this).attr('href');

            $.ajax({
                url: $url,
                type: 'get',
                success: function(data) {
                    $('.caisseManager').html('');
                    $('.panel-fond').html(data);
                }
            });
        });

        $('#clotureCaisse').on('click', function(e){
            e.preventDefault();
            swal({
                title: "Cloture de la session",
                text: 'Vous etes sur le point de cloturer votre session. \n Etes-vous sur de le faire ?',
                type: "warning",
                showCancelButton: true,
                cancelButtonText: 'Annuler',
                confirmButtonColor: "#58748B",
                confirmButtonText: "Confirmer",
                closeOnConfirm: false
            }, function() {
                swal({
                    title: "Montant à la fermeture de la session",
                    text: 'Saisir le montant exact que vous avez constatez à la fermeture de la session',
                    type: "input",
                    inputType : "number",
                    inputValue : 0,
                    confirmButtonColor: "#58748B",
                    confirmButtonText: "Valider",
                    closeOnConfirm: false,
                    showCancelButton: true,
                    cancelButtonText: 'Annuler',
                    inputPlaceholder: "Inserer le montant"
                }, function(inputValue){

                    if (inputValue === false) return false;

                    if (inputValue === "" || parseInt(inputValue) < 0) {
                        swal.showInputError("Saisir un montant valide");
                        return false
                    }else{
                        var $url = "{{ route('caisseManager.checkClose', $caisse->id) }}";
                        $.ajax({
                            url: $url,
                            type: 'get',
                            data: { montant : inputValue },
                            success: function(data) {

                                if(data['error'].length > 0){
                                    swal.showInputError(data['error']);
                                }

                                if(data['success'].length > 0){
                                    if(data['principal'] === 0){
                                        confirmationRedirection()
                                    }else{
                                        swal({
                                            title: data['success'],
                                            text: 'Ce montant va être transferé à la caisse centrale de votre point de vente',
                                            type: "success",
                                            confirmButtonColor: "#58748B",
                                            confirmButtonText: "Valider la cloture",
                                            closeOnConfirm: false,
                                            showCancelButton: true,
                                            cancelButtonText: 'Annuler'
                                        }, function () {
                                            AjaxTransfertFond(data['code']);
                                        });

                                    }
                                }

                            }
                        });
                    }

                })


            });
        });

        function confirmationRedirection($swal){

            var $url = "{{ route('caisseManager.close', $caisse->id) }}";

            $.ajax({
                url: $url,
                type: 'get',
                success: function(data) {

                    if(!$swal){
                        swal({
                            title: "Cloture terminée avec success",
                            text: 'La cloture de votre session a été réussi avec succès',
                            type: "success",
                            showCancelButton: false,
                            showconfirmButton: false
                        });
                    }

                    setTimeout(function () {
                        window.location.href = "{{ route('caisseManager.index') }}";
                    }, 2000); //will call the function after 2 secs.

                }
            });

        }

        function AjaxTransfertFond(code){
            swal({
                title: "Votre code de transfert est: \n "+code,
                text: "Code du transfert !",
                type: "success",
                showCancelButton: false,
                showconfirmButton: true,
                confirmButtonColor: "#58748B",
                confirmButtonText: "Terminer la cloture"
            }, function () {
                var $url = "{{ route('caisseManager.transfertFondClose', $caisse->id) }}";
                $.ajax({
                    url: $url,
                    type: 'get',
                    data : { code : code},
                    success: function (data) {
                        confirmationRedirection();
                    }
                });

            });

        }

        counter = {
            $element : null,
            count : 0,
            maxCount : 1200,
            middleCount: 1140,
            minCount: 60,
            interval : null,
            //Initialize
            init : function(compteur){
                this.$element = compteur;
                this.run();
                this.interval = window.setInterval("counter.run();", 1000);
            },
            // Run
            run : function(){
                if (this.count === this.middleCount){
//                 window.clearInterval(this.interval);
                    $('#modal_expire').modal({
                        show:true,
                        backdrop:'static'
                    });
                }
                if (this.count >= this.middleCount){
                    $('#middle_close').text(this.minCount);
                    this.minCount--;
                }
                if(this.count === this.maxCount){
                    window.clearInterval(this.interval);
                    confirmationRedirection(true);
                }
                this.$element.html(this.count);
                this.count++;
            }
        };

        $.fn.counter = function(){
            counter.init(this);
        };

        $('body').on('click', function(){
            counter.count = 0
        });

        $('#myCount').counter();

    </script>
@stop