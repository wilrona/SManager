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
                                        <div class="panel panel-white">
                                            <div class="panel-heading border-light">
                                                <h3 class="text-center">Caisse ouverte</h3>
                                                <h4 class="panel-title text-center">{{ $caisse->name }}</h4>
                                            </div>
                                        </div>
                                        <a href="" class="btn btn-primary btn-block margin-bottom-30">
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
                                                <a href="{{ route('caisseManager.openReload', $caisse->id) }}" id="CaisseManager"> <span class="title"><i class="ti-shopping-cart"></i> Caisse Manager </span> </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('caisseManager.receiveTransfertFond', $caisse->id) }}" id="ReceiveFond"> <span class="title"><i class="ti-credit-card"></i> Reception de fond</span>  @if($exist_receiveFond) <span class="badge pull-right " id="badge_receiveFond">{{ $exist_receiveFond }}</span> @endif </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('caisseManager.indexTransfertFond', $caisse->id) }}" id="TransfertFond"> <span class="title"><i class="ti-folder"></i> Tranfert de fond </span>  </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('caisseManager.storyTransfertFond', $caisse->id) }}" id="StoryTransfertFond"> <span class="title"><i class="ti-receipt"></i> Historique </span>  </a>
                                            </li>
                                        </ul>

                                        <a href="{{ route('caisseManager.close', $caisse->id) }}" class="btn btn-danger btn-block margin-bottom-30">
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


        })

        $('#TransfertFond').on('click', function (e) {
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

        $('#ReceiveFond').on('click', function (e) {
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

        $('#StoryTransfertFond').on('click', function (e) {
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
    </script>
@stop