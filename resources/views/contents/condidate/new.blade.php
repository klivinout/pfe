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
                <a href="#"><i class="fa fa-dashboard"></i> Home</a>
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
                <h3 class="box-title">Nouveau condidat</h3>
              <!-- tools box -->
                <div class="pull-right box-tools">
                    <button type="button" class="btn btn-info btn-sm btn-flat">
                        liste des condidats
                    </button>
                </div>
                <!-- /. tools -->
            </div>
            <form action="#" method="post">
                <div class="box-body">
                    <div class="col-sm-6 form-group{{ $errors->has('') ? ' has-error' : '' }}">
                        <label for="prenom">Prénom : </label>
                        <input type="text" class="form-control" id="prenom" name="prenom" value="{{ Request::old('prenom') ? old('prenom') : '' }}" required>
                    </div>
                    <div class="col-sm-6 form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                        <label for="nom">Nom : </label>
                        <input type="text" class="form-control" id="nom" name="nom" value="{{ Request::old('nom') ? old('nom') : '' }}" required>
                    </div>
                    <div class="col-sm-6 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Email : </label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ Request::old('email') ? old('email') : '' }}" required>
                    </div>
                    <div class="col-sm-6 form-group{{ $errors->has('etablissement') ? ' has-error' : '' }}">
                        <label for="etablissement">Etablissement : </label>
                        <input type="text" class="form-control" id="etablissement" name="etablissement" value="{{ Request::old('etablissement') ? old('etablissement') : '' }}">
                    </div>
                    <div class="col-sm-6 form-group{{ $errors->has('datefrom') ? ' has-error' : '' }}">
                        <label for="datefrom">Date début :</label>
                        <input type="date" class="form-control" id="datefrom" name="datefrom" value="{{ Request::old('datefrom') ? old('datefrom') : '' }}" required>
                    </div>
                    <div class="col-sm-6 form-group{{ $errors->has('dateend') ? ' has-error' : '' }}">
                        <label for="dateend">Date fin :</label>
                        <input type="date" class="form-control" id="dateend" name="dateend" value="{{ Request::old('dateend') ? old('dateend') : '' }}" required>
                    </div>
                    <div class="col-sm-6 form-group{{ $errors->has('division') ? ' has-error' : '' }}">
                        <label for="division">Division : </label>
                        <select class="form-control" id="division" name="division">
                            <option disabled selected></option>
                            @foreach($departements as $dept)
                            <option value="{{$dept->id}}">{{$dept->nom}}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                </div>
                <div class="box-footer clearfix">
                    <button type="submit" class="pull-right btn btn-default btn-flat" id="sendEmail">Send
                        <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>
            </form>
        </div>

    </section>
</div>
      


@include('template.footer')
  </body>
</html>