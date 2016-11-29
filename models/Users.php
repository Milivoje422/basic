    <?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $firstName
 * @property string $lastName
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $authKey
 * @property integer $userStatus
 * @property integer $adminStatus
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstName', 'lastName', 'username', 'email', 'password', 'authKey', 'userStatus', 'adminStatus'], 'required'],
            [['userStatus', 'adminStatus'], 'integer'],
            [['firstName', 'lastName', 'username', 'authKey'], 'string', 'max' => 44],
            [['email', 'password'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'userStatus' => 'User Status',
            'adminStatus' => 'Admin Status',
        ];
    }

    public function getAuthKEy(){
        // throw new \yii\base\NotSupportedException();
        return $this->authKey;
    }

    public function getId(){
        return $this->id;
    }

    public function validateAuthKey($authKey){
        // throw new \yii\base\NotSupportedException();
        return $this->authKey === $authKey;
    }

    public static function findIdentity($id){
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null){
        throw new \yii\base\NotSupportedException();
    }

    public static function findByUsername($username){
        return self::findOne(['username' => $username]);
    }

    public function validatePassword($password){
        return $this->password === $password;
    }


}





