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
			<h4 class="mainTitle no-margin">Configuration</h4>
			<span class="mainDescription">Gestion des configurations </span>
			<ul class="pull-right breadcrumb">
			<li><a href="/"><i class="fa fa-home margin-right-5 text-large text-dark"></i>Home</a>
			</li>
			<li>Configuration</li>
			</ul>
		</div>
		<!-- end: BREADCRUMB -->

        <div class="container-fluid container-fullw padding-bottom-10">
            <div class="row">
                <div class="col-md-12">
                        @if(session()->has('ok'))
                            <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
                        @endif

                        <div class="panel panel-white">
                            <div class="panel-heading border-light">
                                <h4 class="panel-title">Configurations de l'application</h4>
                            </div>
                            <div class="panel-body">
                                <div class="tabbable tabs-left" style="height: 100%">
                                    <ul class="nav nav-tabs">
                                        @foreach($datas as $data)
                                            @if($data['config'])
                                                <li @if($data['active'] == true) class="active" @endif>
                                                    <a href="#{{ $data['name'] }}_{{ $data['name'] }}" data-toggle="tab"> {{ $data['display_name'] }} </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    <div class="tab-content" style="height: 100%">
                                        @foreach($datas as $data)
                                            @if($data['config'])
                                                <div class="tab-pane fade @if($data['active'] == true) in active @endif" id="{{ $data['name'] }}_{{ $data['name'] }}">
                                                    {!! Form::open(['id'=> $data['name']]) !!}

                                                        <input type="hidden" name="module" value="{{ $data['name'] }}">
                                                        <div class="panel-heading border-light margin-bottom-10">
                                                            <h3 style="margin: 0;">Configuration du module <small><<</small> {{ $data['display_name'] }} <small>>></small></h3>
                                                            <ul class="panel-heading-tabs border-light">
                                                                <li class="middle-center">
                                                                    <a href="{{ route('param.update', $data['name']) }}" class="btn btn-sm btn-success submits" id="{{ $data['name'] }}">Enregistrer les modifications</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        @if($data['name'] == 'magasins')
                                                            <div class="well well-sm">
                                                                <h3 style="margin: 0;">Séquence Magasin Transit</h3>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="transitref" value="<?= isset($values[$data['name']]) && isset($values[$data['name']]['transitref']) ? $values[$data['name']]['transitref'] : '' ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if($data['name'] == 'demandes')
                                                            <div class="well well-sm">
                                                                <h3 style="margin: 0;">N° de séquence des transferts (Expédition/Reception) </h3>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="transfertref" value="<?= isset($values[$data['name']]) && isset($values[$data['name']]['transfertref']) ? $values[$data['name']]['transfertref'] : '' ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if($data['name'] == 'point_de_vente')
                                                            <div class="well well-sm">
                                                                <h3 style="margin: 0;">Point de vente principal</h3>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <select name="pos_center" id="" class="form-control">
                                                                            <option value="">Choix du point de vente</option>
                                                                            @foreach($pos as $point)
                                                                                <option value="{{ $point->id }}" <?= isset($values[$data['name']]) && isset($values[$data['name']]['pos_center']) && intval($values[$data['name']]['pos_center']) == $point->id  ? 'selected' : '' ?>>{{ $point->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if($data['name'] == 'caisses')
                                                            <div class="well well-sm">
                                                                <h3 style="margin: 0;">Devise Appliquée</h3>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <select name="devise" id="" class="form-control">
                                                                            <option value="">Choix de la devise</option>

                                                                            <option value="XAF" <?= isset($values[$data['name']]) && isset($values[$data['name']]['devise']) && $values[$data['name']]['devise'] == 'XAF'  ? 'selected' : '' ?>>Franc CFA</option>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif




                                                        @if($data['name'] != 'parametrages')
                                                            <div class="well well-sm">
                                                                <h3 style="margin: 0;">N° de séquence</h3>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="text-bold"> Code reference : </label>
                                                                        <input type="text" class="form-control" name="coderef" value="<?= isset($values[$data['name']]) && isset($values[$data['name']]['coderef']) ? $values[$data['name']]['coderef'] : '' ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="text-bold"> Incrémentation : </label>
                                                                        <input type="number" class="form-control" name="incref" value="<?= isset($values[$data['name']]) && isset($values[$data['name']]['incref']) ? $values[$data['name']]['incref'] : 1 ?>" min="1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif



                                                    {!! Form::close() !!}
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
						
						
						 
    </div>
@stop

@section('footer')
    @parent

    <script>
        $('.submits').on('click', function(e){
            e.preventDefault();
             var $id = $(this).attr('id');
             var $href = $(this).attr('href');
            $.ajax({
                url: $href,
                data: $('form#'+$id).serialize(),
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(data) {
                    alert(data.success);
                }
            });
        });
    </script>
    
@stop