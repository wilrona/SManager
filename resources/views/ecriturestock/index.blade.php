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
			<h4 class="mainTitle no-margin">Ecriture de stock</h4>
			<span class="mainDescription">Gestion des ecritures de stock </span>
			<ul class="pull-right breadcrumb">
			<li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>Ecriture de stock</li>
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
                                            {{--<div class="panel-heading border-light">--}}
                                                {{--<ul class="panel-heading-tabs border-light">--}}
                                                    {{--<li>--}}
                                                        {{--<div class="pull-right">--}}
                                                            {{--<a href="{{ route('magasin.create') }}" class="btn btn-green btn-sm" style="margin-top: 9px;"><i class="fa fa-plus"></i> Nouveau </a>--}}

                                                        {{--</div>--}}
                                                    {{--</li>--}}

                                                {{--</ul>--}}
                                            {{--</div>--}}
                                            <div class="panel-body">
                                                <table class="table  sample_5">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-xs-1">#</th>
                                                        <th>Ecriture</th>
                                                        <th>Quantité</th>
                                                        <th>Produit</th>
                                                        <th>Transfert</th>
                                                        <th>Magasin</th>
                                                        <th>Date</th>
                                                        <th class="col-xs-1"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($datas as $data)
                                                        <tr>
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>
                                                                @if($data->ordre_transfert_id || $data->transfert_id)
                                                                    @if($data->type_ecriture == 1)
                                                                        Expédition
                                                                    @else
                                                                        Reception
                                                                    @endif
                                                                @else

                                                                    @if($data->commande_id)
                                                                        @if($data->type_ecriture == 1)
                                                                            Sortie de stock
                                                                        @else
                                                                            Retour en stock
                                                                        @endif
                                                                    @else
                                                                        Importation
                                                                    @endif

                                                                @endif
                                                            </td>
                                                            <td>{{ $data->quantite }}</td>
                                                            <td>{{ $data->Produit()->first()->name }}</td>
                                                            <td>@if($data->transfert_id) {{ $data->Transfert()->first()->reference }} @else Indéfinie @endif</td>
                                                            <td>{{ $data->Magasin()->first()->reference }}</td>
                                                            <td>{{ $data->created_at->format('d-m-Y') }}</td>
                                                            <td><a href="{{ route('ecriture.serie', $data->id) }}" data-toggle="modal" data-target="#myModal-lg" data-backdrop="static"><i class="fa fa-eye"></i></a></td>
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