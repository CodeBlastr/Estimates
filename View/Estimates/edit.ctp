<div class="estimates form">
<?php echo $this->Form->create('Estimate');?>
	<fieldset>
 		<legend><?php echo __('Edit Estimate'); ?></legend>
	<?php
		echo $this->Form->input('id');
		//echo $this->Form->input('estimate_type_id');
		//echo $this->Form->input('estimate_status_id');
		echo $this->Form->input('estimate_number');
		echo $this->Form->input('po_number');
		echo $this->Form->input('name');
		echo $this->Form->input('introduction');
		echo $this->Form->input('conclusion');
		echo $this->Form->input('issue_date');
		echo $this->Form->input('expiration_date');
		echo $this->Form->input('discount');
		echo $this->Form->input('sub_total');
		echo $this->Form->input('total');
		echo $this->Form->input('is_accepted');
		echo $this->Form->input('is_archived');
		echo $this->Form->input('recipient_id');
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
			$this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Estimate.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Estimate.id'))),
			$this->Html->link(__('List Estimates', true), array('action' => 'index')),
			$this->Html->link(__('List Enumerations', true), array('controller' => 'enumerations', 'action' => 'index')),
			$this->Html->link(__('New Estimate Type', true), array('controller' => 'enumerations', 'action' => 'add')),
			$this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')),
			$this->Html->link(__('New Recipient', true), array('controller' => 'users', 'action' => 'add')),
			$this->Html->link(__('List Estimateds', true), array('controller' => 'estimateds', 'action' => 'index')),
			$this->Html->link(__('New Estimated', true), array('controller' => 'estimateds', 'action' => 'add')),
			)
		),
	)));
?>