<?php

/*
 * YorClass - ваш class для работы с пагинацией
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models; // у каждого приложения будет своё пространство имён

use app\models\YorClass;
use yii\helpers\Html;


class Pagination 
{
    
	
    protected function viewPagination()
    {
        return YorClass::find();
    } 
	
    public function First() 
    {
	// получаем id первой записи, в порядке убывания (1,2,3 ...40)
        $model = self::viewPagination()
		->orderBy(['id' => SORT_ASC])
		->limit(1)
		->one();
        return $model->id;
    }
    
    public function countPag($params = '') 
    {
	// считаем количество записей до текущего id (по get параметру на текущей странице)
        return self::viewPagination()
		->where(['between', 'id', self::First(), $params])
		->count();
    } 
    
    public function getNext($params = '')
    {
	// узнаём id после текущего id
	$offset = self::countPag($params);
	$limit = self::First()
        $model = self::viewPagination()
		->select('id')
		->offset($offset)
		->limit($limit)
		->orderBy(['id' => SORT_ASC])
		->one();
        return $model->id;
    }
    
    public function getPrev($params = '')
    {
	// узнаём id перед текущим id
	$offset = self::countPag($params)-2;
	$limit = self::First();
        $model = self::viewPagination()
		->select('id')
		->offset($offset)
		->limit($limit)
		->orderBy(['id' => SORT_ASC])
		->one();
        return $model->id;
    }

    public function getNextButton($params = '', $icons = 'ionicons ion-arrow-right-c')
    {
	// Данная функия по id определяет какую ссылку вывести, get параметр выводится по столбцу link
	// функция выводит кнопку к следующей записи
	$next = self::getNext($params)
        $model = self::viewPagination()->where(['id' => $next])->one();
	$arrow_right = Html::tag('i', '', ['class' => $icons]);
        return ($model == null) ? '' : Html::a($arrow_right, '/blog/'.$model->link);
    }

    public function getPrevButton($params = '', $icons = 'ionicons ion-arrow-left-c')
    {
	// Данная функия по id определяет какую ссылку вывести, get параметр выводится по столбцу link
	// функция выводит кнопку к предыдущей записи
	$prev = self::getPrev($params);
        $model = self::viewPagination()->where(['id' => $prev])->one();
	$arrow_left = Html::tag('i', '', ['class' => $icons]);  
        return ($model->id == $params) ? '' : Html::a($arrow_left, '/blog/'.$model->link);
    }

    public function getPanel($params = '')
    {
        // Формируем в разметке Bootstrap - предыдущая / следующая запись
	$prevButton = Html::tag('li', self::getPrevButton($params), ['class' => 'previous']);
        $nextButton = Html::tag('li', self::getNextButton($params), ['class' => 'next']);
        return Html::tag(
		'ul', 
		$prevButton.
		$nextButton, 
		['class' => 'pager']
	);
    }
    

}
