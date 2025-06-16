<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<div class="menu-left">
<ul class="list-menu-left">
<!-- <ACCIONES -->

<li><?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $file->id], ['confirm' => __('¿Esta seguro de eliminar este archivo?')]) ?> </li>
<li><?= $this->Html->link(__('Archivos'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
<!-- ACCIONES> -->
</ul>
</section>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="files view large-9 medium-8 columns content">

    <table class="vertical-table">
      <tr>
          <th scope="row"><?= __('Curso') ?></th>
          <td colspan="2"><?= $file->course->name ?></td>
      </tr>
        <tr>
            <th scope="row"><?= __('Archivo adjuntado') ?></th>
            <td>
              <?php
              $icon = 'DLince.icon.download';
              switch( substr($file->src, strrpos($file->src, ".")+1) )
              {
                case 'pdf':
                  $icon = 'DLince.icon.pdf'; break;
                case 'txt':
                  $icon = 'DLince.icon.txt'; break;
                case 'rar':
                  $icon = 'DLince.icon.rar'; break;
                case '7zip':
                  $icon = 'DLince.icon.7zip'; break;
                case 'zip':
                  $icon = 'DLince.icon.zip'; break;
                case 'jpeg':
                  $icon = 'DLince.icon.jpeg'; break;
                case 'jpg':
                  $icon = 'DLince.icon.jpg'; break;
                case 'gif':
                  $icon = 'DLince.icon.gif'; break;
                case 'png':
                  $icon = 'DLince.icon.png'; break;
                case 'pptx':
                  $icon = 'DLince.icon.powerpoint'; break;
                case 'xlsx':
                  $icon = 'DLince.icon.excel'; break;
                case 'docx':
                  $icon = 'DLince.icon.word'; break;
                case 'odp':
                  $icon = 'DLince.icon.impress'; break;
                case 'odc':
                  $icon = 'DLince.icon.calc'; break;
                case 'odt':
                  $icon = 'DLince.icon.writer'; break;
                default:
                  $icon = 'DLince.icon.download';
              }
              echo $this->Html->link(
                $this->Html->image(Configure::read($icon), ["alt" => __('View')]),
                ['controller'=>'Files','action' => 'download', $file->course_id, $file->id, $file->src],
                ['escape' => false,'target'=>'_blank']
              );

              ?>
            </td>
            <td>
            <?php
              echo $this->Html->link(
                $file->src,
                ['controller'=>'Files','action' => 'download_file', $file->course_id, $file->id, $file->src],
                ['escape' => false,'target'=>'_blank']
              );
            ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?= __('¿El archivo esta activo?') ?></th>
            <td colspan="2">
              <?php
                if(intval($file->state)==1){
                  echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
                }else{
                  echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
                }
              ?>
            </td>
        </tr>
        <tr>
	          <th scope="row"><?= __('Fecha que enviaron el archivo') ?></th>
	          <td colspan="2"><?= $file->created->format('d \d\e ').__($file->created->format('F')).$file->created->format(' \d\e\l Y \a \l\a\s H:i:s A') ?></td>
	      </tr>
        <tr>
            <th scope="row" colspan="2"><?= __('Título del archivo') ?></th>
            <td><?= h($file->title) ?></td>
        </tr>
    </table>
    <div class="description">
        <h4><?= __('Descripción del archivo adjuntado') ?></h4>
        <?= $this->Text->autoParagraph(h($file->description)); ?>
    </div>
</div>

<!-- CONTENIDO PRINCIPAL> -->

</section>
</div>
<!-- VISTA> -->
