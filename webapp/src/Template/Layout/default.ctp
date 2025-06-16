<?php
use Cake\Core\Configure;
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
//echo "\n".$this->Html->script('init.js');
echo "\n".$this->Html->script('reloj.js');
?>
<script type="text/javascript">
skel.init({
	prefix: '<?php echo $this->request->webroot.'css/style';?>',
	resetCSS: true,
	boxModel: 'border',
	grid: {
		gutters: 50
	},
	breakpoints: {
		'mobile': {
			range: '-480',
			lockViewport: true,
			containers: 'fluid',
			grid: {
				collapse: true,
				gutters: 10
			}
		},
		'desktop': {
			range: '481-',
			containers: 1200
		},
		'1000px': {
			range: '481-1200',
			containers: 960
		}
	}
}, {
	panels: {
		panels: {
			navPanel: {
				breakpoints: 'mobile',
				position: 'left',
				style: 'reveal',
				size: '80%',
				html: '<div data-action="navList" data-args="nav"></div>'
			}
		},
		overlays: {
			titleBar: {
				breakpoints: 'mobile',
				position: 'top-left',
				height: 44,
				width: '100%',
				html: '<span class="toggle" data-action="togglePanel" data-args="navPanel"></span><span class="title" data-action="copyHTML" data-args="logo"></span>'
			}
		}
	}
});
</script>
<?php
echo "\n"."<noscript>";
echo "\n".$this->Html->css('skel-noscript.css');
echo "\n".$this->Html->css('style.css');
echo "\n".$this->Html->css('style-desktop.css');
echo "\n"."</noscript>";

echo "\n".$this->Html->css('dlince-home.css');
echo "\n".$this->Html->css('dlince-default.css');

