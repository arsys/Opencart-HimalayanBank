<?php
class ControllerPaymentHbl extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/hbl');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('hbl', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');

		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['merchant_id'] = $this->language->get('merchant_id');
		$data['merchant_key'] = $this->language->get('merchant_key');
		$data['transaction_mode'] = $this->language->get('transaction_mode');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['help_total'] = $this->language->get('help_total');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['merchantid'])) {
			$data['error_merchantid'] = $this->error['merchantid'];
		} else {
			$data['error_merchantid'] = '';
		}

		if (isset($this->error['merchantkey'])) {
			$data['error_merchantkey'] = $this->error['merchantkey'];
		} else {
			$data['error_merchantkey'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('payment/hbl', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('payment/hbl', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['hbl_merchant_id'])) {
			$data['hbl_merchant_id'] = $this->request->post['hbl_merchant_id'];
		} else {
			$data['hbl_merchant_id'] = $this->config->get('hbl_merchant_id');
		}

		if (isset($this->request->post['hbl_merchant_key'])) {
			$data['hbl_merchant_key'] = $this->request->post['hbl_merchant_key'];
		} else {
			$data['hbl_merchant_key'] = $this->config->get('hbl_merchant_key');
		}

		if (isset($this->request->post['hbl_transaction_mode'])) {
			$data['hbl_transaction_mode'] = $this->request->post['hbl_transaction_mode'];
		} else {
			$data['hbl_transaction_mode'] = $this->config->get('hbl_transaction_mode');
		}

		if (isset($this->request->post['hbl_total'])) {
			$data['hbl_total'] = $this->request->post['hbl_total'];
		} else {
			$data['hbl_total'] = $this->config->get('hbl_total');
		}

		if (isset($this->request->post['hbl_order_status_id'])) {
			$data['hbl_order_status_id'] = $this->request->post['hbl_order_status_id'];
		} else {
			$data['hbl_order_status_id'] = $this->config->get('hbl_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['hbl_geo_zone_id'])) {
			$data['hbl_geo_zone_id'] = $this->request->post['hbl_geo_zone_id'];
		} else {
			$data['hbl_geo_zone_id'] = $this->config->get('hbl_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['hbl_status'])) {
			$data['hbl_status'] = $this->request->post['hbl_status'];
		} else {
			$data['hbl_status'] = $this->config->get('hbl_status');
		}

		if (isset($this->request->post['hbl_sort_order'])) {
			$data['hbl_sort_order'] = $this->request->post['hbl_sort_order'];
		} else {
			$data['hbl_sort_order'] = $this->config->get('hbl_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('payment/hbl.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/hbl')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['hbl_merchant_id']) {
			$this->error['merchantid'] = $this->language->get('error_merchantid');
		}

		if (!$this->request->post['hbl_merchant_key']) {
			$this->error['merchantkey'] = $this->language->get('error_merchantkey');
		}

		return !$this->error;
	}
}