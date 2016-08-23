@include('template.header')
@include('template.menu')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">

    <!-- quick email widget -->
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Nouvelle proposition de Sujet</h3>
              <!-- tools box -->
                <div class="pull-right box-tools">
                    <button type="button" class="btn btn-info btn-sm btn-flat">
                        liste des sujets
                    </button>
                </div>
                <!-- /. tools -->
            </div>
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group{{ $errors->has('objet') ? ' has-error' : '' }}">
                        <label for="objet">Objet ou titre : </label>
                        <input type="text" class="form-control" id="objet" name="objet" value="{{ Request::old('objet') ? old('objet') : '' }}" required>
                    </div>
                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description">Description : </label>
                        <textarea type="description" class="form-control" id="description" name="description" value="{{ Request::old('description') ? old('description') : '' }}">

                        </textarea>
                    </div>
                    <div class="form-group{{ $errors->has('attachement') ? ' has-error' : '' }}">
                        <!--div class="btn btn-default btn-file"-->
                          <i class="fa fa-paperclip"></i> Attachment
                          <input class="btn btn-default btn-file" type="file" name="attachement" id="attachement">
                        <!--/div-->
                        <p class="help-block">Max. 5MB</p>
                    </div>

                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                </div>
                <div class="box-footer clearfix">
                    <button type="submit" class="pull-right btn btn-default btn-flat" id="sendEmail">Enoyer
                        <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
      


@include('template.footer')
<script>
  $(function () {
    //Add text editor
    $("#description").wysihtml5();
  });
</script>
  </body>
</html>