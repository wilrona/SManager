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
            <h4 class="mainTitle no-margin">Demandes Stocks</h4>
            <span class="mainDescription">Gestion des demandes de stock </span>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Demande de stock</li>
                <li>Fiche</li>
            </ul>
        </div>
        <!-- end: BREADCRUMB -->
        <!-- start: FIRST SECTION -->
        <div class="container-fluid container-fullw padding-bottom-10">
            @if(session()->has('warning'))
                <div class="alert alert-warning alert-dismissible">{!! session('warning') !!}</div>
            @endif
                @if(session()->has('ok'))
                    <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
                @endif
            <div class="row">


                <div class="col-md-8">
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h3 class="panel-title">Information de la demande reçue</h3>
                            <ul class="panel-heading-tabs border-light">
                                <li class="middle-center">
                                    <a href="{{ route('receive.index') }}" class="btn btn-o btn-sm btn-default">Retour</a>
                                </li>
                                @if($data->statut_doc < 2)
                                <li class="middle-center">
                                    <div class="pull-right">
                                        <div class="btn-group">
                                            <a href="#" data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle"> Actions <span class="caret"></span> </a>
                                            <ul class="dropdown-menu" role="menu">
                                                @if($data->statut_exp < 2)
                                                    <li>
                                                        @if($data->statut_exp == 0)
                                                            <a href="{{ route('receive.edit', $data->id) }}"> Modifier </a>
                                                        @else
                                                            <a href="{{ route('receive.edit', $data->id) }}"> Nouvelle Expédition </a>
                                                        @endif
                                                    </li>
                                                @endif
                                                <li>
                                                    <a href="{{ route('receive.statutDoc', [$data->id, 2]) }}"> Cloturer </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                <li>
                                    @if($data->statut_doc == 1)
                                        @if($data->statut_exp == 1)
                                            <a data-original-title="Expédition Parielle" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm" href="#"><i class="fa fa-circle text-success"></i></a>
                                        @elseif($data->statut_exp == 2)
                                            <a data-original-title="Expédition Totale" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm" href="#"><i class="fa fa-circle text-success"></i></a>
                                        @else
                                            <a data-original-title="En attente" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm" href="#"><i class="fa fa-circle text-success"></i></a>
                                        @endif
                                    @endif
                                    @if($data->statut_doc == 2)
                                        <a data-original-title="Cloturée" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm" href="#"><i class="fa fa-circle text-danger"></i></a>
                                    @endif
                                </li>

                            </ul>
                        </div>
                        <div class="panel-body">

                            <div class="form-group {!! $errors->has('reference') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Reference : </label>
                                {!! Form::text('reference', $data->reference, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('reference', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('pos_dmd_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Point de vente demandeur : </label>
                                {!! Form::select('pos_dmd_id', $pos, $data->pos_dmd_id, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('pos_dmd_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('mag_dmd_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Magasin demandeur : </label>
                                {!! Form::select('mag_dmd_id', $my_mag, $data->mag_dmd_id, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('mag_dmd_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('pos_appro_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Point de vente approvisionneur : </label>
                                {!! Form::select('pos_appro_id', $pos, $data->pos_appro_id, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('pos_appro_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('mag_appro_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Magasin approvisionneur : </label>
                                {!! Form::select('mag_appro_id', $my_mag, $data->mag_appro_id, ['class' => 'form-control', 'disabled' => '', 'placeholder' => 'A définir']) !!}
                                {!! $errors->first('mag_appro_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('motif') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Motif de la demande : </label>
                                {!! Form::textarea('motif', $data->motif, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('motif', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>


                        </div>
                    </div>

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Produits demandés</h4>

                        </div>
                        <div class="panel-body" id="loading">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="col-xs-1">#</th>
                                    <th>Produit</th>
                                    <th class="col-xs-2">Qte ddée</th>
                                    <th class="col-xs-2">Qté Exp.</th>
                                    <th class="col-xs-2">Qté à Exp.</th>
                                </tr>
                                </thead>
                                <tbody>

				                <?php if($data->ligne_transfert()->count()):


				                foreach($data->ligne_transfert()->get() as $key => $value):
				                ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $value->produit()->first()->name ?></td>
                                    <td><?= $value->qte_dmd; ?></td>
                                    <td><?= $value->qte_exp; ?></td>
                                    <td><?= $value->qte_a_exp; ?></td>

                                </tr>
				                <?php
				                endforeach;
				                else:
				                ?>
                                <tr>
                                    <td colspan="3">
                                        <h4 class="text-center" style="margin: 0;">Aucun produit enregistré</h4>
                                    </td>
                                </tr>
				                <?php endif; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
	                <?php if($data->Transferts()->count()): ?>
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Expédition Effectuée</h4>

                        </div>
                        <div class="panel-body">
                            <table class="table sample_3">
                                <thead>
                                    <tr>
                                        <th class="no-sort">Reference</th>
                                        <th class="col-xs-3 no-sort">Exp.</th>
                                        <th class="col-xs-3 no-sort">Reçue</th>
                                        <th class="col-xs-1"></th>
                                    </tr>
                                </thead>
                                <tbody>

				                @foreach($data->Transferts()->get() as $key => $value)
                                    <tr class="@if($value->etat == 1) success @elseif($value->Series()->where("ok", '=', 1)->count() && $value->Series()->where("ok", '=', 1)->count() < $value->Series()->count()) warning @endif" >
                                        <td><?= $value->reference ?></td>
                                        <td><?= $value->Series()->where('type', '=', 0)->count(); ?></td>
                                        <td><?= $value->Series()->where("ok", '=', 1)->count(); ?></td>
                                        <td>
                                            <a href="{{ route('receive.showTransfert', $value->id) }}" data-toggle="modal" data-target="#myModal-lg" data-backdrop="static"><i class="fa fa-list-alt"></i></a>
                                        </td>
                                    </tr>
				                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
	                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    @parent

@stop
