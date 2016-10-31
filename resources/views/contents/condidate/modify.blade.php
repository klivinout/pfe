@include('template.header')
@include('template.menu')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    

    <!-- Main content -->
    <section class="content">

    <!-- quick email widget -->
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Nouveau condidat</h3>
              <!-- tools box -->
                <div class="pull-right box-tools">
                    <a href="{{route('listcondidate')}}" class="btn btn-info btn-sm btn-flat">
                        liste des condidats
                    </a>
                </div>
                <!-- /. tools -->
            </div>
            <form action="#" method="post">
            @if(count($errors)>0)
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
            @endif
                <div class="box-body">
                    <div class="col-sm-4 form-group{{ $errors->has('cin') ? ' has-error' : '' }}">
                        <label for="cin">Code de la CIN : </label>
                        <input type="text" pattern="^[a-zA-Z]{2}(?:\s*\d\s*){6}$" class="form-control" id="cin" name="cin" value="{{ Request::old('cin') ? old('cin') : $condidat->CIN }}" required>
                    </div>
                    <div class="col-sm-4 form-group{{ $errors->has('') ? ' has-error' : '' }}">
                        <label for="prenom">Prénom : </label>
                        <input type="text" class="form-control" id="prenom" name="prenom" value="{{ Request::old('prenom') ? old('prenom') : $condidat->prenom }}" required>
                    </div>
                    <div class="col-sm-4 form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                        <label for="nom">Nom : </label>
                        <input type="text" class="form-control" id="nom" name="nom" value="{{ Request::old('nom') ? old('nom') : $condidat->nom }}" required>
                    </div>
                    <div class="col-sm-4 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Email : </label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ Request::old('email') ? old('email') : $condidat->email }}" required>
                    </div>
                    <div class="col-sm-4 form-group{{ $errors->has('etablissement') ? ' has-error' : '' }}">
                        <label for="etablissement">Etablissement : <a href="route('')">Ajouter ?</a></label>
                        <select class="form-control" id="etablissement" name="etablissement">
                            @foreach($etablissements as $etablissement)
                            <option value="{{$etablissement->id}}">{{$etablissement->nom}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4 form-group{{ $errors->has('etablissement') ? ' has-error' : '' }}">
                        <label for="etablissement">Etablissement : <a href="route('')">Ajouter ?</a></label>
                        <select class="form-control" id="etablissement" name="etablissement">
                            @foreach($etablissements as $etablissement)
                            <option value="{{$etablissement->id}}">{{$etablissement->nom}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4 form-group{{ $errors->has('diplome') ? ' has-error' : '' }}">
                        <label for="diplome">diplome : </label>
                        <select class="form-control" id="diplome" name="diplome">
                            <option disabled selected></option>
                            @foreach($diplomes as $diplome)
                            <option value="{{$diplome->id}}">{{$diplome->nom}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4 form-group{{ $errors->has('stg_diplome') ? ' has-error' : '' }}">
                        <label for="stg_diplome">Diplomé ou pas : </label>
                        <select class="form-control" id="stg_diplome" name="stg_diplome">
                            <option disabled selected></option>
                            <option value="-1">Non</option>
                            <option value="0">en cours</option>
                            <option value="1">Oui</option>
                        </select>
                    </div>
                    <div class="col-sm-4 form-group{{ $errors->has('ville') ? ' has-error' : '' }}">
                        <label for="ville">Ville de résidence : </label>
                        <select class="form-control" id="ville" name="ville">
                            <option disabled selected></option>
                            @foreach($villes as $ville)
                            <option value="{{$ville->id}}">{{$ville->nom}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4 form-group{{ $errors->has('division') ? ' has-error' : '' }}">
                        <label for="division">Division : </label>
                        <select class="form-control" id="division" name="division">
                            <option disabled selected></option>
                            @foreach($departements as $dept)
                            <option value="{{$dept->id}}">{{$dept->nom}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4 form-group{{ $errors->has('datefrom') ? ' has-error' : '' }}">
                        <label for="datefrom">Date début :</label>
                        <input type="date" class="form-control" id="datefrom" name="datefrom" value="{{ Request::old('datefrom') ? old('datefrom') : $condidat->datefrom}}" required>
                    </div>
                    <div class="col-sm-4 form-group{{ $errors->has('dateto') ? ' has-error' : '' }}">
                        <label for="dateend">Date fin :</label>
                        <input type="date" class="form-control" id="dateend" name="dateend" value="{{ Request::old('dateend') ? old('dateend') : $condidat->dateend }}" required>
                    </div>
                    <div class="col-md-4 form-group{{ $errors->has('cv') ? ' has-error' : '' }}">
                        
                        <i class="fa fa-paperclip"></i> Curriculum vitae
                        <input class="btn btn-default btn-file" type="file" name="cv" id="cv">
                        <p class="help-block">Max. 5MB</p>
                        @if($cv != null)
                            <a href="{{route('downloadcurriculumvitae',['id' => $condidat->id])}}" target="_blank">
                                <i class="fa fa-paperclip"></i> Curriculum vitae
                            </a>
                        @endif
                        
                    </div>

                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                </div>
                @if(($condidat->departement == Auth::User()->departement && Auth::User()->type==2) || Auth::User()->type==10)
                <div class="box-footer clearfix">
                    <a href="{{route('newstagiaire' , ['id' => $condidat->id])}}" class="pull-right btn btn-default btn-flat">
                        Confirmer en Stragiaire
                    </a>
                </div>
                @elseif(Auth::User()->type==1)
                <div class="box-footer clearfix">
                    <button type="submit" class="pull-right btn btn-default btn-flat" id="sendEmail">Modifier
                        <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>
                @endif
                @if(Auth::User()->type==10)
                <div class="box-footer clearfix">
                    <button type="submit" class="pull-right btn btn-default btn-flat" id="sendEmail">Modifier
                        <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>
                @endif
            </form>
        </div>

    </section>
</div>
      

<script>
    document.getElementById('division').value = {{$condidat->departement}};
    document.getElementById('stg_diplome').value = {{$condidat->stg_diplome}};
    document.getElementById('ville').value = {{$condidat->ville}};
    document.getElementById('diplome').value = {{$condidat->diplome}};
</script>
@include('template.footer')
  </body>
</html>