@include('template.header')
@include('template.menu')
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Liste des contrats</h3>
            <div class="box-tools pull-right">
              <a href="{{route('newcontract')}}" class="btn bg-maroon btn-flat btn-sm">Nouveau contrat</a>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="listecontrats" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Numéro</th>
                  <th>Client</th>
                  <th>Date d'ajout</th>
                  <th>date d'envoi</th>
                  <th>date de confirmation</th>
                  <th>Statut</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $contract)
                <?php $numero = date_parse_from_format("Y-m-d", $contract->date_confirm); ?>
                <tr>
                  <td> {{$numero['year']}}-{{$numero['month']}}-{{$contract->id}} </td>
                  <td> {{$contract->nom}}  </td>
                  <td>
                    @if($contract->date_confirm == "NULL" || $contract->date_confirm == "")
                    Non Confirmer
                    @else
                    {{$contract->date_confirm}}
                    @endif
                  </td>
                  <td>
                    @if($contract->date_add == "NULL" || $contract->date_add == "")
                    -
                    @else
                    {{$contract->date_add}}
                    @endif
                  </td>
                  <td>
                    @if($contract->date_receive == "NULL" || $contract->date_receive == "")
                    -
                    @else
                    {{$contract->date_receive}}
                    @endif
                  </td>
                  <td>
                    @if($contract->date_add !="0000-00-00" && $contract->attachement=="") Envoyé
                    @elseif($contract->statut==-1) Désactivé
                    @elseif($contract->attachement!="") Signé
                    @else En cours
                    @endif
                  </td>
                  <td>
                    <div class="input-group input-group-sm">
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">Action <span class="fa fa-caret-down"></span></button>
                        <ul class="dropdown-menu">
                          <?php  if(strpos(Auth::User()->privilege, "[999]") !== false || strpos(Auth::User()->privilege, "[1]") !== false){ ?>
                            <li><a href="{{route('modifycontract',['id' => $contract->id])}}"> Consulter - Modifier</a></li>
                            @if($contract->statut == 1)
                            <li><a href="{{route('disablecontract',['id' => $contract->id])}}">Désactiver</a></li>
                            @elseif($contract->statut == 0)
                            <!--li><a href="{{route('modifycontract',['id' => $contract->id])}}">Confirmer</a></li-->
                            @elseif($contract->statut == 1)
                            <!--li><a href="{{route('finishcontract',['id' => $contract->id])}}">Conclure</a></li-->
                            @endif
                            <li><a href="{{$contract->chemin_contrat}}" target="_blank">Visualiser</a></li>
                            <li><a href="{{route('sendcontract',['id' => $contract->id])}}">Envoyer</a></li>
                            <?php  }else{
                              //return redirect()->route('error-accee');
                            } ?>
                          </ul>
                        </div><!-- /btn-group -->
                      </div><!-- /input-group -->
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Numéro</th>
                    <th>Client</th>
                    <th>Date d'ajout</th>
                    <th>date d'envoi</th>
                    <th>date de confirmation</th>
                    <th>Statut</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

  <script>
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
  <script>
  $("#listecontrats").DataTable();
  @if (Session::has('info'))
  swal('succés','{{ Session::get('info') }}','success');
  @endif
  @if (Session::has('error'))
  swal('Erreur','{{ Session::get('error') }}','danger');
  @endif
  </script>
</body>
</html>
