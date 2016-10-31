@include('template.header')
@include('template.menu')

<div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
   

    <!-- Main content -->
    <section class="content">

    <!-- quick email widget -->
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Profile</h3>
            </div>
            
                <div class="box-body">
                    <div class="col-md-12">
                        <form action="#" method="post" enctype="multipart/form-data">
                            <div class="form-group col-md-6{{ $errors->has('prenom') ? ' has-error' : '' }}">
                                <label for="prenom">Prénom : </label>
                                <input type="text" class="form-control" id="prenom" name="prenom" value="{{ Request::old('prenom') ? old('prenom') : Auth::User()->prenom }}" required>
                            </div>
                            <div class="form-group col-md-6{{ $errors->has('nom') ? ' has-error' : '' }}">
                                <label for="nom">Nom : </label>
                                <input type="text" class="form-control" id="nom" name="nom" value="{{ Request::old('nom') ? old('nom') : Auth::User()->nom }}" required>
                            </div>
                            <div class="form-group col-md-6{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email">E-mail : </label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ Request::old('email') ? old('email') : Auth::User()->email }}" required>
                            </div>
                            <div class="form-group col-md-6{{ $errors->has('departement') ? ' has-error' : '' }}">
                                <label for="departement">Departement : </label>
                                <select class="form-control" id="departement" name="departement" required>
                                    @foreach($departements as $d)
                                        <option value="{{$d->id}}"@if(Auth::User()->departement == $d->id) selected @endif>{{$d->nom}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4{{ Session::has('error_psw') ? ' has-error' : '' }}">
                                <label for="password">Mot de passe (obligatoire): </label>
                                <input type="password" class="form-control" id="password" name="password" value="{{ Request::old('password') ? old('password') : '' }}" required>
                            </div>
                            <div class="form-group col-md-4{{ Session::has('error_confirmpsw') ? ' has-error' : '' }}">
                                <label for="new_psw">Nouvelle Mot de passe (non obligatoire): </label>
                                <input type="password" class="form-control" id="new_psw" name="new_psw" value="{{ Request::old('new_psw') ? old('new_psw') : '' }}">
                            </div>
                            <div class="form-group col-md-4{{ Session::has('error_confirmpsw') ? ' has-error' : '' }}">
                                <label for="confirm_psw">Confirmer Mot de passe (non obligatoire): </label>
                                <input type="password" class="form-control" id="confirm_psw" name="confirm_psw" value="{{ Request::old('confirm_psw') ? old('confirm_psw') : '' }}">
                            </div>
                            <div class="form-group col-md-12{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label for="image">Image de profile : </label>
                                <div class="user-header">
                                    
                                    <img src="{{route('profileimage',['id'=>Auth::User()->id])}}" class="img-circle" alt="" style="width: 200px;height: auto;">
                                </div>
                                <input class="btn btn-default btn-file" type="file" name="image" id="image">

                            </div>
                            <div class="col-md-12 box-footer clearfix">
                                <button type="submit" class="pull-right btn btn-default btn-flat" id="sendEmail">Modifier
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