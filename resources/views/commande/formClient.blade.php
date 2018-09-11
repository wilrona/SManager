<div class="modal-header">
    <button type="button" class="close ModalClose" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Creer un client</h4>
</div>

<div class="modal-body">
    {!! Form::open(['id'=> 'submitFormulaire']) !!}
    <div class="row">
        <div class="col-md-6">

            <!-- <label for="exampleInputEmail1" class="text-bold text-capitalize"> Reférence : </label> -->
            {!! Form::hidden('reference', $reference, ['class' => 'form-control hidden', 'placeholder' => 'Entrer un reference']) !!}


            <div class="form-group {!! $errors->has('famille_id') ? 'has-error' : '' !!}">
                <label for="exampleInputEmail1" class="text-bold"> Famille de client : </label>
                {!! Form::select('famille_id', $familles, null, ['class' => 'cs-select cs-skin-elastic', 'placeholder' => 'Selectionnez une famille de client...']) !!}
                {!! $errors->first('famille_id', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                        :message
                    </span>
                </span>
                ') !!}
            </div>

            <div class="form-group {!! $errors->has('nom') ? 'has-error' : '' !!}">
                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Nom : </label>
                {!! Form::text('nom', null, ['class' => 'form-control', 'placeholder' => 'Entrer le nom']) !!}
                {!! $errors->first('nom', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                        :message
                    </span>
                </span>
                ') !!}
            </div>
            <div class="form-group {!! $errors->has('prenom') ? 'has-error' : '' !!}">
                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Prenom : </label>
                {!! Form::text('prenom', null, ['class' => 'form-control', 'placeholder' => 'Entrer le prenom']) !!}
                {!! $errors->first('prenom', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                        :message
                    </span>
                </span>
                ') !!}
            </div>
            <div class="form-group {!! $errors->has('dateNais') ? 'has-error' : '' !!}">
                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Date de naissance : </label>
                {!! Form::date('dateNais', null, ['class' => 'form-control', 'placeholder' => 'Entrer le téléphone']) !!}
                {!! $errors->first('dateNais', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                        :message
                    </span>
                </span>
                ') !!}
            </div>
            <div class="form-group {!! $errors->has('phone') ? 'has-error' : '' !!}">
                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Téléphone principal: </label>
                {!! Form::number('phone', null, ['class' => 'form-control', 'placeholder' => 'Entrer le téléphone principal']) !!}
                {!! $errors->first('phone', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                        :message
                    </span>
                </span>
                ') !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {!! $errors->has('phone_un') ? 'has-error' : '' !!}">
                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Téléphone 1: </label>
                {!! Form::number('phone_un', null, ['class' => 'form-control', 'placeholder' => 'Entrer le téléphone 1']) !!}
                {!! $errors->first('phone_un', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                        :message
                    </span>
                </span>
                ') !!}
            </div>
            <div class="form-group {!! $errors->has('phone_deux') ? 'has-error' : '' !!}">
                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Téléphone 2: </label>
                {!! Form::number('phone_deux', null, ['class' => 'form-control', 'placeholder' => 'Entrer le téléphone 2']) !!}
                {!! $errors->first('phone_deux', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                        :message
                    </span>
                </span>
                ') !!}
            </div>
            <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Adresse email : </label>
                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Entrer une adresse email']) !!}
                {!! $errors->first('email', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                        :message
                    </span>
                </span>
                ') !!}
            </div>
            <div class="form-group {!! $errors->has('ville') ? 'has-error' : '' !!}">
                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Ville : </label>
                {!! Form::text('ville', null, ['class' => 'form-control', 'placeholder' => 'Entrer un ville']) !!}
                {!! $errors->first('ville', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                        :message
                    </span>
                </span>
                ') !!}
            </div>
            <div class="form-group {!! $errors->has('adresse') ? 'has-error' : '' !!}">
                <label for="exampleInputEmail1" class="text-bold text-capitalize"> Adresse Complete : </label>
                {!! Form::textarea('adresse', null, ['class' => 'form-control', 'placeholder' => 'Entrer une adresse']) !!}
                {!! $errors->first('adresse', '<span class="help-block"> <i class="ti-alert text-primary"></i><span class="text-danger">
                        :message
                    </span>
                </span>
                ') !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Annuler</button>
    <input type="button"  id="submits" class="btn btn-primary btn-sm" value="Creer le client"/>
</div>

<script src="{{URL::asset('assets/js/app.js')}}"></script>
<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();
        FormElements.init();

        $('#submits').on('click', function(e){
            e.preventDefault();

            $.ajax({
                url: "{{ route('commande.formClientPost') }}",
                data: $('#submitFormulaire').serialize(),
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(data) {
                    if(data['success'].length > 0){
                        toastr["success"](data['success'], "Enregistrement");
                        $('.modal-header .ModalClose').trigger('click');
                        var option = new Option(data.full_name, data.id, true, true);
                        studentSelect.append(option).trigger('change');
                        $('#select_client_id').val(data['user']).trigger("change")
                    }
                },
                error: function (request, status, error) {

                    json = $.parseJSON(request.responseText);

                    $.each(json.errors, function(key, value){
                        toastr["error"](value, "Saisie incorrecte");
                    });
                }
            });
        });
    });
</script>