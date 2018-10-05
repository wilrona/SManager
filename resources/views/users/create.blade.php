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
			<h4 class="mainTitle no-margin">Utilisateurs</h4>
			<span class="mainDescription">Gestion des utilisateurs </span>
			<ul class="pull-right breadcrumb">
			<li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>Paramètres</li>
			<li>Utilisateurs</li>
			</ul>
		</div>

        <div class="container-fluid container-fullw padding-bottom-10">
            <div class="row">
                {!! Form::open(['route' => 'user.store']) !!}
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
                                        <div class="btn-group" dropdown="">
                                            {!! Form::submit('Valider', ['class' => 'btn btn-primary btn-sm']) !!}
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="panel-body">


                            <div class="form-group {!! $errors->has('reference') ? 'has-error' : '' !!}">
                                {!! Form::hidden('reference', $reference, ['class' => 'form-control', 'placeholder' => 'Reference']) !!}
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
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Numéro phone : </label>
                                {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Numéro phone']) !!}
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

                            <div class="form-group {!! $errors->has('pos_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Point de vente des opérations : </label>
                                {!! Form::select('pos_id', $pos, null, ['class' => 'cs-select cs-selector cs-skin-elastic', 'placeholder' => 'Selectionnez le point de vente']) !!}
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
                            <h4 class="panel-title">Information de Connexion</h4>

                        </div>
                        <div class="panel-body">


                            <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Adresse Email : </label>
                                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
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
                                                                    <input type="checkbox" data-toggle="toggle" name="roles[]" value="{{ $enfant->id }}" data-on="On" data-off="Off" data-onstyle="success" data-offstyle="danger" data-size="mini">
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

	<!--script src="assets/js/letter-icons.js"></script>
	<script src="assets/js/main.js"></script>
	<script src="assets/js/treetable.js"></script-->
	
    
@stop