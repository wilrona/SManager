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
            <h4 class="mainTitle no-margin">Point de vente</h4>
            <span class="mainDescription">Gestion des points de vente </span>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Paramètres</li>
                <li>Points de vente</li>
            </ul>
        </div>

        <div class="container-fluid container-fullw padding-bottom-10">
            @if(session()->has('ok'))
                <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            @endif
            @if(session()->has('warning'))
                <div class="alert alert-warning alert-dismissible">{!! session('warning') !!}</div>
            @endif
            <div class="row">
                <div class="col-md-8">
                    {!! Form::model($data, ['route' => ['pos.update', $data->id]]) !!}
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Information sur le point de vente</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li class="middle-center">
                                    <a href="{{ route('pos.show', $data->id) }}" class="btn btn-o btn-sm btn-default">Retour</a>
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
                                <label for="exampleInputEmail1" class="text-bold"> Reference : </label>
                                {!! Form::text('reference', null, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! Form::hidden('reference') !!}
                                {!! $errors->first('reference', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Nom du POS : </label>
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nom du point de vente']) !!}
                                {!! $errors->first('name', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('type') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Type de POS : </label>
                                @if($data->centrale == 1):
                                    {!! Form::select('type', $type, null, ['class' => 'form-control', 'disabled' => '']) !!}
                                    {!! Form::hidden('type') !!}
                                @else
                                    {!! Form::select('type', $type, null, ['class' => 'cs-select cs-skin-elastic', 'placeholder' => 'Type de point de vente']) !!}
                                @endif
                                {!! $errors->first('type', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                        </div>
                    </div>

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Caisse du point de vente</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li>
                                    <div class="pull-right">
                                        <a href="{{ route('pos.addCaisse', $data->id) }}" class="btn btn-green btn-sm" style="margin-top: 9px;" data-toggle="modal" data-target="#myModal-lg" data-backdrop="static"><i class="fa fa-plus"></i> Gerer les caisses</a>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="panel-body" id="loading">
                            <table class="table ">
                                <thead>
                                <tr>
                                    <th class="col-xs-1">#</th>
                                    <th>Caisse</th>
                                    <th class="col-xs-2">Principale</th>
                                </tr>
                                </thead>
                                <tbody>
				                <?php if($caisses):


				                foreach($caisses as $key => $value):
				                ?>
                                <tr>
                                    <td><?= $key + 1?></td>
                                    <td><?= $value['caisse_name'] ?></td>
                                    <td><?php if($value['caisse_principal']): ?> oui <?php else: ?> non <?php endif; ?></td>
                                </tr>
				                <?php
				                endforeach;
				                else:
				                ?>
                                <tr>
                                    <td colspan="3">
                                        <h4 class="text-center" style="margin: 0;">Aucune caisse enregistrée</h4>
                                    </td>
                                </tr>
				                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Magasin du point de vente</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li>
                                    <div class="pull-right">
                                        <a href="{{ route('pos.addMagasin', $data->id) }}" class="btn btn-green btn-sm" style="margin-top: 9px;" data-toggle="modal" data-target="#myModal-lg" data-backdrop="static"><i class="fa fa-plus"></i> Ajouter un magasin</a>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="panel-body" id="loading_magasin">
                            <table class="table ">
                                <thead>
                                <tr>
                                    <th class="col-xs-1">#</th>
                                    <th>Magasin</th>
                                </tr>
                                </thead>
                                <tbody>
				                <?php if($magasin):


				                foreach($magasin as $key => $value):
				                ?>
                                <tr>
                                    <td><?= $key + 1?></td>
                                    <td><?= $value['magasin_name'] ?></td>
                                </tr>
				                <?php
				                endforeach;
				                else:
				                ?>
                                <tr>
                                    <td colspan="3">
                                        <h4 class="text-center" style="margin: 0;">Aucun magasin enregistré</h4>
                                    </td>
                                </tr>
				                <?php endif; ?>
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