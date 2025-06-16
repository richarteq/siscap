<div id="dlince-message" style="font-family: Arial, Helvetica, sans-serif; background-color: #EFEDFC;">
<div id="logo" style="background-color: #FAE7EC;">
	<h1 style="font-family: Impact, Charcoal, sans-serif;	display: block;	text-decoration: none; font-size: 24px;
	font-weight: 600;	color: #B9264F;	padding:0px; margin:0px;">Nuevo video en Curso SISCAP</h1>
	<span style="font-size: 10px; padding:0px; margin:0px;">Sistema de capacitación</span>
</div>
<br />
<p>Se ha agregado un nuevo video al curso "<?= $course ?>", donde eres participante</p>
<br />
<p><strong>Video</strong></p>
<ul>
<li><?php echo $url?></li>
<br />
<li>
<?php echo $this->Html->link(
    'Ir al curso',
    ['controller' => 'Courses', 'action' => 'view',$id, '_full' => true]
); ?>
</li>
</ul>
<br />
<cite>Atentamente,
<br />Oficina de Capacitación
</cite>
</div
