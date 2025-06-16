<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<div class="menu-left">
<ul class="list-menu-left">
<!-- <ACCIONES -->
<li><?= $this->Html->link(__('Editar'), ['action' => 'edit', $phrase->id]) ?></li>
<li><?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $phrase->id], ['confirm' => __('¿Esta seguro de eliminar esta frase?')]) ?> </li>
<li><?= $this->Html->link(__('Frases'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
<!-- ACCIONES> -->
</ul>
</section>
</div>

<div class="phrases view large-9 medium-8 columns content">

    <table class="vertical-table">


        <tr>
            <th scope="row"><?= __('Autor') ?></th>
            <td><?= h($phrase->author) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Visible') ?></th>
            <td>
              <?php
                if(intval($phrase->state)){
                  echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
                }else{
                  echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
                }
              ?>
            </td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Frase') ?></h4>
        <?= $this->Text->autoParagraph(h($phrase->phrase)); ?>
    </div>
</div>

<!-- CONTENIDO PRINCIPAL> -->

</section>
</div>
<!-- VISTA> -->
