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
            <h4 class="mainTitle no-margin">Création d'un profile</h4>
            <span class="mainDescription">Gestion des profiles </span>
            <ul class="pull-right breadcrumb">
                <li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
                </li>
                <li>Paramètres</li>
                <li>Profile</li>
                <li>Création</li>
            </ul>
        </div>

        <div class="container-fluid container-fullw padding-bottom-10">
            <div class="row">
                <div class="col-md-8">
                    {!! Form::open(['route' => 'profile.store']) !!}
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Information du profile</h4>
                            <ul class="panel-heading-tabs border-light">
                                <li class="middle-center">
                                    <a href="{{ route('profile.index') }}" class="btn btn-o btn-sm btn-default">Retour</a>
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


                            <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Nom du profile : </label>
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nom du profile']) !!}
                                {!! $errors->first('name', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
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





                        </div>
                    </div>
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h3 class="panel-title">Attribution des droits *</h3>
                        </div>
                        <div class="panel-body">
                            <div class="panel-group accordion" id="accordion">
                                @foreach($allRoles as $roles)
                                 <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h5 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#{{ $roles->name }}">  {{ $roles->display_name }} </a></h5>
                                    </div>
                                     @if($roles->enfants())
                                    <div id="{{ $roles->name }}" class="collapse @if($loop->index === 0 ) in @endif"style="">
                                        <div class="panel-body" style="padding: 0;">
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
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
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