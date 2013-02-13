
<div class="well well-large pull-right last span3">
	<span class="label label-info"><?php echo !empty($estimate['Estimate']['total']) ? 'Total : $' . ZuhaInflector::pricify($estimate['Estimate']['total']) : 'No Total'; ?> </span>
</div>

<div class="estimates view">
	<?php
	echo __('<h4>Estimate for %s</h4>', $this->Html->link($estimate['Creator']['full_name'], array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $estimate['Creator']['id'])));
    echo $estimate['Estimate']['introduction'];
    echo $estimate['Estimate']['description'];
    echo $estimate['Estimate']['conclusion'];
	echo __('<h6>Services</h6>'); ?>
	<table class="table table-hover">
		<?php
		foreach ($estimate['EstimateItem'] as $item) { ?>
		<tr>
			<td><?php echo $item['estimate_item_type']; ?></td>
		</tr>
		<?php
		} ?>
	</table>
	<?php
	if ($estimate['Estimate']['estimate_status'] == 'accepted') {
		echo $this->Html->link('Confirm', array('plugin' => 'users', 'controller' => 'users', 'action' => 'confirmjob', $estimate['Estimate']['id']), array('class' => 'btn btn-primary'));
	} ?>
</div>


        
<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Estimates',
		'items' => array(
            $this->Html->link(__('%s', Inflector::singularize(Inflector::humanize($relatedRecord['controller']))), $relatedRecord), 
			$this->Html->link(__('List'), array('plugin' => 'estimates', 'controller'=> 'estimates', 'action' => 'index')),
			$this->Html->link(__('Edit'), array('plugin' => 'estimates', 'controller'=> 'estimates', 'action' => 'edit', $estimate['Estimate']['id'])),
			),
		),
	))); ?>
