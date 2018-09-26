<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Information de la commande <b>{{ $data->reference }}</b></h4>
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

                        <div class="col-md-12 no-padding item-panier" id="{{ $panier->id }}">
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
                            <div class="row">
                                <div class="col-xs-12">
                                    <button type="button" class="btn btn-wide btn-primary margin-bottom-15 btn-block btn-lg" disabled>
                                        Terminer
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

                <div class="col-md-12">

                    <div class="panel panel-white">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">Information du client : <strong>{{ $data->client()->first()->reference }}</strong></h4>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <ul class="list-unstyled invoice-details padding-bottom-10 padding-top-10 text-dark">
                                        <li>
                                            <strong>Nom et prénom :</strong> {{ $data->client()->first()->display_name }}
                                        </li>
                                        <li>
                                            <strong>Famille :</strong> {{ $data->client()->first()->famille()->first()->name }}
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-xs-6">
                                    <ul class="list-unstyled invoice-details padding-bottom-10 padding-top-10 text-dark">
                                        <li>
                                            <strong>Phone :</strong> {{ $data->client()->first()->phone }} {{ $data->client()->first()->phone_un ? ','.$data->client()->first()->phone_un : ''  }} {{ $data->client()->first()->phone_deux ? ','.$data->client()->first()->phone_deux : ''  }}
                                        </li>
                                        <li>
                                            <strong>Email :</strong> {{ $data->client()->first()->email }}
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>

                    <hr>

                    <div class="jumbotron text-center" id="jumbotron">
                        <h1><small>Veuillez sélectionner un produit dans le panier pour associer des numéros de series</small></h1>
                    </div>

                    <div id="reloading">

                    </div>

                </div>

            </div>
        </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Annuler</button>
    {{--<input type="button"  id="submits" class="btn btn-primary btn-sm" value="Valider"/>--}}
</div>


<script>

jQuery(document).ready(function() {

    TableData.init();
    FormElements.init();

    $('body').on('click', '.item-panier', function (e) {
        e.preventDefault();

        if($(this).hasClass('partition-light-primary')){

            $(this).removeClass('partition-light-primary');
            $('#jumbotron').removeClass('hidden');
            $('#reloading').html('');

        }else{

            $('.item-panier.partition-light-primary').each(function () {
                $(this).removeClass('partition-light-primary');
            });

            $(this).addClass('partition-light-primary');

            $('#jumbotron').addClass('hidden');

            $.ajax({
                url: "",
                type: 'GET',
                data: { id: $(this).data('id'), magasin_id: "{{ $request->get('magasin_id') }}" },
                success: function(data) {

                }
            });

        }
    })
});

</script>