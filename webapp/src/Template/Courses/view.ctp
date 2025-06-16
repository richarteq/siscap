<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<div class="menu-left">
<ul class="list-menu-left">
<!-- <ACCIONES -->
<?php if( ($this->request->session()->read('Auth.User'))!=null && $this->request->session()->read('Auth.User.role.name')=='administrator'): ?>
<li><?= $this->Html->link(__('Editar'), ['action' => 'edit', $course->id]) ?></li>
<li><?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $course->id], ['confirm' => __('¿Esta seguro de eliminar este curso?')]) ?> </li>
<li><?= $this->Html->link(__('Cursos'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
<?php endif; ?>
<!-- ACCIONES> -->
</ul>
</section>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="courses view large-9 medium-8 columns content">

	<table class="vertical-table">
    <tr>
      <th scope="row"><?= __('Código del curso') ?></th>
      <td style="font-weight:bold;"><?= $this->Number->format($course->id) ?></td>
    </tr>
		<tr>
      <th scope="row"><?= __('Nombre del curso') ?></th>
      <td style="font-weight:bold;"><?= $course->name ?></td>
    </tr>
		<tr>
      <th scope="row"><?= __('Lugar donde se desarrollará') ?></th>
      <td><?= ( $course->place!=null )?$course->place:'' ?></td>
    </tr>
		<tr>
      <th scope="row"><?= __('Destinado a') ?></th>
      <td><?= ( $course->destined!=null )?$course->destined:'' ?></td>
    </tr>
		<tr>
      <th scope="row"><?= __('Modalidad del curso') ?></th>
      <td>
				<?php
					switch( intval($course->type) )
					{
						case 1:
							echo "Presencial"; break;
						case 2:
							echo "Virtual"; break;
						case 3:
							echo "Ambos"; break;
						default:
							echo "";
					}
				?>
			</td>
    </tr>
    
    <tr>
      <th scope="row"><?= __('Cupos habilitados') ?></th>
      <td><?= $this->Number->format($course->quota) ?></td>
    </tr>

    <tr>
      <th scope="row"><?= __('Cupos disponibles') ?></th>
      <td><?= $this->Number->format($course->quota) ?></td>
    </tr>		

		<tr>
      <th scope="row"><?= __('¿El curso esta activo?') ?></th>
      <td colspan="2">
        <?php
          if( intval($course->state_id) )
          {
            echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
          }
          else
          {
            echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
          }
        ?>
      </td>
    </tr>
    <tr>
      <th scope="row"><?= __('Inicio del curso') ?></th>
			<td>
				<?= ($course->start==null)?'':'Desde el '.$course->start->format('d \d\e ').__($course->start->format('F')).$course->start->format(' \d\e\l Y') ?>				
			</td>
    </tr>
    <tr>
      <th scope="row"><?= __('Fin del curso') ?></th>
      <td>
      	<?= ($course->finish==null)?'':'Hasta el '.$course->finish->format('d \d\e ').__($course->finish->format('F')).$course->finish->format(' \d\e\l Y') ?>      		
    	</td>
    </tr>
		<tr>
      <th scope="row"><?= __('¿El curso es visible?') ?></th>
      <td colspan="2">
        <?php
          if( intval($course->visible) )
          {
            echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
          }
          else
          {
            echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
          }
        ?>
      </td>
    </tr>
		
		<?php
			if ( ($this->request->session()->read('Auth.User'))!==null && ($this->request->session()->read('Auth.User.role.name'))!==null && $this->request->session()->read('Auth.User.role.name')=='administrator' ) :  		
		?>
		<tr>
      <th scope="row"><?= __('Creador') ?></th>
      <td><?= $course->user->full_name_and_email ?></td>
    </tr>
  	<?php endif; ?>

		<tr>
      <th scope="row"><?= __('Fecha de creación del curso') ?></th>
      <td colspan="2"><?= $course->created->format('d \d\e ').__($course->created->format('F')).$course->created->format(' \d\e\l Y \a \l\a\s H:i:s A') ?>
      </td>
    </tr>
  </table>

  <!-- -->
	<!-- <DESCRIPCION -->
	<!-- -->
	<?php if( $course->description!=null || $course->banner!=null ): ?>
		<div class="description">
	    <h4><?= __('Descripción del curso') ?></h4>
	    <p style="float:left; height: auto;">
	    	<?php
	    		$images_banners = array('training01.jpg','training02.jpg','training03.jpg','training04.jpg');
          $select_image = $images_banners[rand(0,3)];
					/*URL del banner*/
          if( $course->banner!=null )
          {
            $select_image = $this->Url->build([
              "controller" => "Courses",
              "action" => "download-banner",
              $course->id,$course->banner
            ],true);
          }
          /**/
          echo $this->Html->image($select_image, ['alt' => 'Pancarta','class' => 'course-image', 'style'=>'float:left;']);
          
					/**/
				?>
	    	<span style="float:left; margin-left:10px; margin-top:20px;"><?= $course->description ?></span>
    	</p>
	  </div>
  <?php endif;?>

  <!-- -->
	<!-- <HORARIO -->
	<!-- -->
	<?php if (!empty($course->schedules)): ?>
		<div class="description">
      <h4><?= __('Horario del curso') ?></h4>
      <p>
				<?php
					/*<Horario*/
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
	        echo "<table class=\"schedule-only-view\">";
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
	              $checked = "<td class=\"hourDay\"></td>";
	              foreach($course->schedules as $schedule){
	                if( $this->Number->precision(floatval($schedule->hour),2)==$this->Number->precision(floatval($i),2) && intval($schedule->day)==intval($index) ){
	                  $checked = "<td class=\"hourDay checked\" style=\"font-weight:bold; font-size:18px;\">x</td>";
	                }
	              }
								echo $checked;
								/*
	              echo $this->Form->input('schedule['.$k.']',[
	                'type' => 'checkbox',
	                'checked' => $checked,

	                'templates' => [
	                  'inputContainer' => '<td class="hourDay">{{content}}</td>'
	                ],
	                'label'=>false,
	                'value' => $this->Number->precision($i, 2).','.strval($index),
	              ]);*/
	            }
	          }
	          echo "</tr>";
	        }
	        echo "</table>";
	        /*Horario>*/
				?>
			</p>
    </div>
	<?php endif; ?>
	
	<!-- -->
	<!-- <ROW -->
	<!-- -->
	<div class="row">
  	<?php
  		//Verifica que hay login que hay rol y que ese rol es un estudiante para que muestre un boton "Deseo inscrbirme ahora"
  		if ( ($this->request->session()->read('Auth.User'))!==null && ($this->request->session()->read('Auth.User.role.name'))!==null && $this->request->session()->read('Auth.User.role.name')=='student' )
  		{
				if(intval($register)==0)
				{
					echo $this->Form->create(null, [
						'url' => ['controller' => 'Courses', 'action' => 'register',$course->id]
						]);
					echo $this->Form->button(__('Deseo inscribirme en este curso'),['class'=>'button']);
					echo $this->Form->end();
				}
			}elseif( $this->request->session()->read('Auth.User')==null ){
				echo "<p style=\"font-weight:normal;\">Si Ud. ya es estudiante de SISCAP, inicie sesión con su correo electrónico y su contraseña SISCAP.</p>";
				echo "<p style=\"font-weight:normal;\">De otro modo Solicite ser estudiante SISCAP, en la Oficina de Capacitación.</p>";
				echo "<p style=\"clear:left\">";
				echo $this->Html->link(
					'Iniciar sesión',[
						'controller' => 'Users',
						'action' => 'login',
						'_full' => false
					],
					['class'=>'button']
				);
				echo "</p>";
			}
		?>
  </div>

	<?php
	if( ( isset($dlince_mycourses) &&  in_array(intval($course->id), $dlince_mycourses) ) || ( ($this->request->session()->read('Auth.User'))!==null && ($this->request->session()->read('Auth.User.role.name'))!==null && $this->request->session()->read('Auth.User.role.name')=='administrator') ):
	?>

		<!-- -->
		<!-- <EVALUACIONES -->
		<!-- -->
    <?php if (!empty($course->evaluations)): ?>
    	<div class="related">
        <h4><?= __('Evaluaciones del curso') ?></h4>        
        <table cellpadding="0" cellspacing="0" class="evaluations-block">
					<?php foreach ($course->evaluations as $evaluations): ?>
						<tr>
							<td style="border:none; background-color:#fae7ec;" colspan="2">
							<?php if( $evaluations->title!=null ): ?>
								<?= "<span style=\"font-weight:bold;\">".$evaluations->title.'</span>' ?>
							<?php endif; ?>
							<?php if( $evaluations->description!==null ): ?>
								<?= ' : '.$evaluations->description ?>
							<?php endif; ?>
							<?php if( $evaluations->title!=null || $evaluations->description!==null ): ?>
							<br/>
							<?php endif; ?>
							<?= "<span style=\"font-weight:bold;\">Enviado</span> : El ".$evaluations->created->format('d \d\e ').__($evaluations->created->format('F')).$evaluations->created->format(' \d\e\l Y \a \l\a\s H:i:s') ?>
							</td>
						</tr>
						<tr>
						<?php if ( $evaluations->filename !=null ):?>
					
							<?php
							$icon = 'DLince.icon.download';
							switch( substr($evaluations->filename, strrpos($evaluations->filename, ".")+1) )
							{
								case 'pdf':
									$icon = 'DLince.icon.pdf'; break;
								case 'txt':
									$icon = 'DLince.icon.txt'; break;
								case 'rar':
									$icon = 'DLince.icon.rar'; break;
								case '7zip':
									$icon = 'DLince.icon.7zip'; break;
								case 'zip':
									$icon = 'DLince.icon.zip'; break;
								case 'jpeg':
									$icon = 'DLince.icon.jpeg'; break;
								case 'jpg':
									$icon = 'DLince.icon.jpg'; break;
								case 'gif':
									$icon = 'DLince.icon.gif'; break;
								case 'png':
									$icon = 'DLince.icon.png'; break;
								case 'pptx':
									$icon = 'DLince.icon.powerpoint'; break;
								case 'xlsx':
									$icon = 'DLince.icon.excel'; break;
								case 'docx':
									$icon = 'DLince.icon.word'; break;
								case 'odp':
									$icon = 'DLince.icon.impress'; break;
								case 'odc':
									$icon = 'DLince.icon.calc'; break;
								case 'odt':
									$icon = 'DLince.icon.writer'; break;
								default:
									$icon = 'DLince.icon.download';
							}
							?>
						<td class="icon-file" style="border:none; background-color:#f2f2f2;">
						<?php
							echo $this->Html->link(
								$this->Html->image(Configure::read($icon), ["alt" => __('Archivo')]),
								['controller'=>'Evaluations','action' => 'download', $course->id, $evaluations->id, $evaluations->filename],
								['escape' => false,'target'=>'_blank']
							);
						?>
						</td>
						<td style="border:none; background-color:#f2f2f2;">
						<?php
							echo $this->Html->link(
								$evaluations->filename,
								['controller'=>'Evaluations','action' => 'download', $course->id, $evaluations->id, $evaluations->filename],
								['escape' => false,'target'=>'_blank']
							);
						?>
						</td>
						
					<?php endif; ?>

					</tr>
					<tr>
						<td style="border:1px solid #E37795; background-color:#f2f2f2;" colspan="2">						
							<?= "<span style=\"font-weight:bold;\">Envíos desde : </span> El ".$evaluations->start->format('d \d\e ').__($evaluations->start->format('F')).$evaluations->start->format(' \d\e\l Y \d\e\s\d\e \l\a\s H:i:s') ?>
							<?= "<span style=\"font-weight:bold;\">Hasta : </span> El ".$evaluations->finish->format('d \d\e ').__($evaluations->finish->format('F')).$evaluations->finish->format(' \d\e\l Y \h\a\s\t\a \l\a\s H:i:s') ?>			
							<?php
								/**/
								$questionsN = count($evaluations->questions);
								$answersN = 0;
								$qualificationT = null;
								$qualificationT = 0;
								foreach($evaluations->questions as $question)
								{
									$answersN = $answersN + count($question->answers);									
									foreach($question->answers as $answer)
									{
										$qualificationT = $qualificationT + floatval($answer->qualification);
									}
								}
								/**/
							?>
							<?php if( $questionsN>0 && $answersN==0 ) :?>
								<!-- <Formulario -->
								<form id="form-evaluation">
							    <fieldset>
							      <legend>Evaluación</legend>							    	
							    		<?php
							    		/**/        
							        echo "<h2 class=\"title-evaluation\">".$evaluations->title."</h2>";
						         	echo "<ul class=\"description-evaluation\">";						         	
							        echo "<li style=\"margin-bottom:0px;\" ><span class=\"label\">Duración </span>: <span class=\"text\">".$evaluations->time_limit." minutos</span></li>";							        
							        echo ($evaluations->description==null)?"":"<li style=\"margin-bottom:0px;\"><span class=\"label\">Descripción </span>: <span class=\"text\">".$evaluations->description."</span></li>";
							        echo "</ul>";
							        echo "<hr>";
							        /**/
							    		?>
							    		<div id="evaluation-questions-choises" style="heigth;auto; font-family:'Montserrat','Helvetica Neue',helvetica,arial,sans-serif;font-size:12pt;">
							    			
							    		</div>
							    </fieldset>
							  </form>
							  <!-- Formulario> -->							  
						  <?php else: ?>
						  	<?php if( $answersN>0 ) :?>
									<br/>
									<?= "<span style=\"font-weight:bold; color:green;\">Ya hay un envío registrado</span>" ?>
								<?php endif; ?>
								<?php if( $qualificationT!=null ) : ?>
									<br/>
									<?= "<span style=\"font-weight:bold; color:blue;\">Calificación : </span><span style=\"font-weight:bold;\">".$qualificationT."</span>" ?>
							  <?php endif; ?>
							<?php endif; ?>
							
						</td>
					</tr>
					<tr><td colspan="2" style="background-color:#EFEDFC; border:none; height:25px;"></td></tr>

					<?php endforeach; ?>
        </table>
        
	    </div>
	  <?php endif; ?>

		<!-- -->
		<!-- <TAREAS -->
		<!-- -->
    <?php if (!empty($course->tasks)): ?>
    	<div class="related">
        <h4><?= __('Tareas del curso') ?></h4>        
        <table cellpadding="0" cellspacing="0" class="tasks-block">
					<?php foreach ($course->tasks as $tasks): ?>
						<tr>
							<td style="border:none; background-color:#fae7ec;" colspan="2">
							<?php if( $tasks->title!=null ): ?>
								<?= "<span style=\"font-weight:bold;\">".$tasks->title.'</span>' ?>
							<?php endif; ?>
							<?php if( $tasks->description!==null ): ?>
								<?= ' : '.$tasks->description ?>
							<?php endif; ?>
							<?php if( $tasks->title!=null || $tasks->description!==null ): ?>
							<br/>
							<?php endif; ?>
							<?= "<span style=\"font-weight:bold;\">Enviado</span> : El ".$tasks->created->format('d \d\e ').__($tasks->created->format('F')).$tasks->created->format(' \d\e\l Y \a \l\a\s H:i:s') ?>
							</td>
						</tr>
						<tr>
						<?php if ( $tasks->filename !=null ):?>
					
							<?php
							$icon = 'DLince.icon.download';
							switch( substr($tasks->filename, strrpos($tasks->filename, ".")+1) )
							{
								case 'pdf':
									$icon = 'DLince.icon.pdf'; break;
								case 'txt':
									$icon = 'DLince.icon.txt'; break;
								case 'rar':
									$icon = 'DLince.icon.rar'; break;
								case '7zip':
									$icon = 'DLince.icon.7zip'; break;
								case 'zip':
									$icon = 'DLince.icon.zip'; break;
								case 'jpeg':
									$icon = 'DLince.icon.jpeg'; break;
								case 'jpg':
									$icon = 'DLince.icon.jpg'; break;
								case 'gif':
									$icon = 'DLince.icon.gif'; break;
								case 'png':
									$icon = 'DLince.icon.png'; break;
								case 'pptx':
									$icon = 'DLince.icon.powerpoint'; break;
								case 'xlsx':
									$icon = 'DLince.icon.excel'; break;
								case 'docx':
									$icon = 'DLince.icon.word'; break;
								case 'odp':
									$icon = 'DLince.icon.impress'; break;
								case 'odc':
									$icon = 'DLince.icon.calc'; break;
								case 'odt':
									$icon = 'DLince.icon.writer'; break;
								default:
									$icon = 'DLince.icon.download';
							}
							?>
						<td class="icon-file" style="border:none; background-color:#f2f2f2;">
						<?php
							echo $this->Html->link(
								$this->Html->image(Configure::read($icon), ["alt" => __('Archivo')]),
								['controller'=>'Tasks','action' => 'download', $course->id, $tasks->id, $tasks->filename],
								['escape' => false,'target'=>'_blank']
							);
						?>
						</td>
						<td style="border:none; background-color:#f2f2f2;">
						<?php
							echo $this->Html->link(
								$tasks->filename,
								['controller'=>'Tasks','action' => 'download', $course->id, $tasks->id, $tasks->filename],
								['escape' => false,'target'=>'_blank']
							);
						?>
						</td>
						
					<?php endif; ?>

					</tr>
					<tr>
						<td style="border:1px solid #E37795; background-color:#f2f2f2;" colspan="2">						
							<?= "<span style=\"font-weight:bold;\">Envíos desde : </span> El ".$tasks->start->format('d \d\e ').__($tasks->start->format('F')).$tasks->start->format(' \d\e\l Y \d\e\s\d\e \l\a\s H:i:s') ?>
							<?= "<span style=\"font-weight:bold;\">Hasta : </span> El ".$tasks->finish->format('d \d\e ').__($tasks->finish->format('F')).$tasks->finish->format(' \d\e\l Y \h\a\s\t\a \l\a\s H:i:s') ?>
							
							<?php if( count($tasks->presentations)==0 ) :?>
								<?php if( $tasks->start->format('Y-m-d H:i:s')<=date('Y-m-d H:i:s') ) :?>
									<!-- <Formulario -->
									<?= $this->Form->create(null,['type' => 'file', 'url'=>['controller'=>'Presentations', 'action'=>'add2']]) ?>
								  <fieldset>
								    <legend><?= __('Presentar tarea') ?></legend>
								    <?php
								      echo $this->Form->hidden('course_id', ['value' => $tasks->course_id]);
								      echo $this->Form->hidden('task_id', ['value' => $tasks->id]);						      
								      /* <Input FILE */
								      $max_size_attachment = ($dlince_max_size_files>=1048576)?round($dlince_max_size_files/1048576,2).' MB':round($dlince_max_size_files/1024,2).' KB';
								      echo "<div class=\"input required\">";
								      echo $this->Form->label('file', 'Adjuntar archivo ('.$max_size_attachment.' máximo)');
								      echo $this->Form->file('file');
								      echo "<div class=\"error-message\">Archivo soportados : ".implode(', ',$dlince_type_files).".</div>";
								      echo "</div>";
								      /* Input FILE> */
								      
								      echo $this->Form->button(
								              $this->Html->image(Configure::read('DLince.icon.save')).'<span>Presentar tarea</span>',
								        ['class'=>'button', 'escape' => false]
								          );        
								        ?>
								  </fieldset>
								  <?= $this->Form->end() ?>
								  <!-- Formulario> -->
								<?php endif; ?>
							<?php else: ?>
								<br/>
								<?= "<span style=\"font-weight:bold; color:green;\">Ya hay un envío registrado : </span> Realizado el ".$tasks->presentations[0]->created->format('d \d\e ').__($tasks->presentations[0]->created->format('F')).$tasks->presentations[0]->created->format(' \d\e\l Y \a \l\a\s H:i:s') ?>
								<?php if($tasks->presentations[0]->qualification!==null ) : ?>
									<br/>
									<?= "<span style=\"font-weight:bold; color:blue;\">Calificación : </span><span style=\"font-weight:bold;\">".$tasks->presentations[0]->qualification."</span>" ?>
								<?php endif; ?>
							<?php endif; ?>
							<!-- Formulario> -->
						</td>
					</tr>
					<tr><td colspan="2" style="background-color:#EFEDFC; border:none; height:25px;"></td></tr>

					<?php endforeach; ?>
        </table>
        
    </div>
  <?php endif; ?>

  <!-- -->
	<!-- <ARCHIVOS -->
	<!-- -->
  <?php if (!empty($course->files)): ?>
		<div class="related">
      <h4><?= __('Archivos del curso') ?></h4>
      <table cellpadding="0" cellspacing="0" class="files-block">
				<?php foreach ($course->files as $files): ?>
					<tr>
						<td style="border:none; background-color:#fae7ec;" colspan="2">
							<?php if( $files->title!=null ): ?>
								<?= "<span style=\"font-weight:bold;\">".$files->title.'</span>' ?>
							<?php endif; ?>
							<?php if( $files->description!==null ): ?>
								<?= ' : '.$files->description ?>
							<?php endif; ?>
							<?php if( $files->title!=null || $files->description!==null ): ?>
							<br/>
							<?php endif; ?>
							<?= "<span style=\"font-weight:bold;\">Enviado</span> : El ".$files->created->format('d \d\e ').__($files->created->format('F')).$files->created->format(' \d\e\l Y \a \l\a\s H:i:s') ?>
						</td>
					</tr>
					<tr>
						<?php
							$icon = 'DLince.icon.download';
							switch( substr($files->src, strrpos($files->src, ".")+1) )
							{
								case 'pdf':
									$icon = 'DLince.icon.pdf'; break;
								case 'txt':
									$icon = 'DLince.icon.txt'; break;
								case 'rar':
									$icon = 'DLince.icon.rar'; break;
								case '7zip':
									$icon = 'DLince.icon.7zip'; break;
								case 'zip':
									$icon = 'DLince.icon.zip'; break;
								case 'jpeg':
									$icon = 'DLince.icon.jpeg'; break;
								case 'jpg':
									$icon = 'DLince.icon.jpg'; break;
								case 'gif':
									$icon = 'DLince.icon.gif'; break;
								case 'png':
									$icon = 'DLince.icon.png'; break;
								case 'pptx':
									$icon = 'DLince.icon.powerpoint'; break;
								case 'xlsx':
									$icon = 'DLince.icon.excel'; break;
								case 'docx':
									$icon = 'DLince.icon.word'; break;
								case 'odp':
									$icon = 'DLince.icon.impress'; break;
								case 'odc':
									$icon = 'DLince.icon.calc'; break;
								case 'odt':
									$icon = 'DLince.icon.writer'; break;
								default:
									$icon = 'DLince.icon.download';
							}
						?>
						<td class="icon-file" style="border:1px solid #E37795; background-color:#f2f2f2;">
							<?php
								echo $this->Html->link(
									$this->Html->image(Configure::read($icon), ["alt" => __('Archivo')]),
									['controller'=>'Files','action' => 'download', $course->id, $files->id, $files->src],
									['escape' => false,'target'=>'_blank']
								);
							?>
						</td>
						<td style="border:1px solid #E37795; background-color:#f2f2f2;">
							<?php
								echo $this->Html->link(
									$files->src,
									['controller'=>'Files','action' => 'download', $course->id, $files->id, $files->src],
									['escape' => false,'target'=>'_blank']
								);
							?>
						</td>
					</tr>
					<tr><td colspan="2" style="background-color:#EFEDFC; border:1px solid #E37795; height:25px;"></td></tr>
				<?php endforeach; ?>
    	</table>        
  	</div>
  <?php endif; ?>

  <!-- -->
	<!-- <VIDEOS -->
	<!-- -->
  <?php if (!empty($course->videos)): ?>
		<div class="related">
        <h4><?= __('Videos del curso') ?></h4>        
        <table cellpadding="0" cellspacing="0" class="videos-block">

            <?php foreach ($course->videos as $videos): ?>
							<?php
								$video = 'video';
								if(  strpos($videos->url,'youtube.com') ){
									$video = 'youtube';
								}elseif(  strpos($videos->url,'vimeo.com') ){
									$video = 'vimeo';
								}
							?>
							<tr>
								<td style="border:none; background-color:#fae7ec;">
								<?php if( $videos->title!=null ){ ?>
									<?= "<span style=\"font-weight:bold;\">".$videos->title.'</span>' ?>
								<?php } ?>
								<?php if( $videos->description!==null ){ ?>
									<?= ' : '.$videos->description ?>
									<br/>
								<?php } ?>
								<a target="_blank" href="<?= trim($videos->url) ?>"><?= $this->Html->image(Configure::read('DLince.icon16.'.$video), ["alt" => __('Video'),'style'=>'margin-right:5px;']).trim($videos->url) ?></a>
								<?= "<br/><span style=\"font-weight:bold;\">Enviado</span> : El ".$videos->created->format('d \d\e ').__($videos->created->format('F')).$videos->created->format(' \d\e\l Y \a \l\a\s H:i:s') ?>
								</td>
							</tr>
						<tr>
              <td style="border:1px solid #E37795; background-color:#f2f2f2;">
							<?php
								switch($video)
								{
									case 'youtube':
										$token = '/watch?v=';
										$search = strrpos($videos->url, $token); 
										if( $search!=false )
										{
											$start = $search + strlen($token);
											$finish = strrpos($videos->url, "&");
											if( $finish==false )
											{
												$finish = strlen($videos->url);
											}
											echo "<iframe width=\"" . $videos->width . "\" height=\"" . $videos->height . "\" src=\"https://www.youtube.com/embed/" . substr($videos->url, $start, $finish-$start) . "\" \"allowfullscreen></iframe>";
										}
										else
										{
											echo "<a target=\"_blank\" href=\"" . trim($videos->url) ."\">" .
											$this->Html->image(Configure::read('DLince.icon256.'.$video), ["alt" => __('Video'),'style'=>'margin-right:5px;']) . "</a>";
										}
									break;
									case 'vimeo':
										$token = '/';
										$search = strrpos($videos->url, $token); 
										if( $search!=false )
										{
											$start = $search + strlen($token);
											$finish = strrpos($videos->url, "&");
											if( $finish==false )
											{
												$finish = strlen($videos->url);
											}
											echo "<iframe src=\"https://player.vimeo.com/video/" . substr($videos->url, $start, $finish-$start) . 
											"\" width=\"" . $videos->width . "\" height=\"" . $videos->height . "\" frameborder=\"0\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";									
										}
										else
										{
											echo "<a target=\"_blank\" href=\"" . trim($videos->url) ."\">" .
											$this->Html->image(Configure::read('DLince.icon256.'.$video), ["alt" => __('Video'),'style'=>'margin-right:5px;']) . "</a>";
										}
									break;
									default:
										echo "<a target=\"_blank\" href=\"" . trim($videos->url) ."\">" .
											$this->Html->image(Configure::read('DLince.icon256.'.$video), ["alt" => __('Video'),'style'=>'margin-right:5px;']) . "</a>";
								}
							?>
							</td>
						</tr>
						<tr><td colspan="2" style="background-color:#EFEDFC; border:none; height:25px;"></td></tr>
            <?php endforeach; ?>
        </table>
        
    </div>
  <?php endif; ?>

  <!-- -->
	<!-- <ENCUESTAS -->
	<!-- -->
  <?php if (!empty($course->polls)): ?>
   <div class="related">
      <h4><?= __('Encuestas') ?></h4>
      
        <table cellpadding="0" cellspacing="0">
          <tr>
            <th scope="col"><?= __('Id') ?></th>
            <th scope="col"><?= __('Title') ?></th>
            <th scope="col"><?= __('Description') ?></th>
            <th scope="col"><?= __('State') ?></th>
            <th scope="col"><?= __('User Id') ?></th>
            <th scope="col"><?= __('Course Id') ?></th>
            <th scope="col"><?= __('Created') ?></th>
            <th scope="col"><?= __('Modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
          </tr>
          <?php foreach ($course->polls as $polls): ?>
          <tr>
            <td><?= h($polls->id) ?></td>
            <td><?= h($polls->title) ?></td>
            <td><?= h($polls->description) ?></td>
            <td><?= h($polls->state) ?></td>
            <td><?= h($polls->user_id) ?></td>
            <td><?= h($polls->course_id) ?></td>
            <td><?= h($polls->created) ?></td>
            <td><?= h($polls->modified) ?></td>
            <td class="actions">
              <?= $this->Html->link(__('View'), ['controller' => 'Polls', 'action' => 'view', $polls->id]) ?>
              <?= $this->Html->link(__('Edit'), ['controller' => 'Polls', 'action' => 'edit', $polls->id]) ?>
              <?= $this->Form->postLink(__('Delete'), ['controller' => 'Polls', 'action' => 'delete', $polls->id], ['confirm' => __('Are you sure you want to delete # {0}?', $polls->id)]) ?>
            </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
    </div>
  <?php endif; ?>
<?php endif; ?>
		
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>
