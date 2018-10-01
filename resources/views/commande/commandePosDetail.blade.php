<style>
    .dataTables_filter{
        display: none !important;
    }
</style>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Commande <strong>{{ $data->reference }}</strong></h4>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <fieldset>
                <legend>
                    <strong>Information du client </strong> :
                </legend>
                <div class="form-group">
                    <label> Nom et prénom : </label>
                    <input type="text" class="form-control underline" disabled value="{{ $data->client()->first()->display_name }}">
                </div>
                <div class="form-group">
                    <label> Famille du client : </label>
                    <input type="text" class="form-control underline" disabled value="{{ $data->client()->first()->famille()->first()->name }}">
                </div>
                <div class="form-group">
                    <label> Téléphone : </label>
                    <input type="text" class="form-control underline" disabled value="{{ $data->client()->first()->phone }}">
                </div>
                <div class="form-group">
                    <label> Email : </label>
                    <input type="text" class="form-control underline" disabled value="{{ $data->client()->first()->email }}">
                </div>


            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset>
                <legend>
                    <strong>Information de la commande </strong> :
                </legend>
                <div class="form-group">
                    <label> Reference : </label>
                    <input type="text" class="form-control underline" disabled value="{{ $data->reference }}">
                </div>
                <div class="form-group">
                    <label> Etat : </label>
                    <input type="text" class="form-control underline" disabled value="@if($data->etat == 0) Enregistré @endif @if($data->etat == 1) Payé @endif @if($data->etat == 2) Produit Traité partiellement @endif @if($data->etat == 3) Produit Traité @endif @if($data->etat == 4) Livré partiellement @endif @if($data->etat == 5) Livré @endif">
                </div>
                <div class="form-group">
                    <label> Code de la commande : </label>
                    <input type="text" class="form-control underline" disabled value="{{ $data->codeCmd }}">
                </div>
                <div class="form-group">
                    <label> Date de création : </label>
                    <input type="text" class="form-control underline" disabled value="{{ $data->created_at->format('d-m-Y H:i') }}">
                </div>


            </fieldset>
        </div>
        <div class="col-md-12">

            <fieldset>
                <legend>
                    <strong>Produit de la commande </strong> :
                </legend>

                <table class="table">
                    <thead>
                    <tr>
                        <th class="col-xs-1">#</th>
                        <th class="col-xs-3">Produit</th>
                        <th class="col-xs-3">Prix</th>
                        <th class="col-xs-3">Qté</th>
                        <th class="col-xs-3 text-right">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data->Produits()->get() as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ number_format($item->pivot->prix, 0, '.', ' ') }} {{ $item->pivot->devise }}</td>
                            <td>{{ $item->pivot->qte }}</td>
                            <td class="text-right">
                                {{ number_format($item->pivot->prix * $item->pivot->qte, 0, '.', ' ') }} {{ $item->pivot->devise }}
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            </fieldset>

            <div class="padding-15" style="text-align: right">
                <ul class="list-unstyled amounts text-small" style="margin: 0;">
                    <li class="text-extra-large">
                        <strong>Sub-Total:</strong> <span id="Subtotal">{{ number_format($data->subtotal, 0, '.', ' ') }}</span> XAF
                    </li>
                    <li class="text-extra-large">
                        <strong>TVA (<span id="tauxTax">{{ round((($data->total - $data->subtotal) * 100) / $data->subtotal, 2) }}%</span>):</strong>  <span id="Tax">{{ number_format($data->total - $data->subtotal, 0, '.', ' ') }}</span> XAF
                    </li>
                    <li class="text-extra-large margin-top-15">
                        <h1 style="margin: 0;"><strong>Total:</strong> <span id="Total">{{ number_format($data->total, 0, '.', ' ') }}</span> XAF</h1>
                    </li>
                </ul>
            </div>

        </div>

        <div class="col-md-12">

            <fieldset>
                <legend>
                    <strong>Traitement produit de la commande </strong> :
                </legend>

                <table class="table">
                    <thead>
                    <tr>
                        <th class="col-xs-1">#</th>
                        <th class="col-xs-3">Produit</th>
                        <th class="col-xs-3">Qté</th>
                        <th class="col-xs-3">Qté sortie</th>
                        <th class="col-xs-3">Qté livrée</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($data->Produits()->get() as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->pivot->qte }}</td>
                            <td>@if(unserialize($item->pivot->serie_sortie)){{ count(unserialize($item->pivot->serie_sortie)) }}@else 0 @endif</td>
                            <td>@if(unserialize($item->pivot->serie_livree)){{ count(unserialize($item->pivot->serie_livree)) }}@else 0 @endif</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            </fieldset>

        </div>

    </div>







</div>