echo "\n"."<!--[if lte IE 8]>".$this->Html->css('ie/v8.css')."<![endif]-->";
echo "\n"."<!--[if lte IE 9]>".$this->Html->css('ie/v9.css')."<![endif]-->";
echo "\n";
?>
</head>
	<body class="left-sidebar">

	<!-- Header -->
		<div id="header">
			<div class="container">

				<!-- /Logo -->				
				<div id="logo">
					<?php if( $dlince_show['default']['all']==true && $dlince_show['default']['logo']==true ): ?>
					<?php echo $this->Html->link($this->Html->image('logo.png', ['alt' => 'SISCAP','id'=>'logo-image']), '/',['escape'=>false]);?>
					<?php endif; ?>
					<?php if( $dlince_show['default']['all']==true && $dlince_show['default']['logo_span']==true ): ?>
						<span>Sistema de capacitación</span>
					<?php endif; ?>
				</div>				
				<!-- Logo/ -->

				<!-- /Menu principal -->
				<?php if( $dlince_show['default']['all']==true && $dlince_show['default']['menu_main']==true ): ?>
				<nav id="nav">
					<ul>
						<?php
							if( $this->request->getParam('controller')==null )
							{
								echo "<li class=\"active\">".$this->Html->link('Inicio', '/')."</li>";
							}else{
								echo "<li>".$this->Html->link('Inicio', '/')."</li>";
							}
							/**/
							if( $this->request->getParam('controller')=='Courses' )
							{
								echo "<li class=\"active\">".$this->Html->link('Cursos', ['controller' => 'Courses','action' => 'index'])."</li>";
							}else{
								echo "<li>".$this->Html->link('Cursos', ['controller' => 'Courses','action' => 'index'])."</li>";
							}					
						?>						
						<li><?php echo $this->Html->link('Galeria', '#' ); ?></li>
						<li><?php echo $this->Html->link('Contáctenos', '#' ); ?></li>
						<?php
							if( $this->request->getParam('controller')=='Users' && $this->request->getParam('action')=='login' )
							{									
								if( null!==($this->request->session()->read('Auth.User')) )
								{
									echo "<li class=\"active\">".$this->Html->link('Cerrar sesión',['controller'=>'Users','action'=>'logout'])."</li>";
								}else
								{
									echo "<li class=\"active\">".$this->Html->link('Iniciar sesión',['controller'=>'Users','action'=>'login'])."</li>";
								}
							}else{
								if( null!==($this->request->session()->read('Auth.User')) )
								{
									echo "<li>".$this->Html->link('Cerrar sesión', ['controller'=>'Users', 'action'=>'logout'])."</li>";
								}else{
									echo "<li>".$this->Html->link('Iniciar sesión', ['controller'=>'Users', 'action'=>'login'])."</li>";
								}
							}
						?>
					</ul>
				</nav>
				<?php endif; ?>
				<!-- Menu principal/ -->

			</div>
		</div>
	<!-- Header -->

	<!-- /Banner -->
	<?php if( $dlince_show['default']['all']==true && $dlince_show['default']['banner']==true ): ?>
		<div id="banner">
			<div class="container">
			</div>
		</div>
	<?php endif; ?>
	<!-- Banner/ -->

	<!-- Main -->
		<div id="page">

			<!-- /Login information -->
			<?php if( $dlince_show['default']['information']['all']==true ): ?>
			<?php
				echo "<div id=\"dlince_login_information\">";
				echo "<ul>";

				/**/
				if( $dlince_show['default']['information']['all']==true && $dlince_show['default']['information']['date']==true )
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
					if( $dlince_show['default']['information']['all']==true && $dlince_show['default']['information']['welcome']==true )
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
					if( $dlince_show['default']['information']['all']==true && $dlince_show['default']['information']['last_login']==true )
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
					echo "<div id=\"dlince_user_menu\">";
					echo "<ul>";
					switch( $this->request->session()->read('Auth.User.role.name') )
					{
						case 'administrator':
							if( $dlince_show['default']['user_menu']['all']==true && $dlince_show['default']['user_menu']['items']==true )
							{
								/**/
								echo "<li>".$this->Html->link('Usuarios', ['controller' => 'Users','action' => 'index'], ($this->request->getParam('controller')=='Users')?['class'=>'active']:array() )."</li>";
								
								echo "<li>".$this->Html->link('Cursos', ['controller' => 'Courses','action' => 'index'], ($this->request->getParam('controller')=='Courses')?['class'=>'active']:array() )."</li>";
								
								echo "<li>".$this->Html->link('Instructores', ['controller' => 'Instructors','action' => 'index'], ($this->request->getParam('controller')=='Instructors')?['class'=>'active']:array() )."</li>";
								
								echo "<li>".$this->Html->link('Archivos', ['controller' => 'Files','action' => 'index'], ($this->request->getParam('controller')=='Files')?['class'=>'active']:array() )."</li>";
								
								echo "<li>".$this->Html->link('Videos', ['controller' => 'Videos','action' => 'index'], ($this->request->getParam('controller')=='Videos')?['class'=>'active']:array() )."</li>";
								
								echo "<li>".$this->Html->link('Tareas', ['controller' => 'Tasks','action' => 'index'], ($this->request->getParam('controller')=='Tasks')?['class'=>'active']:array() )."</li>";							
								
								echo "<li>".$this->Html->link('Evaluaciones', ['controller' => 'Evaluations','action' => 'index'], ($this->request->getParam('controller')=='Evaluations')?['class'=>'active']:array() )."</li>";
								
								echo "<li>".$this->Html->link('Preguntas', ['controller' => 'Questions','action' => 'index'], ($this->request->getParam('controller')=='Questions')?['class'=>'active']:array() )."</li>";
								
								echo "<li>".$this->Html->link('Participantes', ['controller' => 'Participants','action' => 'index'], ($this->request->getParam('controller')=='Participants')?['class'=>'active']:array() )."</li>";
								
								echo "<li>".$this->Html->link('Presentaciones', ['controller' => 'Presentations','action' => 'index'], ($this->request->getParam('controller')=='Presentations')?['class'=>'active']:array() )."</li>";
								
								echo "<li>".$this->Html->link('Frases', ['controller' => 'Phrases','action' => 'index'], ($this->request->getParam('controller')=='Phrases')?['class'=>'active']:array() )."</li>";
								
								echo "<li>".$this->Html->link('Configuración', ['controller' => 'Settings','action' => 'index'], ($this->request->getParam('controller')=='Settings')?['class'=>'active']:array() )."</li>";
							}
							if( $dlince_show['default']['user_menu']['all']==true && $dlince_show['default']['user_menu']['logout']==true )
							{
								echo '<li class="last-link logout-link">'.$this->Html->link('Cerrar sesión', ['controller' => 'Users', 'action' => 'logout'] ).'</li>';
							}
							if( $dlince_show['default']['user_menu']['all']==true && $dlince_show['default']['user_menu']['timer']==true )
							{
								echo '<li class="last-link"><span id="reloj"></span></li>';
							}
						break;							
						
						case 'student':
							if( $dlince_show['default']['user_menu']['all']==true && $dlince_show['default']['user_menu']['items']==true )
							{
								echo "<li>".$this->Html->link('Mis cursos', ['controller' => 'Courses','action' => 'mine'], ($this->request->getParam('controller')=='Courses' && $this->request->getParam('action')=='mine')?['class'=>'active']:array() )."</li>";
							}
							if( $dlince_show['default']['user_menu']['all']==true && $dlince_show['default']['user_menu']['logout']==true )
							{
								echo '<li class="last-link logout-link">'.$this->Html->link('Cerrar sesión', ['controller' => 'Users', 'action' => 'logout'] ).'</li>';
							}
							if( $dlince_show['default']['user_menu']['all']==true && $dlince_show['default']['user_menu']['timer']==true )
							{
								echo '<li class="last-link"><span id="reloj"></span></li>';
							}
						break;
						
						case 'teacher':
							if( $dlince_show['default']['user_menu']['all']==true && $dlince_show['default']['user_menu']['items']==true )
							{						
								echo "<li>".$this->Html->link('Mis cursos', ['controller' => 'Courses','action' => 'mine'], ($this->request->getParam('controller')=='Courses' && $this->request->getParam('action')=='mine')?['class'=>'active']:array() )."</li>";							
								echo "<li>".$this->Html->link('Subir archivo', ['controller' => 'Files','action' => 'add'], ($this->request->getParam('controller')=='Files')?['class'=>'active']:array() )."</li>";							
								echo "<li>".$this->Html->link('Agregar video', ['controller' => 'Videos','action' => 'add'], ($this->request->getParam('controller')=='Videos')?['class'=>'active']:array() )."</li>";							
								echo "<li>".$this->Html->link('Crear tarea', ['controller' => 'Tasks','action' => 'add'], ($this->request->getParam('controller')=='Tareas')?['class'=>'active']:array() )."</li>";							
								echo "<li>".$this->Html->link('Crear evaluación', ['controller' => 'Evaluations','action' => 'add'], ($this->request->getParam('controller')=='Evaluations')?['class'=>'active']:array() )."</li>";							
								echo "<li>".$this->Html->link('Agregar pregunta', ['controller' => 'Questions','action' => 'add'], ($this->request->getParam('controller')=='Questions')?['class'=>'active']:array() )."</li>";							
								echo "<li>".$this->Html->link('Ver participantes', ['controller' => 'Participants','action' => 'index'], ($this->request->getParam('controller')=='Participants')?['class'=>'active']:array() )."</li>";
							}
							if( $dlince_show['default']['user_menu']['all']==true && $dlince_show['default']['user_menu']['logout']==true )
							{
								echo '<li class="last-link logout-link">'.$this->Html->link('Cerrar sesión', ['controller' => 'Users', 'action' => 'logout'] ).'</li>';
							}
							if( $dlince_show['default']['user_menu']['all']==true && $dlince_show['default']['user_menu']['timer']==true )
							{
								echo '<li class="last-link"><span id="reloj"></span></li>';
							}
						break;

						default:
							if( $dlince_show['default']['user_menu']['all']==true && $dlince_show['default']['user_menu']['logout']==true )
							{
								echo '<li class="last-link logout-link">'.$this->Html->link('Cerrar sesión', ['controller' => 'Users', 'action' => 'logout'] ).'</li>';
							}
							if( $dlince_show['default']['user_menu']['all']==true && $dlince_show['default']['user_menu']['timer']==true )
							{
								echo '<li class="last-link"><span id="reloj"></span></li>';
							}
					}
					echo "</ul>";
					echo "</div>";
				}
			?>

			<div id="dlince_messages">
				<?php echo $this->Flash->render() ?>
			</div>

			<!-- Main -->
			<div id="main" class="container">
				<div class="row">

				<!-- <CONTENIDO -->
				<?php echo $this->fetch('content') ?>
				<!-- CONTENIDO> -->

				</div>
			</div>
			<!-- Main -->

		</div>
	<!-- /Main -->

	<!-- Featured -->	
		<div id="featured">
			<!-- /Bloque de videos -->
			<?php if( $dlince_show['default']['all']==true && $dlince_show['default']['block_videos']==true ): ?>
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
			<?php endif; ?>
			<!-- Bloque de videos/ -->
		</div>
	<!-- /Featured -->

	<!-- Footer -->
		<div id="footer">
			<!-- /Foot -->
			<?php //if( $dlince_show['default']['all']==true && $dlince_show['default']['foot']==true ): ?>
			<div class="container">
				<div class="row">
					<div class="3u">
						<section>
							<h2>Tu frase del día</h2>
							<div class="balloon">
								<blockquote>&ldquo;&nbsp;&nbsp;<?php echo ($dlince_phrase==null)?'':$dlince_phrase->phrase; ?>&nbsp;&nbsp;&rdquo;<br>
									<br>
									<strong>&ndash;&nbsp;&nbsp;<?php echo ($dlince_phrase==null)?'':$dlince_phrase->author; ?></strong></blockquote>
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
							<p>Oficina de Capacitacion.
							<br />Arequipa - Perú
							</p>
							<p><strong>Comunicate con nosotros</strong></p>
							<p>Teléfono 957841330
							<br />Correo electrónico richartescobedo@gmail.com
							</p>
						</section>
					</div>
				</div>
			</div>
			<?php //endif; ?>
			<!-- Foot/ -->
		</div>
	<!-- /Footer -->

	<!-- Copyright -->
	<div id="copyright" class="container">
		<?php echo $dlince_values['copyright'];?>
	</div>


	</body>
</html>
