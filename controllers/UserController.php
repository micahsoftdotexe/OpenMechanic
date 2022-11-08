<?php

namespace app\controllers;

use yii\rest\ActiveController;
use Yii;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';
    public function behaviors() {
        $behaviors = parent::behaviors();
		unset($behaviors['authenticator']);
		$behaviors['corsFilter'] = [
			'class' => \yii\filters\Cors::class,
		];
        $behaviors['authenticator'] = [
            'class' =>  \bizley\jwt\JwtHttpBearerAuth::class,
            'except' => [
                'login',
                'refresh-token',
                //'options',
            ],
        ];
        return $behaviors;
    }

    // private function generateJwt(\app\models\User $user) {
	// 	$jwt = Yii::$app->jwt;
	// 	$signer = $jwt->getSigner('HS256');
	// 	$key = $jwt->getKey();
	// 	$time = time();

	// 	$jwtParams = Yii::$app->params['jwt'];

	// 	return $jwt->getBuilder()
	// 		->issuedBy($jwtParams['issuer'])
	// 		->permittedFor($jwtParams['audience'])
	// 		->identifiedBy($jwtParams['id'], true)
	// 		->issuedAt($time)
	// 		->expiresAt($time + $jwtParams['expire'])
	// 		->withClaim('uid', $user->userID)
	// 		->getToken($signer, $key);
	// }

    /**
	 * @throws yii\base\Exception
	 */
	// private function generateRefreshToken(\app\models\User $user, \app\models\User $impersonator = null): \app\models\UserRefreshToken {
	// 	$refreshToken = Yii::$app->security->generateRandomString(200);

	// 	// TODO: Don't always regenerate - you could reuse existing one if user already has one with same IP and user agent
	// 	$userRefreshToken = new \app\models\UserRefreshToken([
	// 		'urf_userID' => $user->id,
	// 		'urf_token' => $refreshToken,
	// 		'urf_ip' => Yii::$app->request->userIP,
	// 		'urf_user_agent' => Yii::$app->request->userAgent,
	// 		'urf_created' => gmdate('Y-m-d H:i:s'),
	// 	]);
	// 	if (!$userRefreshToken->save()) {
	// 		throw new \yii\web\ServerErrorHttpException('Failed to save the refresh token: '. $userRefreshToken->getErrorSummary(true));
	// 	}

	// 	// Send the refresh-token to the user in a HttpOnly cookie that Javascript can never read and that's limited by path

	// 	return $userRefreshToken;
	// }

    public function actionLogin() {
		$model = new \app\models\LoginForm();
        $params = Yii::$app->request->getBodyParams();
		Yii::debug($params, 'dev');
		$username = $params['username'];
		$password = $params['password'];
        $model->username = $username;
        $model->password = $password;
		$model->rememberMe = false;
		//$model->login();
		//$user = Yii::$app->user->identity;
		if ($model->login()) {
			$user = Yii::$app->user->identity;

			if($model->rememberMe) {
				$refreshToken = $user->generateRefreshJwt();
				Yii::$app->response->cookies->add(new \yii\web\Cookie([
					'name' => 'refresh-token',
					'value' => $refreshToken,
					'httpOnly' => true,
					'sameSite' => 'none',
					//'secure' => true,
					'path' => '/auth/refresh',  //endpoint URI for renewing the JWT token using this refresh-token, or deleting refresh-token
				]));

			}
			// $token = $this->generateJwt($user);

			// $this->generateRefreshToken($user);

			return $this->asJson([
				'user' => $user,
				'token' => $user->generateJwt(),
			]);
		} else {
			throw new \yii\web\UnauthorizedHttpException('Wrong username or password');
		}
	}
    public function actionListCurrentUser() {
        return Yii::$app->user->identity;
    }

    public function actionRefreshToken() {
		//Yii::debug(Yii::$app->request->cookies,'dev');
		$refreshToken = Yii::$app->request->cookies->getValue('refresh-token', false);
		if (!$refreshToken) {
			//Yii::debug('no refresh token', 'dev');
			throw new \yii\web\UnauthorizedHttpException('No refresh token found.');
		}
		if (Yii::$app->jwt->validate($refreshToken) && \app\models\User::findIdentityByAccessToken($refreshToken)) {
			$user = \app\models\User::findIdentityByAccessToken($refreshToken);
			return [
				'jwt' => (string) $user->generateJwt($user)
			];
			//$token = $this->generateJwt($user);

		} else {
			throw new \yii\web\UnauthorizedHttpException('The user is inactive.');
		}

		//$userRefreshToken = \app\models\UserRefreshToken::findOne(['urf_token' => $refreshToken]);

		// 	if (Yii::$app->request->getMethod() == 'POST') {
		// 		// Getting new JWT after it has expired
		// 		if (!$userRefreshToken) {
		// 			return new \yii\web\UnauthorizedHttpException('The refresh token no longer exists.');
		// 		}

		// 		$user = \app\models\User::find()  //adapt this to your needs
		// 			->where(['userID' => $userRefreshToken->urf_userID])
		// 			->andWhere(['not', ['usr_status' => 'inactive']])
		// 			->one();
		// 		if (!$user) {
		// 			$userRefreshToken->delete();
		// 			return new \yii\web\UnauthorizedHttpException('The user is inactive.');
		// 		}

		// 		$token = $this->generateJwt($user);

		// 		return [
		// 			'status' => 'ok',
		// 			'token' => (string) $token,
		// 		];

		// 	} elseif (Yii::$app->request->getMethod() == 'DELETE') {
		// 		// Logging out
		// 		if ($userRefreshToken && !$userRefreshToken->delete()) {
		// 			return new \yii\web\ServerErrorHttpException('Failed to delete the refresh token.');
		// 		}

		// 		return ['status' => 'ok'];
		// 	} else {
		// 		return new \yii\web\UnauthorizedHttpException('The user is inactive.');
		// 	}
	}
}

