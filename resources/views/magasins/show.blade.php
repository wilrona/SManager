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
                <li>Paramètres</li>
                <li>Magasins</li>
            </ul>
        </div>

        <div class="container-fluid container-fullw padding-bottom-10">
            <div class="row">
                <div class="col-md-8">

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Information sur le magasin</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li class="middle-center">
                                    <a href="{{ route('magasin.index') }}" class="btn btn-o btn-sm btn-default">Retour</a>
                                </li>
                                <li class="middle-center">
                                    <div class="pull-right">
                                        <div class="btn-group" dropdown="">
                                            <a href="{{ route('magasin.edit', $data->id) }}" class="btn btn-primary btn-sm">
                                                Modifier
                                            </a>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="panel-body">


                            <div class="form-group {!! $errors->has('reference') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Reference (<small>Généré automatiquement si le champ est vide</small>): </label>
                                {!! Form::text('reference', $data->reference, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('reference', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Nom du magasin : </label>
                                {!! Form::text('name', $data->name, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('name', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('transite') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Type de magasin : </label>
                                {!! Form::select('transite', $type, $data->transite, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('transite', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('pos_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Point de vente du magasin : </label>
                                {!! Form::select('pos_id', $pos, $data->pos_id, ['class' => 'form-control', 'disabled' => '', 'placeholder' => '']) !!}
                                {!! $errors->first('pos_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                        </div>
                    </div>

                    @if(!$data->transite)

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Numéro de serie en stock</h4>
                        </div>
                        <div class="panel-body" id="loading">
                            <table class="table sample_5">
                                <thead>
                                <tr>
                                    <th class="">#</th>
                                    <th class="col-xs-4">No Serie</th>
                                    <th class="col-xs-4">No Lot</th>
                                    <th class="col-xs-3">Produit</th>
                                    <th class="col-xs-1 no-sort">Type</th>
                                </tr>
                                </thead>
                                <tbody>

				                <?php
				                $series = $data->Stock()->has('magasins', '=', 1)->get();
				                $id = $data->id;
				                ?>
                                @foreach($series as $serie)

                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>@if($serie->type == 0) {{ $serie->reference }} @else Aucun @endif</td>
                                        <td>
                                            @if($serie->type == 1)
                                                {{ $serie->reference }} <br>
                                                Qté du lot : {{ $serie->SeriesLots()->whereHas('Magasins', function($q) use ($id)
                                                        {
                                                                $q->where('id','=', $id);
                                                        })->count() }}
                                            @else
                                                {{ $serie->lot_id ? $serie->Lot()->first()->reference : '' }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $serie->Produit()->first()->name }}
                                        </td>
                                        <td>@if($serie->type == 1) Lot @else Série @endif</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @else

                        <div class="panel panel-white">
                            <div class="panel-heading border-light">
                                <h4 class="panel-title">Numéro de serie en stock</h4>
                            </div>
                            <div class="panel-body" id="loading">
                                <table class="table sample_5">
                                    <thead>
                                    <tr>
                                        <th class="">#</th>
                                        <th class="col-xs-4">No Serie</th>
                                        <th class="col-xs-4">No Lot</th>
                                        <th class="col-xs-3">Produit</th>
                                        <th class="col-xs-1 no-sort">Type</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($allSerie as $serie)

                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>@if($serie->type == 0) {{ $serie->reference }} @else Aucun @endif</td>
                                            <td>
                                                @if($serie->type == 1)
                                                    {{ $serie->reference }} <br>
                                                    Qté du lot : {{ $serie->SeriesLots()->whereHas('Magasins', function($q) use ($id)
                                                        {
                                                                $q->where('id','=', $id);
                                                        })->count() }}
                                                @else
                                                    {{ $serie->lot_id ? $serie->Lot()->first()->reference : '' }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $serie->Produit()->first()->name }}
                                            </td>
                                            <td>@if($serie->type == 1) Lot @else Série @endif</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    @endif


                </div>
                <div class="col-md-4">

                </div>
            </div>
        </div>



    </div>
@stop

@section('footer')
    @parent

    <!--script src="assets/js/letter-icons.js"></script>
	<script src="assets/js/main.js"></script>
	<script src="assets/js/treetable.js"></script-->


@stop