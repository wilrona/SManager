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
                            <h3 class="panel-title">Demande de stock Reçue</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-stylish sample_5">
                                <thead>
                                <tr>
                                    <th class="col-md-1">#</th>
                                    <th>Reference </th>
                                    <th>POS demandeur</th>
                                    <th>Statut</th>
                                    <th class="col-md-1"></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($datas as $data)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->reference }}</td>
                                        <td>{{ $data->pos_dmd()->first()->name }} ({{ $data->magasin_dmd()->first()->name }})</td>
                                        <td>
                                            @if($data->statut_doc == 1)
                                                @if($data->statut_exp == 0)
                                                    En attente
                                                @elseif($data->statut_exp == 1)
                                                    Expédition partielle
                                                @else
                                                    Expédition totale
                                                @endif
                                            @endif
                                            @if($data->statut_doc == 2)
                                                Cloturée
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('receive.show', $data->id) }}"><i class="fa fa-eye"></i></a>
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