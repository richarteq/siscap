<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<?php use Cake\Routing\Router; ?>
<script>
$(window).load(function() {
  /**/
  $( "#name" ).focus();
  evalCourseType();
  /**/
  $( "#select-course-type" ).change(function() {
    evalCourseType()
  });
  /**/
});

function evalCourseType(){
  var courseType = $('#select-course-type').val();
  /**/
  $.ajax({
    type:'POST',
    url: '<?php echo Router::url(array('controller'=>'Courses','action'=>'showSchedule'));?>' + '/'+ courseType,
    //data:'id='+ID & 'user_id=' + USERID,
    success:function(html){
      //$('#show_more_main'+ID).remove();
      $('#schedule-div').html(html);
    }
  });
  /**/
}
</script>

<div class="menu-left">
<ul class="list-menu-left">
<li><?= $this->Html->link(__('Cursos'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add'],['style'=>'font-weight:bold']) ?></li>
</ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="courses form large-9 medium-8 columns content">
  <?= $this->Form->create($course,['type' => 'file', 'onSubmit'=>"if(!confirm(\"¿Esta seguro de crear este nuevo curso?\")){return false;}",]) ?>
  <fieldset>
    <legend><?= __('Agregar curso') ?></legend>
    <?php
      echo $this->Form->control('name',['label'=>'Nombre del curso']);
      $types = array(1=>'Presencial',2=>'Virtual',3=>'Presencial y Virtual');
      echo $this->Form->control('type', ['options' => $types,'label'=>'Modalidad del curso','default'=>2,'id'=>'select-course-type']);
      echo $this->Form->control('description',['label'=>'Descripción del curso']);
      echo "<div id='schedule-div'></div>";
      echo $this->Form->control('place',['label'=>'Lugar']);
      echo $this->Form->control('destined',['label'=>'Dirigido a']);
      echo $this->Form->label('Course.start', 'Fecha que inicia el curso');
      /**/
      echo $this->Form->date('start', [
        'minYear' => 2017,
        'value' => date('Y-m-d'),
        'empty' => [
            'year' => false,
            'month' => false,
            'day' => false,
        ],
        'day' => [
            'id' => 'start-day',
        ]
      ]);
      /**/
			echo $this->Form->label('Course.finish', 'Fecha que finaliza el curso');
      /**/
      echo $this->Form->date('finish', [
        'minYear' => 2017,
        'value' => date('Y-m-d'),
        'empty' => [
            'year' => false,
            'month' => false,
            'day' => false,
        ],
        'day' => [
            'id' => 'finish-day',
        ]
      ]);
      /*<Input FILE*/
      $max_size_attachment = ($dlince_max_size_banners>=1048576)?round($dlince_max_size_banners/1048576,2).' MB':round($dlince_max_size_banners/1024,2).' KB';
      echo "<div class=\"input\">";
      echo $this->Form->label('banner', 'Adjuntar pancarta ('.$max_size_attachment.' máximo)');
      /*ini_get('upload_max_filesize').'/'.ini_get('post_max_size')*/
      echo $this->Form->file('banner');
      echo "<div class=\"error-message\">Archivo soportados: ".implode(', ',$dlince_type_banners).".</div>";
      echo "</div>";
      /*Input FILE>*/

      echo $this->Form->control('quota',['label'=>'Cupo límite del curso']);
      echo $this->Form->control('state_id', ['options' => $states,'label'=>'Estado del curso']);
			echo $this->Form->control('visible',['label'=>'¿El curso es visible?']);
  		echo $this->Form->button(
          __($this->Html->image(Configure::read('DLince.icon.save')).'<span>Agregar curso</span>'),
          ['class'=>'button', 'escape' => false]
        );     
		?>
  </fieldset>
  <?= $this->Form->end() ?>
</div>

<!-- CONTENIDO PRINCIPAL> -->

</section>
</div>
<!-- VISTA> -->
