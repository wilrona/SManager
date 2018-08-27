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
			</ul>
		</div>
		<!-- end: BREADCRUMB -->

        <div class="container-fluid container-fullw padding-bottom-10">
                            @if(session()->has('ok'))
                                <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
                            @endif
							<div class="row">
								<div class="col-md-12">

                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Caisse centrale du point de vente</h4>
                                            </div>
                                            <div class="panel-body">
                                                <table class="table  sample_3">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-xs-1">#</th>
                                                        <th>Caisse</th>
                                                        <th class="col-xs-1"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach ($datas_pos as $data)
                                                        <tr @if($data->etat) class="success" @endif>
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $data->name }}</td>
                                                            <td>

                                                                <div class="btn-group">
                                                                    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true"> <i class="fa fa-bars"></i> </a>
                                                                    <ul role="menu" class="dropdown-menu dropdown-light pull-right">
                                                                        <li>
                                                                            <a href=""><i class="fa fa-bar-chart"></i> Rapport</a>
                                                                        </li>
                                                                        @if($data->etat == 0)
                                                                            <li>
                                                                                <a href="{{ route('caisseManager.preopen', $data->id) }}" data-toggle="modal" data-target="#myModal" data-backdrop="static"> <i class="fa fa-toggle-off"></i> Ouverture</a>
                                                                            </li>
                                                                        @else
                                                                            <li>
                                                                                <a href="{{ route('caisseManager.open', $data->id) }}"> <i class="fa fa-toggle-on"></i> Manager la caisse</a>
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

                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Mes Caisses</h4>
                                            </div>
                                            <div class="panel-body">
                                                <table class="table  sample_3">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-xs-1">#</th>
                                                        <th>Caisse</th>
                                                        <th class="col-xs-1"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach ($datas as $data)
                                                        <tr  @if($data->etat) class="success" @endif>
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $data->name }}</td>
                                                            <td>

                                                                <div class="btn-group">
                                                                    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true"> <i class="fa fa-bars"></i> </a>
                                                                    <ul role="menu" class="dropdown-menu dropdown-light pull-right">
                                                                        <li>
                                                                            <a href=""><i class="fa fa-bar-chart"></i> Rapport</a>
                                                                        </li>
                                                                        @if($data->pivot->principal)
                                                                            @if($data->etat == 0)
                                                                                <li>
                                                                                    <a href="{{ route('caisseManager.preopen', $data->id) }}" data-toggle="modal" data-target="#myModal" data-backdrop="static"> <i class="fa fa-toggle-off"></i> Ouverture</a>
                                                                                </li>
                                                                            @else
                                                                                <li>
                                                                                    <a href="{{ route('caisseManager.open', $data->id) }}"> <i class="fa fa-toggle-on"></i> Manager la caisse</a>
                                                                                </li>
                                                                            @endif
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
								</div>
							</div>
						</div>
						
						
						 
    </div>
@stop

@section('footer')
    @parent
    
@stop