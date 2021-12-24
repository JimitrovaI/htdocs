<?php

class MY_Controller extends CI_Controller
{

    protected $langs = array();

    public function __construct()
    {

        parent::__construct();
		$this->load->library('mailer');
		$this->load->model('business_model');
		$this->load->model('transactions_model');
        $this->load->model('settings_model');

        if ($this->session->has_userdata('language')) {
            $language = $this->session->userdata('language');
        } else {
            $language = 'English';
        }

        $this->config->set_item('language', $language);
        $lang_array = array('form_validation_lang');
        $lang_array[] = 'app_files/system_lang';

        $this->load->language($lang_array, $language);
    }

}