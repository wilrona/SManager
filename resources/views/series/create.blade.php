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
            <h4 class="mainTitle no-margin">Création des séries</h4>

            <span class="mainDescription">Gestion des numéros de séries </span>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Séries</li>
                <li>Création</li>
            </ul>
        </div>
        <!-- end: BREADCRUMB -->
        <!-- start: FIRST SECTION -->
        <div class="container-fluid container-fullw">
            <div class="row">
                <div class="col-md-12">
                    @if(session()->has('ok'))
                        <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
                    @endif
                        @if(session()->has('nok'))
                            <div class="alert alert-warning alert-dismissible">{!! session('nok') !!}</div>
                        @endif
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h3 class="panel-title">Création/Importation des numéros de series</h3>
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="panel panel-white">
                                        <div class="panel-heading border-light">
                                            <h3 class="panel-title">Créer une serie</h3>
                                        </div>
                                        <div class="panel-body">
                                            {!! Form::open(['route' => 'serie.store']) !!}
                                                <div class="form-group {!! $errors->has('reference') ? 'has-error' : '' !!}">
                                                    <label for="exampleInputEmail1" class="text-bold text-capitalize"> Numéro de serie : </label>
                                                    {!! Form::text('reference', null, ['class' => 'form-control', 'placeholder' => 'Numéro de serie']) !!}
                                                    {!! $errors->first('reference', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                                            :message
                                                        </span>
                                                    </span>
                                                    ') !!}
                                                </div>
                                                <div class="form-group {!! $errors->has('typeproduit_id') ? 'has-error' : '' !!}">
                                                    <label for="exampleInputEmail1" class="text-bold"> Selection du produit : </label>
                                                    {!! Form::select('typeproduit_id', $select, null, ['class' => 'cs-select cs-skin-elastic', 'placeholder' => 'Selectionnez le produit...']) !!}
                                                    {!! $errors->first('typeproduit_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                                            :message
                                                        </span>
                                                    </span>
                                                    ') !!}
                                                </div>
                                                {!! Form::submit('Enregistrer', ['class' => 'btn btn-primary pull-right']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel panel-white">
                                        <div class="panel-heading border-light">
                                            <h3 class="panel-title">Importer un fichier excel</h3>
                                        </div>
                                        <div class="panel-body">
                                            {!! Form::open(['route' => 'serie.importation', 'files' => true]) !!}
                                            <div class="form-group {!! $errors->has('file_import') ? 'has-error' : '' !!}">
                                                <label for="exampleInputEmail1" class="text-bold"> Inserer un fichier excel : </label>
                                                {!! Form::file('file_import', null, ['class' => 'form-control']) !!}
                                                {!! $errors->first('file_import', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                                        :message
                                                    </span>
                                                </span>
                                                ') !!}
                                            </div>
                                            <div class="form-group margin-top-30 {!! $errors->has('typeproduit') ? 'has-error' : '' !!}">
                                                <label for="exampleInputEmail1" class="text-bold"> Selection du produit : </label>
                                                {!! Form::select('typeproduit', $select, null, ['class' => 'cs-select cs-skin-elastic', 'placeholder' => 'Selectionnez le produit...']) !!}
                                                {!! $errors->first('typeproduit', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                                        :message
                                                    </span>
                                                </span>
                                                ') !!}
                                            </div>
                                            {!! Form::submit('Importer', ['class' => 'btn btn-primary pull-right']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>


                            </div>



                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="container-fluid container-fullw">
            <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading border-light">
                    <h3 class="panel-title">Numéro de serie à valider</h3>
                    @if($datas)
                    <ul class="panel-heading-tabs border-light">
                        <li class="middle-center">
                            <div class="pull-right">
                                <div class="btn-group" dropdown="">
                                    <a href="<?= url('series/validation') ?>" class="btn btn-wide btn-success">
                                        Valider l'importation
                                    </a>
                                </div>
                            </div>
                        </li>

                    </ul>
                    @endif
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>No Series</th>
                            <th>Produit</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $data->reference }}</td>
                                <td>
                                    {{ $data->type_produit()->first()->libelle }}
                                </td>
                                <td><a href="{{ url('series/delete', [$data->id]) }}"><i class="fa fa-close"></i></a></td>
                            </tr>

                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
@stop

@section('footer')
    @parent

@stop
