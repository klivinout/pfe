@include('template.header')
@include('template.menu')

<div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"><i class="fa fa-dashboard"></i>Home</a>
            </li>
            <li class="active">
                Dashboard
            </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <!-- quick email widget -->
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Parametres</h3>
              <!-- tools box -->
                <div class="pull-right box-tools">
                    <a href="" class="btn btn-info btn-sm btn-flat">
                        listes
                    </a>
                </div>
                <!-- /. tools -->
            </div>
            
                <div class="box-body">
                    <div class="well col-sm-6"><!-- responsable -->
                        <h4>Ajouter un Responsable : </h4>
                        <form action="{{route('newresponsable')}}" id="form_responsable" method="post">
                            <div class="form-group{{ $errors->has('prenom') ? ' has-error' : '' }}">
                                <label for="prenom">Prénom : </label>
                                <input type="text" class="form-control" id="prenom" name="prenom" value="{{ Request::old('prenom') ? old('prenom') : '' }}" required>
                            </div>
                            <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                                <label for="nom">Nom : </label>
                                <input type="text" class="form-control" id="nom" name="nom" value="{{ Request::old('nom') ? old('nom') : '' }}" required>
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email">E-mail : </label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ Request::old('email') ? old('email') : '' }}" required>
                            </div>
                            <div class="form-group{{ $errors->has('departement') ? ' has-error' : '' }}">
                                <label for="departement">Departement : </label>
                                <select class="form-control" id="departement" name="departement" required>
                                    <option selected disabled></option>
                                    @foreach($departements as $d)
                                    <option value="{{$d->id}}">{{$d->nom}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="box-footer clearfix">
                                <button type="submit" class="pull-right btn btn-default btn-flat" id="sendEmail">Ajouter
                                    <i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="well col-sm-6"><!-- etablissmement -->
                        <h4>Ajouter une Etablissement : </h4>
                        <form action="{{route('newschool')}}" id="form_etablissement" method="post">
                            <div class="form-group{{ $errors->has('school_nom') ? ' has-error' : '' }}">
                                <label for="school_nom">Nom : </label>
                                <input type="text" class="form-control" id="school_nom" name="school_nom" value="{{ Request::old('school_nom') ? old('school_nom') : '' }}" required>
                            </div>
                            <div class="form-group{{ $errors->has('school_adress') ? ' has-error' : '' }}">
                                <label for="school_adress">Adresse : </label>
                                <input type="text" class="form-control" id="school_adress" name="school_adress" value="{{ Request::old('school_adress') ? old('school_adress') : '' }}" required>
                            </div>
                            <div class="form-group{{ $errors->has('school_phone') ? ' has-error' : '' }}">
                                <label for="school_phone">Téléphone : </label>
                                <input type="text" class="form-control" id="school_phone" name="school_phone" value="{{ Request::old('school_phone') ? old('school_phone') : '' }}" required>
                            </div>
                            <div class="form-group{{ $errors->has('school_email') ? ' has-error' : '' }}">
                                <label for="school_email">Email : </label>
                                <input type="email" class="form-control" id="school_email" name="school_email" value="{{ Request::old('school_email') ? old('school_email') : '' }}" required>
                            </div>
                            <div class="box-footer clearfix">
                                <button type="submit" class="pull-right btn btn-default btn-flat" id="sendEmail">Ajouter
                                    <i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="well col-sm-6"><!-- departement -->
                        <h4>Ajouter une division : </h4>
                        <form action="{{route('newdepartement')}}" id="form_departement" method="post">
                            <div class="form-group{{ $errors->has('dep_nom') ? ' has-error' : '' }}">
                                <label for="dep_nom">Nom de la division : </label>
                                <input type="text" class="form-control" id="dep_nom" name="dep_nom" value="{{ Request::old('dep_nom') ? old('dep_nom') : '' }}" required>
                            </div>
                            
                            <div class="box-footer clearfix">
                                <button type="submit" class="pull-right btn btn-default btn-flat" id="sendEmail">Ajouter
                                    <i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="well col-sm-6"><!-- diplome -->
                        <h4>Ajouter un diplôme : </h4>
                        <form action="{{route('newdegree')}}" id="form_diplome" method="post">
                            <div class="form-group{{ $errors->has('diplome_nom') ? ' has-error' : '' }}">
                                <label for="diplome_nom">Nom du diplôme : </label>
                                <input type="text" class="form-control" id="diplome_nom" name="diplome_nom" value="{{ Request::old('diplome_nom') ? old('diplome_nom') : '' }}" required>
                            </div>
                            <div class="box-footer clearfix">
                                <button type="submit" class="pull-right btn btn-default btn-flat" id="sendEmail">Ajouter
                                    <i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="well col-sm-6"><!-- ville -->
                        <h4>Ajouter une Ville : </h4>
                        <form action="{{route('newcity')}}" id="form_ville" method="post">
                            <div class="form-group{{ $errors->has('city_nom') ? ' has-error' : '' }}">
                                <label for="city_nom">Nom du ville : </label>
                                <input type="text" class="form-control" id="city_nom" name="city_nom" value="{{ Request::old('city_nom') ? old('city_nom') : '' }}" required>
                            </div>
                            <div class="form-group{{ $errors->has('city_codepostal') ? ' has-error' : '' }}">
                                <label for="city_codepostal">Code postal : </label>
                                <input type="text" class="form-control" id="city_codepostal" name="city_codepostal" value="{{ Request::old('city_codepostal') ? old('city_codepostal') : '' }}" required>
                            </div>
                            <div class="box-footer clearfix">
                                <button type="submit" class="pull-right btn btn-default btn-flat" id="sendEmail">Ajouter
                                    <i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </form>
        </div>

    </section>
</div>
      


@include('template.footer')

  </body>
</html>