<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Encaissement de la commande <b>{{ $data->reference }}</b></h4>
</div>
<style>

    .left, .right{
        padding: 0;
        overflow-y: scroll;
        height: calc(100vh - 117px);
    }

    .panel{
        margin: 0;
        border-radius: 0;
    }

    .bottom-content{
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
    }

    .top-content{
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        padding: 10px;
        padding-bottom: 0;
    }

    .top-content .panier-commande{
        border-radius: 0;
        max-height: calc(100vh - 550px);
    }

    .top-content .panier-commande .panel-body{
        height: 100%;
        overflow: scroll;
    }

    .select2-container{
        width: 100% !important;
    }

    .select2-container .select2-selection--single{
        height: 46px;
        padding: 10px 16px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered{
        font-size: 16px !important;
        line-height: 1.5 !important;
        height: 100%;
    }

    .select2-container.select2-container--default.select2-container--open, .select2-container--bootstrap.select2-container--open{
        z-index: 10000;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow{
        height: 100%;
    }

    .select2-search--dropdown .select2-search__field{
        height: 36px;
    }

    .partition-light-primary h4{
        color: #ffffff;
    }

    /*.panier-commande{*/
        /*max-height: calc(100vh - 573px);*/
        /*position: absolute;*/
        /*top: 49px;*/
         /*left: 0;*/
        /*right: 0;*/
        /*overflow-y: scroll;*/
    /*}*/

    /*.panier-calc{*/
        /*top: 615px;*/
        /*height: calc(100vh - 740px);*/
        /*left: 0;*/
        /*right: 0;*/
    /*}*/


    /*.panier-title{*/
        /*height: 50px;*/
        /*top: 0;*/
        /*right: 0;*/
        /*left: 0px;*/
        /*margin: 0;*/
    /*}*/

    /*.panier-price{*/
        /*position: absolute;*/
        /*right: 0;*/
        /*left: 0;*/
        /*top: 458px;*/
    /*}*/

</style>

<div class="modal-body" style="height: calc(100vh - 117px); background-color: #F9F9F9; padding: 0;">


        <div class="col-md-3 left">
            <div class="top-content">
                <div class="panel panel-white" style="border-radius: 0;">
                    <div class="panel-heading">
                        <h4 class="panel-title">Panier de la commande</h4>
                    </div>
                </div>
                <div class="panel panel-white panier-commande">
                    <div class="panel-body no-padding" id="panierContent">

                        @foreach($data->Produits()->get() as $panier)

                        <div class="col-md-12 no-padding">
                            <div class="padding-15" style="width: 100%">
                                <h4><strong>{{ $panier->name }}</strong></h4>
                                <p>
                                <h4 style="display: inline-block; float: right"><strong>{{ number_format(($panier->pivot->prix * $panier->pivot->qte), 0, '.', ' ')  }} {{ $panier->pivot->devise ? $panier->pivot->devise : 'XAF' }}</strong></h4>

                                Prix :  <span>{{ number_format($panier->pivot->prix, 0, '.', ' ') }}</span> x Quantite : <span>{{ $panier->pivot->qte }}</span>
                                </p>
                            </div>
                        </div>

                        @endforeach

                    </div>

                </div>
            </div>
            <div class="bottom-content">
                <div class="partition-dark-primary no-padding panier-price">
                    <div class="padding-15">
                        <ul class="list-unstyled amounts text-small" style="margin: 0;">
                            <li class="text-extra-large">
                                <strong>Sub-Total:</strong> <span id="Subtotal">{{  number_format($data->subtotal, 0, '.', ' ') }}</span> {{ $data->devise }}
                            </li>
                            <li class="text-extra-large">
                                <strong>TVA (<span id="tauxTax">{{ (($data->total * 100) / $data->subtotal) - 100 }}%</span>):</strong>  <span id="Tax">{{ number_format($data->total - $data->subtotal, 0, '.', ' ') }}</span> {{ $data->devise }}
                            </li>
                            <li class="text-extra-large margin-top-15">
                                <h1 class="text-white" style="margin: 0;"><strong>Total:</strong> <span id="Total">{{ number_format($data->total, 0, '.', ' ') }}</span> {{ $data->devise }}</h1>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="panier-commande panier-calc">
                    <div class="panel panel-white" style="border-radius: 0;">
                        <div class="panel-body">
                            <div class="form-group text-center h4">
                                <label for="exampleInputEmail1"> Sélectionnez le mode paiement </label>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <button type="button" data-url="{{ route('commande.encaissement', ['paiement' => 'cash', 'id' => $data->id, 'caisse_id' => $request->get('caisse_id')]) }}" class="btn btn-wide btn-primary margin-bottom-15 btn-block btn-lg paiement" disabled>
                                        Cash
                                    </button>
                                </div>

                                <div class="col-xs-6">
                                    <button type="button" data-url="{{ route('commande.encaissement', ['paiement' => 'orange_money', 'id' => $data->id, 'caisse_id' => $request->get('caisse_id')]) }}" class="btn btn-wide btn-primary margin-bottom-15 btn-block btn-lg paiement" disabled>
                                        Orange Money
                                    </button>
                                </div>

                                <div class="col-xs-6">
                                    <button type="button" data-url="{{ route('commande.encaissement', ['paiement' => 'mobile_money', 'id' => $data->id, 'caisse_id' => $request->get('caisse_id')]) }}" class="btn btn-wide btn-primary margin-bottom-15 btn-block btn-lg paiement" disabled>
                                        Mobile Money
                                    </button>
                                </div>
                                <div class="col-xs-6">
                                    <button type="button" data-url="{{ route('commande.encaissement', ['paiement' => 'other', 'id' => $data->id, 'caisse_id' => $request->get('caisse_id')]) }}" class="btn btn-wide btn-primary margin-bottom-15 btn-block btn-lg paiement" disabled>
                                        Autres
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 right">
            <div class="padding-10">

                <div class="col-md-6 col-md-offset-3">

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Information du client : <strong>{{ $data->client()->first()->reference }}</strong></h4>
                        </div>
                        <div class="panel-body">

                            <ul class="list-unstyled invoice-details padding-bottom-10 padding-top-10 text-dark">
                                <li>
                                    <strong>Nom et prénom :</strong> {{ $data->client()->first()->display_name }}
                                </li>
                                <li>
                                    <strong>Famille :</strong> {{ $data->client()->first()->famille()->first()->name }}
                                </li>
                                <li>
                                    <strong>Phone :</strong> {{ $data->client()->first()->phone }} {{ $data->client()->first()->phone_un ? ','.$data->client()->first()->phone_un : ''  }} {{ $data->client()->first()->phone_deux ? ','.$data->client()->first()->phone_deux : ''  }}
                                </li>
                                <li>
                                    <strong>Email :</strong> {{ $data->client()->first()->email }}
                                </li>
                            </ul>

                        </div>

                    </div>

                    <hr>

                    <div class="jumbotron text-center" style="margin: 0;">
                        <h1 style="margin: 0;" data-montant="{{ $data->total }}" id="montant_total">{{ number_format($data->total, 0, '.', ' ') }}</h1>
                    </div>
                    <div class="panel panel-white">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="number" class="form-control input-lg underline" placeholder="Montant reçu" min="0" style="text-align: right; font-size: 25px !important;" id="montant_recu">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-white">
                        <table class="table">
                            <tr>
                                <td>
                                    <h3 style="margin: 10px 0;"><strong>Payée :</strong></h3>
                                </td>
                                <td style="text-align: right; font-weight: 900 !important;">
                                    <span id="payee">0</span> {{ $data->devise }}
                                    <input type="hidden" id="payee_input">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h3 style="margin: 10px 0;"><strong>Reste :</strong></h3>
                                </td>
                                <td style="text-align: right; font-weight: 900 !important;">
                                    <span id="reste">0</span>
                                    {{ $data->devise }}
                                    <input type="hidden" id="reste_input">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h3 style="margin: 10px 0;"><strong>Rendu :</strong></h3>
                                </td>
                                <td style="text-align: right; font-weight: 900 !important;">
                                    <span id="rendu">0</span>
                                    {{ $data->devise }}
                                    <input type="hidden" id="rendu_input">
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>

            </div>
        </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Annuler</button>
    {{--<input type="button"  id="submits" class="btn btn-primary btn-sm" value="Valider"/>--}}
</div>

<script src="{{URL::asset('assets/js/app.js')}}"></script>
<script>
jQuery(document).ready(function() {

        TableData.init();
        FormElements.init();

        $('.paiement').on('click', function (e) {
            e.preventDefault();
            $url = $(this).data('url');

            $.ajax({
                url: $url,
                type: 'GET',
                data: { rendu: $('#rendu_input').val(), payee: $('#payee_input').val(), send : 1 },
                success: function(data) {
                    swal({
                        title: 'Paiement Réussi',
                        text: data['success'],
                        type: "success",
                        showconfirmButton: true,
                        confirmButtonText: 'OK',
                        confirmButtonColor: "#d43f3a"
                    }, function () {
                        oTable_6.fnClearTable();
                        $('#value_encaissement_effectue').html(data['montant_encaisse']);
                        $('#value_montant_caisse').html(data['montant_caisse']);
                        $('.modal-header .close').trigger('click');
                    });

                }
            });
        });

        $('#montant_recu').on('keyup', function (e) {
            e.preventDefault();

            var  $value = parseInt($(this).val());
            var $montant = parseInt($('#montant_total').data('montant'));
            var $reste = $value - $montant;

            $('#rendu_input').val(0);
            $('#payee_input').val(0);

            if($value < $montant){

                $('#payee').html($value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "));
                $('#reste').html($reste.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "));
                $('#rendu').html(0);
                $('.paiement').prop("disabled",true);

                $('#rendu_input').val(0);
                $('#payee_input').val($value);

            }else{

                $('#payee').html($montant.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "));
                $('#reste').html(0);
                $('#rendu').html($reste.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "));
                $('.paiement').prop("disabled",false);

                $('#rendu_input').val($reste);
                $('#payee_input').val($montant);
            }

        });


});

</script>