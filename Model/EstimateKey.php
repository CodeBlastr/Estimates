<?php
  
App::uses('EstimatesAppModel', 'Estimates.Model');

class AppEstimateKey extends EstimatesAppModel {

	public $name = 'EstimateKey';

	public $displayField = 'email';

	public $belongsTo = array(
		'Estimate' => array(
			'className' => 'Estimates.Estimate',
			'foreignKey' => 'estimate_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
			)
		);
		
	public function beforeSave($options = array()) {
		// create a key when saving for the first time (eg. no id present)
		if (empty($this->data[$this->alias]['id']) && !empty($this->data[$this->alias]['estimate_id']) && empty($this->data[$this->alias]['recipient_key'])) {
			$this->data[$this->alias]['recipient_key'] = String::uuid();
		}
		// if you update the email get a new key
		if (!empty($this->data[$this->alias]['email']) && !empty($this->data[$this->alias]['id'])) {
			$key = $this->find('count', array('conditions' => array('EstimateKey.email' => $this->data[$this->alias]['email'], 'EstimateKey.id' => $this->data[$this->alias]['id'])));
			if (empty($key)) {
				$this->data[$this->alias]['recipient_key'] = String::uuid();
			}
		}
		return true;
	}
	
}

if (!isset($refuseInit)) {
	class EstimateKey extends AppEstimateKey {}
}