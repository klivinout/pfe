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
                        Nouveau condidat
                    </button>
                </div>
                <!-- /. tools -->
            </div>
            <div class="box-body">
                <div class="col-sm-12">
                    <table class="table table-striped table-hover" id="listCondidats">
                        <thead>
                            <th class="col-sm-2">NOM</th>
                            <th class="col-sm-2">PRENOM</th>
                            <th class="col-sm-2">E-MAIL</th>
                            <th class="col-sm-2">ETABLISSEMENT</th>
                            <th class="col-sm-3">PERIODE</th>
                            <th class="col-sm-2">DEPARTEMENT</th>
                            <th class="col-sm-2">Action</th>
                        </thead>
                        <tbody>
                            @foreach($condidats as $c)
                                <tr>
                                    <td class="col-sm-2"> {{$c->nom}} </td>
                                    <td class="col-sm-2"> {{$c->prenom}} </td>
                                    <td class="col-sm-2"> {{$c->email}} </td>
                                    <td class="col-sm-2"> {{$c->etablissement}} </td>
                                    <td class="col-sm-3"> {{$c->datefrom}} => {{$c->dateend}} </td>
                                    <td class="col-sm-2"> {{$c->departement}} </td>
                                    <td class="col-sm-2">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">Actions <span class="fa fa-caret-down"></span></button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li>
                                                        <a href="{{route('modifycondidat' , ['id'=>$c->id])}}">
                                                            Consulter ou modifier
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            Confirmer en Stragiaire
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div><!-- /btn-group -->
                                        </div><!-- /input-group -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
</div>
      
@include('template.footer')
<script>
    $(document).ready(function() {
        $('#listCondidats').DataTable();
    } );
</script>
</body>
</html>