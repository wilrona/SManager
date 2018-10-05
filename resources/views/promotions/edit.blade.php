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
            <h4 class="mainTitle no-margin">Modification de la promotion</h4>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Promotion</li>
                <li>Création</li>
            </ul>
        </div>
        <!-- end: BREADCRUMB -->
        <!-- start: FIRST SECTION -->
        <div class="container-fluid container-fullw padding-bottom-10">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h3 class="panel-title">Information de la promotion</h3>
                        </div>
                        <div class="panel-body">
                            {!! Form::model($data, ['route' => ['promotion.update', $data->id]]) !!}

                            <div class="form-group {!! $errors->has('libelle') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Libelle : </label>
                                {!! Form::text('libelle', null, ['class' => 'form-control', 'placeholder' => 'libelle de la promotion']) !!}
                                {!! $errors->first('libelle', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
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
                            <div class="form-group {!! $errors->has('prix_promo') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Prix du produit : </label>
                                {!! Form::number('prix_promo', null, ['class' => 'form-control', 'placeholder' => 'Prix promo à appliquer']) !!}
                                {!! $errors->first('prix_promo', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('date_debut') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Date de début : </label>
                                {!! Form::text('date_debut', date('d/m/Y', strtotime($data->date_debut)), ['class' => 'form-control datepicker_start', 'placeholder' => 'Date de début', 'readonly' => '']) !!}
                                {!! $errors->first('date_debut', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('date_fin') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Date de fin : </label>
                                {!! Form::text('date_fin', date('d/m/Y', strtotime($data->date_fin)), ['class' => 'form-control datepicker_end', 'placeholder' => 'Date de fin', 'readonly' => '']) !!}
                                {!! $errors->first('date_fin', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('typeproduit_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Le produit de la promotion : </label>
                                {!! Form::select('typeproduit_id', $select, null, ['class' => 'cs-select cs-selector cs-skin-elastic', 'placeholder' => 'Selectionnez le produit...']) !!}
                                {!! $errors->first('typeproduit_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <a href="<?= url('promotions/show', [$data->id]) ?>" class="btn btn-o btn-wide btn-default pull-left">Retour</a>

                            {!! Form::submit('Envoyer', ['class' => 'btn btn-primary pull-right']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    @parent

@stop
