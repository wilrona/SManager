<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Traitement des commandes</h4>
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

    .select2-container.select2-container--default.select2-container--open  {
        z-index: 15000;
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
                    <div class="panel-body no-padding">


                        {{--<div class="col-md-12 no-padding partition-light-primary">--}}
                            {{--<div class="padding-15" style="width: 100%">--}}
                                {{--<button type="button" class="close text-white" style="opacity: 1">&times;</button>--}}
                                {{--<h4 class="text-white"><strong>Titre du produit</strong></h4>--}}
                                {{--<p>--}}
                                {{--<h4 style="display: inline-block; float: right" class="text-white"><strong>200 000 XAF</strong></h4>--}}

                                {{--Prix :  <span>10 000</span> x Quantite : <span>2</span>--}}
                                {{--</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="col-md-12 no-padding">--}}
                            {{--<div class="padding-15" style="width: 100%">--}}
                                {{--<button type="button" class="close" style="opacity: 1">&times;</button>--}}
                                {{--<h4><strong>Titre du produit</strong></h4>--}}
                                {{--<p>--}}
                                {{--<h4 style="display: inline-block; float: right"><strong>200 000 XAF</strong></h4>--}}

                                {{--Prix :  <span>10 000</span> x Quantite : <span>1</span>--}}
                                {{--</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="col-md-12 no-padding" style="border-top: 1px solid #eeeeee">
                            <div class="padding-15" style="width: 100%">
                                <h3 class="text-center"><strong>Aucun produit dans le panier</strong></h3>
                            </div>
                        </div>



                    </div>

                </div>
            </div>
            <div class="bottom-content">
                <div class="partition-dark-primary no-padding panier-price">
                    <div class="padding-15">
                        <ul class="list-unstyled amounts text-small" style="margin: 0;">
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
                    <div class="panel panel-white" style="border-radius: 0;">
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
        </div>
        <div class="col-md-9 right">
            <div class="padding-10">
                <div class="panel panel-white">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-9">
                                <select class="js-example-basic form-control">
                                    <optgroup label="Alaskan/Hawaiian Time Zone">
                                        <option value="AK">Alaska</option>
                                        <option value="HI">Hawaii</option>
                                    </optgroup>
                                    <optgroup label="Pacific Time Zone">
                                        <option value="CA">California</option>
                                        <option value="NV">Nevada</option>
                                        <option value="OR">Oregon</option>
                                        <option value="WA">Washington</option>
                                    </optgroup>
                                    <optgroup label="Mountain Time Zone">
                                        <option value="AZ">Arizona</option>
                                        <option value="CO">Colorado</option>
                                        <option value="ID">Idaho</option>
                                        <option value="MT">Montana</option>
                                        <option value="NE">Nebraska</option>
                                        <option value="NM">New Mexico</option>
                                        <option value="ND">North Dakota</option>
                                        <option value="UT">Utah</option>
                                        <option value="WY">Wyoming</option>
                                    </optgroup>
                                    <optgroup label="Central Time Zone">
                                        <option value="AL">Alabama</option>
                                        <option value="AR">Arkansas</option>
                                        <option value="IL">Illinois</option>
                                        <option value="IA">Iowa</option>
                                        <option value="KS">Kansas</option>
                                        <option value="KY">Kentucky</option>
                                        <option value="LA">Louisiana</option>
                                        <option value="MN">Minnesota</option>
                                        <option value="MS">Mississippi</option>
                                        <option value="MO">Missouri</option>
                                        <option value="OK">Oklahoma</option>
                                        <option value="SD">South Dakota</option>
                                        <option value="TX">Texas</option>
                                        <option value="TN">Tennessee</option>
                                        <option value="WI">Wisconsin</option>
                                    </optgroup>
                                    <optgroup label="Eastern Time Zone">
                                        <option value="CT">Connecticut</option>
                                        <option value="DE">Delaware</option>
                                        <option value="FL">Florida</option>
                                        <option value="GA">Georgia</option>
                                        <option value="IN">Indiana</option>
                                        <option value="ME">Maine</option>
                                        <option value="MD">Maryland</option>
                                        <option value="MA">Massachusetts</option>
                                        <option value="MI">Michigan</option>
                                        <option value="NH">New Hampshire</option>
                                        <option value="NJ">New Jersey</option>
                                        <option value="NY">New York</option>
                                        <option value="NC">North Carolina</option>
                                        <option value="OH">Ohio</option>
                                        <option value="PA">Pennsylvania</option>
                                        <option value="RI">Rhode Island</option>
                                        <option value="SC">South Carolina</option>
                                        <option value="VT">Vermont</option>
                                        <option value="VA">Virginia</option>
                                        <option value="WV">West Virginia</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-block btn-lg">
                                    <i class="fa fa-plus"></i>
                                    Ajouter un client
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
                <hr>

                <div class="panel panel-primary">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <input type="text" placeholder="Recherche produit" class="form-control input-lg">
                        </div>
                    </div>
                </div>
                <div class="panel panel-white">
                    <div class="panel-body">

                        <table class="table sample_5">
                            <thead>
                            <tr>
                                <th class="no-sort">#</th>
                                <th >Reference</th>
                                <th >Produit</th>
                                <th >Catégorie</th>
                                <th >Prix</th>
                                <th class="no-sort col-xs-1"></th>
                            </tr>
                            </thead>
                            <tbody>




                            </tbody>
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

        $(".js-example-basic").select2();
    });
</script>