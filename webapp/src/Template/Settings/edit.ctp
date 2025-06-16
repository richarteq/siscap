<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<div class="menu-left">
<ul class="list-menu-left">
<!-- <ACCIONES -->
<li><?= $this->Html->link(__('Ver'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Editar'), ['action' => 'edit'],['style'=>'font-weight:bold']) ?></li>
<!-- ACCIONES> -->
</ul>
</section>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="settings form large-9 medium-8 columns content">
    <?= $this->Form->create($setting) ?>
    <fieldset>
        <legend><?= __('Editar configuración') ?></legend>
        <?php
            
            echo $this->Form->control('folder',['label'=>'Directorio para subída de archivos']);
            echo $this->Form->control('typeFiles',['label'=>'Tipos de archivos soportados para súbida','style'=>'width:750px']);
            echo $this->Form->control('typeBanners',['label'=>'Tipos de pancartas soportadas para súbida']);
            echo $this->Form->control('limitsTime',['label'=>'Lista de tiempos disponibles para rendir evaluaciones']);
            /**/
            echo $this->Form->control('maxSizeFiles', [
                'label'=>'Máximo tamaño para envio de archivos en bytes', 
                'templates' => [
                  'inputContainer' => '<div class="input select required">{{content}}<div class=\"error-message\">Un Megabyte (MB) equivale a 1048576 bytes</div></div>'
                ]
              ]); 
            /**/
            echo $this->Form->control('maxSizeBanners', [
                'label'=>'Máximo tamaño para envio de pancartas en bytes', 
                'templates' => [
                  'inputContainer' => '<div class="input select required">{{content}}<div class=\"error-message\">1 Kilobyte (KB) equivale a 1024 bytes</div></div>'
                ]
              ]); 
            /**/
            echo $this->Form->control('emailFrom',['label'=>'Correo electrónico que envía los mensajes']);
            echo $this->Form->control('nameEmailFrom',['label'=>'Nombre del correo electrónico que envía los mensajes']);
            echo $this->Form->control('sendEmail',['label'=>'¿Enviar correos electrónicos?']);
            echo $this->Form->control('sendEmailUserAdd',['label'=>'¿Enviar correos electrónicos al agregar usuarios?']);
            echo $this->Form->control('sendEmailUserEdit',['label'=>'¿Enviar correos electrónicos al editar usuarios?']);
            echo $this->Form->control('sendEmailUserDisabled',['label'=>'¿Enviar correos electrónicos al desactivar usuarios?']);
            echo $this->Form->control('sendEmailCourseAdd',['label'=>'¿Enviar correos electrónicos al agregar cursos?']);
            echo $this->Form->control('sendEmailInstructorAdd',['label'=>'¿Enviar correos electrónicos al agregar instructores?']);
            echo $this->Form->control('sendEmailParticipantAdd',['label'=>'¿Enviar correos electrónicos al agregar participantes?']);
            echo $this->Form->control('sendEmailParticipantsComunicate',['label'=>'¿Enviar correos electrónicos a participantes de cursos?']);
            

            echo $this->Form->button(
          __($this->Html->image(Configure::read('DLince.icon.save')).'<span>Guardar configuración</span>'),
          ['class'=>'button', 'escape' => false]
        );        
    ?>
    </fieldset>
    <?= $this->Form->end() ?>
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>
