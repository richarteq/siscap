<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<div class="menu-left">
<ul class="list-menu-left">
<!-- <ACCIONES -->
<li><?= $this->Html->link(__('Ver'), ['action' => 'index'],['style'=>'font-weight:bold']) ?></li>
<li><?= $this->Html->link(__('Editar'), ['action' => 'edit']) ?></li>
<!-- ACCIONES> -->
</ul>
</section>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="settings view large-9 medium-8 columns content">
    
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Directorio para subída de archivos') ?></th>
            <td><?= h($setting->folder) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipos de archivos soportados para súbida') ?></th>
            <td><?= h($setting->typeFiles) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipos de pancartas soportadas para súbida') ?></th>
            <td><?= h($setting->typeBanners) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lista de tiempos disponibles para rendir evaluaciones') ?></th>
            <td><?= h($setting->limitsTime) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Máximo tamaño para envio de archivos en bytes') ?></th>
            <td><?= h($setting->maxSizeFiles) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Máximo tamaño para envio de pancartas en bytes') ?></th>
            <td><?= h($setting->maxSizeBanners) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Correo electrónico que envía los mensajes') ?></th>
            <td><?= h($setting->emailFrom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre del correo electrónico que envía los mensajes') ?></th>
            <td><?= h($setting->nameEmailFrom) ?></td>
        </tr>
        
        <tr>
            <th scope="row"><?= __('¿Enviar correos electrónicos?') ?></th>
            <td>
            <?php
                if(intval($setting->sendEmail)==1){
                    echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
                }else{
                    echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
                }
            ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?= __('¿Enviar correos electrónicos al agregar usuarios?') ?></th>
            <td>
            <?php
                if(intval($setting->sendEmailUserAdd)==1){
                    echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
                }else{
                    echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
                }
            ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?= __('¿Enviar correos electrónicos al editar usuarios?') ?></th>
            <td>
            <?php
                if(intval($setting->sendEmailUserEdit)==1){
                    echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
                }else{
                    echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
                }
            ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?= __('¿Enviar correos electrónicos al desactivar usuarios?') ?></th>
            <td>
            <?php
                if(intval($setting->sendEmailUserDisabled)==1){
                    echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
                }else{
                    echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
                }
            ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?= __('¿Enviar correos electrónicos al agregar cursos?') ?></th>
            <td>
            <?php
                if(intval($setting->sendEmailCourseAdd)==1){
                    echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
                }else{
                    echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
                }
            ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?= __('¿Enviar correos electrónicos al agregar instructores?') ?></th>
            <td>
            <?php
                if(intval($setting->sendEmailInstructorAdd)==1){
                    echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
                }else{
                    echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
                }
            ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?= __('¿Enviar correos electrónicos al agregar participantes?') ?></th>
            <td>
            <?php
                if(intval($setting->sendEmailParticipantAdd )==1){
                    echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
                }else{
                    echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
                }
            ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?= __('¿Enviar correos electrónicos a particioantes de cursos?') ?></th>
            <td>
            <?php
                if(intval($setting->sendEmailParticipantsComunicate)==1){
                    echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
                }else{
                    echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
                }
            ?>
            </td>
        </tr>
        
        <tr>
            <th scope="row"><?= __('Nombre del último usuario que edito las configuraciones') ?></th>
            <td><?= $setting->user->full_name_and_email ?></td>
        </tr>
        
        <tr>
            <th scope="row"><?= __('Fecha de creación de las configuraciones') ?></th>
            <td><?= h($setting->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha de edición de las configuraciones') ?></th>
            <td><?= h($setting->modified) ?></td>
        </tr>
    </table>
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>
