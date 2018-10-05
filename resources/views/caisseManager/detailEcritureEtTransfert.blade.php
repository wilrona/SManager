<?php
/**
 * Created by IntelliJ IDEA.
 * User: online2
 * Date: 28/06/2018
 * Time: 12:02
 */
?>

<style>
    .dataTables_filter{
        display: none !important;
    }
</style>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    @if(isset($request['type']))
        <h4 class="modal-title" id="myModalLabel">Transfert de fond</h4>
    @else
        <h4 class="modal-title" id="myModalLabel">{{ $data->libelle }}</h4>
    @endif
</div>

<div class="modal-body">

	<?php
	if(!isset($request['type'])):
		$ecriture =  $data->EcritureCaisse()->first();
	else:
		$ecriture = $data;
	endif;
	?>


    <fieldset>
        <legend>
            <strong>Ecriture Caisse</strong> :
        </legend>
        <div class="form-group">
            <label> Session : </label>
            <input type="text" class="form-control underline" disabled value="session_{{ $ecriture->session_id }}">
        </div>
        <div class="form-group">
            <label> Montant transaction : </label>
            <div class="input-group">
                <input type="text" class="form-control underline" disabled value="{{ $ecriture->montant }}">
                <span class="input-group-addon">{{ $ecriture->devise }}</span>
            </div>
        </div>
        @if($data->montant_remb)
        <div class="form-group">
            <label> Montant remboursement : </label>
            <div class="input-group">
                <input type="text" class="form-control underline" disabled value="{{ $ecriture->montant_remb }}">
                <span class="input-group-addon">{{ $ecriture->devise }}</span>
            </div>
        </div>
        @endif
        <div class="form-group">
            <label> Mode de paiement : </label>
            <input type="text" class="form-control underline" disabled value="{{ $ecriture->type_paiement }}">
        </div>

        <div class="form-group">
            <label> Type d'ecriture : </label>
            <input type="text" class="form-control underline" disabled @if($ecriture->type_ecriture == 0) value="Fermeture session" @endif @if($ecriture->type_ecriture == 1) value="Ouverture session" @endif @if($ecriture->type_ecriture == 2) value="Approvisionnement" @endif @if($ecriture->type_ecriture == 3) value="Encaissement" @endif @if($ecriture->type_ecriture == 4) value="Sortie de fond" @endif">
        </div>

        <div class="form-group">
            <label> Utilisateur : </label>
            <input type="text" class="form-control underline" disabled value="{{ $ecriture->User()->first()->nom }} {{ $ecriture->User()->first()->prenom }}">
        </div>


    </fieldset>


    <?php
        if(!isset($request['type'])):
            $transfert =  $data;
        else:
            $transfert = $data->TransfertFond()->first();
        endif;
    ?>
    @if($transfert)
    <fieldset>
        <legend>
            <strong>Transfert de fond</strong> :
        </legend>

        <div class="form-group">
            <label> Reférence : </label>
            <input type="text" class="form-control underline" disabled value="{{ $transfert->reference }}">
        </div>

        <div class="form-group">
            <label> Motif : </label>
            <textarea id="" cols="10" rows="5" class="form-control underline" disabled>{{ $transfert->motif }}</textarea>
        </div>

        <div class="form-group">
            <label> Montant transaction : </label>
            <div class="input-group">
                <input type="text" class="form-control underline" disabled value="{{ $transfert->montant }}">
                <span class="input-group-addon">{{ $ecriture->devise }}</span>
            </div>
        </div>


        <?php
	        $expedition = $transfert->EcritureCaisse()->where([['type_ecriture', '=', 4], ['caisse_id', '=', $caisse_id]])->first();
        ?>
        @if($expedition)
            <div class="form-group">
                <label> Caisse de reception : </label>
                <input type="text" class="form-control underline" disabled value="{{ $transfert->caisse_receive()->first()->name }}">
            </div>
        @endif

	    <?php
	        $reception = $transfert->EcritureCaisse()->where([['type_ecriture', '=', 2], ['caisse_id', '=', $caisse_id]])->first();
	    ?>
        @if($reception)
            <div class="form-group">
                <label> Caisse d'envoie : </label>
                <input type="text" class="form-control underline" disabled value="{{ $transfert->caisse_sender()->first()->name }}">
            </div>
        @endif
        <div class="form-group">
            <label> Etat du transfert : </label>
            <input type="text" class="form-control underline" disabled value="@if($transfert->statut == 1) Reçu @elseif($transfert->statut == 2) Annulé @else En expédition @endif">
        </div>
    </fieldset>
    @endif

</div>
