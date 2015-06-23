<?php

/**
 * Class Lading_Api_CustomerController
 */
class Lading_Api_CustomerController extends Mage_Core_Controller_Front_Action {
	const XML_PATH_REGISTER_EMAIL_TEMPLATE = 'customer/create_account/email_template';
	const XML_PATH_REGISTER_EMAIL_IDENTITY = 'customer/create_account/email_identity';
	const XML_PATH_REMIND_EMAIL_TEMPLATE = 'customer/password/remind_email_template';
	const XML_PATH_FORGOT_EMAIL_TEMPLATE = 'customer/password/forgot_email_template';
	const XML_PATH_FORGOT_EMAIL_IDENTITY = 'customer/password/forgot_email_identity';
	const XML_PATH_DEFAULT_EMAIL_DOMAIN         = 'customer/create_account/email_domain';
	const XML_PATH_IS_CONFIRM                   = 'customer/create_account/confirm';
	const XML_PATH_CONFIRM_EMAIL_TEMPLATE       = 'customer/create_account/email_confirmation_template';
	const XML_PATH_CONFIRMED_EMAIL_TEMPLATE     = 'customer/create_account/email_confirmed_template';
	const XML_PATH_GENERATE_HUMAN_FRIENDLY_ID   = 'customer/create_account/generate_human_friendly_id';

    /**
     * 获取用户登录状态
     */
	public function statusAction() {
		if (Mage::getSingleton ( 'customer/session' )->isLoggedIn ()) {
			$session = Mage::getSingleton("core/session")->getEncryptedSessionId();
			$customer = Mage::getSingleton ( 'customer/session' )->getCustomer ();
			$storeUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
			$avatar = $customer->getMyAvatar (); 
			if (isset($avatar))
				$avatar = $storeUrl . "customer" . $customer->getMyAvatar ();
			$customerinfo = array (
				'code' => 0,
				'msg' => null,
				'model' => array(
					'entity_id' => $customer->getId(),
					'name' => $customer->getName (),
					'email' => $customer->getEmail (),
					'avatar' => $customer->getMyAvatar (),
					'tel' => $customer->getDefaultMobileNumber (),
					'session' => $session
				)
			);
			echo json_encode ( $customerinfo );
		} else
			echo json_encode(array(
				'code' => 5,
				'msg' => 'not user login',
				'model'=>array () 
			));
	}

    /**
     * 用户登录
     */
	public function loginAction() {
		$session = Mage::getSingleton ( 'customer/session' );
		if (Mage::getSingleton ( 'customer/session' )->isLoggedIn ()) {
			$session->logout ();
		}
		$username = Mage::app ()->getRequest ()->getParam ( 'username' );
		$password = Mage::app ()->getRequest ()->getParam ( 'password' );
		try {
			if (! $session->login ( $username, $password )) {
				echo 'wrong username or password.';
			} else {
				echo $this->statusAction ();
			}
		} catch ( Mage_Core_Exception $e ) {
			switch ($e->getCode ()) {
				case Mage_Customer_Model_Customer::EXCEPTION_EMAIL_NOT_CONFIRMED :
					echo json_encode ( array (
							'code' => 1,
							'msg' => 'This account is not confirmed.',
							'model'=>array () 
					) );
					break;
				case Mage_Customer_Model_Customer::EXCEPTION_INVALID_EMAIL_OR_PASSWORD :
					$message = $e->getMessage ();
					echo json_encode ( array (
							'code' => 1,
							'msg' => $message,
							'model'=>array () 
					) );
					break;
				default :
					$message = $e->getMessage ();
					echo json_encode ( array (
							'code' => 1,
							'msg' => $message,
							'model'=>array () 
					));
			}
		}
	}

