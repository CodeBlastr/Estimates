<?php 
 
echo '<table><tr><td class="span1">';
echo $this->Element('thumb', 
    array(
	    'model' => 'User',
	    'foreignKey' => $transactionItem['assignee_id'],
	    'thumbSize' => 'small',
	    'thumbWidth' => 24,
	    'thumbHeight' => 24,
        'thumbClass' => 'thumbnail',
	    'thumbLink' => '/users/users/view/'.$transactionItem['assignee_id']
	    ),
	array('plugin' => 'galleries')
); 
echo '</td><td>';
echo $this->Html->link('<i class="icon-trash">remove</i>', array('plugin' => 'transactions', 'controller' => 'transaction_items', 'action' => 'delete', $transactionItem['id']), array('title' => 'Remove from cart', 'escape' => false));
   
echo $this->Form->input("TransactionItem.{$i}.quantity", array(
    'label' => false,
    'class' => 'TransactionItemCartQty span1',
    'div' => false,
    'value' => 1,
    'type' => 'hidden',
    ));  
$transactionItemCartPrice = $transactionItem['price'] * $transactionItem['quantity']; ?>

</td><td>

    <div class="TransactionItemCartPrice">
        $<span class="floatPrice"><?php echo number_format($transactionItemCartPrice, 2); ?></span>
    	<span class="priceOfOne"><?php echo number_format($transactionItem['price'], 2) ?></span>
    </div>
    
</td></tr></table>
