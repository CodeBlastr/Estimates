<?php
class Estimated extends EstimatesAppModel {
	var $name = 'Estimated';
	var $useTable = 'estimated';
	var $validate = array(); 
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