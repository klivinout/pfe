@include('template.header')
@include('template.menu')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
		<div class="box box-primary">
            <div class="box-header with-border">
                <h1 class="box-title">Modifier contrat</h1>
                <div class="box-tools pull-right">
                    <a href="{{route('listcontracts',['id'=>'tout'])}}" class="btn bg-maroon btn-flat btn-sm">Liste des contrats</a>
                    <a href="{{route('newcontract')}}" class="btn bg-maroon btn-flat btn-sm">Nouveau contrat</a>
                </div>

            </div><!-- /.box-header -->
            <div class="nav-tabs-custo">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Information de base</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Tarifs Déplacement</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Tarifs Analyses</a></li>
                    <li><a href="#tab_4" data-toggle="tab">Autre tarifs</a></li>
                </ul>

                <!-- Form start -->

                <form role="form" id="fileupload" action="{{route('modifycontract' , ['id' => $id])}}" method="post" enctype="multipart/form-data">
                    <div class="tab-content">
                        @include('contents.contract.modifyforms.contrat')
                        @include('contents.contract.modifyforms.deplacement')
                        @include('contents.contract.modifyforms.autre')

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Sauvegarder</button>


                        </div>

                    </form>

                </div><!-- nav-tabs-custom -->



            </div>

        </section>
    </div>

    <script>

    document.getElementById('client').value='{{$infoContrat[0]->client}}';
    document.getElementById('seller').value='{{$infoContrat[0]->commercial}}';
    document.getElementById('respseller').value='{{$infoContrat[0]->rep_commercial}}';
    document.getElementById('typecontract').value='{{$infoContrat[0]->type}}';
    document.getElementById('trame').value='{{$infoContrat[0]->trame}}';

    @for($i=0 ; $i<count($infoAnalyse) ; $i++)
    document.getElementById('typeanalyse{{$i}}').value='{{$infoAnalyse[$i]->type}}';
    @endfor



        //Ajouter ligne d'analyse
        var ligneAnalyse={{count($infoAnalyse)}};
        function add_line_analyse(){
            ligneAnalyse++;
            $("#tarif-analyse").append( '\
                <div class="form-group col-md-12" id="ligneAnalyse'+ligneAnalyse+'"> \
                <div class="form-group col-md-3"> \
                <select name="typeanalyse[]" class="form-control " style="width: 100%;" > \
                <option value="0" selected >Choisissez un type d\'analyse</option> \
        				@foreach($type_analyses as $type_analyse)\
        				<option value="{{$type_analyse->id}}">\
        					{{$type_analyse->libelle}}\
        				</option>\
        				@endforeach\
                </select> \
                </div> \
                <div class="form-group col-md-3"> \
                <input type="text" class="form-control" id="" name="tarifanalyse[]" placeholder="Tarif d\'analyse :"> \
                </div> \
                <div class="form-group col-md-3"> \
                <input type="text" class="form-control" id="" value="1" readonly name="nombreanalyse[]" placeholder="Nombre d\'analyses :"> \
                </div> \
                <div class="input-group col-md-3"> \
                <input type="text" class="form-control" readonly id="" name="reductionanalyse[]" placeholder="Réduction :"> \
                <span class="input-group-btn">\
                <button class="btn btn-danger btn-flat" type="button"\ onclick=\'document.getElementById("ligneAnalyse'+ligneAnalyse+'").remove();\' >-</button>\
  							</span>\
                </div></div>');
}

        //ajouter Deplacement
        var lignedepalcement = {{count($infoDeplacement)}};
        function add_line_deplacement(){
            lignedepalcement++;
            $("#tarif-deplacement").append( '\
                <div id="tarifdeplacement'+lignedepalcement+'" class="col-md-12">\
                <div class="form-group col-md-6">\
                <select class="form-control " name="departement[]">\
                <option value="0" selected>Choisissez un élément</option>\
                @foreach($depts as $dep)
        				<option value="{{$dep->departement_id}}" id="{{$dep->departement_id}}">\
                    {{$dep->departement_code}} - {{$dep->departement_nom}}\
        				</option>\
        				@endforeach
                </select>\
                </div>\
                <div class="form-group col-md-6">\
                <div class="form-group col-md-12">\
                  <div class="form-inline">\
                    <input type="text" class="form-control" name="depttarif[]">\
                    <button class="btn btn-danger btn-flat" type="button"\ onclick=\'document.getElementById("tarifdeplacement'+lignedepalcement+'").remove();\' >-</button>\
                  </div>\
                  </div>\
                </div>\
                </div>\
                ');
}
        //////////////////////////////////////////////

        // Email de facturaction drop_mail_facturation('+mailFacture+')
        var mailFacture = 0;
        function add_mail_facturation(){
            mailFacture++;
            $("#mail-facturation").append( '\
                <div class="form-group col-md-12" id="mailb'+mailFacture+'"">\
                <div class="input-group input-group-sm">\
                <input type="email" class="form-control" name="mailBil[]">\
                <span class="input-group-btn">\
                <button class="btn btn-danger btn-flat" type="button" onclick=\'document.getElementById("mailb'+mailFacture+'").remove();\' >-</button>\
                </span>\
                </div>  \
                </div>');
        }

        //Ajouter Email d'envoie de rapport
        var mailSend = 0;
        function add_mail_rapport(){
            mailSend++;
            $("#mail-rapport").append( '\
                <div class="form-group col-md-12" id="mails'+mailSend+'">\
                <div class="input-group input-group-sm">\
                <input type="text" class="form-control" name="mailSend[]">\
                <span class="input-group-btn">\
                <button class="btn btn-danger btn-flat" type="button" onclick=\'document.getElementById("mails'+mailSend+'").remove();\' >-</button>\
                </span>\
                </div>  \
                </div>');
        }
        </script>
      @include('template.footer')

      @if (Session::has('info'))
      <script>
        swal("Succès!", "{{ Session::get('info') }} Opération terminée avec succès", "success");
      </script>
      @endif
      @if (Session::has('danger'))
      <script>
      swal("Insuccès!", '{{ Session::get('danger') }}', "warning");
      </script>
      @endif
		<script>
			// Initialize the jQuery File Upload widget:
			$('#fileupload').fileupload({
				// Uncomment the following to send cross-domain cookies:
				//xhrFields: {withCredentials: true},
        url: '{{asset('/server/contracts')}}/',
				maxNumberOfFiles: 1,
				singleFileUploads:true,
        maxFileSize: 5000000,
			});
			var files = [
				{
					"name":"{{$infoContrat[0]->attachement}}",
					"size":775702,
					"type":"image/jpeg",
					"url":"{{$infoContrat[0]->attachement}}",
					"deleteUrl":"{{asset('/server/contracts/index.php?file=')}}{{$infoContrat[0]->attachement}}'",
					"deleteType":"DELETE",
				},
			];

			if(files[0]["name"]){
				var $form = $('#fileupload');
				$form.fileupload('option', 'done').call($form, $.Event('done'), {result: {files: files}});
					$('#fileupload').addClass('fileupload-processing');
						$.ajax({
							// Uncomment the following to send cross-domain cookies:
							//xhrFields: {withCredentials: true},
							url: $('#fileupload').fileupload('option', 'url'),
							dataType: 'json',
							context: $('#fileupload')[1]
						}).always(function () {
							$(this).removeClass('fileupload-processing');
						}).done(function (result) {
							$(this).fileupload('option', 'done')
								.call(this, $.Event('done'), {result: result});
						});
			}
		</script>
    </body>
</html>
