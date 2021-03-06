<?php
  
App::uses('EstimatesAppModel', 'Estimates.Model');

class AppEstimate extends EstimatesAppModel {

	public $name = 'Estimate';

	public $displayField = 'name';
	
	public $actsAs = array('Metable');

	public $validate = array(
		'total' => array(
			'notempty'
			),
		'is_accepted' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				)
			),
		'is_archived' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				)
			)
		);

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
		'EstimateKey' => array(
			'className' => 'Estimates.EstimateKey',
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
			)
		);
	
/**
 * Before Save method
 *
 * @return bool
 */
	public function beforeSave($options = array()) {
		// give the estimate a name for easy drop down fields in other parts
		if (empty($this->data['Estimate']['name']) && !empty($this->data['Estimate']['estimate_number']) && !empty($this->data['Estimate']['id'])) {
			$this->data['Estimate']['name'] = __('Estimate: %s', $this->data['Estimate']['estimate_number']);
		} else if (empty($this->data['Estimate']['name'])) {
			$this->data['Estimate']['name'] = __('Estimate: %s', ($this->find('count') + 1));
		}

		if (!empty($this->data['Estimate']['is_accepted']) && !empty($this->data['Estimate']['id'])) {
			// set the closed date on estimate it is the first time this is being saved with is_accepted equal to true
			$newlyAccepted = $this->find('count', array('conditions' => array('Estimate.is_accepted' => 0, 'Estimate.id' => $this->data['Estimate']['id'])));
			if (!empty($newlyAccepted)) {
				$this->data['Estimate']['closed'] = date('Y-m-d');
			}
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

		return parent::beforeSave($options);
	}
    
/**
 * Constructor
 * 
 */
	public function __construct($id = null, $table = null, $ds = null) {
		if(CakePlugin::loaded('Media')) {
			$this->actsAs[] = 'Media.MediaAttachable';
		}
		parent::__construct($id, $table, $ds); // this order is imortant
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
 * Save all method
 * Overwritten to remove unecessary data
 */
 	public function saveAll($data = null, $options = array()) {
		// remove empty estimate keys for a saveAll
		foreach ($data['EstimateKey'] as $index => $value) {
			if (empty($value['email']) && empty($value['id'])) { // id is here so that we can catch empty emails and delete those keys
				unset($data['EstimateKey'][$index]);
			}
			// if you send an empty email (with an id for estimate keys) then delete that key
			if (!empty($value['id']) && empty($value['email'])) {
				if ($this->EstimateKey->delete($value['id'])) {
					unset($data['EstimateKey'][$index]);
				} else {
					debug('Error deleting empty key, report to admin');
					debug($this->data);
					exit;
				}
			}
		}	
		if (empty($data['EstimateKey'][0])) {
			unset($data['EstimateKey']);
		}
		return parent::saveAll($data, $options);
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
    
/**
 * After Successful Payment update status in estimates table.
 *
 * @access public
 * @param void
 * @name afterSuccessfulPayment
 */
	public function afterSuccessfulPayment($data) {
		foreach($data['TransactionItem'] as $TransactionItem) {
            $this->data['Estimate']['id']=$TransactionItem['foreign_key'];
            $this->data['Estimate']['estimate_status']='accepted';  // Update status 
            $this->save($this->data);
           
            $estimates = $this->findById($TransactionItem['foreign_key']); 
                   
            $TransactionItem['model_id'] = $estimates['Estimate']['foreign_key'];
           
			if ( !empty($estimates['Estimate']['model']) ) {
				$model=$estimates['Estimate']['model'];
				App::uses($model, ZuhaInflector::pluginize($model) . '.Model'); 
				$Model = new $model; 
				if(method_exists($Model,'afterSuccessfulPayment')) { 
					$Model->afterSuccessfulPayment($TransactionItem);
				}
			}
		}        
    } 
	
	
/**
 * After Find Callback
 * 
 */
	public function afterFind($results, $primary = false) {
	    return $this->triggerOriginCallback('origin_afterFind', $results, $primary); 
	}
	
}

if (!isset($refuseInit)) {
	class Estimate extends AppEstimate {}
}