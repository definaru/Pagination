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
    
    public function First() 
    {
	// получаем id первой записи, в порядке убывания (1,2,3 ...40)
        $model = YorClass::find()->orderBy(['id' => SORT_ASC])->limit(1)->one();
        return $model->id;
    }
    
    public function countPag($params = '') 
    {
	// считаем количество записей до текущего id (по get параметру на текущей странице)
        return YorClass::find()->where(['between', 'id', self::First(), $params])->count();
    } 
    
    public function getNext($params = '')
    {
	// узнаём id после текущего id
        $model = YorClass::find()->select('id')->offset(self::countPag($params))->limit(self::First())->orderBy(['id' => SORT_ASC])->one();
        return $model->id;
    }
    
    public function getPrev($params = '')
    {
	// узнаём id перед текущим id
        $model = YorClass::find()->select('id')->offset(self::countPag($params)-2)->limit(self::First())->orderBy(['id' => SORT_ASC])->one();
        return $model->id;
    }

    public function getNextButton($params = '')
    {
	// Данная функия по id определяет какую ссылку вывести, get параметр выводится по столбцу link
	// функция выводит кнопку к следующей записи
        $model = YorClass::find()->where(['id' => self::getNext($params)])->one();
        return ($model == null) ? '' : Html::a('<i class="ionicons ion-arrow-right-c"></i>', '/blog/'.$model->link);
    }

    public function getPrevButton($params = '')
    {
	// Данная функия по id определяет какую ссылку вывести, get параметр выводится по столбцу link
	// функция выводит кнопку к предыдущей записи
        $madel = YorClass::find()->where(['id' => self::getPrev($params)])->one();
        return ($madel->id == $params) ? '' : Html::a('<i class="ionicons ion-arrow-left-c"></i>', '/blog/'.$madel->link);
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
