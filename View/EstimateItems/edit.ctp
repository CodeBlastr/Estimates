<div class="estimateItems form">
<?php echo $this->Form->create('EstimateItem');?>
	<fieldset>
 		<legend><?php echo __('Edit Estimate Item'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('estimate_id');
		echo $this->Form->input('estimate_item_type');
		echo $this->Form->input('foreign_key');
		echo $this->Form->input('model');
		echo $this->Form->input('notes');
		echo $this->Form->input('quantity');
		echo $this->Form->input('price');
		echo $this->Form->input('order');
		echo $this->Form->input('creator_id');
		echo $this->Form->input('modifier_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Estimates',
		'items' => array(
			$this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('EstimateItem.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('EstimateItem.id'))),
			$this->Html->link(__('List Estimate Items', true), array('action' => 'index')),
			$this->Html->link(__('List Estimates', true), array('controller' => 'estimates', 'action' => 'index')),
			$this->Html->link(__('New Estimate', true), array('controller' => 'estimates', 'action' => 'add')),
			$this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')),
			$this->Html->link(__('New Creator', true), array('controller' => 'users', 'action' => 'add')),
			)
		),
	)));
?>