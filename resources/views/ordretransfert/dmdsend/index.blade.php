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
			<h4 class="mainTitle no-margin">Demandes Stocks</h4>
			<span class="mainDescription">Gestion des demandes de stock </span>
			<ul class="pull-right breadcrumb">
			<li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>Demande de stock</li>
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
                        <div class="panel-heading border-light">
                            <h3 class="panel-title">Demande de stock Envoyée</h3>
                            <ul class="panel-heading-tabs border-light">
                                <li>
                                    <div class="pull-right">
                                        <a href="{{ route('dmd.create') }}" class="btn btn-green btn-sm" style="margin-top: 9px;"><i class="fa fa-plus"></i> Creer une demande </a>

                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="panel-body">
                            <table class="table  sample_5">
                                <thead>
                                <tr>
                                    <th class="col-md-1">#</th>
                                    <th>Reference </th>
                                    <th>POS de destination</th>
                                    <th>Statut</th>
                                    <th class="col-md-1"></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($datas as $data)
                                    <tr class="@if($data->statut_doc == 2) danger @endif @if($data->Transferts()->count()) warning @endif">
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->reference }}</td>
                                        <td>{{ $data->pos_appro()->first()->name }}</td>
                                        <td>
                                            @if($data->statut_doc == 0)
                                                Brouillon
                                            @endif
                                            @if($data->statut_doc == 1)
                                                @if($data->mag_appro_id)
                                                    @if($data->transferts()->where('etat', '=', 0)->count())
                                                        Reception en court <b>({{ $data->transferts()->where('etat', '=', 0)->count() }})</b>
                                                    @else
                                                        En traitement
                                                    @endif
                                                @else
                                                    Envoyée
                                                @endif
                                            @endif

                                            @if($data->statut_doc == 3)
                                                Annulée
                                            @endif
                                            @if($data->statut_doc == 2)
                                                Cloturée
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('dmd.show', $data->id) }}"><i class="fa fa-eye"></i></a>
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