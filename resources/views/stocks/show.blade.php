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
            <h4 class="mainTitle no-margin">Fiche du produit</h4>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Produits</li>
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
                            <h4 class="panel-title">Information du produit</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li class="middle-center">
                                    <div class="pull-right">
                                        <div class="btn-group" dropdown="">
                                            <a href="<?= url('produits/edit', [$data->id]) ?>" class="btn btn-primary">
                                                Modifier
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="panel-body">

                            <div class="form-group {!! $errors->has('libelle') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Libelle : </label>
                                {!! Form::text('libelle', $data->libelle, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                            </div>
                            <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Description : </label>
                                {!! Form::textarea('description', $data->description, ['class' => 'form-control', 'disabled' => 'disabled']) !!}

                            </div>
                            <div class="form-group {!! $errors->has('prix') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Prix : </label>
                                {!! Form::number('prix', $data->prix, ['class' => 'form-control', 'disabled' => 'disabled']) !!}

                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Autres informations</h4>

                        </div>
                        <div class="panel-body">
                            <div class="well text-center">
                                <h3 class="text-bold inline-block">Prix appliqué :   </h3>
                                <h3 class="text-success text-bold inline-block">
                                    @if($data->promo)
                                        {{ $data->prix_promo }}
                                    @else
                                        {{ $data->prix }}
                                    @endif
                                    XAF
                                </h3>
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