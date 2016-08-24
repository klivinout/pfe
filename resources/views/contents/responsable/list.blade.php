@include('template.header')
@include('template.menu')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">

    <!-- quick email widget -->
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Liste des responsables</h3>
              <!-- tools box -->
                <div class="pull-right box-tools">
                    <a href="{{route('newresponsable')}}" class="btn btn-info btn-sm btn-flat">
                        Nouveau
                    </a>
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
                            <th class="col-sm-2">DEPARTEMENT</th>
                            <th class="col-sm-2">Action</th>
                        </thead>
                        <tbody>
                            @foreach($resps as $r)
                                <tr>
                                    <td class="col-sm-2"> {{$r->nom}} </td>
                                    <td class="col-sm-2"> {{$r->prenom}} </td>
                                    <td class="col-sm-2"> {{$r->email}} </td>
                                    <td class="col-sm-2"> {{$r->departement}} </td>
                                    <td class="col-sm-2">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">Actions <span class="fa fa-caret-down"></span></button>
                                                
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li>
                                                        <a href="{{route('modifyresponsable' , ['id'=>$r->id])}}">
                                                            Consulter ou modifier Responsable
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
        $('#listResponsable').DataTable();
    } );
</script>
</body>
</html>