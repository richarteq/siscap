<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = false;

?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $dlince_values['title'];?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $dlince_values['description'];?>" />
<meta name="keywords" content="<?php echo $dlince_values['keywords'];?>" />
<?php
echo $this->Html->css('css.css');
echo "\n"."<!--[if lte IE 8]>".$this->Html->script('html5shiv.js')."<![endif]-->";
echo "\n".$this->Html->script('jquery.min.js');
echo "\n".$this->Html->script('skel.min.js');
echo "\n".$this->Html->script('skel-panels.min.js');
echo "\n".$this->Html->script('init.js');
echo "\n".$this->Html->script('reloj.js');

echo "\n".$this->Html->script('jquery.cycle.all.js');

echo "\n"."<noscript>";
echo "\n".$this->Html->css('skel-noscript.css');
echo "\n".$this->Html->css('style.css');
echo "\n".$this->Html->css('style-desktop.css');
echo "\n"."</noscript>";

echo "\n".$this->Html->css('dlince-home.css');
echo "\n".$this->Html->css('dlince-default.css');
echo "\n".$this->Html->css('dlince-menu.css');

echo "\n"."<!--[if lte IE 8]>".$this->Html->css('ie/v8.css')."<![endif]-->";
echo "\n"."<!--[if lte IE 9]>".$this->Html->css('ie/v9.css')."<![endif]-->";
echo "\n";
?>
<style type="text/css">
	#courses-slideshow {height: auto; width: auto; margin: auto; }
	#courses-slideshow section.course-block{
		height: auto !important;
	}
	#courses-slideshow h2.course-name{
		font-size: 1.5em !important;
		height: auto !important;
	}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $('#courses-slideshow').cycle({
			fx:      'scrollDown',
    	speed:    500,
    	timeout:  5000
	});
});
</script>
</head>
	<body class="homepage">

	<!-- /Header -->
		<div id="header">
			<div class="container">

				<!-- /Logo -->
				<?php if( $dlince_show['home']['all']==true && $dlince_show['home']['logo']==true ): ?>
					<div id="logo">
						<?php echo $this->Html->link($this->Html->image('logo.png', ['alt' => 'SISCAP','id'=>'logo-image']), '/',['escape'=>false]);?>
						<?php if( $dlince_show['home']['all']==true && $dlince_show['home']['logo_span']==true ): ?>
						<span>Sistema de capacitación</span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<!-- Logo/ -->

				<!-- /Menu principal -->
				<?php if( $dlince_show['home']['all']==true && $dlince_show['home']['menu_main']==true ): ?>
				<nav id="nav">
					<ul>
						<li class="active"><?= $this->Html->link('Inicio', '/') ?></li>
						<li><?php echo $this->Html->link('Cursos', ['controller' => 'Courses', 'action' => 'index'] ); ?></li>
						<li><?php echo $this->Html->link('Galería', '#' ); ?></li>
						<li><?php echo $this->Html->link('Contáctenos', '#' ); ?></li>
						<?php if ( null!==($this->request->session()->read('Auth.User')) ) : ?>
						<li><?php echo $this->Html->link('Cerrar sesión', ['controller' => 'Users', 'action' => 'logout'] ); ?></li>
						<?php else: ?>
						<li><?php echo $this->Html->link('Iniciar sesión', ['controller' => 'Users', 'action' => 'login'] ); ?></li>
						<?php endif; ?>
					</ul>
				</nav>
				<?php endif; ?>
				<!-- Menu principal/ -->

			</div>
		</div>
	<!-- Header/ -->

	<!-- /Banner -->
	<?php if( $dlince_show['home']['all']==true && $dlince_show['home']['banner']==true ): ?>
		<div id="banner">
			<div class="container">
			</div>
		</div>
	<?php endif; ?>
	<!-- Banner/ -->

	<!-- Main -->
		<div id="page">

			<!-- /Login information -->
			<?php if( $dlince_show['home']['information']['all']==true ): ?>
			<?php
				echo "<div id=\"dlince_login_information\">";
				echo "<ul>";

				/**/
				if( $dlince_show['home']['information']['all']==true && $dlince_show['home']['information']['date']==true )
				{
					//DLince
					//Construyendo saludo:madrugada,mañana,tarde o noche
					$saludo='';
					if(	intval(date("H"))>=0 && intval(date("H"))<6 ){
						$saludo='Buenas madrugadas, ';
					}elseif(	intval(date("H"))>=6 && intval(date("H"))<12 ){
						$saludo='Buenos días, ';
					}elseif(	intval(date("H"))>=12 && intval(date("H"))<18 ){
						$saludo='Buenas tardes, ';
					}else{
						$saludo='Buenas noches, ';
					}
					echo "<li>".$saludo."hoy es ".__(strtolower(date("l"))).", ".date("d")." de ".__(date("F"))." del ".date("Y").".</li>";
				}
				/**/

				/**/
				if ( ($this->request->session()->read('Auth.User'))!==null )
				{
					/**/
					$sesion = $this->request->session()->read('Auth.User');
					/**/
					if( $dlince_show['home']['information']['all']==true && $dlince_show['home']['information']['welcome']==true )
					{						
						$size='16';
						switch($sesion['role']->name){
							case 'administrator':
								$icono = $this->Html->image(Configure::read('DLince.icon'.$size.'.administrator'), ["alt" => __('')]);
								break;
							case 'teacher':
								$icono = $this->Html->image(Configure::read('DLince.icon'.$size.'.teacher'), ["alt" => __('')]);
								break;
							case 'student':
								$icono = $this->Html->image(Configure::read('DLince.icon'.$size.'.student'), ["alt" => __('')]);
								break;
							default:
								$icono = $this->Html->image(Configure::read('DLince.icon'.$size.'.user'), ["alt" => __('')]);
						}					
						echo '<li>Bienvenido <span style="font-weight:bold;">'.$sesion['names'].'</span> '.$icono.' '.ucfirst(__($sesion['role']->name)).'</li>';
					}
					/**/

					/**/
					if( $dlince_show['home']['information']['all']==true && $dlince_show['home']['information']['last_login']==true )
					{
						if($sesion['last_login']<>null){						
							echo $this->Html->link('<li class="last-link">Último acceso</li>', ['controller' => 'Users', 'action' => 'login'], [
								'escape' => false,
								'escapeTitle' => false,
								'title' => $sesion['last_login']->format('\S\u \ú\l\t\i\m\o \a\c\c\e\s\o \f\u\é \e\l d \d\e F \d\e\l Y \a \l\a\s H:i:s A'),
							]);
						}
						else{
							echo $this->Html->link('<li class="last-link">Esta es la primera vez que inicia sesión</li>', ['controller' => 'Users', 'action' => 'login'], [
								'escape' => false,
							]);
						}
					}
					/**/

				}
				/**/

				echo "</ul>";
				echo "</div>";
			?>
			<?php endif; ?>
			<!-- Login information/ -->

			<?php
				if ( ($this->request->session()->read('Auth.User'))!==null && ($this->request->session()->read('Auth.User.role.name'))!==null )
				{
					if( $dlince_show['home']['user_menu']['all']==true )
					{
						echo "\n<!-- /User menu -->";
						echo "<div id=\"dlince_user_menu\">";
						echo "<ul>";

						/**/
						switch( $this->request->session()->read('Auth.User.role.name') )
						{
							case 'administrator':
								if( $dlince_show['home']['user_menu']['all']==true && $dlince_show['home']['user_menu']['items']==true )
								{
									echo "<li>".$this->Html->link('Usuarios', ['controller' => 'Users','action' => 'index'] )."</li>";
									echo "<li>".$this->Html->link('Cursos', ['controller' => 'Courses','action' => 'index'] )."</li>";
									echo "<li>".$this->Html->link('Instructores', ['controller' => 'Instructors','action' => 'index'] )."</li>";
									echo "<li>".$this->Html->link('Archivos', ['controller' => 'Files','action' => 'index'] )."</li>";
									echo "<li>".$this->Html->link('Videos', ['controller' => 'Videos','action' => 'index'] )."</li>";
									echo "<li>".$this->Html->link('Tareas', ['controller' => 'Tasks','action' => 'index'] )."</li>";							
									echo "<li>".$this->Html->link('Evaluaciones', ['controller' => 'Evaluations','action' => 'index'] )."</li>";
									echo "<li>".$this->Html->link('Preguntas', ['controller' => 'Questions','action' => 'index'] )."</li>";
									echo "<li>".$this->Html->link('Participantes', ['controller' => 'Participants','action' => 'index'] )."</li>";
									echo "<li>".$this->Html->link('Frases', ['controller' => 'Phrases','action' => 'index'] )."</li>";
									echo "<li>".$this->Html->link('Presentaciones', ['controller' => 'Presentations','action' => 'index'] )."</li>";
									echo "<li>".$this->Html->link('Configuración', ['controller' => 'Settings','action' => 'index'] )."</li>";
								}
								if( $dlince_show['home']['user_menu']['all']==true && $dlince_show['home']['user_menu']['logout']==true )
								{
									echo '<li class="last-link logout-link">'.$this->Html->link('Cerrar sesión', ['controller' => 'Users', 'action' => 'logout'] ).'</li>';
								}
								if( $dlince_show['home']['user_menu']['all']==true && $dlince_show['home']['user_menu']['timer']==true )
								{
									echo '<li class="last-link"><span id="reloj"></span></li>';
								}
							break;
							
							case 'student':
								if( $dlince_show['home']['user_menu']['all']==true && $dlince_show['home']['user_menu']['items']==true )
								{
									echo "<li>".$this->Html->link('Mis cursos', ['controller' => 'Courses','action' => 'mine'] )."</li>";
								}						
								if( $dlince_show['home']['user_menu']['all']==true && $dlince_show['home']['user_menu']['logout']==true )
								{
									echo '<li class="last-link logout-link">'.$this->Html->link('Cerrar sesión', ['controller' => 'Users', 'action' => 'logout'] ).'</li>';
								}
								if( $dlince_show['home']['user_menu']['all']==true && $dlince_show['home']['user_menu']['timer']==true )
								{
									echo '<li class="last-link"><span id="reloj"></span></li>';
								}
							break;

							case 'teacher':
								if( $dlince_show['home']['user_menu']['all']==true && $dlince_show['home']['user_menu']['items']==true )
								{
									echo "<li>".$this->Html->link('Mis cursos', ['controller' => 'Courses','action' => 'mine'] )."</li>";							
									echo "<li>".$this->Html->link('Subir archivo', ['controller' => 'Files','action' => 'index'] )."</li>";
									echo "<li>".$this->Html->link('Agregar video', ['controller' => 'Videos','action' => 'index'] )."</li>";
									echo "<li>".$this->Html->link('Crear tarea', ['controller' => 'Tasks','action' => 'index'] )."</li>";
									echo "<li>".$this->Html->link('Crear evaluación', ['controller' => 'Evaluations','action' => 'index'] )."</li>";
									echo "<li>".$this->Html->link('Agregar pregunta', ['controller' => 'Questions','action' => 'index'] )."</li>";
									echo "<li>".$this->Html->link('Ver participantes', ['controller' => 'Participants','action' => 'index'] )."</li>";
								}
								if( $dlince_show['home']['user_menu']['all']==true && $dlince_show['home']['user_menu']['logout']==true )
								{
									echo '<li class="last-link logout-link">'.$this->Html->link('Cerrar sesión', ['controller' => 'Users', 'action' => 'logout'] ).'</li>';
								}
								if( $dlince_show['home']['user_menu']['all']==true && $dlince_show['home']['user_menu']['timer']==true )
								{
									echo '<li class="last-link"><span id="reloj"></span></li>';
								}
							break;

							default:
								if( $dlince_show['home']['user_menu']['all']==true && $dlince_show['home']['user_menu']['logout']==true )
								{
									echo '<li class="last-link logout-link">'.$this->Html->link('Cerrar sesión', ['controller' => 'Users', 'action' => 'logout'] ).'</li>';
								}
								if( $dlince_show['home']['user_menu']['all']==true && $dlince_show['home']['user_menu']['timer']==true )
								{
									echo '<li class="last-link"><span id="reloj"></span></li>';
								}
						}
						/**/

						echo "</ul>";
						echo "</div>";
					}
					echo "\n<!-- User menu/ -->";
				}
			?>
			<div id="dlince_messages">
				<?php echo $this->Flash->render() ?>
			</div>

			<!-- Extra -->
			<?php
				$total = $dlince_courses->count();
			?>
			<div id="marketing" class="container">

			</div>
		<!-- /Extra -->

			<!-- Main -->
			<div id="main" class="container">
				<div class="row">
					<div class="6u" style="width:40%;">
						<section>
							<header>
								<h2 style="font-size: 2em;">SISCAP &ndash; Sistema de Capacitación</h2>
								<span class="byline">La aplicación Web, para soporte en capacitaciones</span>
							</header>
							<p><strong>SISCAP</strong>, es una plataforma de trabajo para brindar soporte a estudiantes, instructores y administradores en cursos de capacitación en modalidades virtual, presencial o ambos.</p>
							<?php echo $this->Html->image('siscap.png', ['alt' => 'SISCAP','style'=>'width:100%; object-fit: contain; padding-top:20px;padding-bottom:40px;']);?>
							<p style="margin-bottom: 40px;"><strong>SISCAP</strong>, es una aplicación Web MVC(Modelo-Vista-Controlador) y esta disponible desde Internet como SasS(Software como servicio).</p>
						</section>
					</div>
					<div class="3u" style="width:25%;">
						<section class="sidebar">
							<header>
								<h2>Aprendiendo SISCAP</h2>
							</header>
							<ul class="style2">
								<li>
									<a href="#"><?php echo $this->Html->image('pics07.jpg', ['alt' => '']);?></a>
									<p>Aprende como iniciar sesión en SISCAP, siendo profesor o estudiante registrado.</p>
								</li>
								<li>
									<a href="#"><?php echo $this->Html->image('pics08.jpg', ['alt' => '']);?></a>
									<p>Aprende como inscribirte en un curso de capacitación siendo estudiante SISCAP.</p>
								</li>
								<li>
									<a href="#"><?php echo $this->Html->image('pics09.jpg', ['alt' => '']);?></a>
									<p>Aprende como acceder a recursos de un curso siendo estudiante SISCAP.</p>
								</li>
								<li>
									<a href="#"><?php echo $this->Html->image('pics10.jpg', ['alt' => '']);?></a>
									<p>Aprende como agregar recursos a un curso siendo profesor SISCAP.</p>
								</li>
							</ul>
						</section>
					</div>,
					<div class="3u" style="width:35%; height:100% !important;">
						<div id="courses-slideshow">
							<?php
							/**/
							foreach($dlince_courses as $course) {
							?>
								<section class="course-block" style="width:auto !important;">
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
					         	/**/
					          echo "<p class=\"course-attribute\">";
					          echo ($course->start==null)?'':"<span class='dlince-label'>Empieza: </span>".$course->start->format('d \d\e ').__($course->start->format('F')).$course->start->format(' \d\e\l Y');
					          echo "</p>";
					          /**/
					          echo "<p class=\"course-attribute\">";
					          echo ($course->finish==null)?'':"<span class='dlince-label'>Termina: </span>".$course->finish->format('d \d\e ').__($course->finish->format('F')).$course->finish->format(' \d\e\l Y');
					          echo "</p>";
					          /**/
					          echo "<p class=\"course-image-block\" >";
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
					          echo $this->Html->link($this->Html->image($select_image, ['alt' => '','class' => 'course-image']),[
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
					<?php
						}
					?>
				</div>

					</div>
				</div>
			</div>
			<!-- Main -->

		</div>
	<!-- /Main -->

	<!-- Featured -->
		<div id="featured">
			<div class="container">
				<div class="row">
					<section class="4u">
						<div class="box">
							<a href="#" class="image left">
							<?php
								echo $this->Html->image('pics04.jpg', ['alt' => '']);
							?>
							</a>
							<h3>Videos SISCAP</h3>
							<p>para estudiantes registrados en el sistema de capacitación.</p>
							<a href="#" class="button">Ver los videos</a>
						</div>
					</section>
					<section class="4u">
						<div class="box">
							<a href="#" class="image left">
							<?php
								echo $this->Html->image('pics05.jpg', ['alt' => '']);
							?>
							</a>
							<h3>Videos SISCAP</h3>
							<p>para profesores registrados en el sistema de capacitación.</p>
							<a href="#" class="button">Ver los videos</a>
						</div>
					</section>
					<section class="4u">
						<div class="box">
							<a href="#" class="image left">
							<?php
								echo $this->Html->image('pics06.jpg', ['alt' => '']);
							?>
							</a>
							<h3>Videos SISCAP</h3>
							<p>para administradores registrados en el sistema de capacitación.</p>
							<a href="#" class="button">Ver los videos</a>
						</div>
					</section>
				</div>
				<div class="divider"></div>
			</div>
		</div>
	<!-- /Featured -->

	<!-- Footer -->
		<div id="footer">
			<div class="container">
				<div class="row">
					<div class="3u">
						<section>
							<h2>Tu frase del día</h2>
							<div class="balloon">
								<blockquote>&ldquo;&nbsp;&nbsp;<?php echo ($dlince_phrase==null)?'No hay nada tan agotador como la eterna presencia de una tarea sin completar':$dlince_phrase->phrase; ?>&nbsp;&nbsp;&rdquo;<br>
									<br>
									<strong>&ndash;&nbsp;&nbsp;<?php echo ($dlince_phrase==null)?'William James':$dlince_phrase->author; ?></strong></blockquote>
							</div>
							<div class="ballon-bgbtm">&nbsp;</div>
						</section>
					</div>
					<div class="3u">
						<section>
							<h2>Capacitación</h2>
							<p><strong>Acerca de nosotros</strong></p>
							<p>Capacitación.</p>
							<p><strong>Nuestros objetivos</strong></p>
							<p>Mantener la capacitación permanente.</p>
							<p>Otorgar modalidades de capacitacion virtual y presencial a todos los participantes de cursos.</p>
							<p>Administrar el Sistema de Capacitacion - SISCAP.</p>
						</section>
					</div>
					<div class="3u">
						<section>
							<h2>Cursos SISCAP</h2>
							<p>Accede a nuestros cursos de capacitación y obtén certificación.</p>
							<p>Si todavia no eres estudiante SISCAP solicita tu inscripción y si ya lo eres ingresa con tu usuario y contraseña e inscribité y ya estarás participando del curso que más te guste.</p>
							<ul class="style5">
								<li><a href="#"><?php echo $this->Html->image('pics07.jpg', ['alt' => '']);?></a></li>
								<li><a href="#"><?php echo $this->Html->image('pics08.jpg', ['alt' => '']);?></a></li>
								<li><a href="#"><?php echo $this->Html->image('pics09.jpg', ['alt' => '']);?></a></li>
								<li><a href="#"><?php echo $this->Html->image('pics10.jpg', ['alt' => '']);?></a></li>
								<li><a href="#"><?php echo $this->Html->image('pics11.jpg', ['alt' => '']);?></a></li>
								<li><a href="#"><?php echo $this->Html->image('pics12.jpg', ['alt' => '']);?></a></li>
							</ul>
							<?php
								echo $this->Html->link(
									'Ver cursos',[
										'controller' => 'Courses',
										'action' => 'index',
										'_full' => false],[
										'class'=>'button-know-plus']
								);
							?>
						</section>
					</div>
					<div class="3u">
						<section>
							<h2>Contactános</h2>
							<p><strong>Visitanos</strong></p>
							<p>Capacitación
							<br />Arequipa - Perú
							</p>
							<p><strong>Comunicate con nosotros</strong></p>
							<p>Teléfono 95784130
							<br />Correo electrónio richartescobedo@gmail.com
							</p>
						</section>
					</div>
				</div>
			</div>
		</div>
	<!-- /Footer -->

	<!-- Copyright -->
		<div id="copyright" class="container">
			<?php echo $dlince_values['copyright'];?>
		</div>


	</body>
</html>