// use Yii;
// use yii\filters\AccessControl;
// use yii\filters\VerbFilter;
// use app\models\User;
// class UserController extends SafeController
// {
//     public function behaviors()
//     {
//         return [
//             'verbs' => [
//                 'class' => VerbFilter::class,
//                 'actions' => [
//                     'delete' => ['POST'],
//                 ],
//             ],
//             'access' => [
//                 'class' => AccessControl::class,
//                 'rules' => [
//                     [
//                         'actions' => ['deactivate', 'activate'],
//                         'allow' => true,
//                         'roles' => ['admin'],
//                     ],
//                     [
//                         'actions' => ['create'],
//                         'allow' => true,
//                         'roles' => ['createUser'],
//                     ],
//                     [
//                         'actions' => ['edit'],
//                         'allow' => true,
//                         'roles' => ['editOwnUser'],
//                         'roleParams' => function() {
//                             return ['id' => Yii::$app->request->get('id')];
//                         }
//                     ]
//                 ],
//             ],
//         ];
//     }


//     public function actionDeactivate($id)
//     {
//         $user = \app\models\User::findOne($id);
//         if ($id != Yii::$app->user->id) {
//             $user->status = 0;
//             $user->save();
//         } else {
//             Yii::$app->session->setFlash('error', 'You Cannot Deactivate Yourself, Silly.');
//         }

//         return $this->redirect(['/admin/view']);
//     }

//     public function actionActivate($id)
//     {
//         $user = \app\models\User::findOne($id);
//         $user->status = 1;
//         $user->save();
//         return $this->redirect(['/admin/view']);
//     }

//     public function actionCreate()
//     {
//         $formModel = new \app\models\SignupForm();
//         $userModel = new \app\models\User();
//         if ($formModel->load(Yii::$app->request->post()) && $formModel->validate()) {
//             $userModel->username = $formModel->username;
//             $userModel->first_name = $formModel->first_name;
//             $userModel->last_name = $formModel->last_name;
//             $userModel->setPassword($formModel->password);
//             $userModel->generateAuthKey();
//             $userModel->status = 1;
//             if ($userModel->save()) {
//                 Yii::$app->authManager->assign(Yii::$app->authManager->getRole('employee'), $userModel->id);
//                 Yii::$app->session->setFlash('success', 'User Created');
//                 return $this->redirect(['/admin/view']);
//             } else {
//                 Yii::$app->session->setFlash('error', 'User Not Created');
//                 return $this->redirect(['/admin/view']);
//             }
//         } else {
//             Yii::$app->session->setFlash('error', 'User Not Created');
//             return $this->redirect(['/admin/view']);
//         }
//     }

//     public function actionEdit($id)
//     {
//         $model = new \app\models\UserEditForm();
//         $model->roles = array_keys(Yii::$app->authManager->getRolesByUser($id));
//         $user= User::findOne($id);
//         $model->id = $user->id;
//         $model->username = $user->username;
//         $model->first_name = $user->first_name;
//         $model->last_name = $user->last_name;
//         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//             if (array_key_exists('roles', Yii::$app->request->post('UserEditForm'))) {
//                 $model->roles = Yii::$app->request->post('UserEditForm')['roles'];
//             }
//             $user->username = $model->username;
//             $user->first_name = $model->first_name;
//             $user->last_name = $model->last_name;
//             if ($model->password != '' && $model->password == $model->password_repeat) {
//                 $user->setPassword($model->password);
//             }
//             // redo roles
//             $auth = Yii::$app->authManager;
//             $auth->revokeAll($user->id);
//             foreach ($model->roles as $role) {
//                 $auth->assign($auth->getRole($role), $user->id);
//             }
//             if ($user->save()) {
//                 Yii::$app->session->setFlash('success', 'User Updated');
//             } else {
//                 Yii::$app->session->setFlash('error', 'User Not Updated');
//             }
//             return Yii::$app->user->can('admin') ? $this->redirect(['/admin/view']) : $this->redirect(['/site/index']);
//         } else {
//             return $this->render('/admin/_user_sign_up', [
//                 'model' => $model,
//                 'edit'  => true,
//             ]);
//         }
//     }
// }
