<?php

class CategoryController extends Controller
{
	public $layout='//layouts/column2';

	private $_model;

	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
            array(
                'allow',
                'users' => array('*'),
            ),
		);
	}

    public function actionCache()
    {
        Category::model()->buildCategoryTree();
    }

    public function actionCreate()
    {
        Category::model()->buildCategoryTree();
        
        $category = new Category();
        
        if( isset($_POST[get_class($category)]) && isset($_POST[get_class($category)]['parent']) )
        {
            $categoryParent = Category::model()->findByPk($_POST[get_class($category)]['parent']);
            if( is_null($categoryParent) )
            {
                throw new CHttpException('404', 'Указанная родительская категория не существует.');
            }
            $category->attributes = $_POST[get_class($category)];
            if( $category->insert() )
            {                
                $this->redirect(array('admin'));
            }
        }

        $this->render(
            'create',
            array(
                'model' => $category,
                'categoryList' => Category::model()->getCategoryListByTree(false),
            )
        );
    }

	public function actionUpdate()
	{
		$category = $this->loadModel();

		if( isset($_POST[get_class($category)]) )
		{
			$category->attributes = $_POST[get_class($category)];
			if( $category->update() )
            {
				$this->redirect(array('admin'));
            }
		}

		$this->render(
            'update',
            array(
                'model' => $category,
                'showParentCategory' => false,
            )
        );
	}

	public function actionDelete()
	{
		if( Yii::app()->request->isPostRequest )
		{
			$this->loadModel()->delete();
            
			if( !isset($_GET['ajax']) )
            {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
		}
		else
        {
			throw new CHttpException(400, 'Ошибка в запросе.');
        }
	}

	public function actionAdmin()
	{
        $сategory = Category::model()->getCategoryByArrayTree(false);

        $dataProvider = new CArrayDataProvider(
            $сategory,
            array(
                'pagination' => array(
                    'pageSize' => 50,
                )
            )
        );

		$this->render(
            'admin',
            array(
                'dataProvider' => $dataProvider,
            )
		);
	}

	public function loadModel()
	{
		if($this->_model === null)
		{
			if(isset($_GET['id']))
            {
				$this->_model = Category::model()->findbyPk($_GET['id']);
            }
			if( $this->_model === null )
            {
				throw new CHttpException(404, 'Указанная категория не найдена.');
            }
		}
		return $this->_model;
	}

    public function actionUpload()
    {
        $model = new PriceForm();

        if( isset($_POST['PriceForm']) )
        {
            $model->file = CUploadedFile::getInstance($model, 'file');
            if( $model->validate() )
            {
                $this->parsePriceList($model->file->tempName);

                $this->redirect(array('admin'));
            }
        }

		$this->render(
            'upload',
            array(
                'model' => $model,
            )
		);
    }

    private function parsePriceList($filename)
    {
        if( $this->csvToTempDbTable($filename) === false )
        {
            return false;
        }
exit;
        $connection = Yii::app()->db;

        $sqlUpdateOldItems = "UPDATE `item` SET `cost` = 0";
        $connection->createCommand($sqlUpdateOldItems)->execute();

        $sqlUpdateExistsItems = "
            UPDATE
                `item`, `csvitems`
            SET
                `item`.`category_id` = `csvitems`.`category_id`,
                `item`.`type` = `csvitems`.`type`,
                `item`.`name` = `csvitems`.`name`,
                `item`.`cost` = `csvitems`.`cost`,
                `item`.`vendor` = `csvitems`.`vendor`,
                `item`.`model` = `csvitems`.`model`,
                `item`.`category` = `csvitems`.`category`,
                `item`.`brand` = `csvitems`.`brand`,
                `item`.`typename` = `csvitems`.`type_name`,
                `item`.`et` = `csvitems`.`et`,
                `item`.`dia` = `csvitems`.`dia`,
                `item`.`pcd` = `csvitems`.`pcd`,
                `item`.`d` = `csvitems`.`d`,
                `item`.`season` = `csvitems`.`season`,
                `item`.`w` = `csvitems`.`w`,
                `item`.`hw` = `csvitems`.`hw`,
                `item`.`indg` = `csvitems`.`indg`,
                `item`.`indv` = `csvitems`.`indv`
            WHERE
                `item`.`id` = `csvitems`.`id`
        ";
        $connection->createCommand($sqlUpdateExistsItems)->execute();

        $sqlInsertNewItems = "
            INSERT INTO
                `item`
                (`id`,`category_id`,`type`,`name`,`cost`,`vendor`,`model`,`category`,`brand`,`typename`,`et`,`dia`,`pcd`,`d`,`season`,`w`,`hw`,`indg`,`indv`)
                SELECT
                    `ci`.`id` AS `id`,
                    `ci`.`category_id` AS `category_id`,
                    `ci`.`type` AS `type`,
                    `ci`.`name` AS `name`,
                    `ci`.`cost` AS `cost`,
                    `ci`.`vendor` AS `vendor`,
                    `ci`.`model` AS `model`,
                    `ci`.`category` AS `category`,
                    `ci`.`brand` AS `brand`,
                    `ci`.`type_name` AS `typename`,
                    `ci`.`et` AS `et`,
                    `ci`.`dia` AS `dia`,
                    `ci`.`pcd` AS `pcd`,
                    `ci`.`d` AS `d`,
                    `ci`.`season` AS `season`,
                    `ci`.`w` AS `w`,
                    `ci`.`hw` AS `hw`,
                    `ci`.`indg` AS `indg`,
                    `ci`.`indv` AS `indv`
                FROM
                    `csvitems` AS `ci`
                LEFT OUTER JOIN
                    `item` AS `i`
                ON
                    `ci`.`id` = `i`.`id`
                WHERE
                    `i`.`id` IS NULL
        ";
        $connection->createCommand($sqlInsertNewItems)->execute();

        $sqlDropTable = "
            DROP TABLE `csvitems`
        ";
        $connection->createCommand($sqlDropTable)->execute();
    }

    private function csvToTempDbTable($filename = '', $delimiter = ';')
    {
        $firstRow = true;

        $sqlCreateTable = "
            CREATE TABLE IF NOT EXISTS `csvitems` (
                `category_id` INT,
                `type` enum('tire','disc') DEFAULT 'tire',
                `name` varchar(255) NOT NULL DEFAULT '',
                `cost` decimal(16,2) NOT NULL DEFAULT '0.00',
                `vendor` varchar(128) NOT NULL DEFAULT '' COMMENT 'производитель',
                `model` varchar(128) NOT NULL DEFAULT '' COMMENT 'модель',
                `category` varchar(64) NOT NULL DEFAULT '' COMMENT 'категория',
                `brand` varchar(128) NOT NULL DEFAULT '' COMMENT 'марка',
                `type_name` varchar(128) NOT NULL DEFAULT '' COMMENT 'тип',
                `et` varchar(7) NOT NULL DEFAULT '' COMMENT 'вылеты',
                `dia` varchar(7) NOT NULL DEFAULT '' COMMENT 'диаметры',
                `pcd` varchar(16) NOT NULL DEFAULT '' COMMENT 'посадочные размеры',
                `d` varchar(10) NOT NULL DEFAULT '' COMMENT 'посадочные диаметры',
                `season` varchar(16) NOT NULL DEFAULT '' COMMENT 'сезон',
                `w` varchar(10) NOT NULL DEFAULT '' COMMENT 'ширина',
                `hw` varchar(7) NOT NULL DEFAULT '' COMMENT 'профили',
                `indg` varchar(16) NOT NULL DEFAULT '' COMMENT 'индекс нагрузки',
                `indv` varchar(2) NOT NULL DEFAULT '' COMMENT 'индекс скорости'
            ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci
        ";

        $connection = Yii::app()->db;
        $connection->createCommand($sqlCreateTable)->execute();

        $sqlTruncateCsvItems = "TRUNCATE TABLE `csvitems`";
        $connection->createCommand($sqlTruncateCsvItems)->execute();

        $sqlInsert = "INSERT INTO `csvitems`"
                   ." (`category_id`,`type`,`name`,`cost`,`vendor`,`model`,`category`,`brand`,`et`,`dia`,`pcd`,`d`,`season`,`w`,`hw`,`indg`,`indv`) "
             ." VALUES(:category_id, :type, :name, :cost, :vendor, :model, :category, :brand, :et, :dia, :pcd, :d, :season, :w, :hw, :indg, :indv)";
        $insertCommand = $connection->createCommand($sqlInsert);

        if( ($handle = fopen($filename, 'r')) !== FALSE )
        {
        	$category_id = 2;
            while( ($row = fgetcsv($handle, 2000, $delimiter)) !== FALSE )
            {
                var_dump($row);
                
                if( !empty($row[0]) && empty($row[1]) && empty($row[2]) )
                {
                	$category_id = 0;
                	continue;
                }
                
                $in

                //$insertCommand->execute();
            }
            fclose($handle);
        }

        return true;
    }
}
