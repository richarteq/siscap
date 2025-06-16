<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>

<div class="menu-left">
<ul class="list-menu-left">
<li><?= $this->Html->link(__('Frases'), ['action' => 'index'],['style'=>'font-weight:bold']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
</ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="phrases index large-9 medium-8 columns content">
    
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>

                <th scope="col"><?= $this->Paginator->sort('author','Autor/Frase') ?></th>
                
                <th scope="col"><?= $this->Paginator->sort('state','Visible') ?></th>

                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($phrases as $phrase): ?>
            <tr>

                
                <td><?= '<strong>'.$this->Text->autoParagraph(h($phrase->author)).'</strong>'.$this->Text->autoParagraph(h($phrase->phrase)) ?></td>
                <td>
                <?php
									if(intval($phrase->state)){
										echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
									}else{
										echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
									}
								?>
                </td>

                <td class="actions">
              	<?php
              		echo $this->Html->link(
										$this->Html->image(Configure::read('DLince.icon.view'), ["alt" => __('View')]),
										['action' => 'view', $phrase->id],
										['escape' => false]
									);
									echo $this->Html->link(
										$this->Html->image(Configure::read('DLince.icon.edit'), ["alt" => __('Edit')]),
										['action' => 'edit', $phrase->id],
										['escape' => false]
									);
									echo $this->Form->postLink(
										$this->Html->image(Configure::read('DLince.icon.delete'), ["alt" => __('Delete')]),
										['action' => 'delete', $phrase->id],
										['escape' => false, 'confirm' => __('¿Esta seguro de eliminar la frase {0} del autor {1}?', $phrase->id,$phrase->author)]
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
