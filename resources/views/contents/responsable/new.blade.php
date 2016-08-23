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
                <h3 class="box-title">Nouveau responsable de stage</h3>
              <!-- tools box -->
                <div class="pull-right box-tools">
                    <a href="" class="btn btn-info btn-sm btn-flat">
                        liste des responsables
                    </a>
                </div>
                <!-- /. tools -->
            </div>
            
                <div class="box-body">
                    <div class="col-sm-5">
                        <form action="#" method="post">
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

                </div>
            </form>
        </div>

    </section>
</div>
      


@include('template.footer')

  </body>
</html>