<?php
App::uses('EstimatesAppController', 'Estimates.Controller');

class AppEstimatesController extends EstimatesAppController {
    
/**
 * Name
 * 
 * @var string
 */
	public $name = 'Estimates';
    
/**
 * Uses
 * 
 * @var string
 */
	public $uses = 'Estimates.Estimate';
    
/**
 * Components
 * 
 * @var array
 */
	//public $components = array('Comments.Comments' => array('userModelClass' => 'Users.User'));
	
/**
 * Before Filter
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->passedArgs['comment_view_type'] = 'threaded';
	}

/**
 * Index method
 * 
 * @param type $model
 * @param type $foreignKey
 */
	public function index($model = null, $foreignKey = null) { 
		$this->set('estimates', $this->paginate());                        
	}

/**
 * View method
 * 
 * @param type $id
 * @throws NotFoundException
 */
	public function view($id = null) {
		$this->Estimate->id = $id;
		if (!$this->Estimate->exists()) {
			throw new NotFoundException(__('Estimate not found'));
		}
		
		$this->Estimate->contain(array('EstimateItem', 'Contact', 'Creator', 'Recipient'));
        $estimate = $this->Estimate->read(null, $id);
		$this->set('estimate', $estimate);
        $this->set('page_title_for_layout', $estimate['Estimate']['name']);
        $this->set('relatedRecord', array('plugin' => Inflector::tableize(ZuhaInflector::pluginize($estimate['Estimate']['model'])), 'controller' => Inflector::tableize($estimate['Estimate']['model']), 'action' => 'view', $estimate['Estimate']['foreign_key']));
	}

/**
 * Accept method
 * 
 * @param type $id
 * @throws NotFoundException
 */
	public function accept($id = null) {
		$this->Estimate->id = $id;
		if (!$this->Estimate->exists()) {
			throw new NotFoundException(__('Estimate not found'));
		}
		
		try {
			$this->Estimate->accept($id);
			$this->Session->setFlash(__('Estimate accepted'));
			$this->redirect(array('action' => 'view', $id));
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'view', $id));
		}
	}

/**
 * Add method
 * 
 * @param type $model
 * @param type $foreignKey
 */
	public function add($model = null, $foreignKey = null) {
		if (!empty($this->request->data)) {
			try {
				$this->Estimate->create();
				$this->Estimate->saveAll($this->request->data);
				$this->Session->setFlash(__('The estimate has been saved'));
				$this->redirect(array('action' => 'view', $this->Estimate->id));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		if (!empty($model)) {
			$this->Model = ClassRegistry::init($model);
			$foreignRecord = $this->Model->find('first', array('conditions' => array($model.'.id' => $foreignKey)));
		}
		$recipients = $this->Estimate->Recipient->find('list');
		$this->set(compact('model', 'foreignKey', 'foreignRecord', 'recipients'));
	}

/**
 * Edit method
 * 
 * @param type $id
 * @throws NotFoundException
 */
	public function edit($id = null) {
		$this->Estimate->id = $id;
		if (!$this->Estimate->exists()) {
			throw new NotFoundException(__('Estimate not found'));
		}
		if (!empty($this->request->data)) {
			try {
				$this->Estimate->save($this->request->data);
				$this->Session->setFlash(__('Estimate has been saved'));
				$this->redirect(array('action' => 'index'));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		
		$this->request->data = $this->Estimate->read(null, $id);
		//$estimateTypes = $this->Estimate->EstimateType->find('list');
		//$estimateStatuses = $this->Estimate->EstimateStatus->find('list');
		$recipients = $this->Estimate->Recipient->find('list');
		$this->set(compact('recipients'));
        $this->set('relatedRecord', array('plugin' => Inflector::tableize(ZuhaInflector::pluginize($this->request->data['Estimate']['model'])), 'controller' => Inflector::tableize($this->request->data['Estimate']['model']), 'action' => 'view', $this->request->data['Estimate']['foreign_key']));
	}

/**
 * Delete method
 * 
 * @param type $id
 * @throws NotFoundException
 */
	public function delete($id = null) {
		$this->Estimate->id = $id;
		if (!$this->Estimate->exists()) {
			throw new NotFoundException(__('Estimate not found'));
		}
		if ($this->Estimate->delete($id)) {
			$this->Session->setFlash(__('Estimate deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Estimate was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}

if (!isset($refuseInit)) {
	class EstimatesController extends AppEstimatesController {}
}