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
			<li>Rapport</li>
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
                                                <h3 class="text-center">Rapport Caisse </h3>
                                                <h4 class="panel-title text-center">{{ $caisse->name }}</h4>
                                            </div>
                                        </div>

                                        <p class="email-options-title no-margin">
                                            NAVIGATION
                                        </p>
                                        <ul class="main-options padding-15">
                                            <li>
                                                <a href="{{ route('caisseManager.rapportSession', $caisse->id) }}" id="Sessions"> <span class="title"> Rapport des sessions</span> </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('caisseManager.storyTransfertFond', $caisse->id) }}" id="Story"> <span class="title"> Rapport des activités </span> </a>
                                            </li>

                                            <li>
                                                <a href="" id="TransfertFond"> <span class="title"> Rapport des ventes </span>  </a>
                                            </li>
                                        </ul>
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
                                        <div class="panel-body">
                                            <div class="col-md-6"></div>

                                            <div class="col-md-6">
                                                <div class="input-group input-daterange format-datepicker-fr">
                                                    <span class="input-group-addon bg-primary">Filtre de</span>
                                                    <input type="text" class="form-control" value="{{ date_format($date_now, 'd/m/Y') }}" id="date_start">
                                                    <span class="input-group-addon bg-primary">à</span>
                                                    <input type="text" class="form-control" value="{{ date_format($date_now, 'd/m/Y') }}" id="date_end">
                                                    <span class="input-group-addon bg-primary" id="filtre" data-href="{{ route('caisseManager.rapportSession', $caisse->id) }}">
                                                       OK
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div id="loading_rapport">
                                        <div class="panel panel-white">

                                            <div class="panel-heading border-light">
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
                                                                <td>{{ $data->montant_ouverture }}</td>
                                                                <td>{{ $data->montant_fermeture }}</td>
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

        $('#Sessions, #Story').on('click', function (e) {
            e.preventDefault();

            var $url = $(this).attr('href');

            var $data_start = $('#date_start').val();
            var $data_end = $('#date_end').val();

            $.ajax({
                url: $url,
                type: 'get',
                data: {date_start: $data_start, date_end : $data_end, type: true},
                success: function(data) {
                    $('#loading_rapport').html(data);
                    $('#filtre').data('href', $url);
                }
            });

        });

        $('#filtre').on('click', function (e) {
            e.preventDefault();

            var $url = $(this).data('href');

            var $data_start = $('#date_start').val();
            var $data_end = $('#date_end').val();

            $.ajax({
                url: $url,
                type: 'get',
                data: {date_start: $data_start, date_end : $data_end, type: true},
                success: function(data) {
                    $('#loading_rapport').html(data);
                    $('#filtre').data('href', $url);
                }
            });

        });

        $('body').on('click', '#rapportSession', function (e) {
            e.preventDefault();

            var $url = $(this).attr('href');
            var $session = $(this).data('session');

            var $data_start = $('#date_start').val();
            var $data_end = $('#date_end').val();

            $.ajax({
                url: $url,
                type: 'get',
                data: {date_start: $data_start, date_end : $data_end, type: true, session: $session},
                success: function(data) {
                    $('#loading_rapport').html(data);
                }
            });

        });

        $('body').on('click', '#retourSession', function (e) {
            e.preventDefault();

            var $url = $(this).attr('href');

            var $data_start = $('#date_start').val();
            var $data_end = $('#date_end').val();

            $.ajax({
                url: $url,
                type: 'get',
                data: {date_start: $data_start, date_end : $data_end, type: true},
                success: function(data) {
                    $('#loading_rapport').html(data);
                }
            });

        });



    </script>
@stop