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
            <div class="row">


                <div class="col-md-8">
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h3 class="panel-title">Information de la demande reçue</h3>
                            <ul class="panel-heading-tabs border-light">
                                <li class="middle-center">
                                    <a href="{{ route('receive.index') }}" class="btn btn-o btn-sm btn-default">Retour</a>
                                </li>
                                @if($data->statut_doc < 2 && $data->statut_exp == 0)
                                <li class="middle-center">
                                    <div class="pull-right">
                                        <div class="btn-group">
                                            <a href="#" data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle"> Actions <span class="caret"></span> </a>
                                            <ul class="dropdown-menu" role="menu">
                                                @if($data->statut_doc == 1)
                                                    @if(empty($data->mag_appro_id))
                                                        <li>
                                                            <a href="{{ route('receive.edit', $data->id) }}"> Modifier </a>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <a href="{{ route('receive.edit', $data->id) }}"> Creer une expédition </a>
                                                        </li>
                                                    @endif
                                                @endif

                                                @if($data->statut_doc == 1)
                                                <li>
                                                    <a href="{{ route('receive.statutDoc', [$data->id, 2]) }}"> Cloturer </a>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                <li>
                                    @if($data->statut_doc == 0)
                                    <a data-original-title="Brouillon" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm" href="#"><i class="fa fa-circle text-beige"></i></a>
                                    @endif
                                    @if($data->statut_doc == 1)
                                        <a data-original-title="Envoyée" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm" href="#"><i class="fa fa-circle text-success"></i></a>
                                    @endif
                                    @if($data->statut_doc == 2)
                                        <a data-original-title="Cloturé" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm" href="#"><i class="fa fa-circle text-danger"></i></a>
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
                                <label for="exampleInputEmail1" class="text-bold"> Magasin associée : </label>
                                {!! Form::select('mag_dmd_id', $my_mag, $data->mag_dmd_id, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('mag_dmd_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('pos_appro_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Point de vente destinataire : </label>
                                {!! Form::select('pos_appro_id', $pos, $data->pos_appro_id, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('pos_appro_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('mag_appro_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Votre magasin de sortie des produits : </label>
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
                            <table class="table table-stylish">
                                <thead>
                                <tr>
                                    <th class="col-xs-1">#</th>
                                    <th>Produit</th>
                                    <th class="col-xs-1">Quantité</th>
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
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    @parent

@stop