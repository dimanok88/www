<?php

class CategoryTreeBehaviour extends CActiveRecordBehavior
{
    const ROOT_NODE_ID = 1;
    const ROOT_NODE_NAME = 'Корневой раздел';

    const REPEAT_STRING = '&nbsp;&nbsp;&nbsp;&nbsp;';

    public $categoryLink = '';

    public function init()
    {
        
    }

    public function getCategoryLink($id)
    {
        return array(
            $this->categoryLink,
            'id' => $id,
        );
    }

    public function getCacheName()
    {
        return 'cacheTree' . get_class($this->owner);
    }

    /*
     * получить список категорий для ListBox
     */
    public function getCategoryListByTree($buildTree = true)
    {
        $list = array();
        $tree = Yii::app()->cache->get($this->getCacheName());
        if( !is_array($tree) )
        {
            return $list;
        }
        $this->buildCategoryList(
            array(
                'children' => $tree,
                'name' => CategoryTreeBehaviour::ROOT_NODE_NAME,
                'id' => CategoryTreeBehaviour::ROOT_NODE_ID,
            ),
            $list,
            0,
            $buildTree
        );
        return $list;
    }

    private function buildCategoryList($parentNode, &$listNode, $level, $buildTree)
    {
        if( count($parentNode['children']) > 0 )
        {
            $name = str_repeat(CategoryTreeBehaviour::REPEAT_STRING, $level) . ' ' . $parentNode['name'];
            $id = $parentNode['id'];
            if( $buildTree )
            {
                $listNode[$name] = array();
            }
            else
            {
                $listNode[$id] = $name;
            }
            foreach($parentNode['children'] as $child)
            {
                if( $buildTree )
                {
                    $this->buildCategoryList($child, $listNode[$name], $level+1, $buildTree);
                }
                else
                {
                    $this->buildCategoryList($child, $listNode, $level+1, $buildTree);
                }
            }
        }
        else
        {
            $name = str_repeat(CategoryTreeBehaviour::REPEAT_STRING, $level) . ' ' . $parentNode['name'];
            $listNode[$parentNode['id']] = $name;
        }
    }

    /*
     * получить дерево в виде массива (например, для CArrayDataProvider)
     */
    public function getCategoryByArrayTree($returnRoot = false)
    {
        $list = array();
        $tree = Yii::app()->cache->get($this->getCacheName());
        if( !is_array($tree) )
        {
            return $list;
        }
        $this->buildCategoryByArrayTree(
            array(
                'children' => $tree,
                'name' => CategoryTreeBehaviour::ROOT_NODE_NAME,
                'id' => CategoryTreeBehaviour::ROOT_NODE_ID,
            ),
            $list,
            0
        );
        if( $returnRoot == false )
        {
            unset($list[0]);
        }
        return $list;
    }

    private function buildCategoryByArrayTree($parentNode, &$listNode, $level)
    {
        $name = $parentNode['name'];
        if( count($parentNode['children']) > 0 )
        {
            $name = "<b>{$name}</b>";
        }
        $name = str_repeat(CategoryTreeBehaviour::REPEAT_STRING, $level) . ' ' . $name;
        $id = $parentNode['id'];
        array_push(
            $listNode,
            array(
                'id' => $id,
                'name' => $name,
            )
        );
        foreach($parentNode['children'] as $child)
        {
            $this->buildCategoryByArrayTree($child, $listNode, $level+1);
        }
    }

    /*
     * построить дерево категорий
     */
    public function buildCategoryTree($returnRootNode = false)
    {
        $idField = $this->owner->getIdField();
        $parentIdField = $this->owner->getParentIdField();
        $nameField = $this->owner->getNameField();

        $criteria = new CDbCriteria();
        $criteria->order = $nameField . ' ASC';

        $categoryList = $this->owner->findAll($criteria);

        $allCategories = array();

        foreach($categoryList as $category)
        {
            $allCategories[$category->$idField] = array(
                'id' => $category->$idField,
                'name' => $category->getNameByUcFirst(),
                'parent' => $category->$parentIdField,
            );
        }

        $tree = array();
        $this->_buildCategoryTree($allCategories, CategoryTreeBehaviour::ROOT_NODE_ID, $tree);
        
        if( $returnRootNode == false )
        {
            reset($tree);
            $tree = $tree[key($tree)]['children'];
        }

        Yii::app()->cache->set($this->getCacheName(), $tree);

        return $tree;
    }

    private function _buildCategoryTree($allCategories, $node, &$result)
    {
        $result[] = array(
            'id' => $allCategories[$node]['id'],
            'children' => array(),
            'name' => $allCategories[$node]['name']
        );

        if( $node == CategoryTreeBehaviour::ROOT_NODE_ID )
        {
            $result[count($result)-1]['expanded'] = true;
        }
        else
        {
            $result[count($result)-1]['expanded'] = false;
        }

        $result[count($result)-1]['text'] = CHtml::link(
            $allCategories[$node]['name'],
            $this->getCategoryLink($allCategories[$node]['id'])
        );

        foreach($allCategories as $childItem)
        {
            if( $childItem['parent'] == $node && $childItem['id'] != CategoryTreeBehaviour::ROOT_NODE_ID)
            {
                $this->_buildCategoryTree($allCategories, $childItem['id'], $result[count($result)-1]['children']);
            }
        }
    }

    private function hasChildCategories($allCategories, $node)
    {
        foreach($allCategories as $category)
        {
            if( $category['parent'] == $node )
            {
                return true;
            }
        }
        return false;
    }

    public function clearCache()
    {
        Yii::app()->cache->delete($this->getCacheName());
    }

    public function getCache()
    {
        return Yii::app()->cache->get($this->getCacheName());
    }

    public function getChildrenCategory($id = self::ROOT_NODE_ID)
    {
        return $this->owner->findAll(
            $this->owner->getParentIdField() . ' = :id',
            array(
                ':id' => $id,
            )
        );
    }

    /*
     * удаление children категорий
     */
    public function beforeDelete()
    {
        $id = $this->owner->getIdField();
        $parentId = $this->owner->getParentIdField();

        $criteria = new CDbCriteria();
        $criteria->condition = "{$parentId} = :id";
        $criteria->params = array(
            ':id' => $this->owner->$id,
        );

        $childs = $this->owner->findAll($criteria);
        foreach($childs as $category)
        {
            $category->delete();
        }

        return true;
    }

    public function afterDelete()
    {
        $this->buildCategoryTree();
        return true;
    }

    public function afterSave()
    {
        $this->buildCategoryTree();
        return true;
    }
}

?>
