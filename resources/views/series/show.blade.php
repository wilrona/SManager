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

                        </div>
                        <div class="panel-body">

                            <div class="form-group {!! $errors->has('reference') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Numéro de serie : </label>
                                {!! Form::text('reference', $data->reference, ['class' => 'form-control', 'disabled' => '']) !!}
                            </div>
                            <div class="form-group {!! $errors->has('typeproduit_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Selection du produit : </label>
                                {!! Form::select('typeproduit_id', $select, $data->typeproduit_id, ['class' => 'cs-select cs-skin-elastic', 'disabled' => '']) !!}
                            </div>
                            <a href="<?= url('series') ?>" class="btn btn-o btn-wide btn-default pull-left">Retour</a>
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