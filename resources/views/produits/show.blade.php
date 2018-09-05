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
                                @if($single)
                                    <li class="middle-center">
                                        <a href="{{ route('produit.indexUser', $single) }}" class="btn btn-o btn-sm btn-default">Retour</a>
                                    </li>
                                @endif
                                @if(!$single)
                                <li class="middle-center">
                                    <a href="{{ route('produit.index') }}" class="btn btn-o btn-sm btn-default">Retour</a>
                                </li>
                                <li class="middle-center">
                                    <div class="pull-right">
                                        <div class="btn-group">
                                            <a href="#" data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle"> Actions <span class="caret"></span> </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a href="{{ route('produit.edit', $data->id) }}"> Modifier </a>
                                                </li>
                                                {{--<li class="divider"></li>--}}
                                                <li>
                                                    @if($data->active)
                                                        <a href="{{ route('produit.active', $data->id) }}"> Désactiver </a>
                                                    @else
                                                        <a href="{{ route('produit.active', $data->id) }}"> Activer </a>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                <li>
                                    @if($data->active)
                                        <a data-original-title="Actvité" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm" href="#"><i class="fa fa-circle text-success"></i></a>
                                    @else
                                        <a data-original-title="Désactivé" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm" href="#"><i class="fa fa-circle text-danger"></i></a>
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

                            <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Nom du produit : </label>
                                {!! Form::text('name', $data->name, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('name', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Description : </label>
                                {!! Form::textarea('description', $data->description, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('description', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('unite_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Unité du produit : </label>
                                {!! Form::select('unite_id', $unites, $data->unite_id, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('unite_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('famille_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Famille du produit : </label>
                                {!! Form::select('famille_id', $familles, $data->famille_id, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('famille_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('bundle') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Type de produit : </label>
                                {!! Form::select('bundle', $select_bundle, $data->bundle, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('bundle', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('prix') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Prix du produit (<small>le prix du produit ne sera pas pris en compte pour les composés de produit (Bundle, Offres)</small>) : </label>
                                {!! Form::number('prix', $data->prix, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('prix', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>




                        </div>
                    </div>
                    @if($data->bundle == 1)
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Produits du bundle</h4>
                        </div>
                        <div class="panel-body" id="loading">
                            <table class="table ">
                                <thead>
                                <tr>
                                    <th class="col-xs-1">#</th>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th>Prix</th>
                                </tr>
                                </thead>
                                <tbody>
				                <?php if($data->ProduitBundle()->count()):


				                foreach($data->ProduitBundle()->get() as $key => $value):
				                ?>
                                <tr>
                                    <td><?= $key + 1?></td>
                                    <td><?= $value->name ?></td>
                                    <td><?= $value->pivot->quantite ?></td>
                                    <td><?= $value->pivot->prix ?></td>
                                </tr>
				                <?php
				                    endforeach;
				                else:
				                ?>
                                <tr>
                                    <td colspan="4">
                                        <h4 class="text-center" style="margin: 0;">Aucun produit enregistré</h4>
                                    </td>
                                </tr>
				                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Groupe de prix</h4>
                        </div>
                        <div class="panel-body" id="loading">
                            <table class="table ">
                                <thead>
                                <tr>
                                    <th class="col-xs-1">#</th>
                                    <th>Client</th>
                                    <th>Prix.</th>
                                    <th>Remise</th>
                                    <th>Qté min</th>
                                    <th>Programmé</th>
                                </tr>
                                </thead>
                                <tbody>
				                <?php if($data->GroupePrix()->count()):


				                foreach($data->GroupePrix()->get() as $key => $value):
				                ?>
                                <tr>
                                    <td><?= $key + 1?></td>
                                    <td>
                                        <?= $value->client_id ? $value->Client()->first()->display_name : ''; ?>
                                        <?= $value->famille_id ? $value->Famille()->first()->name : ''; ?>
                                    </td>
                                    <td><?= $value->prix ?> </td>
                                    <td><?= $value->remise ?> <?= $value->type_remise ? "%" : ''; ?></td>
                                    <td><?= $value->quantite_min ?></td>
                                    <td>
                                        <?= empty($value->date_debut) && empty($value->date_fin) ? "Non" : '' ?>
                                        <?= $value->date_debut ? "<strong>Début :</strong> ".date('d-m-Y', $value->date_debut) : '' ?>
                                        <?= $value->date_fin ? "<strong>Fin :</strong> ".date('d-m-Y', $value->date_fin) : '' ?>
                                    </td>
                                </tr>
				                <?php
				                endforeach;
				                else:
				                ?>
                                <tr>
                                    <td colspan="5">
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
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Stocks</h4>

                        </div>
                        <div class="panel-body">
                            <table class="table sample_3">
                                <thead>
                                <tr>
                                    <th class="no-sort">Magasin</th>
                                    <th class="col-xs-3 no-sort">Quantite</th>
                                    <th class="col-xs-1"></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($mag as $item)
                                    <tr class="">
                                        <td><?= $item->name ?></td>
                                        <td><?= $item->Stock()->where([['produit_id', '=', $data->id],['type', '=', 0]])->count(); ?></td>
                                        <td>
                                            <a href="{{ route('produit.serieMagasin', ['magasin_id' => $item->id, 'produit_id' => $data->id]) }}" data-toggle="modal" data-target="#myModal-lg" data-backdrop="static"><i class="fa fa-list-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
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