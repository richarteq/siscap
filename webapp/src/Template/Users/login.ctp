<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<!-- include the BotDetect layout stylesheet -->
<?= $this->Html->css(captcha_layout_stylesheet_url(), ['inline' => false]) ?>
<script>
$(window).load(function() {
  $("#email").focus();  
});
</script>

<div class="menu-left">
  <ul class="list-menu-left">
    <li><?= $this->Html->link(__('Iniciar sesión'), ['action' => 'login'],['style'=>'font-weight:bold']) ?></li>
    <li><?= $this->Html->link(__('Cerrar sesión'), ['action' => 'logout']) ?></li>
  </ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="users form large-9 medium-8 columns content">
<?php if( ($this->request->session()->read('Auth.User'))==null ): ?>
  <?php echo $this->Form->create(); ?>
  <fieldset>
  <legend><?= __('Iniciar sesión en SISCAP') ?></legend>
  <?php

  echo $this->Form->control('email',[
    'label' => 'Correo electrónico',
    'required' => true,
    'value' => 'admin@siscap.com',
    'autocomplete' => 'off',
    'tabindex' => '1',
  ]);
  echo $this->Form->control('password',[
    'label' => 'Contraseña SISCAP',
    'required' => true,
    'value' => '12345678',
    'autocomplete' => 'new-password',
    'tabindex' => '2',
  ]);
  echo "<!-- show captcha image -->";
  echo captcha_image_html();
  echo "<!-- Captcha code user input textbox -->";
  echo $this->Form->input('CaptchaCode', [
    'label' => 'Escriba los caracteres de la imagen:',
    'maxlength' => '10',
    'style' => 'width: 270px;',
    'id' => 'CaptchaCode',
    'tabindex' => '3',
  ]);
  echo $this->Form->button(
    $this->Html->image(Configure::read('DLince.icon.login')).'<span>Iniciar sesión</span>',
    ['class' => 'button', 'escape' => false, 'tabindex' => '4',]
  );
  echo "</fieldset>";
  echo $this->Form->end();

  ?>
<?php else: ?>
<div class="message success" style="text-align:left;" onclick="this.classList.add('hidden')">Ya hay una sesión iniciada</div>
  <table class="vertical-table">
    <tr>
        <th scope="row"><?= __('ID-Usuario') ?></th>
        <td style="font-weight:bold;" colspan="2"><?= $this->request->session()->read('Auth.User.id') ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Datos de la sesión') ?></th>
        <td colspan="2"><?= $this->request->session()->read('Auth.User.full_name_and_email') ?></td>
    </tr>
    <?php
    switch($this->request->session()->read('Auth.User.role.name')){
      case 'administrator':
        $icono = $this->Html->image(Configure::read('DLince.icon.administrator'), ["alt" => __('Administrador')]);
        break;
      case 'teacher':
        $icono = $this->Html->image(Configure::read('DLince.icon.teacher'), ["alt" => __('Profesor')]);
        break;
      case 'student':
        $icono = $this->Html->image(Configure::read('DLince.icon.student'), ["alt" => __('Estudiante')]);
        break;
      default:
        $icono = $this->Html->image(Configure::read('DLince.icon.user'), ["alt" => __('Usuario')]);
    }
    ?>
    <tr>
      <th scope="row"><?= __('Rol del usuario') ?></th>
      <td><?= $icono ?></td>
      <td style="font-weight:bold"><?= ucfirst(__($this->request->session()->read('Auth.User.role.name'))) ?></td>
    </tr>
    <tr>
      <th scope="row"><?= __('Último acceso') ?></th>
      <?php if( $this->request->session()->read('Auth.User.last_login')!=null ): ?>
      <td colspan="2"><?= $this->request->session()->read('Auth.User.last_login')->format('d \d\e ').__($this->request->session()->read('Auth.User.last_login')->format('F')).$this->request->session()->read('Auth.User.last_login')->format(' \d\e\l Y \a \l\a\s H:i:s A') ?></td>
      <?php else: ?>
      <td colspan="2">Esta es la primera vez que inicia sesión</td>
      <?php endif; ?>
    </tr>
    <tr>
      <th scope="row" colspan="3">
      <?php
        echo $this->Html->link(
        $this->Html->image(Configure::read('DLince.icon.login')).'<span>Cerrar sesión</span>',[
          'controller' => 'Users',
          'action' => 'logout',
          '_full' => false],[
            'class'=>'button',
            'escape' => false
            ]
        );
      ?>
      </th>
    </tr>
  </table>
<?php endif; ?>

</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>
