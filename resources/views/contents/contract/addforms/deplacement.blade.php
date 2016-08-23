<div class="tab-pane" id="tab_2">
	<div class="box-body">
		<div class="form-group col-md-12">
			<label for="">Tarif unique pour Paris et ses régions</label>
			<input type="number" class="form-control" name="tarifnormal" id="tarifnormal" required>
		</div>
	</div><!-- /.box-body -->
	<div class="box-body">
		<div class="form-group col-md-6">
			<label for="">Autre tarif personnalisé par département</label>
			<select class="form-control select2" style="width: 100%;" name="departement[]">
				<option value="0" selected>Choisissez un élément</option>
				@foreach($depts as $dep)
				<option value="{{$dep->departement_id}}" id="{{$dep->departement_id}}">
					 {{$dep->departement_code}} - {{$dep->departement_nom}}
				</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-md-6">
			<label for="">Tarifs</label>
			<input type="number" class="form-control" id="" placeholder="" name="depttarif[]">
		</div>
		<div id="tarif-deplacement">
		</div>
		<span href='#' style='float:right;' class="btn btn-warning btn-xs btn-animate-demo" onclick='add_line_deplacement()' >Ajouter une ligne</span>
	</div>

</div><!-- /.tab-pane -->
<div class="tab-pane" id="tab_3">
	<div class="box-body">
		<div class="form-group col-md-3">
			<label for="">Type d'analyse</label>
			<select class="form-control select2" style="width: 100%;" name="typeanalyse[]">
				<option value="0" selected>Choisissez un élément</option>
				@foreach($type_analyses as $type_analyse)
				<option value="{{$type_analyse->id}}">
					{{$type_analyse->libelle}}
				</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-md-3">
			<label for="">Tarif</label>
			<input type="number" class="form-control" id="" name="tarifanalyse[]">
		</div>
		<div class="form-group col-md-3">
			<label for="">Nombre</label>
			<input type="number" class="form-control" value="1" readonly id="" name="nombreanalyse[]">
		</div>
		<div class="form-group col-md-3">
			<label for="">Réduction</label>
			<input type="number" readonly class="form-control" id="" name="reductionanalyse[]">
		</div>
		<div id="tarif-analyse">
		</div>
		<span href='#' style='float:right;' class="btn btn-warning btn-xs btn-animate-demo" onclick='add_line_analyse()' >Ajouter une ligne</span>
	</div><!-- /.box-body -->

</div><!-- /.tab-pane -->
