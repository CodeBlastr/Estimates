<?php
class EstimateItem extends EstimatesAppModel {
	var $name = 'EstimateItem';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Estimate' => array(
			'className' => 'Estimates.Estimate',
			'foreignKey' => 'estimate_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>