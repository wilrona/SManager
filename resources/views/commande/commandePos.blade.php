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
			<h4 class="mainTitle no-margin">Commandes</h4>
			<span class="mainDescription">Gestion des commandes </span>
			<ul class="pull-right breadcrumb">
			<li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>Commandes</li>
			</ul>
		</div>
		<!-- end: BREADCRUMB -->

        <div class="container-fluid container-fullw padding-bottom-10">
							<div class="row">
								<div class="col-md-12">
                                    @if(session()->has('ok'))
                                        <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
                                    @endif

                                        <div class="panel panel-white">
                                            <div class="panel-heading border-light">
                                                <h4 class="panel-title">Liste des commandes du point de vente</h4>
                                            </div>
                                            <div class="panel-body">
                                                <table class="table  sample_5">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-xs-1">#</th>
                                                        <th>Reference</th>
                                                        <th>Client</th>
                                                        <th>Montant</th>
                                                        <th>Etat</th>
                                                        <th>Date creation</th>
                                                        <th class="col-xs-1"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($datas as $data)
                                                        <tr>
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $data->reference }}</td>
                                                            <td>{{ $data->client()->first()->display_name }}</td>
                                                            <td>{{ number_format($data->total, 0, '.', ' ') }}</td>
                                                            <td>
                                                                @if($data->etat == 0)
                                                                    Enregistré
                                                                @endif
                                                                @if($data->etat == 1)
                                                                    Payé
                                                                @endif
                                                                @if($data->etat == 2)
                                                                    Produit Traité
                                                                @endif
                                                                @if($data->etat == 3)
                                                                    Produit Traité partiellement
                                                                @endif
                                                                @if($data->etat == 4)
                                                                    Livré
                                                                @endif
                                                            </td>
                                                            <td>{{ $data->created_at->format('d-m-Y H:i') }}</td>

                                                            <td>
                                                                <a href="{{ route('commande.commandePosDetail', $data->id) }}" data-toggle="modal" data-target="#myModal-hr-lg" data-backdrop="static">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
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