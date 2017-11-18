<?php
class ControllerPaymentHbl extends Controller {
	public function index() {
		$data['text_loading'] = $this->language->get('text_loading');

		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['text_loading'] = $this->language->get('text_loading');

		$data['continue'] = $this->url->link('checkout/success');

		$data['merchant_id']  = $this->config->get('hbl_merchant_id');
		$data['merchant_key']  = $this->config->get('hbl_merchant_key');
		$data['merchant_currency'] = '524';

		if($this->config->get('hbl_transaction_mode')===1) {
			$data['transaction_link']  = 'https://hblpgw.2c2p.com/HBLPGW/Payment/Payment/Payment';
		} else {
			$data['transaction_link']  = 'https://hblpgw.2c2p.com/HBLPGW/Payment/Payment/Payment';
		}


		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$data['person_info'] = $order_info['firstname'].' '.$order_info['lastname'].' ('.$order_info['email'].')';

		$data['order_id'] = $this->session->data['order_id'];
		$getTotalPrice = $this->currency->format($order_info['total'], $this->currency->$order_info['currency_code'], $order_info['currency_value'], false);
		$getTotalPrice = number_format($getTotalPrice,2);
		$prcNumric = filter_var(@$getTotalPrice,FILTER_SANITIZE_NUMBER_INT);
		$amount_con = $prcNumric;
		$amount_con_length = strlen($amount_con);
		for($length=$amount_con_length;$length < 12;$length++){
			$amount_con = '0'.$amount_con;	
		}

		$data['amount'] = $amount_con;
		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/hbl.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/hbl.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/hbl.tpl', $data);
		}
	}

	public function confirm() {
		// for cancel : http://localhost/opencart/index.php?route=checkout/checkout
		// for confirm : http://localhost/opencart/index.php?route=payment/hbl/confirm
		/*$transaction = array(
		  	'nibl_order_id'   => $transaction_id,
		  	'order_id'        => $order_id,
		  	'capture_status'  => 'Complete',
		  	'currency_code'   => $currency,
		  	'total'           => $amt,
		  	'transaction_id'  => (isset($_REQUEST['BID']) ? $_REQUEST['BID'] : '')
	  	);

		$this->model_payment_nibl->updateTransaction($transaction);
		$this->model_checkout_order->addOrderHistory($order_id, 5, 'Auto-Verification of transaction successful.');*/ 

		if ($this->session->data['payment_method']['code'] == 'hbl') {
			$this->load->model('checkout/order');

			if(!empty($_POST)) {
				// Success
				$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], 5, 'Himalayan Payment Transaction Successful.');
			}
			else {
				// Failed
				$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], 7, 'Himalayan Payment Failed. Manually Check The Transaction.');  
			}
		}
	}
}