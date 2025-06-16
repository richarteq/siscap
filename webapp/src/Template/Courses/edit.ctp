<?php
/**
  *
  */
?>
<div class="menu-left">

<ul class="list-menu-left">
<!-- <ACCIONES -->
<li><?= $this->Form->postLink(
        __('Eliminar'),
        ['action' => 'delete', $course->id],
        ['confirm' => __('¿Esta seguro de eliminar el curso, {0}: {1}?',$course->id,$course->name)]
    )
?></li>
<li><?= $this->Html->link(__('Cursos'), ['action' => 'index']) ?></li>
<!-- ACCIONES> -->
</ul>

</div>
<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="courses form large-9 medium-8 columns content">
    <?= $this->Form->create($course,['type' => 'file', 'onSubmit'=>"if(!confirm(\"¿Esta seguro de guardar los cambios a este curso?\")){return false;}",]) ?>
    <fieldset>
        <legend><?= __('Editando curso') ?></legend>
        <?php
        echo $this->Form->control('name',['label'=>'Nombre del curso']);
        $types = array(1=>'Presencial',2=>'Virtual',3=>'Presencial y Virtual');
        echo $this->Form->control('type', ['options' => $types,'label'=>'Modalidad del curso']);
        echo $this->Form->control('description',['label'=>'Descripción del curso']);
        /**/
        /*
        $schedules = $this->Courses->Schedules->find('all')
    			->select(['hour','day'])
    			->where(['course_id'=>$course->id])
          ->order(['id' => 'ASC']);
        */
        /*<Horario*/
        echo $this->Form->label(null, 'Horario');
        $hour= array(
          'es'=>'Hora',
        );
        $days = array(
          'es'=>array(
            'Hora',
            'Lunes',
            'Martes',
            'Miércoles',
            'Jueves',
            'Viernes',
            'Sábado',
            'Domingo'
          )
        );
        $start_time = 7; // start hours
        $lenght_time = 60; // minutes
        $top_time = 20; // finish hour
        $step_time = round(($lenght_time/60),2);
        //$step_time = (($lenght_time/60)<1)?$lenght_time:$lenght_time/60; // pass hour
        $languaje = 'es'; // default language
        echo "<table class=\"schedule\">";
        $k=-1;
        for( $i=$start_time-$step_time;$i<$top_time;$i=$i+$step_time )
        {
          echo "<tr>";
          foreach( $days[$languaje] as $index=>$day )
          {
            if( ($days[$languaje][0]==$hour[$languaje]) && $i==($start_time-$step_time) && $index==0 && $day==$days[$languaje][0] ) // Hour in default language
            {
              echo "<th>".$day."</th>";
            }
            elseif( ($days[$languaje][0]==$hour[$languaje]) && $index==0 && $day==$days[$languaje][0] ) //hour:start-time - +step_time
            {
              $hours1 = floor($i);
              $minutes1 = round(($i - $hours1)*60,0);
              $hours1 = str_pad($hours1, 2, "0", STR_PAD_LEFT).':'.str_pad($minutes1, 2, "0", STR_PAD_LEFT);
              //
              $hours2 = floor($i+$step_time);
              $minutes2 = round((($i+$step_time) - $hours2)*60,0);
              $hours2 = str_pad($hours2, 2, "0", STR_PAD_LEFT).':'.str_pad($minutes2, 2, "0", STR_PAD_LEFT);
              //
              echo "<td class=\"step-time\">".$hours1.' - '.$hours2."</td>";
              //echo self::strFormatHours($i).' - '.self::strFormatHours($i+$step_time);
            }
            elseif( $i==($start_time-$step_time) ) // days of the week
            {
              switch($day){
  							case 'Sábado':
  								echo "<th style=\"color:green\">".$day."</th>"; break;
  							case 'Domingo':
  								echo "<th style=\"color:red\">".$day."</th>"; break;
  							default:
  								echo "<th style=\"color:blue\">".$day."</th>"; break;
  						}
            }
            else // alls the others cells
            {
              $k++;
              $checked = false;
              foreach($course->schedules as $schedule){
                if( $this->Number->precision(floatval($schedule->hour),2)==$this->Number->precision(floatval($i),2) && intval($schedule->day)==intval($index) ){
                  $checked = true;
                }
              }
              echo $this->Form->input('schedule['.$k.']',[
                'type' => 'checkbox',
                'checked' => $checked,

                'templates' => [
                  'inputContainer' => '<td class="hourDay">{{content}}</td>'
                ],
                'label'=>false,
                'value' => $this->Number->precision($i, 2).','.strval($index),
              ]);
            }
          }
          echo "</tr>";
        }
        echo "</table>";
        /*Horario>*/

        echo $this->Form->control('place',['label'=>'Lugar']);
        echo $this->Form->control('destined',['label'=>'Dirigido a']);
        echo $this->Form->label('start', 'Fecha que inicia el curso');
        /**/
        echo $this->Form->date('start', [
          'minYear' => 2017,
          //'value' => date('Y-m-d'),
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
  			echo $this->Form->label('finish', 'Fecha que finaliza el curso');
        /**/
        echo $this->Form->date('finish', [
          //'minYear' => 2017,
          //'value' => date('Y-m-d'),
          'empty' => [
              'year' => false,
              'month' => false,
              'day' => false,
          ],
          /*'day' => [
              'id' => 'finish-day',
          ]*/
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
        echo$this->Form->button(__('Grabar cambios'),['class'=>'button'])
      ?>
    </fieldset>
    <?= $this->Form->end() ?>
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>