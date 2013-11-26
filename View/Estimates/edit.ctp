<div class="estimates form">
<?php echo $this->Form->create('Estimate');?>
	<fieldset>
	<?php
		echo $this->Form->input('Estimate.id');
		//echo $this->Form->input('estimate_type_id');
		//echo $this->Form->input('estimate_status_id');
		//echo $this->Form->input('estimate_number');
		//echo $this->Form->input('po_number');
		echo $this->Form->input('Estimate.name');
		echo $this->Form->input('Estimate.total');
		//echo $this->Form->input('introduction', array('type' => 'richtext'));
		echo $this->Form->input('Estimate.description', array('type' => 'richtext'));
		//echo $this->Form->input('conclusion', array('type' => 'richtext'));
		//echo $this->Form->input('issue_date');
		//echo $this->Form->input('expiration_date');
		//echo $this->Form->input('discount');
		//echo $this->Form->input('sub_total');
		echo $this->Form->input('Estimate.is_accepted');
		echo $this->Form->input('Estimate.is_archived');
		echo $this->Form->input('Estimate.closed', array('label' => 'Date Accepted', 'type' => 'datepicker'));
		//echo $this->Form->input('recipient_id', array('empty' => '-- Optional --'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Save'));?>
</div>
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Estimates',
		'items' => array(
            $this->Html->link(__('%s', Inflector::singularize(Inflector::humanize($relatedRecord['controller']))), $relatedRecord), 
			$this->Html->link(__('List'), array('action' => 'index')),
			$this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Estimate.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Estimate.id'))),
			)
		),
	)));