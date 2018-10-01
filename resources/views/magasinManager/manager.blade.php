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
			<h4 class="mainTitle no-margin">Magasins</h4>
			<span class="mainDescription">Gestion des magasins </span>
			<ul class="pull-right breadcrumb">
			<li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>Magasins</li>
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

                                        <a href="{{ route('magasinManager.index') }}" class="btn btn-default btn-block margin-bottom-30">
                                            Retour aux magasins
                                        </a>
                                        <div class="panel panel-white">
                                            <div class="panel-heading border-light">
                                                <h3 class="text-center">Magasin ouvert</h3>
                                                <h4 class="panel-title text-center">{{ $magasin->name }}</h4>
                                            </div>
                                        </div>

                                        <p class="email-options-title no-margin">
                                            NAVIGATION
                                        </p>
                                        <ul class="main-options padding-15">
                                            <li>
                                                <a href="{{ route('magasinManager.openReload', $magasin->id) }}" id="CaisseManager"> <span class="title"><i class="ti-shopping-cart"></i> Magasin Manager </span> </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('magasinManager.storyTransfertStock', $magasin->id) }}" id="StoryTransfertStock"> <span class="title"><i class="ti-receipt"></i> Historique </span>  </a>
                                            </li>
                                        </ul>

                                        <a href="#" class="btn btn-danger btn-block margin-bottom-30" id="clotureCaisse">
                                            Fermer le magasin
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
                                    .no_filter_6 .dataTables_filter{
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
                                                            <span id="value_article_sortie">{{ $produit_sortie }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="panel panel-white" id="panel4">
                                                    <div class="panel-body">
                                                        <h3 class="text-center">Articles restant</h3>
                                                        <p class="text-center h2">
                                                            <span id="value_article_restant">{{ $produit_restant }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="panel panel-white" id="panel4">
                                                    <div class="panel-body">
                                                        <h3 class="text-center">Articles en magasin</h3>
                                                        <p class="text-center h2">
                                                            {{ $produit_mag }}
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
                                        <div class="panel-body no_filter_6">

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
@stop

@section('footer')
    @parent
    <script>
        $('body').on('keyup', '#search_commande',  function(e){

            e.preventDefault();

            var $url = '{{ route('magasinManager.searchCommande') }}';

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
                            '<a href="{{ route('magasinManager.stockCommande') }}/'+value['id']+'?magasin_id={{ $magasin->id }}" class="btn btn-primary" data-toggle="modal" data-target="#myModal-vt" data-backdrop="static"><i class="fa fa-credit-card"></i></a>'
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

                confirmationRedirection();

            });
        });

        $('#StoryTransfertStock').on('click', function (e) {
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
        })

        function confirmationRedirection(){

            var $url = "{{ route('magasinManager.close', $magasin->id) }}";

            $.ajax({
                url: $url,
                type: 'get',
                success: function(data) {

                    swal({
                        title: "Cloture terminée avec success",
                        text: 'La cloture de votre session a été réussi avec succès',
                        type: "success",
                        showCancelButton: false,
                        showconfirmButton: false
                    });

                    setTimeout(function () {
                        window.location.href = "{{ route('magasinManager.index') }}";
                    }, 2000); //will call the function after 2 secs.

                }
            });

        }
    </script>
@stop