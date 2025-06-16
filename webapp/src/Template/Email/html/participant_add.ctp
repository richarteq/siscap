<div id="dlince-message" style="font-family: Arial, Helvetica, sans-serif; background-color: #EFEDFC;">
<div id="logo" style="background-color: #FAE7EC;">
	<h1 style="font-family: Impact, Charcoal, sans-serif;	display: block;	text-decoration: none; font-size: 24px;
	font-weight: 600;	color: #B9264F;	padding:0px; margin:0px;">SISCAP - Inscripción en Curso de capacitación</h1>
	<span style="font-size: 10px; padding:0px; margin:0px;">Sistema de capacitación</span>
</div>
<br />
<p>Estas inscrito en un curso de capacitación.</p>
<br />
<p><strong>Datos del curso</strong></p>
<ul>
<li>Nombre : <?php echo $name?></li>
<li>Inicio : <?php echo $start?></li>
<li>Fin : <?php echo $finish?></li>
<li>Modalidad : <?php echo $type?></li>
<li>Cupos : <?php echo $quota?></li>
</ul>
<br />
<p><strong>Opciones:</strong></p>
<ul>
<li>
<?php echo $this->Html->link(
    'Ir al curso',
    ['controller' => 'Courses', 'action' => 'view', $id, '_full' => true]
); ?>
</li>
</ul>
<br />
<cite>Atentamente,
<br />Oficina de Capacitación
</cite>
</div>
