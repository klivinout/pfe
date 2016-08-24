@include('template.header')
@include('template.menu')
<div class="content-wrapper">

    <section class="content-header">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h1 class="box-title">Ajouter Contrat</h1>
                <div class="box-tools pull-right">
                    <a href="{{route('listcontracts',['id'=>'tout'])}}" class="btn bg-maroon btn-flat btn-sm">Liste des contrats</a>
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
                <form role="form" id="fileupload" action="{{ route('newcontract') }}" method="post" enctype="multipart/form-data">
                    <div class="tab-content">
                        @include('contents.contract.addforms.contrat')
                        @include('contents.contract.addforms.deplacement')
                        @include('contents.contract.addforms.autre')
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Sauvegarder</button>
                        </div>
                </form>

                </div><!-- nav-tabs-custom -->



            </div>

        </section>
    </div>

    <script>

        //get old values of the selects
        var old={};
        old.client = {{ Request::old('client') ? old('client') : '0' }};
        old.typecontract = '{{ Request::old('typecontract') ? old('typecontract') : '0' }}';
        old.seller = {{ Request::old('seller') ? old('seller') : '0' }};
        old.respseller = {{ Request::old('respseller') ? old('respseller') : '0' }};

        document.getElementById('client').value=old.client;
        document.getElementById('seller').value=old.seller;
        document.getElementById('respseller').value=old.respseller;
        document.getElementById('typecontract').value=old.typecontract;



        //Ajouter ligne d'analyse
        var ligneAnalyse=0;
        function add_line_analyse(){
            ligneAnalyse++;
            $("#tarif-analyse").append( '\
            <div class="form-group col-md-12" id="ligneAnalyse'+ligneAnalyse+'"> \
                <div class="form-group col-md-3"> \
                <select name="typeanalyse[]" class="form-control select2" style="width: 100%;" > \
                <option value="0" selected >Choisissez un élément</option> \
          				@foreach($type_analyses as $type_analyse)\
          				<option value="{{$type_analyse->id}}">\
          					{{$type_analyse->libelle}}\
          				</option>\
          				@endforeach\
                </select> \
                </div> \
                <div class="form-group col-md-3"> \
                <input type="text" class="form-control" id="" name="tarifanalyse[]"> \
                </div> \
                <div class="form-group col-md-3"> \
                <input type="text" class="form-control" id="" value="1" readonly name="nombreanalyse[]"> \
                </div> \
                <div class="input-group col-md-3"> \
                <input type="text" class="form-control" readonly id="" name="reductionanalyse[]"> \
                <span class="input-group-btn">\
                <button class="btn btn-danger btn-flat" type="button"\ onclick=\'document.getElementById("ligneAnalyse'+ligneAnalyse+'").remove();\' >-</button>\
  							</span>\
                </div></div>');
}

        //ajouter Deplacement
        var lignedepalcement = 0;
        function add_line_deplacement(){
            lignedepalcement++;
            $("#tarif-deplacement").append( '\
                <div class="col-md-12" id="lignedepalcement'+lignedepalcement+'">\
                <div class="form-group col-md-6">\
                <select class="form-control select2" style="width: 100%;" name="departement[]" required>\
                <option value="0" selected>Choisissez un élément</option>\
                @foreach($depts as $dep)
        				<option value="{{$dep->departement_id}}" id="{{$dep->departement_id}}">\
                  	{{$dep->departement_code}} - {{$dep->departement_nom}}\
        				</option>\
        				@endforeach
                </select>\
                </div>\
                <div class="form-group col-md-6">\
                <div class="input-group input-group-sm">\
                <input type="number" class="form-control" name="depttarif[]">\
                <span class="input-group-btn">\
                <button class="btn btn-danger btn-flat" type="button" onclick=\'document.getElementById("lignedepalcement'+lignedepalcement+'").remove()\' >-</button>\
                </span>\
                </div>\
                </div></div>');
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
                <input type="text" class="form-control" name="mailSend['+mailSend+']">\
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
		</script>
    </body>
</html>
