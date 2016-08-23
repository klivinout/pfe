<div class="tab-pane" id="tab_3">
	<div class="box-body">
		<div class="form-group col-md-12">
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="form-group col-md-12">
							<label for="">Autre tarif personnalisé par Analyse</label>
							<select class="form-control select2" style="width: 100%;">
								<option value="0" selected="selected">Choisissez un élément</option>
								<?php for($i=1;$i<=100;$i++){ ?>
								<option><?php echo $i; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="form-group col-md-12">
							<label for="">Autre tarif personnalisé par département</label>
							<select class="form-control " style="width: 100%;">
								<option value="0" selected="selected">Choisissez un élément</option>
								<?php for($i=1;$i<=100;$i++){ ?>
								<option><?php echo $i; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- /.box-body -->
	<div class="box-body">

		<div class="form-group col-md-6">
			<label for="">Tarifs</label>
			<input type="text" class="form-control" id="" name="" >
		</div>
		<div id="tarif-deplacement">
		</div>
		<span href='#' style='float:right;' class="btn btn-warning btn-xs btn-animate-demo" onclick='add_line_deplacement()' >Ajouter une ligne</span>
	</div>

</div><!-- /.tab-pane -->
