<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<?php
if( ( ($this->request->session()->read('Auth.User'))!==null && ($this->request->session()->read('Auth.User.role.name'))!==null && $this->request->session()->read('Auth.User.role.name')=='administrator') ){
?>
<div class="menu-left">

<ul class="list-menu-left">
<!-- <ACCIONES -->
<li><?= $this->Html->link(__('Cursos'), ['action' => 'index'],['style'=>'font-weight:bold']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
<!-- ACCIONES> -->
</ul>

</section>
</div>
<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="courses index large-9 medium-8 columns content">

    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
              <th scope="col"><?= $this->Paginator->sort('id','Código') ?></th>
              <th scope="col"><?= $this->Paginator->sort('name','Nombre del curso') ?></th>
              <th scope="col"><?= $this->Paginator->sort('quota','Cupos') ?></th>
              <th scope="col"><?= $this->Paginator->sort('state_id','¿Activo?') ?></th>
              <th scope="col"><?= $this->Paginator->sort('type','Modalidad') ?></th>
              <th scope="col"><?= $this->Paginator->sort('start','Inicio - Fin') ?></th>
              <th scope="col"><?= $this->Paginator->sort('user_id','Creador') ?></th>
              <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course): ?>
            <tr>
                <td style="font-weight:bold;"><?= $this->Number->format($course->id) ?></td>
                <td style="font-weight:bold;"><?= $this->Html->link($course->name, ['controller' => 'Courses', 'action' => 'view', $course->id]) ?></td>
                <td><?= $this->Number->format($course->quota) ?></td>
                <td>
                  <?php
  									if(intval($course->state_id)==1){
  										echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
  									}else{
  										echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
  									}
  								?>
                </td>
                <td>
                  <?php
  									switch(intval($course->type)){
  										case 1:
                        echo 'Presencial'; break;
                        case 2:
                          echo 'Virtual'; break;
                          case 3:
                            echo 'Ambos'; break;
                            default:
                              echo '';
  									}
  								?>
                </td>
                <td><?= h($course->start->format('d/m')).' - '.h($course->finish->format('d/m Y')) ?></td>

                <td><?= $course->user->names ?></td>

                <td class="actions">
                <?php
              		echo $this->Html->link(
										$this->Html->image(Configure::read('DLince.icon.view'), ["alt" => __('View')]),
										['action' => 'view', $course->id],
										['escape' => false]
									);
									echo $this->Html->link(
										$this->Html->image(Configure::read('DLince.icon.edit'), ["alt" => __('Edit')]),
										['action' => 'edit', $course->id],
										['escape' => false]
									);
									echo $this->Form->postLink(
										$this->Html->image(Configure::read('DLince.icon.delete'), ["alt" => __('Delete')]),
										['action' => 'delete', $course->id],
										['escape' => false, 'confirm' => __('¿Esta seguro de eliminar el curso, {0}: {1}?', $course->id,$course->name)]
									);
								?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
<?php
}
?>
<!-- CONTENIDO PRINCIPAL> -->

</section>
</div>
<!-- VISTA> -->


