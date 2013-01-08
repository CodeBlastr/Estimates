<?php
class EstimateItem extends EstimatesAppModel {
	public $name = 'EstimateItem';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
    public $actsAs = array('Metable');
    
	public $belongsTo = array(
		'Estimate' => array(
			'className' => 'Estimates.Estimate',
			'foreignKey' => 'estimate_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
    
    
    
}