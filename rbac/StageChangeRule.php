<?php
namespace app\rbac;

use yii\rbac\Rule;
use app\models\Order;
use Yii;

/**
 * Checks if authorID matches user passed via params
 */
class StageChangeRule extends Rule
{
    public $name = 'canChangeStage';

    private $associations = [
        1 => 'employee',
        2 => 'employee',
        3 => 'shopManager',
        4 => 'shopManager',
    ];

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (isset($params['id']) && isset($params['increment'])) {
            $model = Order::findOne(['id' => $params['id']]);
            //Yii::debug($model->stage + $params['increment'], 'dev');
            //Yii::debug(($this->associations[$model->stage + $params['increment']]), 'dev');
            return (($model) && ($model->canChangeStage($params['increment'])) && (Yii::$app->user->can($this->associations[$model->stage + $params['increment']])));
        }
        return false;
    }
}
