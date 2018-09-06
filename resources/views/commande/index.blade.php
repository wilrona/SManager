<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Traitement des commandes</h4>
</div>
<style>
    .panier-commande{
        max-height: calc(100vh - 573px);
        position: absolute;
        top: 49px;
         left: 0;
        right: 0;
        overflow-y: scroll;
    }

    .panier-calc{
        top: 615px;
        height: calc(100vh - 740px);
        left: 0;
        right: 0;
    }


    .panier-title{
        height: 50px;
        top: 0;
        right: 0;
        left: 0px;
        margin: 0;
    }

    .panier-price{
        position: absolute;
        right: 0;
        left: 0;
        top: 458px;
    }

</style>

<div class="modal-body" style="height: calc(100vh - 117px); background-color: #F9F9F9; padding: 0;">


        <div class="col-md-3 " style="height: 100%;">
            <div class="panel panel-white panier-commande panier-title" style="border-radius: 0;">
                <div class="panel-heading">
                    <h4 class="panel-title">Panier de la commande</h4>
                </div>
            </div>
            <div class="panel panel-white panier-commande" style="border-radius: 0;">
                <div class="panel-body no-padding">


                    <div class="col-md-12 no-padding partition-light-primary">
                        <div class="padding-15" style="width: 100%">
                            <button type="button" class="close text-white" style="opacity: 1">&times;</button>
                            <h4 class="text-white"><strong>Titre du produit</strong></h4>
                            <p>
                            <h4 style="display: inline-block; float: right" class="text-white"><strong>200 000 XAF</strong></h4>

                            Prix :  <span>10 000</span> x Quantite : <span>2</span>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-12 no-padding">
                        <div class="padding-15" style="width: 100%">
                            <button type="button" class="close" style="opacity: 1">&times;</button>
                            <h4><strong>Titre du produit</strong></h4>
                            <p>
                            <h4 style="display: inline-block; float: right"><strong>200 000 XAF</strong></h4>

                            Prix :  <span>10 000</span> x Quantite : <span>1</span>
                            </p>
                        </div>
                    </div>

                    {{--<div class="col-md-12 no-padding" style="border-top: 1px solid #eeeeee">--}}
                        {{--<div class="padding-15" style="width: 100%">--}}
                            {{--<h3 class="text-center"><strong>Aucun produit dans le panier</strong></h3>--}}
                        {{--</div>--}}
                    {{--</div>--}}



                </div>

            </div>
            <div class="partition-dark-primary no-padding panier-price">
                <div class="padding-20">
                    <ul class="list-unstyled amounts text-small">
                        <li class="text-extra-large">
                            <strong>Sub-Total:</strong> 0 XAF
                        </li>
                        <li class="text-extra-large">
                            <strong>TVA:</strong> 0%
                        </li>
                        <li class="text-extra-large margin-top-15">
                            <h1 class="text-white" style="margin: 0;"><strong>Total:</strong> 0 XAF</h1>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="panier-commande panier-calc">
                <div class="panel panel-white" style="border-radius: 0; height: 100%;">
                    <div class="panel-body">

                        <div class="col-md-10 col-md-offset-1">
                            <div class="text-center"> <h5>Modifier la quantité du produit</h5><h6><strong>Aucun produit selectionné</strong></h6> </div>
                            <div class="input-group margin-bottom-10">
                                <span class="input-group-addon" style="cursor: pointer;"><i class="fa fa-plus"></i></span>
                                <input type="number" class="form-control text-center">
                                <span class="input-group-addon" style="cursor: pointer;"><i class="fa fa-minus"></i></span>
                            </div>

                            <button class="btn btn-primary btn-block">
                                Valider les modifications
                            </button>
                            <hr>
                            <button class="btn btn-success btn-block">
                                Enregistrer la commande
                            </button>
                        </div>

                    </div>

                </div>
            </div>

        </div>
        <div class="col-md-9">
            Contenu
        </div>
</div>



<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Annuler</button>
    {{--<input type="button"  id="submits" class="btn btn-primary btn-sm" value="Valider"/>--}}
</div>