    /**
     * 用户注册
     */
	public function registerAction() {
		$params = Mage::app ()->getRequest ()->getParams ();
		$session = Mage::getSingleton ( 'customer/session' );
		$session->setEscapeMessages ( true );
		$customer = Mage::registry ( 'current_customer' );
		$errors = array ();
		if (is_null ( $customer )) {
			$customer = Mage::getModel ( 'customer/customer' )->setId ( null );
		}
		if (isset ( $params ['isSubscribed'] )) {
			$customer->setIsSubscribed ( 1 );
		}
		$customer->getGroupId ();
		try {
			$customer->setPassword ( $params ['pwd'] );
			$customer->setConfirmation ( $this->getRequest ()->getPost ( 'confirmation', $params ['pwd'] ) );
			$customer->setData ( 'email', $params ['email'] );
			$customer->setData ( 'firstname', $params ['firstname'] );
			$customer->setData ( 'lastname', $params ['lastname'] );
			$customer->setData ( 'gender', $params ['gender'] );
			$customer->setData ( 'default_mobile_number', $params ['default_mobile_number'] );
			$validationResult = count ( $errors ) == 0;
			if (true === $validationResult) {
				$customer->save ();
				if ($customer->isConfirmationRequired ()) {
					$customer->sendNewAccountEmail ( 'confirmation', $session->getBeforeAuthUrl (), Mage::app ()->getStore ()->getId () );
				} else {
					$session->setCustomerAsLoggedIn ( $customer );
					$customer->sendNewAccountEmail ( 'registered', '', Mage::app ()->getStore ()->getId () );
				}
				$addressData = $session->getGuestAddress ();
				if ($addressData && $customer->getId ()) {
					$address = Mage::getModel ( 'customer/address' );
					$address->setData ( $addressData );
					$address->setCustomerId ( $customer->getId () );
					$address->save ();
					$session->unsGuestAddress ();
				}
				echo json_encode ( array (
						'code'=>0,
						'msg'=>null,
						'model'=>array (
							'entity_id' => $customer->getId(),
							'name' => $customer->getName (),
							'email' => $customer->getEmail (),
							'avatar' => $customer->getMyAvatar (),
							'tel' => $customer->getDefaultMobileNumber (),
							'session' => Mage::getSingleton("core/session")->getEncryptedSessionId()
						)
				) );
			} else {
				echo json_encode ( array (
						'code'=>1,
						'msg'=>$errors,
						'model'=>array () 
				) );
			}
		} catch ( Mage_Core_Exception $e ) {
			if ($e->getCode () === Mage_Customer_Model_Customer::EXCEPTION_EMAIL_EXISTS) {
				$url = Mage::getUrl ( 'customer/account/forgotpassword' );
				$message = $this->__ ( 'There is already an account with this email address. If you are sure that it is your email address, %s', $url );
				$session->setEscapeMessages ( false );
			} else {
				$message = $e->getMessage ();
			}
			echo json_encode ( array (
					'code'=>1,
					'msg'=>$message,
					'model'=>array ()
			) );
		} catch ( Exception $e ) {
			echo json_encode ( array (
					'code'=>1,
					'msg'=>$e->getMessage (),
					'model'=>array ()
					 
			) );
		}
	}

    /**
     * 忘记密码处理
     */
	public function forgotpwdAction() {
		$email = Mage::app ()->getRequest ()->getParam ( 'email' );
		$session = Mage::getSingleton ( 'customer/session' );
		$customer = Mage::registry ( 'current_customer' );
		if (is_null ( $customer )) {
			$customer = Mage::getModel ( 'customer/customer' )->setId ( null );
		}
 		if ($this->_user_isexists ( $email )) {
			$customer = Mage::getModel ( 'customer/customer' )->setWebsiteId ( Mage::app ()->getStore ()->getWebsiteId () )->loadByEmail ( $email );
			$this->_sendEmailTemplate ( $customer,self::XML_PATH_FORGOT_EMAIL_TEMPLATE, self::XML_PATH_FORGOT_EMAIL_IDENTITY, array (
					'customer' => $customer 
			), null);
			echo json_encode ( array (
					'code' => 0,
					'message' => 'Request has sent to your Email.',
					'model'=>array()
			) );
		} else
			echo json_encode ( array (
					'code' => 1,
					'message' => 'No matched email data.' ,
					'model'=>array()
			) );
	}

    /**
     * 用户退出登录
     */
	public function logoutAction() {
		try {
			Mage::getSingleton ( 'customer/session' )->logout();
			echo json_encode(array('code'=>0, 'msg'=>null, 'model'=>array()));
		} catch (Exception $e) {
			echo json_encode(array('code'=>1, 'msg'=>$e->getMessage(), 'model'=>array()));
		}
	}


	/**
     * 判断用户是否存在
	 * @param $email
	 * @return bool
	 */
	protected function _user_isexists($email) {
		$info = array ();
		$customer = Mage::getModel ( 'customer/customer' )->setWebsiteId ( Mage::app ()->getStore ()->getWebsiteId () )->loadByEmail ( $email );
		$info ['uname_is_exist'] = $customer->getId () > 0;
		$result = array (
				'code' => 0,
				'message' => $info,
				'model'=>array()
		);
		return $customer->getId () > 0;
	}

