<?php
namespace app\models;

use Yii;
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE   = 1;

    public function afterSave($isInsert, $changedOldAttributes) {
		// Purge the user tokens when the password is changed
		if (array_key_exists('usr_password', $changedOldAttributes)) {
			\app\models\UserRefreshToken::deleteAll(['urf_userID' => $this->userID]);
		}

		return parent::afterSave($isInsert, $changedOldAttributes);
	}

    public static function getStatusList()
    {
        return [
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_ACTIVE   => 'Active',
        ];
    }

    public static function getStatusLabel($status_id)
    {
        $statusList = self::getStatusList();
        return $statusList[$status_id];
    }

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['username', 'password', 'first_name', 'last_name', 'auth_key', 'status'], 'required'],
            [['username', 'password'], 'string', 'max' => 100],
            [['first_name', 'last_name'], 'string', 'max' => 50],
            [['username'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'username'   => 'Username',
            'password'   => 'Password',
            'first_name' => 'First Name',
            'last_name'  => 'Last Name'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
		$claims = \Yii::$app->jwt->parse($token)->claims();
        $uid = $claims->get('uid');
        if (!is_numeric($uid)) {
            throw new ForbiddenHttpException('Invalid token provided');
        }

        return static::findOne(['id' => $uid]);
    }

    public static function getActiveUsers()
    {
        return static::find()->where(['status' => static::STATUS_ACTIVE])->all();
    }

    public static function getInactiveUsers()
    {
        return static::find()->where(['status' => static::STATUS_INACTIVE])->all();
    }
    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getIsActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function generateJwt()
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone(\Yii::$app->timeZone));
        $token = \Yii::$app->jwt->getBuilder()
            // Configures the time that the token was issued
            ->issuedAt($now)
            // Configures the time that the token can be used
            ->canOnlyBeUsedAfter($now)
            // Configures the expiration time of the token
            ->expiresAt($now->modify('+1 hour'))
            // Configures a new claim, called "uid", with user ID, assuming $user is the authenticated user object
            ->withClaim('uid', $this->id)
            // Builds a new token
            ->getToken(
                \Yii::$app->jwt->getConfiguration()->signer(),
                \Yii::$app->jwt->getConfiguration()->signingKey()
            );
        return $tokenString = $token->toString();
    }

    public function generateRefreshJwt()
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone(\Yii::$app->timeZone));
        $refreshToken = \Yii::$app->jwt->getBuilder()
            // Configures the time that the token was issued
            ->issuedAt($now)
            // Configures the time that the token can be used
            ->canOnlyBeUsedAfter($now)
            // Configures the expiration time of the token
            ->expiresAt($now->modify('+1 day'))
            // Configures a new claim, called "uid", with user ID, assuming $user is the authenticated user object
            ->withClaim('uid', $this->id)
            // Builds a new token
            ->getToken(
                \Yii::$app->jwt->getConfiguration()->signer(),
                \Yii::$app->jwt->getConfiguration()->signingKey()
            );
        return $tokenString = $refreshToken->toString();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);  // password hash (recommended)
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }
}
