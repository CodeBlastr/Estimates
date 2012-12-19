<?php
App::uses('EstimatesAppModel', 'Estimates.Model'); 

class Estimate extends EstimatesAppModel {
	public $name = 'Estimate';
	public $displayField = 'name';
	public $validate = array(
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

	public $belongsTo = array(
		'Contact' => array(
			'className' => 'Contacts.Contact',
			'foreignKey' => 'foreign_key',
			'conditions' => array('model' => 'Contact'),
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
	);

	public $hasMany = array(
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
	);
	
/**
 * Before Save method
 *
 * @return bool
 */
	public function beforeSave() {
		// give the estimate a name for easy drop down fields in other parts
		if (!empty($this->data['Estimate']['estimate_number']) && !empty($this->data['Estimate']['id'])) {
			$this->data['Estimate']['name'] = __('Estimate: ', true).$this->data['Estimate']['estimate_number'];
		} else {
			$this->data['Estimate']['name'] = __('Estimate: ', true) . ($this->find('count') + 1);
		}
		
		if (in_array('Activities', CakePlugin::loaded())) {
			// logs when an estimate is created
			$this->Behaviors->attach('Activities.Loggable', array(
				'nameField' => 'name', 
				'descriptionField' => 'total',
				'actionDescription' => 'estimate created', 
				'userField' => '', 
				'parentForeignKey' => ''
				));
		}
		return true;
	}
	
/** 
 * Accept method
 * 
 * @return bool
 */
	public function accept($id) {
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
    
    /**
 * This trims an object, formats it's values if you need to, and returns the data to be merged with the Transaction data.
 * 
 * @param string $key
 * @return array The necessary fields to add a Transaction Item
 */
    public function mapTransactionItem($key) {
        
        $itemData = $this->find('first', array('conditions' => array('id' => $key)));
        
        $fieldsToCopyDirectly = array(
            'name',
            'weight',
            'height',
            'width',
            'length',
            'shipping_type',
            'shipping_charge',
            'payment_type',
            'arb_settings',
            'is_virtual'
            );
        
        foreach($itemData['Product'] as $k => $v) {
            if(in_array($k, $fieldsToCopyDirectly)) {
                $return['TransactionItem'][$k] = $v;
            }
        }
        return $return;
    }
    
    
    public function afterSuccessfulPayment($data) {  
        
      // debug($data);
       foreach($data['TransactionItem'] as $TransactionItem) {
           $this->data['Estimate']['id']=$TransactionItem['foreign_key'];
           $this->data['Estimate']['estimate_status']='accepted'; 
           $this->save($this->data);
       }
        
    }                                               
    
    

}