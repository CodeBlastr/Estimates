<div class="estimates form">
<?php echo $this->Form->create('Estimate');?>
	<fieldset>
 		<legend><?php __('Add Estimate'); ?></legend>
	<?php
		echo $this->Form->input('Estimate.recipient_id');
		echo $this->Form->input('Estimate.estimate_number');
		echo $this->Form->input('Estimate.issue_date');
		echo $this->Form->input('Estimate.expiration_date');
		echo $this->Form->input('Estimate.po_number');
		#echo $this->Form->input('Estimate.estimate_type_id');
		#echo $this->Form->input('Estimate.estimate_status_id');
		echo $this->Form->input('Estimate.introduction' /*, array('type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))) */);
		#echo $this->Form->input('Estimate.conclusion' /*, array('type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image')))*/);
		echo $this->Form->input('Estimate.is_accepted', array('value' => 0, 'type' => 'hidden'));
		echo $this->Form->input('Estimate.is_archived', array('value' => 0, 'type' => 'hidden'));
	?>
	</fieldset>
<div class="e_result">    
<div class="addMoreEstimateItem">
		<div class="formRow">   
	<fieldset>
 		<legend><?php __('Add Estimate Item'); ?></legend>
	<?php
		echo $this->Form->input('EstimateItem.0.estimate_item_type_id');
		echo $this->Form->input('EstimateItem.0.foreign_key');
		echo $this->Form->input('EstimateItem.0.model');
		echo $this->Form->input('EstimateItem.0.notes');
		echo $this->Form->input('EstimateItem.0.quantity');
		echo $this->Form->input('EstimateItem.0.price');
		echo $this->Form->input('EstimateItem.0.order', array('default' => 0));
		echo $this->Form->input('EstimateItem.0.is_reusable', array('default' => 0));
	?>
	</fieldset>
	</div>
</div>
</div>
	<fieldset>
 		<legend><?php __('Cost'); ?></legend>
	<?php
		echo $this->Form->input('Estimate.discount', array('after' => '%'));
		echo $this->Form->input('Estimate.sub_total');
		echo $this->Form->input('Estimate.total');
		echo !empty($model) ? $this->Form->input('Estimated.0.model', array('value' => $model, 'type' => 'hidden')) : null;
		echo !empty($foreignKey) ? $this->Form->input('Estimated.0.foreign_key', array('value' => $foreignKey, 'type' => 'hidden')) : null;
	?>
	</fieldset>
    
    
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Estimates', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Enumerations', true), array('controller' => 'enumerations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estimate Type', true), array('controller' => 'enumerations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recipient', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Estimateds', true), array('controller' => 'estimateds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estimated', true), array('controller' => 'estimateds', 'action' => 'add')); ?> </li>
	</ul>
</div>
<?php echo $this->Html->script('/js/jquery.formmodifier.js');?>
<a id="addMoreEstimateItem_lnk" href="#">New Estimated Item</a>
<script type="text/javascript">
$(function() {
	$('#addMoreEstimateItem_lnk').live('click', function(e) {
		   e.preventDefault();		   
			$('.addMoreEstimateItem').FormModifier({
				actionElem		:		'#addMoreEstimateItem_lnk',
				cloneElem		:		'.addMoreEstimateItem',
				cloneRow		:		true,
				isParent		:		true,
				labelPrefix		:		null,
				labelDiv		:		'',
				child			:		'.formRow',
				formid			:		'EstimateAddForm',
				canDeleteLast	:		true,
				appendTo		:		'e_result'
			});
			$('.addMoreEstimateItem').data('FormModifier').appendRow();		
		});
});
</script>