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
	public function statusAction() {
		$customerinfo = array ();
		if (Mage::getSingleton ( 'customer/session' )->isLoggedIn ()) {
			$session = Mage::getSingleton("core/session")->getEncryptedSessionId();
			$customer = Mage::getSingleton ( 'customer/session' )->getCustomer ();
			$customerinfo = array (
				'code' => 0,
				'msg' => null,
				'model' => array( 
					'name' => $customer->getName (),
					'email' => $customer->getEmail (),
					'avatar' => $customer->getMyAvatar (),
					'tel' => $customer->getDefaultMobileNumber (),
<<<<<<< HEAD
					'session' => $session
=======
					'session' => $session->getCustomerId()
>>>>>>> 82e28a9... add options with product detail
				)
			);
			echo json_encode ( $customerinfo );
		} else
			echo json_encode(array(
				'code' => 1,
				'msg' => 'not user login',
				'model'=>array () 
			));
	}
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
					$value = Mage::helper ( 'customer' )->getEmailConfirmationUrl ( $uname );
					$message = Mage::helper ( 'customer' )->__ ( 'This account is not confirmed. %s', $value );
					echo json_encode ( array (
							'code' => 1,
							'msg' => $message,
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
					) );
			}
		}
	}
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
						'model'=>array () 
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
			), $storeId );
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
	public function logoutAction() {
		try {
			Mage::getSingleton ( 'customer/session' )->logout();
			echo json_encode(array('code'=>0, 'msg'=>null, 'model'=>array()));
		} catch (Exception $e) {
			echo json_encode(array('code'=>1, 'msg'=>$e->getMessage(), 'model'=>array()));
		}
	}

	/**
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

} 