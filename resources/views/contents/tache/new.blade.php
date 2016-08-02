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
                <h3 class="box-title">Nouvelle Tache</h3>
              <!-- tools box -->
                <div class="pull-right box-tools">
                    <a href="" class="btn btn-info btn-sm btn-flat">
                        liste des Taches du Stage
                    </a>
                </div>
                <!-- /. tools -->
            </div>
            
                <div class="box-body">
                    <div class="col-md-4">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-green-active">
                                @if(isset($responsable))
                                <div class="widget-user-image">
                                    <img class="img-circle" src="http://localhost:8000/assets/img/avatar.png" alt="User Avatar">
                                </div>
                                <h3 class="widget-user-username">{{strtoupper($responsable->nom)}}</h3>
                                <h5 class="widget-user-desc"><i class="fa fa-bank"></i> {{$responsable->dep_nom}}</h5>
                                <h5 class="widget-user-desc"><i class="fa fa-envelope"></i> {{$responsable->email}}</h5>
                                @endif
                            </div>
                        </div>
                        <!-- /.widget-user -->
                        <div class="box box-widget widget-user-2">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-aqua-active">
                                @if(isset($stagiaire))
                                <div class="widget-user-image">
                                    <img class="img-circle" src="http://localhost:8000/assets/img/avatar.png" alt="User Avatar">
                                </div>
                                <h3 class="widget-user-username">{{strtoupper($stagiaire->nom)}}</h3>
                                <h5 class="widget-user-desc"><i class="fa fa-bank"></i> {{$stagiaire->dep_nom}}</h5>
                                <h5 class="widget-user-desc"><i class="fa fa-envelope"></i> {{$stagiaire->email}}</h5>
                                @endif
                            </div>
                            @if(isset($stagiaire))
                            <div class="box-footer">
                                <div class="row">
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">Début</h5>
                                            <span class="description-text">{{$stagiaire->datefrom}}</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">Fin</h5>
                                            <span class="description-text">{{$stagiaire->dateend}}</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4">
                                        <div class="description-block">
                                            <h5 class="description-header"></h5>
                                            <span class="description-text">{{$stagiaire->etablissement}}</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            @endif
                        </div>


                        <div class="box box-widget widget-user-2">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-yellow">
                                <h3>
                                    <i class="glyphicon glyphicon-pushpin"></i> @if(isset($sujet)) {{$sujet->objet}} @endif
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="box box-default">
                            <div class="box-header with-border">
                            <h3 class="box-title">Timeline des taches</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                @if(isset($taches))
                                <ul class="timeline">
                                    @foreach($taches as $tache)
                                    <?php $tacheDateTime = DateTime::createFromFormat('Y-m-d H:i:s' , $tache->created_at); ?>
                                    <?php $statut = json_decode($tache->statut) ?>
                                    <!-- timeline time label -->
                                    <li class="time-label">
                                          <span class="bg-red">
                                            {{$tacheDateTime->format('j M Y')}}
                                          </span>
                                    </li>
                                    <!-- /.timeline-label -->

                                    <!-- timeline item -->
                                    <li>
                                        @if(is_array($statut))
                                            @if($statut[0] == -1) <i class="fa fa-envelope bg-red"></i>
                                            @endif
                                        @else <i class="fa fa-envelope bg-blue"></i>
                                        @endif
                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> {{$tacheDateTime->format('G:i')}}</span>

                                            <h3 class="timeline-header">{{$tache->from_nom}} : {{$tache->objet}}</h3>

                                            <div class="timeline-body">
                                                {{$tache->description}}
                                            </div>
                                            <div class="timeline-footer">
                                                Delai : {{$tache->delai}}
                                            </div>
                                            
                                            <div class="timeline-footer">
                                                @if($statut==null || $statut==0)
                                                <button class="btn btn-primary btn-xs" onclick="modifierTacheStatut({{$tache->id}},1)">
                                                    <i class="fa fa-thumbs-o-up"></i>
                                                </button>
                                                <button class="btn btn-success btn-xs" onclick="modifierTacheStatut({{$tache->id}},10)">
                                                    <i class="fa fa-thumbs-up"></i>
                                                </button>
                                                <button class="btn btn-danger btn-xs" onclick="modifierTacheStatut({{$tache->id}},-1)">
                                                    <i class="fa  fa-thumbs-down"></i>
                                                </button>
                                                <button class="btn btn-primary btn-xs" onclick="modifierTache({{$tache->id}})">
                                                    <i class="fa  fa-pencil-square-o"></i>Modifier
                                                </button>
                                                @elseif($statut[0]==1 || $statut[0]==-1)
                                                <button class="btn btn-success btn-xs" onclick="modifierTacheStatut({{$tache->id}},1)">
                                                    <i class="fa fa-thumbs-o-up"></i>
                                                </button>
                                                <button class="btn btn-danger btn-xs" onclick="modifierTacheStatut({{$tache->id}},-1)">
                                                    <i class="fa  fa-thumbs-down"></i>
                                                </button>
                                                @elseif($statut[0]==10)
                                                <button class="btn btn-success btn-xs" disabled>
                                                    <i class="fa fa-thumbs-o-up"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    <!-- END timeline item -->
                                    @endforeach
                                </ul> 
                                @else
                                <div class="form-group">
                                    <select class="form-control" id="stages" onchange="selectStage()">
                                        <option selected>Liste des stages</option>
                                        @foreach($stages as $stage)
                                        <option value="{{$stage->stage}}">{{$stage->nom}} {{$stage->prenom}} {{$stage->datefrom}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                            </div>
                            <!-- /.box-body -->
                        </div>          
                    </div>

                    <div class="col-md-4">
                        <form action="#" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">
                            <div class="box-body">
                                @if(isset($tache_modif))
                                    <div class="form-group">
                                        <label for="objet">Objet : </label>
                                        <input type="text" name="objet" id="objet" class="form-control" value="{{ Request::old('objet') ? old('objet') : $tache_modif->objet }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description : </label>
                                        <textarea class="form-control" rows="4" name="description" id="description">{{ Request::old('description') ? old('description') : $tache_modif->description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="delai">Delai : </label>
                                        <input type="date" name="delai" id="delai" class="form-control" value="{{ Request::old('delai') ? old('delai') : $tache_modif->delai }}">
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label for="objet">Objet : </label>
                                        <input type="text" name="objet" id="objet" class="form-control" value="{{ Request::old('objet') ? old('objet') : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description : </label>
                                        <textarea class="form-control" rows="4" name="description" id="description">{{ Request::old('description') ? old('description') : '' }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="delai">Delai : </label>
                                        <input type="date" name="delai" id="delai" class="form-control" value="{{ Request::old('delai') ? old('delai') : '' }}">
                                    </div>
                                @endif
                                @if(isset($sujet))
                                <div class="box-footer clearfix">
                                    <button type="submit" class="pull-right btn btn-default btn-flat">Ajouter
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </button>
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>

                </div>
            </form>
        </div>

    </section>
</div>
      


@include('template.footer')
<script>
    function modifierTache(tache) {
        var url = "{{route('ajaxmodifiertache' , ['id'=>':id'])}}";
        url = url.replace(':id',tache);
        var urlForm = "{{route('newtache',['id'=>$stage->id,'tache'=>':tache'])}}";
        urlForm = urlForm.replace(':tache',tache);
        $.get(url, function (rep) {
            if(rep.code == 200) {
                $('#objet').val(rep.tache.objet);
                $('#description').val(rep.tache.description);
                $('#delai').val(rep.tache.delai);
                $('form').get(0).setAttribute('action', urlForm);
            }
        });
    }

    function modifierTacheStatut(tache,statut) {
        var url = "{{route('ajaxmodifiertachestatut' , ['id'=>':id'])}}";
        url = url.replace(':id',tache);

        $.post(
            url,
            {
                'statut' : statut,
                '_token' : $('#_token').val()
            },
            function (rep) {

            }
        );
    }
</script>
@if(isset($stages))
<script>
    function selectStage() {
        var url = "{{route('newtache' , ['id'=>':id','tache'=>'tout'])}}";
        stage = $('#stages').val();

        url = url.replace(':id',stage);

        window.location = url;
    }
    
</script>
@endif
  </body>
</html>