	/**
	 * @param $customer
	 * @param $template
	 * @param $sender
	 * @param array $templateParams
	 * @param null $storeId
	 * @return $this
	 */
	protected function _sendEmailTemplate($customer,$template, $sender, $templateParams = array(), $storeId = null)
	{
		/** @var $mailer Mage_Core_Model_Email_Template_Mailer */
		$mailer = Mage::getModel('core/email_template_mailer');
		$emailInfo = Mage::getModel('core/email_info');
		$emailInfo->addTo($customer->getEmail(), $customer->getName());
		$mailer->addEmailInfo($emailInfo);
	
		// Set all required params and send emails
		$mailer->setSender(Mage::getStoreConfig($sender, $storeId));
		$mailer->setStoreId($storeId);
		$mailer->setTemplateId(Mage::getStoreConfig($template, $storeId));
		$mailer->setTemplateParams($templateParams);
		$mailer->send();
		return $this;
	}

	/**
	 * update user account info
	 */
	public function updateAccountAction(){
		if (Mage::getSingleton ( 'customer/session' )->isLoggedIn()) {
			$email = Mage::app()->getRequest()->getParam('email');
			$firstname = Mage::app()->getRequest()->getParam('firstname' );
			$lastname = Mage::app()->getRequest()->getParam('lastname');
			$customer = Mage::getSingleton('customer/session')->getCustomer();
			$customerForm = Mage::getModel('customer/form');
			$customerForm->setFormCode('customer_account_edit')->setEntity($customer);
			$userData = array(
				'email' => $email,
				'firstname' => $firstname,
				'lastname' => $lastname
			);
			$customerErrors = $customerForm->validateData($userData);
			if ($customerErrors !== true) {
	            $errors = array_merge($customerErrors);
	        } else {
	            $customerForm->compactData($userData);
	            $customerErrors = $customer->validate();
	            if (is_array($customerErrors)) {
	                $errors = array_merge($customerErrors);
	            }
	        }
	        if (!empty($errors)) {
	            echo json_encode(array('code'=>1, 'msg'=>$errors, 'model'=>array()));
	            return ;
	        }
	        try {
	        	$customer->save();
	        	echo json_encode(array('code'=>0, 'msg'=>'success', 'model'=>$userData));
	        } catch (Mage_Core_Exception $e){
	        	echo json_encode(array('code'=>1, 'msg'=>$e->getMessage(), 'model'=>array()));
	        } catch (Exception $e){
	        	echo json_encode(array('code'=>2, 'msg'=>$e->getMessage(), 'model'=>array()));
	        }
	    } else {
	    	echo json_encode(array(
				'code' => 5,
				'msg' => 'not user login',
				'model'=>array () 
			));
	    }
	}



	/**
	 * get user account info
	 */
	public function getAccountInfoAction(){
		if (Mage::getSingleton('customer/session')->isLoggedIn()) {
			$customer = Mage::getSingleton('customer/session')->getCustomer();
			$userData = array(
				'email' => $customer->getEmail(),
				'firstname' => $customer->getFirstname(),
				'lastname' => $customer->getLastname()
			);
			echo json_encode(array('code'=>0, 'msg'=>'get customer info success!', 'model'=>$userData));
		}else{
			echo json_encode(array(
				'code' => 5,
				'msg' => 'not user login',
				'model'=>array ()
			));
		}
	}



	/**
	 * update user account info
	 */
	public function updatePasswordAction()
	{
		if (Mage::getSingleton('customer/session')->isLoggedIn()) {
			$password = $_REQUEST['password'];
			$new_password = $_REQUEST['new_password'];
			$customer = Mage::getSingleton('customer/session')->getCustomer();
			$storeId = Mage::app()->getStore()->getStoreId();
			$websiteId = Mage::getModel('core/store')->load($storeId)->getWebsiteId();
			try {
				$login_customer_result = Mage::getModel('customer/customer')->setWebsiteId($websiteId)->authenticate($customer->getEmail(), $password);
				$validate = 0;
			}
			catch(Exception $ex) {
				$validate = 1;
			}
			if($password && $new_password && ($validate == 0)){
				$customer->setPassword($new_password);
				try {
					$customer->save();
					echo json_encode(array('code' => 0, 'msg' => 'success', 'model' => array()));
				} catch (Mage_Core_Exception $e) {
					echo json_encode(array('code' => 1, 'msg' => $e->getMessage(), 'model' => array()));
				} catch (Exception $e) {
					echo json_encode(array('code' => 2, 'msg' => $e->getMessage(), 'model' => array()));
				}
			}else{
				echo json_encode(array('code' => 2, 'msg' => 'password is not correct ', 'model' => array()));
			}
		}else {
			echo json_encode(array(
				'code' => 5,
				'msg' => 'not user login',
				'model' => array()
			));
		}
	}

} 