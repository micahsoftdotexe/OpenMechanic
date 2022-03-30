<?php
namespace app\rbac;

use yii\rbac\Rule;
use app\models\Note;
use Yii;

/**
 * Checks if authorID matches user passed via params
 */
class NoteAuthorRule extends Rule
{
    public $name = 'isNoteAuthor';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess(). This should contain the id of the note.
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        return (Note::findOne(['id' => $params['id']])->created_by == $user) || (Yii::$app->user->can('admin'));
    }
}
