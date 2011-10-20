<?php
class Estimate extends EstimatesAppModel {
	var $name = 'Estimate';
	var $displayField = 'name';
	var $validate = array(
		'is_accepted' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_archived' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'EstimateType' => array(
			'className' => 'Enumeration',
			'foreignKey' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'EstimateStatus' => array(
			'className' => 'Enumeration',
			'foreignKey' => 'estimate_status_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Recipient' => array(
			'className' => 'Users.User',
			'foreignKey' => 'recipient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creator' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Modifier' => array(
			'className' => 'Users.User',
			'foreignKey' => 'modifier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'EstimateItem' => array(
			'className' => 'Estimates.EstimateItem',
			'foreignKey' => 'estimate_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Estimated' => array(
			'className' => 'Estimates.Estimated',
			'foreignKey' => 'estimate_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	
	function beforeSave() {
		# give the estimate a name for easy drop down fields in other parts
		if (!empty($this->request->data['Estimate']['estimate_number']) && !empty($this->request->data['Estimate']['id'])) {
			$this->request->data['Estimate']['name'] = __('Estimate: ', true).$this->request->data['Estimate']['estimate_number'];
		} else {
			$this->request->data['Estimate']['name'] = __('Estimate: ', true).$this->request->data['Estimate']['id'];
		}
		return true;
	}
	
	function accept($id) {
		$estimate = $this->findById($id);
		if(!empty($estimate)) {
			$estimate['Estimate']['is_accepted'] = 1;
			if ($this->save($estimate)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
		break;
	}

}
?>