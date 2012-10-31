<?php
class EstimatesController extends EstimatesAppController {

	public $name = 'Estimates';
	public $uses = 'Estimates.Estimate';
	public $components = array('Comments.Comments' => array('userModelClass' => 'Users.User'));
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->passedArgs['comment_view_type'] = 'threaded';
	}

	public function index($model = null, $foreignKey = null) {
		$this->set('estimates', $this->paginate());
	}

	public function view($id = null) {
		$this->Estimate->id = $id;
		if (!$this->Estimate->exists()) {
			throw new NotFoundException(__('Estimate not found'));
		}
		
		$this->Estimate->contain(array('EstimateItem', 'Contact', 'Creator', 'Recipient'));
		$this->set('estimate', $this->Estimate->read(null, $id));
	}

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

	public function edit($id = null) {
		$this->Estimate->id = $id;
		if (!$this->Estimate->exists()) {
			throw new NotFoundException(__('Estimate not found'));
		}
		if (!empty($this->request->data)) {
			try {
				$this->Estimate->save($this->request->data);
				$this->Session->setFlash(__('The estimate has been saved'));
				$this->redirect(array('action' => 'index'));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		
		$this->request->data = $this->Estimate->read(null, $id);
		//$estimateTypes = $this->Estimate->EstimateType->find('list');
		//$estimateStatuses = $this->Estimate->EstimateStatus->find('list');
		$recipients = $this->Estimate->Recipient->find('list');
		$creators = $this->Estimate->Creator->find('list');
		$modifiers = $this->Estimate->Modifier->find('list');
		$this->set(compact('recipients', 'creators', 'modifiers'));
	}

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