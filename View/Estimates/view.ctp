
<div class="well well-large pull-right last span3">
	<span class="label label-info"><?php echo !empty($estimate['Estimate']['total']) ? ZuhaInflector::pricify($estimate['Estimate']['total']) : 'No Total'; ?> </span>
</div>

<div class="estimates view">
	<?php
	echo '<h4>Details ' . $this->Html->link('Edit', array('plugin' => 'estimates', 'controller' => 'estimates', 'action' => 'edit', $estimate['Estimate']['id']), array('class' => 'btn btn-mini btn-primary')) . '</h4>';
    echo $estimate['Estimate']['introduction'];
    echo $estimate['Estimate']['description'];
    echo $estimate['Estimate']['conclusion']; ?>

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
