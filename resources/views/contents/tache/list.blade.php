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
                <h3 class="box-title">Liste des propositions de sujets</h3>
              <!-- tools box -->
                <div class="pull-right box-tools">
                    <a href="{{route('newtache',['id'=>'tout','tache'=>'tout'])}}" class="btn btn-info btn-sm btn-flat">
                        Nouvelle tache
                    </a>
                </div>
                <!-- /. tools -->
            </div>
            <div class="box-body">
                <div class="col-md-offset-1 col-sm-10" id="listStagesDiv">
                    <table class="table table-striped table-hover" id="listStages">
                        <thead>
                            <th class="col-sm-2">Stagiaire</th>
                            <th class="col-sm-2">Responsable</th>
                            <th class="col-sm-2">Departement</th>
                            <th class="col-sm-2">Sujet</th>
                            <th class="col-sm-2">Date</th>
                            <th class="col-sm-2">Statut</th>
                            <th class="col-sm-1">Action</th>
                        </thead>
                        <tbody>
                            @foreach($stages as $s)
                                <tr>
                                    <td class="col-sm-2"> 
                                        <a href="{{route('newstagiaire' , ['id'=>$s->stg])}}" target="_blank">
                                            {{$s->stg_nom}} {{$s->stg_prenom}}
                                        </a> 
                                    </td>
                                    <td class="col-sm-2"> {{$s->resp_nom}} {{$s->resp_prenom}} </td>
                                    <td class="col-sm-2"> {{$s->dep_nom}} </td>
                                    <td class="col-sm-2">
                                        <a href="{{route('modifysujet' , ['id'=>$s->sujet])}}" target="_blank"> 
                                            {{$s->sujet_objet}} 
                                        </a>
                                    </td>
                                    <td class="col-sm-2"> 
                                        {{DateTime::createFromFormat('Y-m-d H:i:s' , $s->created_at)->format('j M Y')}} 
                                    </td>
                                    <td class="col-sm-2">
                                        @if($s->statut == 0 || $s->statut == null)
                                            <label class="label label-default">en cours</label>
                                        @elseif($s->statut == 1)
                                            <label class="label label-success">conclut</label>
                                        @elseif($s->statut == -1)
                                            <label class="label label-danger">non fini</label>
                                        @endif
                                    </td>
                                    <td class="col-sm-1">
                                        <button class="btn btn-primary btn-xs" onclick="voirTaches({{$s->stage}})">
                                            <i class="fa fa-list-ol"></i>Taches
                                        </button>
                                        @if(($s->statut == 0 || $s->statut == null) && $s->statut != 1)
                                        <button class="btn btn-success btn-xs">
                                            <i class="fa fa-thumbs-up"></i>Conclut
                                        </button>
                                        @endif
                                        @if($s->statut == 0 || $s->statut == null)
                                        <button class="btn btn-danger btn-xs">
                                            <i class="fa  fa-thumbs-down"></i>non fini
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="col-md-offset-1 col-sm-10" id="listTachesDiv" style="display:none;">
                    <div class="form-group">
                        <button class="btn btn-flat btn-default" onclick="backToStages()">Retour au Stages</button>
                    </div>
                    <table class="table table-striped table-hover" id="listTaches">
                        <thead>
                            <th class="col-sm-2">Objet</th>
                            <th class="col-sm-2">Description</th>
                            <th class="col-sm-2">Date</th>
                            <th class="col-sm-2">Delai</th>
                            <th class="col-sm-2">Statut</th>
                            <th class="col-sm-1">Action</th>
                        </thead>
                        <tbody id="bodyTaches">
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
        $('#listStages').DataTable();
        $('#listTaches').DataTable();
    } );
</script>
<script>
    function voirTaches(id) {
        url = "{{route('ajaxlisttachebystage' , ['id' => ':id'])}}";
        url = url.replace(':id' , id);
        var statut;
        var action;
        var urlModifier = "{{route('newtache' , ['id' => ':id','tache'=>':tache'])}}";
        $.get(url , function (rep) {
            if(rep.code == 200) {
                $('#bodyTaches').empty();
                $.each(rep.taches , function(i,tache) {
                    statut = '';
                    action = '';
                    if(tache.statut == 0 || tache.statut == null)
                        statut = '<span class="label label-default">En cours</span>';
                    else {
                        if(tache.statut.code == 10)
                            statut = '<span class="label label-success">Valider</span>';
                        else if(tache.statut.code == 11)
                            statut = '<span class="label label-primary">à Examiner</span>';
                        else if(tache.statut.code == -1)
                            statut = '<span class="label label-danger">à Examiner</span>';
                    }
                    urlModifier = urlModifier.replace(':id',tache.stage);
                    urlModifier = urlModifier.replace(':tache',tache.id);
                    action = '<a href="'+urlModifier+'" class="label label-success">Modifier</a>';

                    $('#bodyTaches').append('\
                        <tr>\
                            <td class="col-sm-2">'+tache.objet+'</td>\
                            <td class="col-sm-2">'+tache.description+'</td>\
                            <td class="col-sm-2">'+tache.created_at+'</td>\
                            <td class="col-sm-2">'+tache.delai+'</td>\
                            <td class="col-sm-2">'+statut+'</td>\
                            <td class="col-sm-1">'+action+'</td>\
                        </tr>\
                    ');  
                });

            }
        });

        $('#listStagesDiv').hide(800);
        $('#listTachesDiv').show(800);
    }

    function backToStages() {
        $('#listTachesDiv').hide(800);
        $('#listStagesDiv').show(800);
    }
</script>
</body>
</html>