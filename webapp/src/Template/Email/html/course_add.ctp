<div id="dlince-message" style="font-family: Arial, Helvetica, sans-serif; background-color: #EFEDFC;">
<div id="logo" style="background-color: #FAE7EC;">
	<h1 style="font-family: Impact, Charcoal, sans-serif;	display: block;	text-decoration: none; font-size: 24px;
	font-weight: 600;	color: #B9264F;	padding:0px; margin:0px;">SISCAP - Curso nuevo disponible</h1>
	<span style="font-size: 10px; padding:0px; margin:0px;">Sistema de capacitación</span>
</div>
<br />
<p>Acaba de crearse un Curso nuevo en SISCAP y esta disponible para que puedas inscribirte.</p>
<br />
<p><strong>Datos del curso:</strong></p>
<ul>
<li>Código : <?= $id ?></li>
<li>Nombre : <?= $name ?></li>
<?php if($place!=null): ?><li>Lugar : <?= $place ?></li><?php endif; ?>
<?php if($destined!=null): ?><li>Destinado a : <?= $destined ?></li><?php endif; ?>
<li>Modalidad : <?= $type ?></li>
<li>Cupos : <?= $quota?> (hasta el momento)</li>
<li>Inicia : <?= $start ?></li>
<li>Termina : <?= $finish ?></li>
</ul>
<p><strong>Opciones:</strong></p>
<ul>
<li>
<?php echo $this->Html->link(
    'Saber más detalles del curso',
    ['controller' => 'Courses', 'action' => 'view', $id, '_full' => true]
); ?>
</li>

</ul>
<br />
<cite>Atentamente,
<br />Oficina de Capacitación
</cite>
</div>
