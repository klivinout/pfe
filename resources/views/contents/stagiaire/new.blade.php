@include('template.header')
@include('template.menu')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">

    <!-- quick email widget -->
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Nouveau Stagiaire</h3>
              <!-- tools box -->
                <div class="pull-right box-tools">
                    <a href="{{route('liststagiaires')}}" class="btn btn-info btn-sm btn-flat">
                        liste des Stagiaires
                    </a>
                </div>
                <!-- /. tools -->
            </div>
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="col-sm-6 form-group{{ $errors->has('prenom') ? ' has-error' : '' }}">
                        <label for="prenom">Prénom : </label>
                        <input type="text" class="form-control" id="prenom" name="prenom" value="{{ Request::old('prenom') ? old('prenom') : $condidat->prenom }}" required>
                        @if($errors->has('prenom'))
                            <span class="help-block">{{ $errors->first('prenom') }}</span>
                        @endif
                    </div>
                    <div class="col-sm-6 form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                        <label for="nom">Nom : </label>
                        <input type="text" class="form-control" id="nom" name="nom" value="{{ Request::old('nom') ? old('nom') : $condidat->nom }}" required>
                        @if($errors->has('nom'))
                            <span class="help-block">{{ $errors->first('nom') }}</span>
                        @endif
                    </div>
                    <div class="col-sm-6 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Email : </label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ Request::old('email') ? old('email') : $condidat->email }}" required>
                        @if($errors->has('email'))
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="col-sm-6 form-group{{ $errors->has('etablissement') ? ' has-error' : '' }}">
                        <label for="etablissement">Etablissement : </label>
                        <input type="text" class="form-control" id="etablissement" name="etablissement" value="{{ Request::old('etablissement') ? old('etablissement') : $condidat->etablissement_nom }}" readonly="true">
                        @if($errors->has('etablissement'))
                            <span class="help-block">{{ $errors->first('etablissement') }}</span>
                        @endif
                    </div>
                    <div class="col-sm-6 form-group{{ $errors->has('ville') ? ' has-error' : '' }}">
                        <label for="ville">Ville : </label>
                        <input type="text" class="form-control" id="ville" name="ville" value="{{ Request::old('ville') ? old('ville') : $condidat->ville_nom }}" readonly="true">
                        @if($errors->has('ville'))
                            <span class="help-block">{{ $errors->first('ville') }}</span>
                        @endif
                    </div>
                    <div class="col-sm-6 form-group{{ $errors->has('datefrom') ? ' has-error' : '' }}">
                        <label for="datefrom">Date début :</label>
                        <input type="date" class="form-control" id="datefrom" name="datefrom" value="{{ Request::old('datefrom') ? old('datefrom') : $condidat->datefrom }}" required>
                        @if($errors->has('datefrom'))
                            <span class="help-block">{{ $errors->first('datefrom') }}</span>
                        @endif
                    </div>
                    <div class="col-sm-6 form-group{{ $errors->has('dateend') ? ' has-error' : '' }}">
                        <label for="dateend">Date fin :</label>
                        <input type="date" class="form-control" id="dateend" name="dateend" value="{{ Request::old('dateend') ? old('dateend') : $condidat->dateend }}" required>
                        @if($errors->has('dateend'))
                            <span class="help-block">{{ $errors->first('dateend') }}</span>
                        @endif
                    </div>
                    <div class="col-sm-6 form-group{{ $errors->has('division') ? ' has-error' : '' }}">
                        <label for="division">Division : </label>
                        <select class="form-control" id="division" name="division" onchange="getData()">
                            <option selected></option>
                            @foreach($departements as $dept)
                            <option value="{{$dept->id}}">{{$dept->nom}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('division'))
                            <span class="help-block">{{ $errors->first('division') }}</span>
                        @endif
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="responsable">Responsable : </label>
                        <select class="form-control" id="responsable" name="responsable">
                            <option disabled selected></option>
                        </select>
                        @if($errors->has('responsable'))
                            <span class="help-block">{{ $errors->first('responsable') }}</span>
                        @endif
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="sujet">Sujet de stage : </label>
                        <select class="form-control" id="sujet" name="sujet">
                            <option disabled selected></option>
                        </select>
                        @if($errors->has('sujet'))
                            <span class="help-block">{{ $errors->first('sujet') }}</span>
                        @endif
                    </div>
                    <div class="col-sm-6 form-group{{ $errors->has('observation') ? ' has-error' : '' }}">
                        <label for="observation">Observation : </label>
                        <input type="text" class="form-control" id="observation" name="observation" value="{{ Request::old('observation') ? old('observation') : $condidat->observation }}">
                        @if($errors->has('observation'))
                            <span class="help-block">{{ $errors->first('observation') }}</span>
                        @endif
                    </div>

                    <div class="col-md-6 col-md-offset-1 form-group{{ $errors->has('assurence') ? ' has-error' : '' }}">
                        <!--div class="btn btn-default btn-file"-->
                          <i class="fa fa-paperclip"></i> Assurance
                          <input class="btn btn-default btn-file" type="file" name="assurence" id="assurence">
                        <!--/div-->
                        <p class="help-block">Max. 5MB</p>
                        @if($errors->has('assurence'))
                            <span class="help-block">{{ $errors->first('assurence') }}</span>
                        @endif
                        @if($document != '0')
                            <a href="{{route('downloadcondidatattachement' , ['id' => $condidat->id , 'type' => 'assurence'])}}" class="btn btn-info" target="_blanc">
                                {{$document->assurence->document}}
                            </a>
                        @endif
                    </div>
                    <div class="col-md-6 col-md-offset-1 form-group{{ $errors->has('convention') ? ' has-error' : '' }}">
                        <!--div class="btn btn-default btn-file"-->
                          <i class="fa fa-paperclip"></i> Convention de stage
                          <input class="btn btn-default btn-file" type="file" name="convention" id="convention">
                        <!--/div-->
                        <p class="help-block">Max. 5MB</p>
                        @if($errors->has('convention'))
                            <span class="help-block">{{ $errors->first('convention') }}</span>
                        @endif
                        @if($document != '0')
                            <a href="{{route('downloadcondidatattachement' , ['id' => $condidat->id , 'type' => 'convention'])}}" class="btn btn-info" target="_blanc">
                                {{$document->convention->document}}
                            </a>
                        @endif
                    </div>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                </div>
                <div class="box-footer clearfix">
                    <button type="submit" class="pull-right btn btn-default btn-flat">Confirmer
                        <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>
            </form>
        </div>

    </section>
</div>
      


@include('template.footer')

<script>
    function getData(){

        $('#sujet').empty();
        $('#responsable').empty();

        var dept = $('#division').val();
        var url = "{{route('ajaxdeptrespanssujets' , ['id' => ':id'])}}";
        url = url.replace(':id',dept);

        $.get(url , function (rep) {
            if(rep.code == 200) {
                $('#responsable').append('<option value="0"></option>');
                $.each(rep.responsables, function(i , responsable) {
                    $('#responsable').append('\
                        <option value="' +responsable.id+ '">\
                            ' +responsable.nom+ ' ' +responsable.prenom+ '\
                        </option>\
                    ');
                });
                $('#sujet').append('<option value="0"></option>');
                $.each(rep.sujets, function(i , sujet) {
                    $('#sujet').append('\
                        <option value="' +sujet.id+ '">\
                            ' +sujet.objet+ '\
                        </option>\
                    ');
                });
            } else if (rep.code == 400) {
                swal('Erreur' , rep.msgError , 'error');
            } else {
                swal('Erreur' , 'une erreur est survenue !!' , 'error');
            }
        });
    }
</script>


<script>
    document.getElementById('division').value = {{$condidat->departement}};
    document.onload = getData();
</script>
  </body>
</html>