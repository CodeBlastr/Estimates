<div class="estimates view">
	
    <?php debug($estimate); ?>
	
</div>


        
<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Estimates',
		'items' => array(
			$this->Html->link(__('List'), array('plugin' => 'estimates', 'controller'=> 'estimates', 'action' => 'index')),
			$this->Html->link(__('Edit'), array('plugin' => 'estimates', 'controller'=> 'estimates', 'action' => 'edit', $estimate['Estimate']['id'])),
			),
		),
	))); ?>
