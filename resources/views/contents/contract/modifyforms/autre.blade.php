<div class="tab-pane" id="tab_4">
			<div class="box-body">
				<div class="form-group col-md-3">
					<label for="">Tarif de la stratégie</label>
					<input type="hidden" name="id_autre_tarifs" value="@if(isset($infoAutreTarif[0])) {{ $infoAutreTarif[0]->id}} @endif">
					<input type="text" class="form-control" id="tarifstratautre" name="tarifstratautre" value="@if(isset($infoAutreTarif[0])) {{ $infoAutreTarif[0]->tarif_strategie}} @endif">
				</div>
				<div class="form-group col-md-3">
					<label for="">Tarifs weekend et nuit</label>
					<input type="text" class="form-control" id="tarifweekendnuit" name="tarifweekendnuit" value="@if(isset($infoAutreTarif[0])) {{ $infoAutreTarif[0]->tarif_weekend_nuit}} @endif">
				</div>
				<div class="form-group col-md-3">
					<label for="">Cout de déplacement sans prestation</label>
					<input type="text" class="form-control" id="tarifautredeplace" name="tarifautredeplace" value="@if(isset($infoAutreTarif[0])) {{ $infoAutreTarif[0]->tarif_deplacement_autre}} @endif">
				</div>
				<div class="form-group col-md-3">
					<label for="">Tarif utilisation batterie</label>
					<input type="text" class="form-control" id="tarifsbatterie" name="tarifsbatterie" value="@if(isset($infoContrat[0])) {{ $infoContrat[0]->tarifsbatterie}} @endif">
				</div>
				<div class="form-group col-md-3">
					<label for="">Tarif de la stratégie urgente</label>
					<input type="text" class="form-control" id="tarifstratautreu" name="tarifstratautreu" value="@if(isset($infoAutreTarif[0])) {{ $infoAutreTarif[0]->tarif_strategieu}} @endif">
				</div>
			</div>
		</div>
	</div><!-- /.tab-content -->
