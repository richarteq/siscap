<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>

<div class="menu-left">
  <ul class="list-menu-left">
    <li><?= $this->Html->link(__('Archivos'), ['action' => 'index'],['style'=>'font-weight:bold']) ?></li>
    <li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
  </ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->
<div class="files index large-9 medium-8 columns content">
  <table cellpadding="0" cellspacing="0">
    <thead>
      <tr>
        <th scope="col"><?= $this->Paginator->sort('course_id','Curso') ?></th>
        <th scope="col" colspan="2"><?= $this->Paginator->sort('src','Archivo') ?></th>
        <th scope="col"><?= $this->Paginator->sort('state','¿Visible?') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created','Publicado') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($files as $file): ?>
      <tr>
        <td style="font-weight:bold;"><?= $file->has('course') ? $file->course->id .' '. $this->Html->link($file->course->name, ['controller' => 'Courses', 'action' => 'view', $file->course->id]) : '' ?>          
        </td>
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
						['controller'=>'Files','action' => 'download', $file->course_id, $file->id, $file->src],
						['escape' => false,'target'=>'_blank']
					);
          ?>
        </td>
        <td>
          <?php
						if(intval($file->state)==1){
							echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
						}else{
							echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
						}
					?>
        </td>
        <td><?= h($file->created) ?></td>
        <td class="actions">
          <?php
            echo $this->Html->link(
              $this->Html->image(Configure::read('DLince.icon.view'), ["alt" => __('View')]),
              ['action' => 'view', $file->id],
              ['escape' => false]
            );
            
            echo $this->Form->postLink(
              $this->Html->image(Configure::read('DLince.icon.delete'), ["alt" => __('Delete')]),
              ['action' => 'delete', $file->id],
              ['escape' => false, 'confirm' => __('¿Esta seguro de quitar el archivo {0}?',$file->src)]
            );
          ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="paginator">
    <ul class="pagination">
      <?= $this->Paginator->first('<< ' . __('first')) ?>
      <?= $this->Paginator->prev('< ' . __('previous')) ?>
      <?= $this->Paginator->numbers() ?>
      <?= $this->Paginator->next(__('next') . ' >') ?>
      <?= $this->Paginator->last(__('last') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
  </div>
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>