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
                {!! Form::model($data, ['route' => ['receive.update', $data->id]]) !!}
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

                                {!! Form::select('mag_appro_id', $my_mag, null, ['class' => 'cs-select cs-skin-elastic', 'placeholder' => 'Selectionnez l\'un de vos magasins...']) !!}

                                {!! $errors->first('mag_appro_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                                        :message
                                    </span>
                                </span>
                                ') !!}
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
                            <h4 class="panel-title">Produits de la <demande></demande></h4>
                        </div>
                        <div class="panel-body" id="loading">
                            <table class="table ">
                                <thead>
                                <tr>
                                    <th class="col-xs-1">#</th>
                                    <th>Produit</th>
                                    <th class="col-xs-2">Qte demandé</th>
                                    <th class="col-xs-2">Qté  Exp.</th>
                                    <th class="col-xs-2">Qté à Exp.</th>
                                    <th class="col-xs-1"></th>
                                </tr>
                                </thead>
                                <tbody>

				                <?php if($produits):


				                foreach($produits as $key => $value):
				                ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $value['produit_name'] ?> <span class="text-danger" id="<?= $value['produit_id'] ?>"></span> </td>
                                    <td><?= $value['quantite'] ?></td>
                                    <td><?= $value['quantite_exp'] ?></td>
                                    <td>
                                        <input type="number" class="form-control number_max" style="display: inline; width: 100%" name="quantite_a_exp[]" value="<?= $value['quantite_a_exp']  ?>" min="0" max="<?= $value['quantite'] ?>" data-produit="<?= $value['produit_id'] ?>">
                                        <!--<span class="validity"></span>-->
                                    </td>
                                    <td>
                                        <div aria-label="First group" role="group" class="btn-group col-xs-12">
                                            {{--<a href="" class="btn btn-dark-azure bnt-ckeck">--}}
                                                {{--<i class="fa fa-check"></i>--}}
                                            {{--</a>--}}
                                            <a href="#" class="btn btn-primary btn-serie">
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
                                    <td colspan="4">
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

            $('.btn-serie').bind('click', false);
            $('.btn-serie').attr('disabled', true);

            $('li[data-option]').on('click', function () {
                $mag_appro_id = $(this).data('value');

                // Enregistrement du magasin approvisionneur

                $.ajax({
                    url: "<?= route('receive.saveStockAppro') ?>",
                    type: 'GET',
                    data: { mag_appro_id: $mag_appro_id, id:{{ $data->id }} },
                    success : function(list){

                    }
                });

                $('.number_max').each(function (number) {
                    $(this).val(0);
                });
            });

            $('.number_max').on('focusout', function (e) {
                e.preventDefault();

                if($('[name=mag_appro_id]').val() !== ''){
                    $mag_appro_id = $('[name=mag_appro_id]').val();
                }

                $content = $(this).parent().parent();

                if($mag_appro_id === ''){
                    $('.btn-serie').bind('click', false);
                    $('.btn-serie').attr('disabled', true);
                }else{
                    // Envoyer les données pour verifier que la quantite demandé est dans le stock
                    $('.btn-serie').unbind('click', false);
                    $('.btn-serie').attr('disabled', false);
                    // Ajx pour vérifier que la quantité est en stock
                    $.ajax({
                        url: "<?= route('receive.verifieStock') ?>",
                        data: { qte_a_exp : $(this).val(), produit_id: $(this).data('produit'), magasin_id: $mag_appro_id },
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function(data) {

                            if(data['success'] !== ''){
                                $content.removeClass('danger');
                                $('#'+$(this).data('produit')).html('');
                            }

                            if(data['success'] !== ''){
                                $content.addClass('danger');
                                $('#'+$(this).data('produit')).html('Quantité en stock : '+ data['qte_stock']);
                            }
                        }
                    });

                }


            })

        });



    </script>
	
    
@stop