<?php /* Smarty version Smarty-3.1-DEV, created on 2012-12-16 22:12:37
         compiled from "/data/Projects/www/Telelab/app/Example/tpl/submit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:79149763250ce3945164602-91625476%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'be729109aaf47914f9cf9e8910c38e6765aca123' => 
    array (
      0 => '/data/Projects/www/Telelab/app/Example/tpl/submit.tpl',
      1 => 1355692281,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '79149763250ce3945164602-91625476',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1-DEV',
  'unifunc' => 'content_50ce394516cb21_23015299',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50ce394516cb21_23015299')) {function content_50ce394516cb21_23015299($_smarty_tpl) {?><script type="text/javascript">
    $(document).ready(function() {
        $('#form-submit').on('click', function(e){
            $('#submit .control-group').removeClass('error');
            $('#submit .help-inline').html('');
            $('#submited-error').hide();

            e.preventDefault();
            $('#submitForm').submit();
        });

        $('#submitForm').on('submit', function(){
          $.post("/submit", $(this).serialize(), function(data){
            data = $.parseJSON(data);
            if (data.status == 'OK') {
                $('#submited-ok').show();
                var delay = 2000;
                setTimeout(function(){
                  $("#submit").modal('hide');
                  $('#submited-ok').hide();
                  $('#submited-error').hide();
                  $('#submit .control-group').removeClass('error');
                  $('#submit .help-inline').html('');
                  $('#name_val').val('');
                  $('#expression_val').val('');
                  $('#title_val').val('');
                }, delay);
            } else {
                $.each(data.error, function(key, val) {
                    if (key == 'form') {
                        $('#submited-error').show();
                    } else {
                        $('#'+key).addClass('error');
                        $('#'+key+' .help-inline').html(val);
                    }
                });
            }
          });

          return false;
        });
    });
</script>

<div id="submit" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Soumettre une Expression D'Enfant</h3>
    </div>
      <div class="modal-body">
            <form action="#" method="POST" id="submitForm">
                <fieldset>
                    <div id="name" class="control-group">
                        <div class="controls">
                            <input name="name" id="name_val" class="span2" type="text" placeholder="Prénom de l'enfant">
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div id="age" class="control-group">
                        <div class="controls">
                            <select name="age" class="span2">
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select> ans
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div id="title" class="control-group">
                        <div class="controls">
                            <input name="title" id="title_val" class="span5" type="text" placeholder="Titre">
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div id="expression" class="control-group">
                        <div class="controls">
                            <textarea name="expression" id="expression_val" rows="3" class="span5" placeholder="Aujourd'hui un enfant m'a dit ..."></textarea>
                            <span class="help-inline"></span>
                        </div>
                    </div>
                </fieldset>
            </form>
      </div>
      <div id="submited-ok" class="alert alert-success" style="display:none">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <h4>Félicitations !!</h4>
          Votre expression va maintenant être soumise à validation !
      </div>
      <div id="submited-error" class="alert alert-error" style="display:none">
          <h4>Oops !</h4>
          Une erreur s'est produite lors de la validation !
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
        <button class="btn btn-primary" id="form-submit">Soumettre</button>
      </div>
</div><?php }} ?>