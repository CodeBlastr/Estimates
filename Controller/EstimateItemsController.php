<?php
class EstimateItemsController extends EstimatesAppController {

	public $name = 'EstimateItems';
	public $uses = 'Estimates.EstimateItem';

	public function index() {
		$this->EstimateItem->recursive = 0;
		$this->set('estimateItems', $this->paginate());
	}

	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid estimate item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('estimateItem', $this->EstimateItem->read(null, $id));
	}

	public function add() {
		if (!empty($this->request->data)) {
			$this->EstimateItem->create();
			if ($this->EstimateItem->save($this->request->data)) {
				$this->Session->setFlash(__('The estimate item has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The estimate item could not be saved. Please, try again.', true));
			}
		}
		$estimates = $this->EstimateItem->Estimate->find('list');
		$this->set(compact('estimates'));
	}

	public function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid estimate item', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->EstimateItem->save($this->request->data)) {
				$this->Session->setFlash(__('The estimate item has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The estimate item could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->EstimateItem->read(null, $id);
		}
		$estimates = $this->EstimateItem->Estimate->find('list');
		$this->set(compact('estimates'));
	}

	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for estimate item'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EstimateItem->delete($id)) {
			$this->Session->setFlash(__('Estimate item deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Estimate item was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}