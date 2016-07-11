<?PHP

class LoginModel extends BaseModel {

	var $class_name = 'login_model';

	function __construct() {

		 parent::__construct();
	}

	function getMemberGroup() {

		$context = Context::getInstance();
		$query = array();
		$query['select'] = 'name';
		$query['from'] = $context->get('db_member_group');
		$query['orderBy'] = 'id asc';	
		parent::select($query);		
	}

	function getLogpass($params=NULL, $type=NULL) {

		$context = Context::getInstance();

		if ($type === 'select') {
			$query = array();
			$query['select'] = '*';
			$query['from'] = $context->getPost('member');
			$query['where'] =array(
				'ljs_memberid' => $context->getPost('memberid')
			);
			parent::select($query);
			
		} else if ($type === 'update') {
			$query = array();
			$query['tables'] = $context->getPost('member');
			$query['columnList'] = array();
			$query['columnList'][] = 'hit='.$params['hit'];
			$query['where'] =array(
				'ljs_memberid' => $context->getPost('memberid')
			);
			parent::update($query);
		}
	}

	function getLogout() {}

	function getSearchid() {

		$context = Context::getInstance();
		$member = $context->getPost('member');
		$check_name = $context->getPost('check_name');

		$query = array();
		$query['select'] = 'ljs_memberid, email';
		$query['from'] = $member;
		$query['where'] = array(
			'name' => $check_name
		);
		parent::select($query);
	}

	function getSearchpwd() {

		$context = Context::getInstance();
		$member = $context->getPost('member');
		$check_name = $context->getPost('check_name');
		$check_email = $context->getPost('check_email');

		$query = array();
		$query['select'] = 'ljs_memberid, email, ljs_pass1';
		$query['from'] = $member;
		$query['where'] = array(
			'name' => $check_name
		);
		parent::select($query);
	}
}
?>