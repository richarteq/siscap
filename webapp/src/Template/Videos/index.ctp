<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>

<div class="menu-left">
<ul class="list-menu-left">
<li><?= $this->Html->link(__('Videos'), ['action' => 'index'],['style'=>'font-weight:bold']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
</ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="videos index large-9 medium-8 columns content">
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('course_id','Curso - URL del video') ?></th>                
                <th scope="col"><?= $this->Paginator->sort('state','¿Activo?') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created','Publicado') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($videos as $video): ?>
            <tr>
                <td>
                  <span style="clear:left; float:left;"><?= $video->has('course') ? "<span style=\"font-weight:bold;\">" . $video->course->id .' '. $this->Html->link($video->course->name, ['controller' => 'Courses', 'action' => 'view', $video->course->id])."</span>" : '' ?>
                  </span>
                  <span style="clear:left; float:left; margin-top: 5px;">
                    <a target="_blank" href="<?= trim($video->url) ?>"><?= trim($video->url) ?></a>
                  </span>
                </td>
            
                <td>
                  <?php
  									if(intval($video->state)){
  										echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
  									}else{
  										echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
  									}
  								?>
                </td>
                <td><?= h($video->created) ?></td>
                <td class="actions">
                <?php
                  echo $this->Html->link(
                    $this->Html->image(Configure::read('DLince.icon.view'), ["alt" => __('View')]),
                    ['action' => 'view', $video->id],
                    ['escape' => false]
                  );
                  echo $this->Html->link(
                    $this->Html->image(Configure::read('DLince.icon.edit'), ["alt" => __('Edit')]),
                    ['action' => 'edit', $video->id],
                    ['escape' => false]
                  );
                  echo $this->Form->postLink(
                    $this->Html->image(Configure::read('DLince.icon.delete'), ["alt" => __('Delete')]),
                    ['action' => 'delete', $video->id],
                    ['escape' => false, 'confirm' => __('¿Esta seguro de quitar el video?')]
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
<!-- VISTA> -->
