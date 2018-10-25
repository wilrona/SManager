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
                                <h3 class="text-center" style="margin: 0;"><strong>Aucun produit dans le panier</strong></h3>
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
                                <strong>Sub-Total:</strong> <span id="Subtotal">0</span> XAF
                            </li>
                            <li class="text-extra-large">
                                <strong>TVA (<span id="tauxTax">0%</span>):</strong>  <span id="Tax">0</span> XAF
                            </li>
                            <li class="text-extra-large margin-top-15">
                                <h1 class="text-white" style="margin: 0;"><strong>Total:</strong> <span id="Total">0</span> XAF</h1>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="panier-commande panier-calc">
                    <div class="panel panel-white" style="border-radius: 0;">
                        <div class="panel-body">

                            <div class="col-md-10 col-md-offset-1">
                                <div class="text-center"> <h5>Modifier la quantité du produit</h5><h6><strong id="item-name-update">Aucun produit selectionné</strong></h6> </div>
                                <div class="input-group margin-bottom-10">
                                    <span class="input-group-addon plus" style="cursor: pointer;"><i class="fa fa-plus"></i></span>
                                    <input type="number" class="form-control text-center" id="item-qte-update" name="qte_name" value="1" min="1">
                                    <span class="input-group-addon minus" style="cursor: pointer;"><i class="fa fa-minus"></i></span>
                                </div>

                                <button class="btn btn-primary btn-block" id="submit-update-qte" data-id="">
                                    Valider les modifications
                                </button>
                                <hr>
                                <button class="btn btn-success btn-block" id="submit-commande">
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
                                <select class="js-example-basic form-control input-lg" id="select_client_id">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <a  href="{{ route('commande.formClient') }}" class="btn btn-primary btn-block btn-lg" data-toggle="modal" data-target="#myModal-lg" data-backdrop="static">
                                    <i class="fa fa-plus"></i>
                                    Ajouter un client
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
                <hr>

                <div class="panel panel-primary">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <input type="text" placeholder="Recherche produit" class="form-control input-lg" id="form-field-search">
                        </div>
                    </div>
                </div>
                <div class="panel panel-white">
                    <div class="panel-body">

                        <table class="table sample_6">
                            <thead>
                            <tr>
                                <th class="no-sort col-xs-1">#</th>
                                <th >Reference</th>
                                <th >Produit</th>
                                <th class="col-xs-2">Catégorie</th>
                                <th >Prix</th>
                                <th class="no-sort col-xs-1"></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($produit_list as $produit)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $produit->reference }}</td>
                                    <td>{{ $produit->name }}</td>
                                    <td>{{ $produit->Famille()->first()->name }}</td>
                                    <td>{{ number_format($produit->prix, 0, '.', ' ') }}</td>
                                    <td>
                                        <a  href="{{ route('commande.panier', $produit->id) }}" class="btn btn-danger btn-block btn-sm panier">
                                            <i class="fa fa-cart-plus"></i>
                                            Panier
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

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

        $(".js-example-basic").select2({
//            dropdownParent: $("#myModal-vt"),
            placeholder: "Selection du client",
            allowClear: true,
            theme: "bootstrap",
            language: "fr",
            ajax: {
                url: '{{ route('client.index', ['ajax' => true]) }}',
                dataType: 'json',
                processResults: function(data, page) {
                    return { results: data };
                },
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            }
        });

        $('#form-field-search').on('keyup', function(){
            oTable_6.fnFilter($(this).val());
        });

        $('#select_client_id').on('change', function(){

            var $value = $(this).val();

            $.ajax({
                url: "{{ route('commande.selectClient') }}",
                type: 'GET',
                data: { client_id: $value },
                success: function(data) {

                    if(data['countItem'] > 0){

                        $('#Subtotal').text(data['subtotal']);
                        $('#tauxTax').text(data['tauxTax']);
                        $('#Tax').text(data['tax']);
                        $('#Total').text(data['total']);

                        $('#item-name-update').text('Aucun produit selectionné');
                        $('#item-qte-update').val(1);
                        $('#submit-update-qte').data('id', '');

                        $('.item-panier.partition-light-primary').each(function () {
                            $(this).removeClass('partition-light-primary');
                        });

                        $.each(data['itemContent'], function (index, value) {

                            $.ajax({
                                url: "{{ route('commande.listpanier') }}",
                                type: 'GET',
                                data: { id: value.id },
                                success: function(data2nd) {

                                    $('.item-panier').each(function (index) {
                                        if($(this).data('id') === value.id){
                                            $(this).replaceWith(data2nd);
                                        }
                                    })


                                }
                            });

                        });

                    }
                }
            });

        });

        $('.panier').on('click', function (e) {
            e.preventDefault();

            var $url = $(this).attr('href');
            var $client = $('#select_client_id').val();

            $.ajax({
                url: $url,
                type: 'GET',
                data: { client_id: $client },
                success: function(data) {
                    if(data['success'].length > 0){
                        toastr["success"](data['success'], "Succès");
                        $('#Subtotal').text(data['subtotal']);
                        $('#tauxTax').text(data['tauxTax']);
                        $('#Tax').text(data['tax']);
                        $('#Total').text(data['total']);

                        $('#item-name-update').text('Aucun produit selectionné');
                        $('#item-qte-update').val(1);
                        $('#submit-update-qte').data('id', '');

                        $('.item-panier.partition-light-primary').each(function () {
                            $(this).removeClass('partition-light-primary');
                        });

                        $.ajax({
                            url: "{{ route('commande.listpanier') }}",
                            type: 'GET',
                            data: { id: data['id'] },
                            success: function(data2nd) {

                                if(data['update'] === 0){
                                    if(data['countItem'] === 1){
                                        $('#panierContent').html('');
                                    }
                                    $('#panierContent').append(data2nd)
                                }else{
                                    $('.item-panier').each(function (index) {
                                        if($(this).data('id') === data['id']){
                                            $(this).replaceWith(data2nd);
                                        }
                                    })
                                }

                            }
                        });

                    }

                    if(data['error'].length > 0){
                        toastr["error"](data['error'], "Erreur");
                    }
                }
            });
        });



        $('body').on('click', '.item-panier', function (e) {

            e.preventDefault();
            var $this = $(this);

            if($this.hasClass('partition-light-primary')){

                $this.removeClass('partition-light-primary');

                $('#item-name-update').text('Aucun produit selectionné');
                $('#item-qte-update').val(1);
                $('#submit-update-qte').data('id', '');

            }else{

                $('.item-panier.partition-light-primary').each(function () {
                    $(this).removeClass('partition-light-primary');

                });

                $.ajax({
                    url: "{{ route('commande.DeleteItemPanier') }}",
                    type: 'GET',
                    data: { id: $this.data('id'), request: 'select'},
                    success: function(data) {


                        $this.addClass('partition-light-primary');

                        $('#item-name-update').text(data['name']);
                        $('#item-qte-update').val(data['qte']);
                        $('#submit-update-qte').data('id', data['id']);
                    }
                });

            }
        }).on('click', '.closed-panier', function (e) {

            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            var $this = $(this);
            var $parent = $this.parent().parent();

            $('.item-panier.partition-light-primary').each(function () {
                $(this).removeClass('partition-light-primary');
            });

            $('#item-name-update').text('Aucun produit selectionné');
            $('#item-qte-update').val(1);
            $('#submit-update-qte').data('id', '');

            $.ajax({
                url: "{{ route('commande.DeleteItemPanier') }}",
                type: 'GET',
                data: { id: $(this).data('close'), request: 'remove'},
                success: function(data) {
                    if(data['success'].length > 0){
                        toastr["success"](data['success'], "Succès");
                        $('#Subtotal').text(data['subtotal']);
                        $('#tauxTax').text(data['tauxTax']);
                        $('#Tax').text(data['tax']);
                        $('#Total').text(data['total']);

                        var count_exist = 0;

                        $parent.replaceWith('');

                        $('.item-panier').each(function (index) {
                            count_exist += 1;
                        });

                        if(count_exist === 0){
                            $.ajax({
                                url: "{{ route('commande.listpanier') }}",
                                type: 'GET',
                                data: { id: $this.data('close') },
                                success: function(data2nd) {
                                    $('#panierContent').append(data2nd);
                                }
                            });
                        }


                    }

                    if(data['error'].length > 0){
                        toastr["error"](data['error'], "Erreur");
                    }
                }
        });



    });

        $('#submit-update-qte').on('click', function (e) {
            e.preventDefault();

            var $this = $(this);

            if($this.data('id') !== ''){

                $.ajax({
                    url: "{{ route('commande.DeleteItemPanier') }}",
                    type: 'GET',
                    data: { id: $this.data('id'), request: 'updateQte', quantite: $('#item-qte-update').val(), client_id: $('#select_client_id').val()},
                    success: function(data) {

                        $('#item-name-update').text('Aucun produit selectionné');
                        $('#item-qte-update').val(1);
                        $('#submit-update-qte').data('id', '');

                        if(data['success'].length > 0){

                            toastr["success"](data['success'], "Succès");
                            $('#Subtotal').text(data['subtotal']);
                            $('#tauxTax').text(data['tauxTax']);
                            $('#Tax').text(data['tax']);
                            $('#Total').text(data['total']);



                        }

                        if(data['error'].length > 0){
                            toastr["error"](data['error'], "Error");
                        }

                        $.ajax({
                            url: "{{ route('commande.listpanier') }}",
                            type: 'GET',
                            data: { id: data['id'] },
                            success: function(data2nd) {

                                $('.item-panier').each(function (index) {
                                    if(parseInt($(this).data('id')) === parseInt(data['id'])){
                                        $(this).replaceWith(data2nd);
                                    }
                                });

                            }
                        });

                    }
                });

            }

        });

        $('.minus').on('click', function (e) {
            e.preventDefault();

            var $minus = $('#item-qte-update');
            var $value = 1;

            if($('#submit-update-qte').data('id') !== ''){
                if($minus.val() > 1){
                    $value = parseInt($minus.val());
                    $value -= 1;
                    $minus.val($value);
                }
            }

        });

        $('.plus').on('click', function (e) {
            e.preventDefault();

            var $minus = $('#item-qte-update');
            var $value = 1;

            if($('#submit-update-qte').data('id') !== ''){
                $value = parseInt($minus.val());
                $value += 1;
                $minus.val($value);
            }

        });

        $('#submit-commande').on('click', function (e) {
            e.preventDefault();
            var $client = $('#select_client_id').val();
            var $count = 0;
            var $update_qte = $('#submit-update-qte').data('id');

            $('.item-panier').each(function (index) {
                $count += 1;
            });

            var $error = false;

            if($client.length === 0){

                swal({
                    title: "Selection du client",
                    text: 'La sélection du client est obligatoire',
                    type: "error",
                    showconfirmButton: true,
                    confirmButtonText: 'OK',
                    confirmButtonColor: "#d43f3a"
                });

                $error = true;

            }else{

                if($count === 0){

                    swal({
                        title: "Panier vide",
                        text: 'Aucun produit dans le panier de la commande',
                        type: "error",
                        showconfirmButton: true,
                        confirmButtonText: 'OK',
                        confirmButtonColor: "#d43f3a"
                    });

                    $error = true;
                }

            }

            if($error === false){
                if($update_qte !== ''){
                    swal({
                        title: 'Modification en cours',
                        text: 'Les modifications de quantité de produit en cours ne seront pas pris en compte.',
                        type: "warning",
                        confirmButtonColor: "#5cb85c",
                        confirmButtonText: "Valider",
                        closeOnConfirm: false,
                        showCancelButton: true,
                        cancelButtonText: 'Annuler'
                    }, function () {
                        saveCommande($client);
                    });
                }else{
                    saveCommande($client);
                }
            }

        });

        function saveCommande(client){

            $.ajax({
                url: "{{ route('commande.save') }}",
                type: 'GET',
                data: { client_id: client, caisse_id: "{{ $request['caisse_id'] }}"},
                success: function(data) {

                    if(data['error'].length > 0){

                        swal({
                            title: 'Produit inssuffisant',
                            text: data['error'],
                            type: "error",
                            showconfirmButton: true,
                            confirmButtonText: 'OK',
                            confirmButtonColor: "#d43f3a"
                        });

                    }else{

                        $('#item-name-update').text('Aucun produit selectionné');
                        $('#item-qte-update').val(1);
                        $('#submit-update-qte').data('id', '');

                        $('#Subtotal').text(0);
                        $('#tauxTax').text(0);
                        $('#Tax').text(0);
                        $('#Total').text(0);

                        swal({
                            title: data['codeCmd'],
                            text: 'Code de la commande à remettre au client ou à noter',
                            type: "success",
                            showConfirmButton: true,
                            confirmButtonText: 'Payer',
                            confirmButtonColor: "#58748B",
                            showCancelButton: true,
                            cancelButtonText: 'Valider',
                            cancelButtonColor: "#d43f3a"
                        }, function (result) {
                            if(result === true){
                                $.ajax({
                                    url: "{{ route('commande.encaissementCommande') }}/"+data['id'],
                                    type: 'GET',
                                    data: { caisse_id: "{{ $request['caisse_id'] }}" },
                                    success: function(data) {
                                        $('#myModal-vt').modal('show');
                                        $('#myModal-vt').find('.modal-content').html(data);
                                    }
                                });
                            }else{
                                $('.modal-header .close').trigger('click');
                            }
                        });

                        $.ajax({
                            url: "{{ route('commande.listpanier') }}",
                            type: 'GET',
                            data: { id: null },
                            success: function(data2nd) {
                                $('#panierContent').html(data2nd);
                            }
                        });

                    }


                }
            });

        }


    oTable_6.api().columns().every( function () {
        var column = this;
        if(column.index() === 3){
            var name = null;
            name = 'Catégorie';

            var select = $('<select class="form-control" style="width: 100%"><option value="">'+name+'</option></select>')
                .appendTo( $(column.header()).empty() )
                .on( 'change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column.search( val ? '^'+val+'$' : '', true, false ).draw();
                } );

            column.data().unique().sort().each( function ( d, j ) {
                select.append( '<option value="'+d+'">'+d+'</option>' )
            } );
        }

    } );
});

</script>