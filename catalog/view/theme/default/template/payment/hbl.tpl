<form method="post" action="<?php echo $transaction_link;?>">
	<input type="hidden" id="paymentGatewayID" name="paymentGatewayID" value="<?php echo $merchant_id;?>"/>
	<input type="hidden" id="invoiceNo" name="invoiceNo" value="<?php echo $order_id;?>"/>
	<input type="hidden" id="productDesc" name="productDesc" value="<?php echo $person_info;?>"/>
	<input type="hidden" id="amount" name="amount" value="<?php echo $amount;?>"/>
	<input type="hidden" id="currencyCode" name="currencyCode" value="<?php echo $merchant_currency;?>"/>
	<input type="hidden" id="userDefined1" name="userDefined1" value="<?php echo $order_id;?>"/>
	<input type="hidden" id="nonSecure" name="nonSecure" value="Y"/>
	<input type="hidden" id="hashValue" name="hashValue" value="<?php echo $merchant_key;?>">
	<div class="buttons">
	    <div class="pull-right">
	      	<input type="submit" value="<?php echo $button_confirm; ?>" class="btn btn-primary" data-loading-text="<?php echo $text_loading; ?>"/>
	    </div>
  	</div>
</form>
