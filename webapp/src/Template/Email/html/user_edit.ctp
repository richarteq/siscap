<div id="dlince-message" style="font-family: Arial, Helvetica, sans-serif; background-color: #EFEDFC;">
<div id="logo" style="background-color: #FAE7EC;">
	<h1 style="font-family: Impact, Charcoal, sans-serif;	display: block;	text-decoration: none;	font-size: 24px;
	font-weight: 600;	color: #B9264F; padding:0px; margin:0px;">Cambios en tu cuenta SISCAP</h1>
	<span style="font-size: 10px; padding:0px; margin:0px;">Sistema de capacitación</span>
</div>
<br />
<p>Se han realizado cambios en tu cuenta SISCAP</p>
<br />
<p><strong>Tus datos para ingresar en SISCAP son</strong></p>
<ul>
<li>Correo electrónico : <?php echo $email?></li>
<li>Contraseña SISCAP : La primera vez tu contraseña es tu número de DNI. Si no, contáctate con nosotros.</li>
<br />
<li>
<?php echo $this->Html->link(
    'Iniciar sesión en SISCAP',
    ['controller' => 'Users', 'action' => 'login', '_full' => true]
); ?>
</li>
</ul>
<br />
<cite>Atentamente,
<br />Oficina de Capacitación.
</cite>
</div>
