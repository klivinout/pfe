<div class="tab-pane" id="tab_2">
	<div class="box-body">
		<div class="form-group col-xs-5">
			<label for="">Tarif unique pour Paris et ses régions</label>
			<input type="text" value="{{$infoContrat[0]->tarifnormal}}" class="form-control" name="tarifnormal" id="tarifnormal">
		</div>
	</div><!-- /.box-body -->
	<div class="box-body" id="tarif-deplacement">
		<div id="">
			<div class="form-group col-md-6">
				<label for="">Autre tarif personnalisé par département</label>
			</div>
			<div class="form-group col-md-6">
				<label for="">Tarifs</label>
			</div>
		</div>
		@for($i=0 ; $i < count($infoDeplacement) ; $i++)
		<div id="tarifdeplacement{{$i}}">
			<div class="form-group col-md-6">
				<input type="hidden" name="id_deplacement[]" value="{{$infoDeplacement[$i]->id}}">
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
					<div class="form-group col-md-12">
						<div class="input-group">
							<input type="text" class="form-control" name="depttarif[]" value="{{$infoDeplacement[$i]->tarif}}">
							<span class="input-group-btn">
								<button class="btn btn-danger btn-flat" type="button" onclick='document.getElementById("tarifdeplacement{{$i}}").remove();' >-</button>
							</span>
						</div>
					</div>
			</div>
		</div>
		@endfor
	</div>
	<span href='#' style='float:right;' class="btn btn-warning btn-xs btn-animate-demo" onclick='add_line_deplacement()' >Ajouter une ligne</span>

</div><!-- /.tab-pane -->
<div class="tab-pane" id="tab_3">
	<div class="box-body" id="tarif-analyse">
		<div class="form-group col-md-3">
			<label for="">Type d'analyse</label>
		</div>
		<div class="form-group col-md-3">
			<label for="">Tarif</label>
		</div>
		<div class="form-group col-md-3">
			<label for="">Nombre</label>
		</div>
		<div class="form-group col-md-3">
			<label for="">Réduction</label>
		</div>
		@for($i=0 ; $i<count($infoAnalyse) ; $i++)
		<input type="hidden" value="$infoAnalyse->id" name="id_analyse[]">
		<div class="form-group col-md-12" id="ligneAnalyse{{$i}}">
		<div class="form-group col-md-3">
			<select class="form-control " style="width: 100%;" id="typeanalyse{{$i}}" name="typeanalyse[]">
				<option value="0" selected>Choisissez un élément</option>
				@foreach($type_analyses as $type_analyse)
				<option value="{{$type_analyse->id}}">
					{{$type_analyse->libelle}}
				</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-md-3">
			<input type="number" class="form-control" name="tarifanalyse[]" value="{{$infoAnalyse[$i]->tarif}}">
		</div>
		<div class="form-group col-md-3">
			<input type="number" class="form-control"  value="1" readonly name="nombreanalyse[]" value="{{$infoAnalyse[$i]->nombre}}">
		</div>
		<div class="input-group col-md-3">
			<input type="number" readonly class="form-control" name="reductionanalyse[]" value="{{$infoAnalyse[$i]->reduction}}">
			<span class="input-group-btn">
				<button class="btn btn-danger btn-flat" type="button" onclick='document.getElementById("ligneAnalyse{{$i}}").remove();' >-</button>
			</span>
		</div>
	</div>
		@endfor
	</div><!-- /.box-body -->
	<span href='#' style='float:right;' class="btn btn-warning btn-xs btn-animate-demo" onclick='add_line_analyse()' >Ajouter une ligne</span>

</div><!-- /.tab-pane -->
