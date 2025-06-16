<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<div class="menu-left">

<ul class="list-menu-left">
<!-- <ACCIONES -->
<li><?= $this->Html->link(__('Editar'), ['action' => 'edit', $video->id]) ?></li>
<li><?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $video->id], ['confirm' => __('¿Esta seguro de eliminar este video?')]) ?> </li>
<li><?= $this->Html->link(__('Videos'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
<!-- ACCIONES> -->
</ul>

</div>
<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="videos view large-9 medium-8 columns content">
    
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Curso') ?></th>
            <td><?= $video->course->name ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('URL del video') ?></th>
            <td><a target="_blank" href="<?= trim($video->url) ?>"><?= trim($video->url) ?></a></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tamaño') ?></th>
            <td><?= $this->Number->format($video->width).' x '.$this->Number->format($video->height) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('¿El video esta visible?') ?></th>
            <td>
              <?php
                if(intval($video->state)){
                  echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
                }else{
                  echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
                }
              ?>
            </td>
        </tr>
        <tr>
	          <th scope="row"><?= __('Fecha que publicaron el video') ?></th>
	          <td colspan="2"><?= 'El '.$video->created->format('d \d\e ').__($video->created->format('F')).$video->created->format(' \d\e\l Y \a \l\a\s H:i:s A') ?></td>
	      </tr>
        <tr>
            <th scope="row"><?= __('Título del video') ?></th>
            <td><?= h($video->title) ?></td>
        </tr>
    </table>
    <div class="description">
        <h4><?= __('Descripción del video') ?></h4>
        <?= $this->Text->autoParagraph(h($video->description)); ?>
        <br/>
        <?php
          $video_type = 'video';
          if(  strpos($video->url,'youtube.com') ){
            $video_type = 'youtube';
          }elseif(  strpos($video->url,'vimeo.com') ){
            $video_type = 'vimeo';
          }
        ?>
        <?php
          switch($video_type){
            case 'youtube':
            ?>
            <iframe frameborder="0" allowfullscreen src="https://www.youtube.com/embed/<?= substr($video->url, strrpos($video->url, "=")+1)."?showinfo=0" ?>" width="<?= $video->width ?>" height="<?= $video->height ?>" ></iframe>
            <?php
            break;
            case 'vimeo':
            ?>
            <iframe src="https://player.vimeo.com/video/<?= substr($video->url, strrpos($video->url, "/")+1) ?>" width="<?= $video->width ?>" height="<?= $video->height ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            <?php
            break;
            default:
            ?>
            <a target="_blank" href="<?= trim($video->url) ?>"><?= $this->Html->image(Configure::read('DLince.icon256.'.$video), ["alt" => __('Video'),'style'=>'margin-right:5px;']) ?></a>
            <?php
          }
        ?>
    </div>
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>