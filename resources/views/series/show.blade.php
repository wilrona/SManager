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
            <h4 class="mainTitle no-margin">Liste des series</h4>

            <span class="mainDescription">Gestion des numéros de series </span>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Series</li>
                <li>Fiche</li>
            </ul>
        </div>
        <!-- end: BREADCRUMB -->
        <!-- start: FIRST SECTION -->
        <div class="container-fluid container-fullw padding-bottom-10">
            @if(session()->has('ok'))
                <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            @endif
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Information de la serie</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li>
                                    <div class="pull-right">
                                        @if($single)
                                            <a href="{{ route('serie.indexUser', $single) }}" class="btn btn-default btn-sm bnt-o" style="margin-top: 9px;"> Retour </a>
                                        @else
                                            <a href="{{ route('serie.index', $single) }}" class="btn btn-default btn-sm bnt-o" style="margin-top: 9px;"> Retour </a>
                                        @endif
                                    </div>
                                </li>

                            </ul>

                        </div>
                        <div class="panel-body">

                            <div class="form-group {!! $errors->has('reference') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Numéro de serie : </label>
                                {!! Form::text('reference', $data->reference, ['class' => 'form-control', 'disabled' => '']) !!}
                            </div>
                            <div class="form-group {!! $errors->has('produit_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Produit : </label>
                                {!! Form::select('produit_id', $select, $data->produit_id, ['class' => 'form-control', 'disabled' => '']) !!}
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="text-bold"> Magasin en cours : </label>
                                {!! Form::text('magasin_id', $data->Magasins()->first()->name, ['class' => 'form-control', 'disabled' => '']) !!}
                            </div>
                            @if($data->lot_id)
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="text-bold"> Numéro de lot : </label>
                                {!! Form::text('magasin_id', $data->Lot()->first()->reference, ['class' => 'form-control', 'disabled' => '']) !!}
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Mouvement de la serie</h4>
                        </div>
                        <div class="panel-body">
                            <table class="table  sample_3">
                                <thead>
                                <tr>
                                    <th class="col-xs-1">#</th>
                                    <th>Ecriture</th>
                                    <th>Transfert</th>
                                    <th>Magasin</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data->EcriureStocks()->get() as $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            @if($item->ordre_transfert_id || $item->transfert_id)
                                                @if($item->type_ecriture == 1)
                                                    Expédition
                                                @else
                                                    Reception
                                                @endif
                                            @else
                                                @if($item->commande_id)
                                                    @if($item->type_ecriture == 1)
                                                        Sortie de stock
                                                    @else
                                                        Retour en stock
                                                    @endif
                                                @else
                                                    Importation
                                                @endif
                                            @endif
                                        </td>
                                        <td>@if($item->transfert_id) {{ $item->Transfert()->first()->reference }} @else Indéfinie @endif</td>
                                        <td>{{ $item->Magasin()->first()->reference }}</td>
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>



                </div>
                <div class="col-md-4">

                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    @parent

@stop