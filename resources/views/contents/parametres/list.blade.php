@include('template.header')
@include('template.menu')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">

    <!-- quick email widget -->
        <div class="box box-info">
            <div class="box-header">
                &nbsp;
                @if($type_list == 'responsables')
                <h3 class="box-title">Liste des responsables</h3>
                @elseif($type_list == 'etablissements')
                <h3 class="box-title">Liste des etablissements</h3>
                @elseif($type_list == 'divisions')
                <h3 class="box-title">Liste des divisions</h3>
                @elseif($type_list == 'diplomes')
                <h3 class="box-title">Liste des diplomes</h3>
                @elseif($type_list == 'villes')
                <h3 class="box-title">Liste des villes</h3>
                @endif
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
                    <div class="form-group">
                        <form method="get" action="#" class="form-inline">
                            <select class="form-control" name="type_list">
                                <option selected disabled></option>
                                <option value="responsables">responsables</option>
                                <option value="etablissements">etablissements</option>
                                <option value="divisions">divisions</option>
                                <option value="diplomes">diplômes</option>
                                <option value="villes">villes</option>
                            </select>
                            <input type="submit" value="changer" class="btn btn-flat">
                        </form>
                    </div>
                </div>
                <div class="col-sm-6 well" id="div_table">
                    @if($type_list == 'responsables')
                    <table class="table table-striped table-hover" id="listResponsables">
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
                                    <td class="col-sm-2"> {{$r->dept_nom}} </td>
                                    <td class="col-sm-2">
                                        <button onclick="modify('responsable',{{$r->id}})" class="btn btn-xs">
                                            <i class="fa  fa-pencil-square"></i>Modifier
                                        </button>

                                        <button onclick="delete_('responsable',{{$r->id}})" class="btn btn-danger btn-xs">
                                            <i class="fa  fa-trash"></i>Supprimer
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @elseif($type_list == 'etablissements')
                    <table class="table table-striped table-hover" id="listEtablissements">
                        <thead>
                            <th class="col-sm-2">NOM</th>
                            <th class="col-sm-2">ADRESSE</th>
                            <th class="col-sm-2">E-MAIL</th>
                            <th class="col-sm-2">TELEPHONE</th>
                            <th class="col-sm-2">Action</th>
                        </thead>
                        <tbody>
                            @foreach($etablissements as $e)
                                <tr>
                                    <td class="col-sm-2"> {{$e->nom}} </td>
                                    <td class="col-sm-2"> {{$e->adresse}} </td>
                                    <td class="col-sm-2"> {{$e->email}} </td>
                                    <td class="col-sm-2"> {{$e->telephone}} </td>
                                    <td class="col-sm-2">
                                        <button onclick="modify('etablissement',{{$e->id}})" class="btn btn-xs">
                                            <i class="fa  fa-pencil-square"></i>Modifier
                                        </button>

                                        <button onclick="delete_('etablissement',{{$e->id}})" class="btn btn-danger btn-xs">
                                            <i class="fa  fa-trash"></i>Supprimer
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @elseif($type_list == 'divisions')
                    <table class="table table-striped table-hover" id="listDepartements">
                        <thead>
                            <th class="col-sm-2">NOM</th>
                            <th class="col-sm-2">Action</th>
                        </thead>
                        <tbody>
                            @foreach($departements as $d)
                                <tr>
                                    <td class="col-sm-2"> {{$d->nom}} </td>
                                    <td class="col-sm-2">
                                        <button onclick="modify('division',{{$d->id}})" class="btn btn-xs">
                                            <i class="fa  fa-pencil-square"></i>Modifier
                                        </button>

                                        <button onclick="delete_('division',{{$d->id}})" class="btn btn-danger btn-xs">
                                            <i class="fa  fa-trash"></i>Supprimer
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @elseif($type_list == 'diplomes')
                    <table class="table table-striped table-hover" id="listDiplomes">
                        <thead>
                            <th class="col-sm-2">NOM</th>
                            <th class="col-sm-2">Action</th>
                        </thead>
                        <tbody>
                            @foreach($diplomes as $di)
                                <tr>
                                    <td class="col-sm-2"> {{$di->nom}} </td>
                                    <td class="col-sm-2">
                                        <button onclick="modify('diplome',{{$di->id}})" class="btn btn-xs">
                                            <i class="fa  fa-pencil-square"></i>Modifier
                                        </button>

                                        <button onclick="delete_('diplome',{{$di->id}})" class="btn btn-danger btn-xs">
                                            <i class="fa  fa-trash"></i>Supprimer
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @elseif($type_list == 'villes')
                    <table class="table table-striped table-hover" id="listCondidats">
                        <thead>
                            <th class="col-sm-2">NOM</th>
                            <th class="col-sm-2">CODE POSTAL</th>
                            <th class="col-sm-2">Action</th>
                        </thead>
                        <tbody>
                            @foreach($villes as $v)
                                <tr>
                                    <td class="col-sm-2"> {{$v->nom}} </td>
                                    <td class="col-sm-2"> {{$v->code_postal}} </td>
                                    <td class="col-sm-2">
                                        <button onclick="modify('ville',{{$v->id}})" class="btn btn-xs">
                                            <i class="fa  fa-pencil-square"></i>Modifier
                                        </button>

                                        <button onclick="delete_('ville',{{$v->id}})" class="btn btn-danger btn-xs">
                                            <i class="fa  fa-trash"></i>Supprimer
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
                <div class="col-sm-6 well" id="div_modify" style="display : none;">
                    @if($type_list == 'responsables')
                    <h3 class="box-title">Modifier responsable : </h3>
                    <form method="post" action="{{route('modifyresponsable',['id' => ':id'])}}" id='modifyForm'>
                        <div class="form-group{{ $errors->has('resp_nom') ? ' has-error' : '' }}">
                            <label for="resp_nom">Nom : </label>
                            <input type="text" class="form-control" name="resp_nom" id="resp_nom" value="{{ Request::old('resp_nom') ? old('resp_nom') : '' }}">
                        </div>
                        <div class="form-group{{ $errors->has('resp_prenom') ? ' has-error' : '' }}">
                            <label for="resp_prenom">Prénom : </label>
                            <input type="text" class="form-control" name="resp_prenom" id="resp_prenom" value="{{ Request::old('resp_prenom') ? old('resp_prenom') : '' }}">
                        </div>
                        <div class="form-group{{ $errors->has('resp_email') ? ' has-error' : '' }}">
                            <label for="resp_email">E-mail : </label>
                            <input type="text" class="form-control" name="resp_email" id="resp_email" value="{{ Request::old('resp_email') ? old('resp_email') : '' }}">
                        </div>
                        <div class="form-group{{ $errors->has('resp_dept') ? ' has-error' : '' }}">
                            <label for="resp_dept">Division : </label>
                            <select class="form-control" name="resp_dept" id="resp_dept" value="{{ Request::old('resp_dept') ? old('resp_dept') : '' }}">
                                <option selected disabled></option>
                                @foreach($departements as $departement)
                                <option value="{{$departement->id}}">{{$departement->nom}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="box-footer clearfix">
                            <button type="submit" class="pull-right btn btn-default btn-flat">modifier
                                <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </form>
                    @elseif($type_list == 'etablissements')
                    <h3 class="box-title">Modifier etablissement : </h3>
                    <form method="post" action="{{route('modifyschool',['id' => ':id'])}}" id='modifyForm'>
                        <div class="form-group{{ $errors->has('school_nom') ? ' has-error' : '' }}">
                            <label for="school_nom">Nom : </label>
                            <input type="text" class="form-control" name="school_nom" id="school_nom" value="{{ Request::old('school_nom') ? old('school_nom') : '' }}">
                        </div>
                        <div class="form-group{{ $errors->has('school_adress') ? ' has-error' : '' }}">
                            <label for="school_adress">Adresse : </label>
                            <input type="text" class="form-control" name="school_adress" id="school_adress" value="{{ Request::old('school_adress') ? old('school_adress') : '' }}">
                        </div>
                        <div class="form-group{{ $errors->has('school_phone') ? ' has-error' : '' }}">
                            <label for="school_phone">Téléphone : </label>
                            <input type="text" class="form-control" name="school_phone" id="school_phone" value="{{ Request::old('school_phone') ? old('school_phone') : '' }}">
                        </div>
                        <div class="form-group{{ $errors->has('school_email') ? ' has-error' : '' }}">
                            <label for="school_email">E-mail : </label>
                            <input type="email" class="form-control" name="school_email" id="school_email" value="{{ Request::old('school_email') ? old('school_email') : '' }}">
                        </div>
                        <div class="box-footer clearfix">
                            <button type="submit" class="pull-right btn btn-default btn-flat">modifier
                                <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </form>
                    @elseif($type_list == 'divisions')
                    <h3 class="box-title">Modifier Division : </h3>
                    <form method="post" action="{{route('modifydepartement',['id' => ':id'])}}" id='modifyForm'>
                        <div class="form-group{{ $errors->has('dept_nom') ? ' has-error' : '' }}">
                            <label for="dept_nom">Nom : </label>
                            <input type="text" class="form-control" name="dept_nom" id="dept_nom" value="{{ Request::old('dept_nom') ? old('dept_nom') : '' }}">
                        </div>
                        <div class="box-footer clearfix">
                            <button type="submit" class="pull-right btn btn-default btn-flat">modifier
                                <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </form>
                    @elseif($type_list == 'diplomes')
                    <h3 class="box-title">Modifier diplôme : </h3>
                    <form method="post" action="{{route('modifydegree',['id' => ':id'])}}" id='modifyForm'>
                        <div class="form-group{{ $errors->has('diplome_nom') ? ' has-error' : '' }}">
                            <label for="diplome_nom">Nom : </label>
                            <input type="text" class="form-control" name="diplome_nom" id="diplome_nom" value="{{ Request::old('diplome_nom') ? old('diplome_nom') : '' }}">
                        </div>
                        <div class="box-footer clearfix">
                            <button type="submit" class="pull-right btn btn-default btn-flat">modifier
                                <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </form>
                    @elseif($type_list == 'villes')
                    <h3 class="box-title">Modifier Ville : </h3>
                    <form method="post" action="{{route('modifycity',['id' => ':id'])}}" id='modifyForm'>
                        <div class="form-group{{ $errors->has('ville_nom') ? ' has-error' : '' }}">
                            <label for="ville_nom">Nom : </label>
                            <input type="text" class="form-control" name="ville_nom" id="ville_nom" value="{{ Request::old('ville_nom') ? old('ville_nom') : '' }}">
                        </div>
                        <div class="form-group{{ $errors->has('ville_codepostal') ? ' has-error' : '' }}">
                            <label for="ville_codepostal">Nom : </label>
                            <input type="text" class="form-control" name="ville_codepostal" id="ville_codepostal" value="{{ Request::old('ville_codepostal') ? old('ville_codepostal') : '' }}">
                        </div>
                        <div class="box-footer clearfix">
                            <button type="submit" class="pull-right btn btn-default btn-flat">modifier
                                <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>

    </section>
</div>
<script>
    function modify(type,id) {
        var url = "";

        if(type == 'responsable'){
            url = "{{route('modifyresponsable',['id'=>':id'])}}";
            url = url.replace(':id',id);
            $.get(url,function(rep) {
                if(rep.code == 200) {
                    $('#div_modify').show();

                    $('#resp_nom').val(rep.data.nom);
                    $('#resp_prenom').val(rep.data.prenom);
                    $('#resp_email').val(rep.data.email);
                    document.getElementById('resp_dept').value = rep.data.departement;
                    var action = $('#modifyForm').attr('action');
                    action = action.replace(':id',id);
                    $('#modifyForm').attr('action',action);
                }   
            });
        }
        else if(type == 'etablissement'){
            url = "{{route('modifyschool',['id'=>':id'])}}";
            url = url.replace(':id',id);
            $.get(url,function(rep) {
                if(rep.code == 200) {
                    $('#div_modify').show();
                    
                    $('#school_nom').val(rep.data.nom);
                    $('#school_adress').val(rep.data.adresse);
                    $('#school_email').val(rep.data.email);
                    $('#school_phone').val(rep.data.telephone);
                    var action = $('#modifyForm').attr('action');
                    action = action.replace(':id',id);
                    $('#modifyForm').attr('action',action);
                }
            });
        }
        else if(type == 'division'){
            url = "{{route('modifydepartement',['id'=>':id'])}}";
            url = url.replace(':id',id);
            $.get(url,function(rep) {
                if(rep.code == 200) {
                    $('#div_modify').show();
                    
                    $('#dept_nom').val(rep.data.nom);
                    var action = $('#modifyForm').attr('action');
                    action = action.replace(':id',id);
                    $('#modifyForm').attr('action',action);
                }
            });
        }
        else if(type == 'diplome'){
            url = "{{route('modifydegree',['id'=>':id'])}}";
            url = url.replace(':id',id);
            $.get(url,function(rep) {
                if(rep.code == 200) {
                    $('#div_modify').show();
                    
                    $('#diplome_nom').val(rep.data.nom);
                    var action = $('#modifyForm').attr('action');
                    action = action.replace(':id',id);
                    $('#modifyForm').attr('action',action);
                }
            });
        }
        else if(type == 'ville'){
            url = "{{route('modifycity',['id'=>':id'])}}";
            url = url.replace(':id',id);
            $.get(url,function(rep) {
                if(rep.code == 200) {
                    $('#div_modify').show();
                    
                    $('#ville_nom').val(rep.data.nom);
                    $('#ville_codepostal').val(rep.data.code_postal);
                    var action = $('#modifyForm').attr('action');
                    action = action.replace(':id',id);
                    $('#modifyForm').attr('action',action);
                }
            });
        }
    }
</script>
      
@include('template.footer')
</body>
</html>