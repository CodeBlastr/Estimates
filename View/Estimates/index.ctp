<div class="estimates index">
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('estimate_number');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('expiration_date');?></th>
			<th><?php echo $this->Paginator->sort('total');?></th>
			<th><?php echo $this->Paginator->sort('is_accepted');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($estimates as $estimate):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $estimate['Estimate']['estimate_number']; ?>&nbsp;</td>
		<td><?php echo $estimate['Estimate']['name']; ?>&nbsp;</td>
		<td><?php echo $estimate['Estimate']['expiration_date']; ?>&nbsp;</td>
		<td><?php echo __('$'); echo $estimate['Estimate']['total']; ?>&nbsp;</td>
		<td><?php echo $estimate['Estimate']['is_accepted']?'yes':'no' ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $estimate['Estimate']['id'])); ?>
			<?php # echo $this->Html->link(__('Edit', true), array('action' => 'edit', $estimate['Estimate']['id'])); ?>
			<?php # echo $this->Html->link(__('Delete', true), array('action' => 'delete', $estimate['Estimate']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $estimate['Estimate']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
<?php echo $this->Element('paging'); ?>
<!--div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Estimate', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Enumerations', true), array('controller' => 'enumerations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estimate Type', true), array('controller' => 'enumerations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recipient', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Estimateds', true), array('controller' => 'estimateds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estimated', true), array('controller' => 'estimateds', 'action' => 'add')); ?> </li>
	</ul>
</div-->


        
<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Estimates',
		'items' => array(
			$this->Html->link(__('Add'), array('plugin' => 'estimates', 'controller'=> 'estimates', 'action' => 'add')),
			),
		),
	))); ?>