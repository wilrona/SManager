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
            <h4 class="mainTitle no-margin">Fiche Utilisateur</h4>
            <span class="mainDescription">Gestion des utilisateurs </span>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Paramètres</li>
                <li>Utilisateurs</li>
                <li>Fiche</li>
            </ul>
        </div>

        <div class="container-fluid container-fullw padding-bottom-10">
            @if(session()->has('ok'))
                <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            @endif
            <div class="row">
                <div class="col-md-8">

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Information de l'utilisateur</h4>
                            <ul class="panel-heading-tabs border-light">

                                <li class="middle-center">
                                    <a href="{{ route('user.index') }}" class="btn btn-o btn-sm btn-default">Retour</a>
                                </li>
                                <li class="middle-center">
                                    <div class="pull-right">
                                        <div class="btn-group">
                                            <a href="#" data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle"> Actions <span class="caret"></span> </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a href="{{ route('user.edit', $data->id) }}"> Modifier </a>
                                                </li>
                                                {{--<li class="divider"></li>--}}
                                                <li>
                                                    @if($data->active)
                                                        <a href="{{ route('user.active', $data->id) }}"> Désactiver </a>
                                                    @else
                                                        <a href="{{ route('user.active', $data->id) }}"> Activer </a>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
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
                                <label for="exampleInputEmail1" class="text-bold"> Reference : </label>
                                {!! Form::text('reference', $data->reference, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('reference', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('nom') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Nom : </label>
                                {!! Form::text('nom', $data->nom, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('nom', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('prenom') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Prenom : </label>
                                {!! Form::text('prenom', $data->prenom, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('prenom', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('phone') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Numéro phone : </label>
                                {!! Form::text('phone', $data->phone, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('phone', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('ville') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Ville : </label>
                                {!! Form::text('ville', $data->ville, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('ville', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('sexe') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Sexe : </label>
                                {!! Form::select('sexe', $sexe, $data->sexe, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('sexe', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('adresse') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Adresse : </label>
                                {!! Form::textarea('adresse', $data->adresse, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('adresse', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('pos_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Point de vente des opérations : </label>
                                {!! Form::select('pos_id', $pos, $data->pos_id, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('pos_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>



                        </div>
                    </div>

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Caisse de l'utilisateur</h4>
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
				                <?php if($data->Caisses()->count()):

				                foreach($data->Caisses()->get() as $key => $value):
				                ?>
                                <tr>
                                    <td><?= $key + 1?></td>
                                    <td><?= $value->name ?></td>
                                    <td><?php if($value->pivot->principal): ?> oui <?php else: ?> non <?php endif; ?></td>
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
                            <h4 class="panel-title">Magasin de l'utilisateur</h4>
                        </div>
                        <div class="panel-body" id="loading">
                            <table class="table ">
                                <thead>
                                <tr>
                                    <th class="col-xs-1">#</th>
                                    <th>Magasin</th>
                                    <th class="col-xs-2">Principale</th>
                                </tr>
                                </thead>
                                <tbody>
				                <?php if($data->Magasins()->count()):

				                foreach($data->Magasins()->get() as $key => $value):
				                ?>
                                <tr>
                                    <td><?= $key + 1?></td>
                                    <td><?= $value->name ?></td>
                                    <td><?php if($value->pivot->principal): ?> oui <?php else: ?> non <?php endif; ?></td>
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

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Information de Connexion</h4>
                            <div class="panel-tools">
                                <a data-original-title="Regroupement" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm panel-collapse" href="#"><i class="ti-minus collapse-off"></i><i class="ti-plus collapse-on"></i></a>
                            </div>

                        </div>
                        <div class="panel-body">


                            <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Adresse Email : </label>
                                {!! Form::email('email', $data->email, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! $errors->first('email', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h3 class="panel-title">Attribution des droits *</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group {!! $errors->has('profile_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Profil de l'utlisateur : </label>
                                {!! Form::select('profile_id', $profile, $data->profile_id, ['class' => 'form-control', 'disabled' => '', 'placeholder' => '']) !!}
                                {!! $errors->first('profile_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="panel-group accordion" id="accordion">
                                @foreach($allRoles as $roles)
                                    @if(!in_array($roles->name, $no_role))
                                    <div class="panel panel-white">
                                        <div class="panel-heading">
                                            <h5 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#{{ $roles->name }}">  {{ $roles->display_name }} </a></h5>
                                        </div>
                                        @if($roles->enfants())
                                            <div id="{{ $roles->name }}" class="collapse @if($loop->index === 0 ) in @endif"style="">
                                                <div class="panel-body" style="padding:0;">
                                                    <table class="table">
                                                        <tbody>
                                                        @foreach($roles->enfants()->get() as $enfant)
                                                            <tr>
                                                                <td class="text-small">{{ $enfant->display_name }}</td>
                                                                <td>
                                                                    <input type="checkbox" data-toggle="toggle" name="roles[]" value="{{ $enfant->id }}" @if(in_array($enfant->id, $roles_profile)) checked @endif data-on="On" data-off="Off" data-onstyle="success" data-offstyle="danger" data-size="mini" disabled>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
@stop

@section('footer')
    @parent

    <!--script src="assets/js/letter-icons.js"></script>
	<script src="assets/js/main.js"></script>
	<script src="assets/js/treetable.js"></script-->


@stop