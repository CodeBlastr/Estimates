<?php
class EstimatesController extends EstimatesAppController {

	var $name = 'Estimates';
	var $components = array('Comments.Comments' => array('userModelClass' => 'Users.User'));
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->passedArgs['comment_view_type'] = 'threaded';
	}

	function index($model = null, $foreignKey = null) {
		if (!empty($model) && !empty($foreignKey)) {
			$options = array(
				'joins' => array(
					array(
						'table' => 'estimated',
						'alias' => 'Estimated',
						'type' => 'LEFT',
						'conditions' => array(
								'Estimated.estimate_id = Estimate.id',
								),
							),
						),
				'conditions' => array(
					'Estimated.model' => $model,
					'Estimated.foreign_key' => $foreignKey,
					),
				'contain' => array(
					'EstimateStatus',
					'Recipient',
					),
				);
		} else {
			$options = array(
				'contain' => array(
					'EstimateStatus',
					'Recipient',
					),
				);
		} 
	
		$this->paginate = $options;
		$this->set('estimates', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid estimate', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Estimate->contain(array('Creator', 'Estimated'));
		$this->set('estimate', $this->Estimate->read(null, $id));
	}

	function accept($id = null) {
		if ($id) {
			if ($this->Estimate->accept($id)){
				$estimate = $this->Estimate->find('first', array(
					'conditions' => array(
						'Estimate.id' => $id
						),
					'contain' => array(
						'Creator',
						),
					)); 
				$message = '<p>Congratulations, your estimate was accepted. You can review your estimate <a href="'.$_SERVER['HTTP_HOST'].'/estimates/estimates/view/'.$estimate['Estimate']['id'].'">here</a></p>';
				$this->__sendMail($estimate['Creator']['email'], 'Estimate Accepted', $message, $template = 'default');
				$this->Session->setFlash(__('Estimate accepted', true));
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('There was a problem please try again.', true));
				$this->redirect(array('action' => 'view', $id));
			}
		} else {
			$this->Session->setFlash(__('Invalid estimate', true));
			$this->redirect(array('action' => 'view', $id));
		}
	}

	function add($model = null, $foreignKey = null) {
		if (!empty($this->request->data)) {
			$this->Estimate->create();
			if ($this->Estimate->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The estimate has been saved', true));
				$this->redirect(array('action' => 'view', $this->Estimate->id));
			} else {
				$this->Session->setFlash(__('The estimate could not be saved. Please, try again.', true));
			}
		}
		if (!empty($model)) {
			$this->Model = ClassRegistry::init($model);
			$foreignRecord = $this->Model->find('first', array('conditions' => array($model.'.id' => $foreignKey)));
		}
		$estimateTypes = $this->Estimate->EstimateType->find('list');
		$estimateStatuses = $this->Estimate->EstimateStatus->find('list');
		$recipients = $this->Estimate->Recipient->find('list');
		$estimateItemTypes = $this->Estimate->EstimateItem->EstimateItemType->find('list');
		$this->set(compact('model', 'foreignKey', 'foreignRecord', 'estimateTypes', 'estimateStatuses', 'recipients', 'estimateItemTypes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid estimate', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Estimate->save($this->request->data)) {
				$this->Session->setFlash(__('The estimate has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The estimate could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Estimate->read(null, $id);
		}
		$estimateTypes = $this->Estimate->EstimateType->find('list');
		$estimateStatuses = $this->Estimate->EstimateStatus->find('list');
		$recipients = $this->Estimate->Recipient->find('list');
		$creators = $this->Estimate->Creator->find('list');
		$modifiers = $this->Estimate->Modifier->find('list');
		$this->set(compact('estimateTypes', 'estimateStatuses', 'recipients', 'creators', 'modifiers'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for estimate', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Estimate->delete($id)) {
			$this->Session->setFlash(__('Estimate deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Estimate was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->Estimate->recursive = 0;
		$this->set('estimates', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid estimate', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('estimate', $this->Estimate->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->request->data)) {
			$this->Estimate->create();
			if ($this->Estimate->save($this->request->data)) {
				$this->Session->setFlash(__('The estimate has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The estimate could not be saved. Please, try again.', true));
			}
		}
		$estimateTypes = $this->Estimate->EstimateType->find('list');
		$estimateStatuses = $this->Estimate->EstimateStatus->find('list');
		$recipients = $this->Estimate->Recipient->find('list');
		$creators = $this->Estimate->Creator->find('list');
		$modifiers = $this->Estimate->Modifier->find('list');
		$this->set(compact('estimateTypes', 'estimateStatuses', 'recipients', 'creators', 'modifiers'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid estimate', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Estimate->save($this->request->data)) {
				$this->Session->setFlash(__('The estimate has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The estimate could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Estimate->read(null, $id);
		}
		$estimateTypes = $this->Estimate->EstimateType->find('list');
		$estimateStatuses = $this->Estimate->EstimateStatus->find('list');
		$recipients = $this->Estimate->Recipient->find('list');
		$creators = $this->Estimate->Creator->find('list');
		$modifiers = $this->Estimate->Modifier->find('list');
		$this->set(compact('estimateTypes', 'estimateStatuses', 'recipients', 'creators', 'modifiers'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for estimate', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Estimate->delete($id)) {
			$this->Session->setFlash(__('Estimate deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Estimate was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>