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
            <h4 class="mainTitle no-margin">Produits</h4>
            <span class="mainDescription">Gestion des produits </span>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Produits</li>
                <li>Création</li>
            </ul>
        </div>
        <!-- end: BREADCRUMB -->
        <!-- start: FIRST SECTION -->
        <div class="container-fluid container-fullw padding-bottom-10">
            <div class="row">

                {!! Form::open(['route' => 'produit.store', 'files' => true]) !!}
                <div class="col-md-8">
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h3 class="panel-title">Information du produit</h3>
                            <ul class="panel-heading-tabs border-light">
                                <li class="middle-center">
                                    <a href="{{ route('produit.index') }}" class="btn btn-o btn-sm btn-default">Retour</a>
                                </li>
                                <li class="middle-center">
                                    <div class="pull-right">
                                        <div class="btn-group" dropdown="">
                                            {!! Form::submit('Valider', ['class' => 'btn btn-primary btn-sm']) !!}
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="panel-body">

                            <div class="form-group {!! $errors->has('reference') ? 'has-error' : '' !!}">
                                <!--<label for="exampleInputEmail1" class="text-bold text-capitalize"> Reference : </label>-->
                                {!! Form::text('reference', $reference, ['class' => 'form-control hidden', 'placeholder' => 'reference du produit']) !!}
                                {!! $errors->first('reference', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('filename') ? 'has-error' : '' !!}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="panel panel-white no-radius">
                                            <div class="panel-body">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="exampleInputEmail1" class="text-bold text-capitalize"> Image du produit : </label>
                                        {!! Form::file('filename', ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                {!! $errors->first('filename', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>


                            <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Nom du produit : </label>
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nom du produit']) !!}
                                {!! $errors->first('name', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Description : </label>
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Entrer une description']) !!}
                                {!! $errors->first('description', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('unite_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Unité du produit : </label>
                                {!! Form::select('unite_id', $unites, null, ['class' => 'cs-select cs-selector cs-skin-elastic', 'placeholder' => 'Selectionnez l\'unité du produit...']) !!}
                                {!! $errors->first('unite_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('famille_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Famille du produit : </label>
                                {!! Form::select('famille_id', $familles, null, ['class' => 'cs-select cs-selector cs-skin-elastic', 'placeholder' => 'Selectionnez une famille de produit...']) !!}
                                {!! $errors->first('famille_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('bundle') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Type de produit : </label>
                                {!! Form::select('bundle', $select_bundle, null, ['class' => 'cs-select cs-selector cs-skin-elastic', 'placeholder' => 'Selectionnez le type de produit...']) !!}
                                {!! $errors->first('bundle', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('prix') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Prix du produit (<small>le prix du produit ne sera pas pris en compte pour les composés de produit (Bundle, Offres)</small>) : </label>
                                {!! Form::number('prix', null, ['class' => 'form-control', 'placeholder' => 'Prix']) !!}
                                {!! $errors->first('prix', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>


                        </div>
                    </div>

                </div>
                <div class="col-md-4"></div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@section('footer')
    @parent

@stop
