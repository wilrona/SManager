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
            <h4 class="mainTitle no-margin">Modification Utilisateur</h4>
            <span class="mainDescription">Gestion des utilisateurs </span>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Paramètres</li>
                <li>Utilisateurs</li>
                <li>Modification</li>
            </ul>
        </div>

        <div class="container-fluid container-fullw padding-bottom-10">
            @if(session()->has('ok'))
                <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            @endif
            <div class="row">
                {!! Form::model($data, ['route' => ['user.update', $data->id]]) !!}
                <div class="col-md-8">

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Information de l'utilisateur</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li class="middle-center">
                                    <a href="{{ route('user.show', $data->id) }}" class="btn btn-o btn-sm btn-default">Retour</a>
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
                            <div class="form-group {!! $errors->has('nom') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Nom : </label>
                                {!! Form::text('nom', null, ['class' => 'form-control', 'placeholder' => 'Nom']) !!}
                                {!! $errors->first('nom', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('prenom') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Prenom : </label>
                                {!! Form::text('prenom', null, ['class' => 'form-control', 'placeholder' => 'Prénom']) !!}
                                {!! $errors->first('prenom', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('phone') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Numéro téléphone : </label>
                                {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Numéro téléphone']) !!}
                                {!! $errors->first('phone', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('ville') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Ville : </label>
                                {!! Form::text('ville', null, ['class' => 'form-control', 'placeholder' => 'Ville']) !!}
                                {!! $errors->first('ville', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('sexe') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Sexe : </label>
                                {!! Form::select('sexe', $sexe, null, ['class' => 'cs-select cs-selector cs-skin-elastic', 'placeholder' => 'Selectionnez le sexe']) !!}
                                {!! $errors->first('sexe', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('adresse') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Adresse : </label>
                                {!! Form::textarea('adresse', null, ['class' => 'form-control', 'placeholder' => 'Adresse']) !!}
                                {!! $errors->first('adresse', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            @if(!$caisses)
                                <div class="form-group {!! $errors->has('pos_id') ? 'has-error' : '' !!}">
                                    <label for="exampleInputEmail1" class="text-bold"> Point de vente des opérations : </label>
                                    {!! Form::select('pos_id', $pos, null, ['class' => 'cs-select cs-selector cs-skin-elastic', 'placeholder' => 'Selectionnez le point de vente']) !!}
                                    {!! $errors->first('pos_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                            :message
                                        </span>
                                    </span>
                                    ') !!}
                                </div>
                            @else
                                <div class="form-group {!! $errors->has('pos_id') ? 'has-error' : '' !!}">
                                    <label for="exampleInputEmail1" class="text-bold"> Point de vente des opérations : </label>
                                    {!! Form::select('pos_id', $pos, $data->pos_id, ['class' => 'form-control', 'disabled' => '']) !!}
                                    {!! Form::hidden('pos_id', $data->pos_id) !!}
                                    {!! $errors->first('pos_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                            :message
                                        </span>
                                    </span>
                                    ') !!}
                                </div>
                            @endif

                        </div>
                    </div>

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Caisse de l'utilisateur</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li>
                                    <div class="pull-right">
                                        <a href="@if($data->pos_id){{ route('user.addCaisse', ['pos_id' => $data->pos_id, 'user_id' => $data->id]) }}@endif" class="btn btn-green btn-sm" style="margin-top: 9px;" data-toggle="modal" data-target="#myModal-lg" data-backdrop="static"><i class="fa fa-plus"></i> Affecter les caisses</a>
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
				                <?php
                                if($caisses):


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
                            <h4 class="panel-title">Magasin de l'utilisateur</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li>
                                    <div class="pull-right">
                                        <a href="@if($data->pos_id){{ route('user.addMagasin', ['pos_id' => $data->pos_id, 'user_id' => $data->id]) }}@endif" class="btn btn-green btn-sm" style="margin-top: 9px;" data-toggle="modal" data-target="#myModal-lg" data-backdrop="static"><i class="fa fa-plus"></i> Affecter des magasins</a>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="panel-body" id="loading_mag">
                            <table class="table ">
                                <thead>
                                <tr>
                                    <th class="col-xs-1">#</th>
                                    <th>Magasin</th>
                                    <th class="col-xs-2">Principale</th>
                                </tr>
                                </thead>
                                <tbody>
				                <?php
				                if($magasins):


				                foreach($magasins as $key => $value):
				                ?>
                                <tr>
                                    <td><?= $key + 1?></td>
                                    <td><?= $value['mag_name'] ?></td>
                                    <td><?php if($value['mag_principal']): ?> oui <?php else: ?> non <?php endif; ?></td>
                                </tr>
				                <?php
				                endforeach;
				                else:
				                ?>
                                <tr>
                                    <td colspan="3">
                                        <h4 class="text-center" style="margin: 0;">Aucune magasin enregistré</h4>
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

                        </div>
                        <div class="panel-body">


                            <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Adresse Email : </label>
                                {!! Form::email('email', null, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! Form::hidden('email') !!}
                                {!! $errors->first('email', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('password') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Mot de passe : </label>
                                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Mot de passe']) !!}
                                {!! $errors->first('password', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>
                            <div class="form-group {!! $errors->has('password_confirmation') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Confirmation du mot de passe : </label>
                                {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirmation du mot de passe']) !!}
                                {!! $errors->first('password_confirmation', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
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
                                {!! Form::select('profile_id', $profile, null, ['class' => 'cs-select cs-selector cs-skin-elastic', 'placeholder' => 'Selectionnez le profil de l\'utilisateur']) !!}
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
                                                                    <input type="checkbox" data-toggle="toggle" name="roles[]" value="{{ $enfant->id }}" @if(in_array($enfant->id, $roles_profile)) checked @endif data-on="On" data-off="Off" data-onstyle="success" data-offstyle="danger" data-size="mini">
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
                {!! Form::close() !!}
            </div>
        </div>



    </div>
@stop

@section('footer')
    @parent


@stop