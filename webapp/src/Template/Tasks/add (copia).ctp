<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<?php use Cake\Routing\Router; ?>
<script>
$(window).load(function()
{
  $("#course-id").focus();
  /**/
  $("#course-id" ).change(function()
  {
    var courseId = $(this).val();
    /**/
    $.ajax(
    {
      type:'POST',
      url: '<?php echo Router::url(array('controller'=>'Tasks','action'=>'getCourseDates'));?>' + '/'+ courseId,
      dataType:'json',
      //data:'id='+ID & 'user_id=' + USERID,
      success:function(response)
      {
        //$('#show_more_main'+ID).remove();
        //$('#schedule-div').html(html);
        if(Object.keys(response).length>0)
        {
          //console.log(response.start);          
          $('#start-day').val(("0"+response.start.day).slice(-2));
          $('#start-month').val(("0"+response.start.month).slice(-2));
          $('#start-year').val(response.start.year);
          $('#start-hour').val("00");
          $('#start-minute').val("00");
          $('#finish-day').val(("0"+response.finish.day).slice(-2));
          $('#finish-month').val(("0"+response.finish.month).slice(-2));
          $('#finish-year').val(response.finish.year);
          $('#finish-hour').val("23");
          $('#finish-minute').val("59");
        }
      }
    });
    /**/
  });
  /**/
});

/* Función que suma o resta días a una fecha, si el parámetro
   días es negativo restará los días*/
function sumarDias(fecha, dias){
  fecha.setDate(fecha.getDate() + dias);
  return fecha;
}
/* Función que suma o resta meses a una fecha, si el parámetro
   mes es negativo restará los meses*/
function sumarMeses(fecha, meses){
  fecha.setMonth(fecha.getMonth() + meses);
  return fecha;
}
</script>
<div class="menu-left">
  <ul class="list-menu-left">
    <li><?= $this->Html->link(__('Tareas'), ['action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('Agregar'), ['action' => 'add'],['style'=>'font-weight:bold']) ?></li>
  </ul>
</div>
<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="tasks form large-9 medium-8 columns content">
    <?= $this->Form->create($task,['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('Enviar tarea a un curso') ?></legend>
        <?php
            echo $this->Form->control('course_id', ['options' => $courses,'label'=>'Curso','empty'=>'Seleccione un Curso']);
            
            /*<Input FILE*/
            echo "<div class=\"input\">";
            $size_attachment = ($dlince_max_size_files>=1048576)?($dlince_max_size_files/1048576).'MB':($dlince_max_size_files/1024).'KB';
            echo $this->Form->control('title',['label'=>'Título de la tarea']);
            echo $this->Form->label('filename', 'Adjuntar archivo ('.$size_attachment.' máximo)');
            /*ini_get('upload_max_filesize').'/'.ini_get('post_max_size')*/
            echo $this->Form->file('filename');
            echo "<div class=\"error-message\">Archivo soportados: ".implode(', ',$dlince_type_files).".</div>";
            echo "</div>";
            /*Input FILE>*/
            echo $this->Form->control('start',[
              'label'=>'Fecha y hora de inicio de envíos',
              'day' => [
                  'id' => 'start-day',
              ],
              'month' => [
                  'id' => 'start-month',
              ],
              'year' => [
                  'id' => 'start-year',
              ],
              'hour' => [
                  'id' => 'start-hour',
              ],
              'minute' => [
                  'id' => 'start-minute',
              ]
            ]);
            echo $this->Form->control('finish',[
              'label'=>'Fecha y hora límite para hacer envíos',
              'day' => [
                  'id' => 'finish-day',
              ],
              'month' => [
                  'id' => 'finish-month',
              ],
              'year' => [
                  'id' => 'finish-year',
              ],
              'hour' => [
                  'id' => 'finish-hour',
              ],
              'minute' => [
                  'id' => 'finish-minute',
              ]
            ]);
            
            echo $this->Form->control('description',['label'=>'Descripción de la tarea']);
            echo $this->Form->control('state',['label'=>'¿Tarea activa?']);
            echo $this->Form->button(
          __($this->Html->image(Configure::read('DLince.icon.save')).'<span>Enviar tarea</span>'),
          ['class'=>'button', 'escape' => false]
        );        
          ?>
        </fieldset>
        <?= $this->Form->end() ?>
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>