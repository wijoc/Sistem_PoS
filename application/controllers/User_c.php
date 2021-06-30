<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class User_c extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('User_m');
	}

  /** Function : List user */
	public function index(){
	  /** Check allowed user */
		$this->auth_user(['uAll']);

		$this->pageData = array(
			'title'  => 'PoS | List User',
			'assets' => array('datatables', 'sweetalert2', 'list_user', 'f_confirm'),
			'userAjaxUrl' => site_url('User_c/listUserAjax/')
		);
		$this->page = 'setting/user_setting_v';
		$this->layout();
	}

  /** Function : Ajax List User */
  	public function listUserAjax(){
		$userData	= array();
		foreach($this->User_m->selectUser($this->input->post('length'), $this->input->post('start'))->result_array() as $show){
			/** Set level */
			switch($show['u_level']) {
				case 'uAll':
					$showLevel = '<span class="badge badge-danger">Administrator</span>';
					break;
				case 'uO':
					$showLevel = '<span class="badge badge-warning">Owner</span>';
					break;
				case 'uG':
					$showLevel = '<span class="badge badge-info">Admin Gudang</span>';
					break;
				case 'uP':
					$showLevel = '<span class="badge badge-secondary">Admin Purchasing</span>';
					break;
				case 'uK':
					$showLevel = '<span class="badge badge-secondary">Kasir</span>';
					break;
			}

			$actionBtn = '<a class="btn btn-xs btn-warning" data-toggle="tooltip" data-target="modal-edit-user" data-placement="top" title="Edit user" onclick="editUser(\''.urlencode(base64_encode($show['u_id'])).'\', \''.site_url('User_c/detailUser/').'\', \'edit\')"><i class="fas fa-edit"></i></a>';

			$actionBtn .= ($this->session->userdata('logedInLevel') == 'uAll')? '&nbsp<a class="btn btn-xs btn-secondary" data-toggle="tooltip" data-target="modal-change-password" data-placement="top" title="Ganti Password" onclick="editUser(\''.urlencode(base64_encode($show['u_id'])).'\', \''.site_url('User_c/detailUser/').'\', \'change-password\')"><i class="fas fa-key"></i></a>' : '';

			if($show['u_level'] != $this->session->userdata('logedInLevel')){
				$actionBtn .= '&nbsp;<a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus user" onclick="confirmDelete(\'hard-user\', \''.urlencode(base64_encode($show['u_id'])).'\', \' '.site_url('User_c/deleteUser/hard/').' \')"><i class="fas fa-trash"></i></a>';
			}

			$row = array();
			
			$row[] = $show['u_name'];
			$row[] = $show['u_username'];
			$row[] = $showLevel;
			if( in_array($this->session->userdata('logedInLevel'), ['uAll']) == TRUE ){
				$row[] = $actionBtn;
			}
			$userData[] = $row;
		}

		$output = array(
			'draw'			  => $this->input->post('draw'),
			'recordsTotal'	  => $this->User_m->count_all(),
			'recordsFiltered' => $this->User_m->selectUser($this->input->post('length'), $this->input->post('start'), $this->input->post('search'), $this->input->post('order')),
			'data'			  => $userData
		);

		header('Content-Type: application/json');
		echo json_encode($output);
	}

  /** Function : Proses Add User */
	public function addUserProses(){
	  /** Load Library & Helper */
		$this->load->library('form_validation');

	  /** Set Rules Validation */
		$configValidation = array(
			array(
				'field'	 => 'postUserName',
				'label'	 => 'Nama Pengguna',
				'rules'	 => 'trim|required',
				'errors' => array(
					'required' => 'Nama Pengguna tidak boleh kosong'
				)
			),
			array(
				'field'	 => 'postUserUsername',
				'label'	 => 'Username',
				'rules'	 => 'trim|required|is_unique[tb_user.u_username]',
				'errors' => array(
					'required' => 'Username tidak boleh kosong',
					'is_unique' => 'Username sudah digunakan'
				)
			),
			array(
				'field'	 => 'postUserPassword',
				'label'	 => 'Password',
				'rules'	 => 'trim|required|min_length[8]',
				'errors' => array(
					'required' => 'Password tidak boleh kosong',
					'min_length' => 'Password minimal 8 karakter'
				)
			),
			array(
				'field'	 => 'postUserRePassword',
				'label'	 => 'Ulang Password',
				'rules'	 => 'trim|required|matches[postUserPassword]',
				'errors' => array(
					'required' => 'Password tidak boleh kosong',
					'matches' => 'Password tidak sama'
				)
			),
			array(
				'field'	 => 'postUserLevel',
				'label'	 => 'Level',
				'rules'	 => 'trim|required|in_list[O,G,P,K]',
				'errors' => array(
					'required' => 'Password tidak boleh kosong',
					'in_list' => 'Pilih opsi yang tersedia'
				)
			),
		);
		$this->form_validation->set_rules($configValidation);

	  /** Run Validation */
		if($this->form_validation->run() == FALSE) {
			$arrReturn = array(
				'error'		=> TRUE,
				'errorUName'	=> form_error('postUserName'),
				'errorUUsername'	=> form_error('postUserUsername'),
				'errorUPassword'	=> form_error('postUserPassword'),
				'errorURePassword'	=> form_error('postUserRePassword'),
				'errorULevel'	=> form_error('postUserLevel'),
			);
		} else {
			$postData = array(
				'u_name' 	 => $this->input->post('postUserName'),
				'u_username' => strtolower(htmlspecialchars($this->input->post('postUserUsername'))),
				'u_password' => password_hash(htmlspecialchars($this->input->post('postUserPassword')), PASSWORD_DEFAULT, ['cost' => '10']),
				'u_level' 	 => 'u'.$this->input->post('postUserLevel'),
			);

			/** Input proses */
			$inputUser = $this->User_m->insertUser($postData);
			if($inputUser > 0){
				$arrReturn = array(
					'success'	=> TRUE,
					'status'	=> 'successInsert',
					'statusIcon' => 'success',
					'statusMsg'	 => 'Berhasil menambahkan user',
				);
			} else {
				$arrReturn = array(
					'success'	=> TRUE,
					'status'	=> 'failedInsert',
					'statusIcon' => 'error',
					'statusMsg'	 => 'Gagal menambahkan user',
				);
			}
		}

		header('Content-Type: application/json');
		echo json_encode($arrReturn);
	}

  /** Function : Proses Edit User */
	public function editUserProses(){
	  /** Load Library & Helper */
		$this->load->library('form_validation');

	  /** Set Rules Validation */
		$configValidation = array(
			array(
				'field'	 => 'postUserID',
				'label'	 => '',
				'rules'	 => 'trim|required|callback__validation_uid',
				'errors' => array(
					'required' => 'ID tidak boleh kosong'
				)
			),
			array(
				'field'	 => 'postUserName',
				'label'	 => 'Nama Pengguna',
				'rules'	 => 'trim|required',
				'errors' => array(
					'required' => 'Nama Pengguna tidak boleh kosong'
				)
			),
			array(
				'field'	 => 'postUserUsername',
				'label'	 => 'Username',
				'rules'	 => 'trim|required|callback__validation_edit_username',
				'errors' => array(
					'required' => 'Username tidak boleh kosong'
				)
			),
			array(
				'field'	 => 'postUserLevel',
				'label'	 => 'Level',
				'rules'	 => 'trim|required|in_list[O,G,P,K]',
				'errors' => array(
					'required' => 'Password tidak boleh kosong',
					'in_list' => 'Pilih opsi yang tersedia'
				)
			),
		);
		$this->form_validation->set_rules($configValidation);

	  /** Run Validation */
		if($this->form_validation->run() == FALSE) {
			$arrReturn = array(
				'error'		=> TRUE,
				'errorUID'		=> form_error('postUserID'),
				'errorUName'	=> form_error('postUserName'),
				'errorUUsername' => form_error('postUserUsername'),
				'errorULevel'	=> form_error('postUserLevel'),
			);
		} else {
			$userID = base64_decode(urldecode($this->input->post('postUserID')));
			$postData = array(
				'u_name' 	 => $this->input->post('postUserName'),
				'u_username' => strtolower(htmlspecialchars($this->input->post('postUserUsername'))),
				'u_level' 	 => 'u'.$this->input->post('postUserLevel'),
			);

			/** Update proses */
			$updateUser = $this->User_m->updatetUser($postData, $userID);
			if($updateUser > 0){
				$arrReturn = array(
					'success'	=> TRUE,
					'status'	=> 'successUpdate',
					'statusIcon' => 'success',
					'statusMsg'	 => 'Berhasil mengubah data user',
				);
			} else {
				$arrReturn = array(
					'success'	=> TRUE,
					'status'	=> 'failedUpdate',
					'statusIcon' => 'error',
					'statusMsg'	 => 'Gagal mengubah data user',
				);
			}
		}

		header('Content-Type: application/json');
		echo json_encode($arrReturn);
	}

  /** Function : Change Password User */
	public function changePasswordProses(){
	  /** Load Library & Helper */
		$this->load->library('form_validation');

	  /** Set Rules Validation */
		$configValidation = array(
			array(
				'field'	 => 'postUserID',
				'label'	 => '',
				'rules'	 => 'trim|required|callback__validation_uid',
				'errors' => array(
					'required' => 'ID tidak boleh kosong'
				)
			),
			array(
				'field'	 => 'postUserPassword',
				'label'	 => 'Password',
				'rules'	 => 'trim|required|min_length[8]',
				'errors' => array(
					'required' => 'Password tidak boleh kosong',
					'min_length' => 'Password minimal 8 karakter'
				)
			),
			array(
				'field'	 => 'postUserRePassword',
				'label'	 => 'Ulang Password',
				'rules'	 => 'trim|required|matches[postUserPassword]',
				'errors' => array(
					'required' => 'Password tidak boleh kosong',
					'matches' => 'Password tidak sama'
				)
			),
		);
		$this->form_validation->set_rules($configValidation);

	  /** Run Validation */
		if($this->form_validation->run() == FALSE) {
			$arrReturn = array(
				'error'		=> TRUE,
				'errorUID'		=> form_error('postUserID'),
				'errorUPassword' => form_error('postUserPassword'),
				'errorURePassword' => form_error('postUserRePassword'),
			);
		} else {
			$userID = base64_decode(urldecode($this->input->post('postUserID')));
			$postData = array(
				'u_password' => password_hash($this->input->post('postUserPassword'), PASSWORD_DEFAULT, ['cost' => '10'])
			);

			/** Update proses */
			$updateUser = $this->User_m->updatetUser($postData, $userID);
			if($updateUser > 0){
				$arrReturn = array(
					'success'	=> TRUE,
					'status'	=> 'successUpdate',
					'statusIcon' => 'success',
					'statusMsg'	 => 'Berhasil mengubah password user',
				);
			} else {
				$arrReturn = array(
					'success'	=> TRUE,
					'status'	=> 'failedUpdate',
					'statusIcon' => 'error',
					'statusMsg'	 => 'Gagal mengubah password user',
				);
			}
		}

		header('Content-Type: application/json');
		echo json_encode($arrReturn);
	}

  /** Function : Ajax Detail User */
	public function detailUser(){
		$data = $this->User_m->selectUserByID(base64_decode(urldecode($this->input->get('uid'))))->result_array();
		$returnData['set_id']		= urlencode(base64_encode($data[0]['u_id']));
		$returnData['set_name']		= $data[0]['u_name'];
		$returnData['set_username'] = $data[0]['u_username'];
		$returnData['set_level'] 	= substr($data[0]['u_level'], 1);

		header('Content-Type: application/json');
		echo json_encode($returnData);
	}

  /** Validation */
	/** Validation : UID */
	function _validation_uid($post){
		if($this->User_m->selectUserByID( base64_decode(urldecode($post)) )->num_rows() > 0){
			return TRUE;
		} else {
			$this->form_validation->set_message('_validation_uid', 'User tidak ditemukan');
			return FALSE;
		}
	}
	
	/** Validation : UID */
	function _validation_edit_username($post){
		if($this->User_m->validationUsername( $post, base64_decode(urldecode($this->input->post('postUserID'))) )->num_rows() > 0){
			$this->form_validation->set_message('_validation_edit_username', 'Username sudah digunakan');
			return FALSE;
		} else {
			return TRUE;
		}
	}
}