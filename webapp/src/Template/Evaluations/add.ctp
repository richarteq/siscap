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
      url: '<?php echo Router::url(array('controller'=>'Evaluations','action'=>'getCourseDates'));?>' + '/'+ courseId,
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
</script>
<div class="menu-left">
<ul class="list-menu-left">
<li><?= $this->Html->link(__('Evaluaciones'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add'],['style'=>'font-weight:bold']) ?></li>
</ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="evaluations form large-9 medium-8 columns content">
    <?= $this->Form->create($evaluation,['type' => 'file']) ?>
    <fieldset>
      <legend><?= __('Agregar evaluación a un curso') ?></legend>
      <?php
          echo $this->Form->control('course_id', ['options' => $courses,'label'=>'Curso','empty'=>'Seleccione un Curso']);
          echo $this->Form->control('title', ['label'=>'Titulo de la evaluación']);
          /**/
          echo $this->Form->control('limit_time', [
            'options'=>$dlince_limits_time, 
            'default'=>1, 
            'label'=>'Tiempo límite', 
            'templates' => [
              'inputContainer' => '<div class="input select required">{{content}}<span style="font-weight:bold">minutos</span>'
            ]
          ]); 
          /**/          
          /**/
          /*<Input FILE*/
          echo "<div class=\"input\">";
          $max_size_attachment = ($dlince_max_size_files>=1048576)?round($dlince_max_size_files/1048576,2).' MB':round($dlince_max_size_files/1024,2).' KB';
          
          echo $this->Form->label('filename', 'Adjuntar archivo ('.$max_size_attachment.' máximo)');
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

          echo $this->Form->control('description',['label'=>'Descripción de la evaluación']);
          
          echo $this->Form->control('state',['label'=>'¿Evaluación visible?']);
          echo $this->Form->button(
        __($this->Html->image(Configure::read('DLince.icon.save')).'<span>Agregar evaluación</span>'),
        ['class'=>'button', 'escape' => false]
      );        
      ?>
    </fieldset>
    <?= $this->Form->end() ?>
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>