<div class="tab-pane active" id="tab_1">
			<!-- general form elements -->
			<div class="box-body">
				<div class="form-group{{ $errors->has('client') ? ' has-error' : '' }} col-md-3">
					<label for="client">Client</label>
					<select id="client" name="client" class="form-control select2" style="width: 100%;">
						@foreach($clients as $client)
						<option value="{{$client->id}}">
							{{$client->nom}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group col-md-3 {{ $errors->has('typecontract') ? ' has-error' : '' }}">
					<label for="typecontract">Type de contrat</label>
					<select class="form-control" style="width: 100%;" name="typecontract" id="typecontract">
						<option value="Ponctuel" >Ponctuel</option>
						<option value="Annuelle" >Annuelle</option>
					</select>
					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
				</div>
				<div class="form-group col-md-3 {{ $errors->has('typecontract') ? ' has-error' : '' }}">
					<label for="trame">Type de trame</label>
					<select class="form-control" style="width: 100%;" name="trame" id="trame">
						<option value="1" >Prélèvement et analyse - Amiante</option>
						<option value="4" >Plomb</option>
						<option value="2" >Analyse - Amiante</option>
					</select>
					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
				</div>
				<!--div class="form-group col-md-6{{ $errors->has(' dateSend') ? ' has-error' : '' }}">
					<label for="dateSend">Date d'envoie</label>
					<input type="date" class="form-control has-feedback"  id="dateSend" name="dateSend" value="{{$infoContrat[0]->date_add}}">
				</div-->
				<div class="form-group col-md-3{{ $errors->has(' dateValid') ? ' has-error' : '' }}">
					<label for="dateValid">Date d'ajout</label>
					<input type="date" class="form-control" id="dateValid" name="dateValid" value="{{$infoContrat[0]->date_confirm}}">
				</div>
				<div class="form-group col-md-6{{ $errors->has('respseller') ? ' has-error' : '' }}">
					<label for="respseller">Responsable commercial</label>
					<select class="form-control select2" id="respseller" name="respseller" style="width: 100%;" required>
						@foreach($sellers as $seller)
						<option value="{{$seller->id}}" id="{{$seller->id}}" >
							{{$seller->nom}} {{$seller->prenom}}
						</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-md-6{{ $errors->has('seller') ? ' has-error' : '' }}">
					<label for="seller">Commercial</label>
					<select class="form-control select2" name="seller" id="seller" style="width: 100%;" required>
						@foreach($sellers as $seller)
						<option value="{{$seller->id}}" id="{{$seller->id}}">
							{{$seller->nom}} {{$seller->prenom}}
						</option>
						@endforeach
					</select>
				</div>


				<div class="row">

				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="box box-primary">
							<div class="box-header with-border">
								<i class="glyphicon glyphicon-envelope"></i>
								<h3 class="box-title">Adresses</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group {{ $errors->has('adrSend') ? ' has-error' : '' }}">
											<label for="adrSend">Adresse d'expédition rapport</label>
											<input type="text" class="form-control" value="{{$infoContrat[0]->adr_send}}" id="adrSend" name="adrSend" >
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group {{ $errors->has(' adrBil') ? ' has-error' : '' }}">
											<label for="adrBil">Adresse facturation  </label>
											<input type="text" class="form-control" value="{{$infoContrat[0]->adr_bil}}" id="adrBil" name="adrBilling" >
										</div>
									</div>
								</div>


							</div>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
					<div class="col-md-6">
						<div class="box box-primary">
							<div class="box-header with-border">
								<i class="fa fa-at"></i>
								<h3 class="box-title">E-mail</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group col-md-12{{ $errors->has('mailBil') ? ' has-error' : '' }}">
											<label>E-Mail de facturation </label>
											<div class="input-group input-group-sm">
												<input type="email" class="form-control" name="mailBil[]" value="{{json_decode($infoContrat[0]->emails_bil)[0]}}">
												<span class="input-group-btn">
													<button class="btn btn-info btn-flat" type="button" onclick='add_mail_facturation()' >+</button>
												</span>
											</div><!-- /input-group -->
										</div>
										<div id="mail-facturation">
										@if(count(json_decode($infoContrat[0]->emails_bil))>1)
										@for($i=1 ; $i < count(json_decode($infoContrat[0]->emails_bil)) ; $i++)
										<div class="form-group col-md-12" id="mailb{{$i}}">
											<div class="input-group input-group-sm">
												<input type="email" class="form-control" name="mailBil[]" value="{{json_decode($infoContrat[0]->emails_bil)[$i]}}">
												<span class="input-group-btn">
													<button class="btn btn-danger btn-flat" type="button" onclick='document.getElementById("mailb{{$i}}").remove();' >-</button>
												</span>
											</div>
										</div>
										@endfor
										@endif
										</div>

									</div>

									<div class="col-md-6">
										<div class="form-group col-md-12{{ $errors->has('mailSend') ? ' has-error' : '' }}">
											<label>E-Mail d'expédition rapport </label>
											<div class="input-group input-group-sm">
												<input type="email" class="form-control" name="mailSend[]" value="{{json_decode($infoContrat[0]->emails_send)[0]}}">
												<span class="input-group-btn">
													<button class="btn btn-info btn-flat" type="button" onclick='add_mail_rapport()' >+</button>
												</span>
											</div><!-- /input-group -->
										</div>
										<div id="mail-rapport">
											@if(count(json_decode($infoContrat[0]->emails_send))>1)
												@for($i=1 ; $i < count(json_decode($infoContrat[0]->emails_send)) ; $i++)
												<div class="form-group col-md-12" id="mails{{$i}}">
														<div class="input-group input-group-sm">
																<input type="text" class="form-control" name="mailSend[]" value="{{json_decode($infoContrat[0]->emails_send)[$i]}}">
																<span class="input-group-btn">
																		<button class="btn btn-danger btn-flat" type="button" onclick='document.getElementById("mails{{$i}}").remove()'>-</button>
																</span>
														</div>
												</div>
												@endfor
											@endif
										</div>

									</div>


								</div>


							</div>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div>


				<div class="form-group col-md-6{{ $errors->has('observation') ? ' has-error' : '' }}">
					<label for="observation">Observation  </label>
					<textarea class="form-control" id="observation" name="observation" value="">{{$infoContrat[0]->observation}}</textarea>
				</div>
				<div class="form-group col-md-6{{ $errors->has('payCondition') ? ' has-error' : '' }}">
					<label for="payCondition">Conditions de paiement  </label>
					<textarea class="form-control" id="payCondition" name="payCondition" value="">{{$infoContrat[0]->payment_condition}}</textarea>
				</div>
				<div class="form-group col-md-12">
                        @include('contents.contract.modifyforms.attachment')
                </div><!-- /.box-body -->

			</div><!-- /.box-body -->
		</div><!-- /.tab-pane -->
