<?php 
use yii\bootstrap5\Html;
use yii\helpers\Json;
use app\models\Response;
use app\models\Task;
use app\models\Status;
use app\models\AuthAssignment;
use yii\helpers\VarDumper;
use app\models\AuthItem;
?>

<?php if(($a = AuthItem::findOne($model->authAssignments->item_name)->title) != 'Администратор'){ ?>
<tr>
    <td><?= $model->surname ?></td>
    <td><?= $model->name ?></td>
    <td><?= $model->patronymic ?></td>
    <td><?= $model->login ?></td>
    <td><?= $model->email ?></td>
    <td><?= $a ?></td>
    <td class="text-center" style="width: 50px;">
        <button type="button" rel="tooltip" class="btn btn-link">
            <?= Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye text-info" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/></svg>', ['view', 'id'=>$model->id]) ?>
        </button>
    </td>
    <td class="text-center" style="width: 50px;">  
        <button type="button" rel="tooltip" class="btn btn-link">
            <?= Html::a('<i class="tim-icons icon-pencil text-info"></i>', ['update', 'id'=>$model->id]) ?>
        </button>
    </td>
    <td class="text-center" style="width: 50px;"> 
        <button type="button" rel="tooltip" class="btn btn-link">
            <?= Html::a('<i class="tim-icons icon-simple-remove text-info"></i>', ['delete', 'id'=>$model->id], ['data' => [
                'confirm' => 'Вы уверены, что хотите удалить пользователя?',
                'method' => 'post',
            ]]) ?>
        </button>
    </td>
</tr>
<?php } ?>
    



