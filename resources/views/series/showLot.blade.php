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
            <h4 class="mainTitle no-margin">Liste des lots</h4>

            <span class="mainDescription">Gestion des numéros de lots </span>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Lots</li>
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
                            <h4 class="panel-title">Information du lot</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li>
                                    <div class="pull-right">
                                        <a href="{{ route('serie.index') }}" class="btn btn-default btn-sm bnt-o" style="margin-top: 9px;"> Retour </a>
                                    </div>
                                </li>

                            </ul>

                        </div>
                        <div class="panel-body">

                            <div class="form-group {!! $errors->has('reference') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Numéro de lot : </label>
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
                        </div>
                    </div>

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Numéro de serie</h4>
                        </div>
                        <div class="panel-body" id="loading">
                            <table class="table sample_5">
                                <thead>
                                <tr>
                                    <th class="col-xs-1">#</th>
                                    <th>Reference</th>
                                </tr>
                                </thead>
                                <tbody>

				                <?php
				                $series = $data->SeriesLots()->whereHas('Magasins', function ($q) use ($mags){
					                $q->whereIn('id', $mags);
				                })->get();
				                ?>
				                @foreach($series as $serie)

                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $serie->reference }}</td>
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