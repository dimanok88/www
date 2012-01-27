<h1>Просмотр Профиля <?= $user->name?>(<?= $user->login;?>)</h1>

    <?= CHtml::link('Назад', array('users/listUsers'), array('class'=>'edit_user_left'))?>
    <?= CHtml::link('Редактировать', array('users/newed', 'id'=>$user->id), array('class'=>'edit_user'))?>

    <?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$user,
	'attributes'=>array(
		'id',
        'login',
        'email',
		'phone',
		'name',
        'role',
        'code_active',
        'organization',
        array(               // related city displayed as a link
            'name'=>'org_type_user',
            'value'=>Users::model()->getOrgTypeUser($user->org_type_user),
        ),
        array(               // related city displayed as a link
            'name'=>'type_user',
            'value'=>Percent::model()->getType($user->type_user),
        ),
        'inn',
        'kpp',
        'bik',
        'bank',
        'r_s',
        'k_s',
        'address',
        'info',
	),
)); ?>