@include('template.header')
@include('template.menu')
<?php
$privilege = Auth::User()->type;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">

    <!-- quick email widget -->
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Liste des propositions de sujets</h3>
              <!-- tools box -->
                <div class="pull-right box-tools">
                    <button type="button" class="btn btn-info btn-sm btn-flat">
                        Nouvea sujet
                    </button>
                </div>
                <!-- /. tools -->
            </div>
            <div class="box-body">
                <div class="col-sm-12">
                    <table class="table table-striped table-hover" id="listCondidats">
                        <thead>
                            <th class="col-sm-2">PAR</th>
                            <th class="col-sm-2">E-MAIL</th>
                            <th class="col-sm-2">DEPARTEMENT</th>
                            <th class="col-sm-2">OBJET</th>
                            <th class="col-sm-2">DATE</th>
                            <th class="col-sm-2">ETAT</th>
                            <th class="col-sm-1">Action</th>
                        </thead>
                        <tbody>
                            @foreach($sujets as $s)
                                <tr>
                                    <td class="col-sm-2"> {{$s->nom}} {{$s->prenom}} </td>
                                    <td class="col-sm-2"> {{$s->email}} </td>
                                    <td class="col-sm-2"> {{$s->departement}} </td>
                                    <td class="col-sm-2"> {{$s->objet}} </td>
                                    <td class="col-sm-2"> {{$s->created_at}} </td>
                                    <td class="col-sm-2">
                                        @if($s->etat == 0 || $s->etat == null)
                                            <label class="label label-default">en attente</label>
                                        @elseif($s->etat == 1)
                                            <label class="label label-info">en cours</label>
                                        @elseif($s->etat == 2)
                                            <label class="label label-primary">à confirmer</label>
                                        @elseif($s->etat == 3)
                                            <label class="label label-success">réaliser</label>
                                        @endif
                                        @if($privilege==2 || $privilege==10)
                                        <div class="input-group input-group-xs">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-xs dropdown-toggle" data-toggle="dropdown"><span class="fa fa-caret-down"></span></button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li>
                                                        <a href="{{route('modifysujetetat' , ['id'=>$s->id , 'etat' => 0])}}">
                                                            en attente
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{route('modifysujetetat' , ['id'=>$s->id , 'etat' => 1])}}">
                                                            en cours
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{route('modifysujetetat' , ['id'=>$s->id , 'etat' => 2])}}">
                                                            à confirmer
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{route('modifysujetetat' , ['id'=>$s->id , 'etat' => 3])}}">
                                                            realiser
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div><!-- /btn-group -->
                                        </div>
                                        @endif
                                    </td>
                                    <td class="col-sm-1">
                                        @if($s->proposer_par == Auth::User()->id)
                                        <a class="btn btn-info btn-flat btn-xs" href="{{route('modifysujet' , ['id'=>$s->id])}}">
                                            Modifier
                                        </a>
                                        @endif
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