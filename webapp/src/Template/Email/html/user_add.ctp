<div id="dlince-message" style="font-family: Arial, Helvetica, sans-serif; background-color: #EFEDFC;">
<div id="logo" style="background-color: #FAE7EC;">
	<h1 style="font-family: Impact, Charcoal, sans-serif;	display: block;	text-decoration: none;	font-size: 24px;
	font-weight: 600;	color: #B9264F; padding:0px; margin:0px;">SISCAP - Bienvenido usuario <?= $rol ?></h1>
	<span style="font-size: 10px; padding:0px; margin:0px;">Sistema de capacitación</span>
</div>
<br />
<p>Bienvenido: <?= $full_name ?>, ahora eres <strong><?= $rol ?></strong> en SISCAP.</p>
<br />
<p><strong>Tus datos para ingresar a SISCAP son:</strong></p>
<ul>
<li>Correo electrónico : <?= $email ?></li>
<li>Contraseña SISCAP : La primera vez tu contraseña es tu número de DNI. De lo contrario, contáctate con nosotros.</li>
</ul>
<p><strong>Prueba SISCAP ahora mismo:</strong></p>
<ul>
<li>
<?php echo $this->Html->link(
    'Iniciar sesión en SISCAP',
    ['controller' => 'Users', 'action' => 'login', '_full' => true]
); ?>
</li>
<li>
<?php echo $this->Html->link(
    'Ver más detalles de  tu usuario',
    ['controller' => 'Users', 'action' => 'view', $id, '_full' => true]
); ?>
</li>
</ul>
<br />
<cite>Atentamente,
<br />Oficina de Capacitación.
</cite>
</div>
