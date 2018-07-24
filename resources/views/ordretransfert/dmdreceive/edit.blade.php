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

        <div class="container-fluid container-fullw padding-bottom-10">
            @if(session()->has('ok'))
                <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            @endif
                @if(session()->has('warning'))
                    <div class="alert alert-warning alert-dismissible">{!! session('warning') !!}</div>
                @endif
            <div class="row">
                <form id="expedition_submit" method="post" action="{{ route('receive.expedition', $data->id) }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="expedition" value="1">
                </form>
                {!! Form::model($data, ['route' => ['receive.update', $data->id], 'id'=> 'submitFormulaire']) !!}
                <div class="col-md-8">
                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h3 class="panel-title">Information de la demande reçue</h3>
                            <ul class="panel-heading-tabs border-light">
                                <li class="middle-center">
                                    <a href="{{ route('receive.show', $data->id) }}" class="btn btn-o btn-sm btn-default">Retour</a>
                                </li>
                                <li class="middle-center">
                                    <div class="pull-right">
                                        <div class="btn-group" dropdown="">
                                            {!! Form::submit('Valider', ['class' => 'btn btn-primary btn-sm']) !!}
                                        </div>
                                    </div>
                                </li>
                                @if($data->statut_exp != 2)
                                <li class="middle-center">
                                        <div class="pull-right">
                                            <div class="btn-group" dropdown="">
                                                <button class="btn btn-blue btn-sm" id="submit_exp" type="button">Expédier les produits</button>
                                            </div>
                                        </div>

                                </li>
                                @endif


                            </ul>
                        </div>
                        <div class="panel-body">

                            <div class="form-group {!! $errors->has('reference') ? 'has-error' : '' !!}">
                                <!--<label for="exampleInputEmail1" class="text-bold text-capitalize"> Reference : </label>-->
                                {!! Form::text('reference', null, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! Form::hidden('reference') !!}

                                {!! $errors->first('reference', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('pos_dmd_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Point de vente demandeur : </label>
                                {!! Form::select('pos_dmd_id', $pos, null, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! Form::hidden('pos_dmd_id') !!}
                                {!! $errors->first('pos_dmd_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('mag_dmd_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Magasin demandeur : </label>
                                {!! Form::select('mag_dmd_id', $mag, null, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! Form::hidden('mag_dmd_id') !!}
                                {!! $errors->first('mag_dmd_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('pos_appro_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Point de vente approvisionneur : </label>
                                {!! Form::select('pos_appro_id', $pos, null, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! Form::hidden('pos_appro_id') !!}
                                {!! $errors->first('pos_appro_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
                            </div>

                            <div class="form-group {!! $errors->has('mag_appro_id') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Magasin approvisionneur : </label>
                                @if($data->statut_exp == 0)

                                    {!! Form::select('mag_appro_id', $my_mag, null, ['class' => 'cs-select cs-skin-elastic', 'placeholder' => 'Selectionnez l\'un de vos magasins...']) !!}

                                @else
                                    {!! Form::select('mag_appro_id', $my_mag, null, ['class' => 'form-control', 'disabled' => '']) !!}
                                    {!! Form::hidden('mag_appro_id') !!}
                                @endif

                                {!! $errors->first('mag_appro_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}

                                <span class="help-block hidden mag_appro_id">
                                    <i class="ti-alert text-primary"></i>
                                    <span class="text-danger">
                                        Le magasin approvisionneur n'a pas été défini pour le controle de stock disponible
                                    </span>
                                </span>
                            </div>

                            <div class="form-group {!! $errors->has('motif') ? 'has-error' : '' !!}">
                                <label for="exampleInputEmail1" class="text-bold"> Motif de la demande : </label>
                                {!! Form::textarea('motif', null, ['class' => 'form-control', 'disabled' => '']) !!}
                                {!! Form::hidden('motif') !!}
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
                            <h4 class="panel-title">Produits de la demande</h4>
                        </div>
                        <div class="panel-body" id="loading">
                            <table class="table ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="col-xs-5">Produit</th>
                                    <th class="col-xs-2 text-center">Qté ddé</th>
                                    <th class="col-xs-2 text-center">Qté  Exp.</th>
                                    <th class="col-xs-2 text-center">Qté à Exp.</th>
                                    <th class="col-xs-1"></th>
                                </tr>
                                </thead>
                                <tbody>

				                <?php if($produits):


				                foreach($produits as $key => $value):
				                ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $value['produit_name'] ?> <div><small class="text-danger" id="<?= $value['produit_id'] ?>"></small></div> </td>
                                    <td class="text-center"><?= $value['quantite'] ?></td>
                                    <td class="text-center"><?= $value['quantite_exp'] ?></td>
                                    <td class="text-center"><?= $value['quantite_a_exp']; ?></td>
                                    <td>
                                        <div aria-label="First group" role="group" class="btn-group col-xs-12">
                                            <a href="{{ route('receive.addSerie', [$value['ligne_id']]) }}" class="btn btn-primary btn-serie" data-toggle="modal" data-target="#myModal-lg" data-backdrop="static" data-quantite="<?= $value['quantite'] ?>" data-ligne="<?= $value['ligne_id'] ?>" data-produit="<?= $value['produit_id'] ?>">
                                                <i class="fa fa-list-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
				                <?php
				                endforeach;
				                else:
				                ?>
                                <tr>
                                    <td colspan="6">
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
                {!! Form::close() !!}
            </div>
        </div>

					
    </div>
@stop

@section('footer')
    @parent

    <script>
        $( document ).ready(function() {

            var $mag_appro_id = '';

            if($('[name=mag_appro_id]').val() !== ''){
                $mag_appro_id = $('[name=mag_appro_id]').val();
            }else{
                $('.btn-serie').bind('click', false);
                $('.btn-serie').attr('disabled', true);
            }

            $('li[data-option]').on('click', function () {
                $mag_appro_id = $(this).data('value');

                if($mag_appro_id !== ''){
                    $('.mag_appro_id').addClass('hidden');
                    $('.btn-serie').unbind('click', false);
                    $('.btn-serie').attr('disabled', false);
                }else{
                    $('.btn-serie').bind('click', false);
                    $('.btn-serie').attr('disabled', true);
                }

                // Enregistrement du magasin approvisionneur
                $.ajax({
                    url: "<?= route('receive.saveStockAppro') ?>",
                    type: 'GET',
                    data: { mag_appro_id: $mag_appro_id, id:{{ $data->id }} },
                    success: function(data) {
                        if(data['error'].length > 0){
                            toastr["error"](data['error'], "Erreur");
                            $('.mag_appro_id').removeClass('hidden');
                        }
                    }
                });
            });

            $('#submit_exp').on('click', function(e){
                e.preventDefault();
                $('form#expedition_submit').submit();
            });


        });



    </script>
	
    
@stop