<!-- Extra -->
<?php
  $total = $dlince_courses->count();
  $rows = ceil($total/3);
  $contador = 3;
  $pasadas = 0;
  if( $total>0 ){
    echo "\n<!-- <CURSOS -->";
?>
<div id="marketing" class="container">
    <?php foreach($dlince_courses as $course) {
      $pasadas++;
      if( $contador==3 ){
        echo "<div class='row'>";
        $contador = 0;
      }
      echo "\n<!-- <CURSO -->";
    ?>
    <div class="3u" style="margin-right: 5px; margin-bottom: 5px; padding:0px !important; ">
      <section class="course-block" style="width:280px !important;" >
        <header>
          <h2 class="course-name">
          <?php
          echo $this->Html->link($course->name, [
            'controller' => 'Courses',
            'action' => 'view',
            $course->id],['escape'=>false]);
          ?>
          </h2>
        </header>
        <?php
          echo "<p class=\"course-description\">";
          if( strlen($course->description)<=100)
          {
            echo $course->description;
          }
          else
          {
            echo substr($course->description,0,100).'...';
          }
          echo "</p>";
          /**/
          $types = array(1=>'Presencial',2=>'Virtual',3=>'Presencial y Virtual');
          echo "<p class=\"course-attribute\">";
          echo "<span class='dlince-label'>Modalidad: </span>".$types[$course->type];
          echo "</p>";
          echo "<p class=\"course-attribute\">";
          echo ($course->start==null)?'':"<span class='dlince-label'>Empieza: </span>".$course->start->format('d \d\e ').__($course->start->format('F')).$course->start->format(' \d\e\l Y');
          echo "</p>";
          /**/
          echo "<p class=\"course-attribute\">";
          echo ($course->finish==null)?'':"<span class='dlince-label'>Termina: </span>".$course->finish->format('d \d\e ').__($course->finish->format('F')).$course->finish->format(' \d\e\l Y');
          echo "</p>";
          /**/
          echo "<p class=\"course-image-block\" style=\"padding:0px;margin:0px;\">";
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
          echo $this->Html->link($this->Html->image($select_image, ['alt' => 'Pancarta','class' => 'course-image']),[
            'controller' => 'Courses',
            'action' => 'view',
            $course->id],['escape'=>false]);
          echo "</p>";
          /**/
          if( ($course->place!=null) )
          {
            echo "<p class=\"course-attribute\">";
            echo "<span class='dlince-label'>Lugar: </span>".$course->place;
            echo "</p>";
          }
          /**/
          if( ($course->destined!=null) )
          {
            echo "<p class=\"course-attribute\">";
            echo "<span class='dlince-label'>Dirigido a: </span>".$course->destined;
            echo "</p>";
          }
          /**/
          echo "<p class=\"course-attribute\">";
          echo "<span class='dlince-label'>Estado: </span>".$course->state['description'];
          echo "</p>";
          /**/
          echo "<p class=\"course-attribute\">";
          echo "<span class='dlince-label'>Vacantes: </span>".strval(intval($course->quota)-intval($course->total_participants));
          //Verifica que hay login que hay rol y que ese rol es un estudiante para que muestre un boton "Deseo inscrbirme ahora"
          if ( ($this->request->session()->read('Auth.User'))!==null && ($this->request->session()->read('Auth.User.role.name'))!==null && $this->request->session()->read('Auth.User.role.name')=='student' )
          {
            if( null!==$this->request->session()->read('Auth.User.courses') && in_array($course->id, $this->request->session()->read('Auth.User.courses')) )
            {
              echo ' (Eres participante)';
            }
          }
          echo "</p>";
        ?>
        <?php
          //Verifica que hay login que hay rol y que ese rol es un estudiante para que muestre un boton "Deseo inscrbirme ahora"
          if ( ($this->request->session()->read('Auth.User'))!==null && ($this->request->session()->read('Auth.User.role.name'))!==null && $this->request->session()->read('Auth.User.role.name')=='student' )
          {
            if( null!==$this->request->session()->read('Auth.User.courses') && in_array($course->id, $this->request->session()->read('Auth.User.courses')) )
            {
              echo $this->Html->link(
                'Acceder',[
                  'controller' => 'Courses',
                  'action' => 'view',
                  $course->id,
                  '_full' => false],[
                  'class'=>'button-to-enroll']
              );
            }else{
              echo $this->Html->link(
                'Saber más',[
                  'controller' => 'Courses',
                  'action' => 'view',
                  $course->id,
                  '_full' => false],[
                  'class'=>'button-know-plus']
              );
              echo $this->Html->link(
                'Inscribirme',[
                  'controller' => 'Courses',
                  'action' => 'register',
                  $course->id,
                  '_full' => false],[
                  'class'=>'button-to-enroll']
              );
            }
          }else{
            echo $this->Html->link(
            'Saber más',[
              'controller' => 'Courses',
              'action' => 'view',
              $course->id,
              '_full' => false],[
              'class'=>'button-know-plus']
            );
          }
          ?>
      </section>
    </div>
    <?php
      $contador++;
      if( $contador==3 || ($total-$pasadas==0) ){
        echo "</div>";
      }else{

      }
      echo "\n<!-- CURSO> -->";
      }//endforeach;
    ?>
</div>
<?php
  echo "\n<!-- CURSOS> -->";
  }//endif;
?>
<!-- /Extra -->
