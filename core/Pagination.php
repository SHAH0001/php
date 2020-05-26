<?php

namespace Core;

use RedBeanPHP\R;

class Pagination
{
    // текущая страница
    public $currentPage;

    // кол-во записей выводимых на стрвницу по умолчанию
    public $perpage = 15;

    // всего записей в таблице
    public $total;

    // кол-во страниц
    public $countPages;

    // отслеживает параметр ?page=#
    protected $uri;

    // имя таблицы из которой нужно произвести выбор данных
    protected $tableName;

    // данные выбраные из бд 
    protected $data = [];

    public function __construct($tableName, $perpage = null) {
        $this->tableName = $tableName;
        $this->perpage = $perpage ? (int) $perpage : 15;
        $this->total = $this->getTotal();
        $this->countPages = $this->getCountPages();
        $this->currentPage = $this->getCurrentPage($this->getPage());
        $this->uri = $this->getParams();
        $this->data = $this->setData();
    }

    public function __toString(){
        return $this->getHtml();
    }

    /**
     * Получает данные из бд
     */
    protected function setData()
    {
        return $this->data = R::findAll($this->tableName, "LIMIT {$this->getStart()}, {$this->perpage}");
    }

    /**
     * Возвращает данные полученные из бд
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Получате текущую страницу
     */
    protected function getPage()
    {
        return isset($_GET['page']) ? (int) $_GET['page'] : 1;
    }

    /**
     * Получает кол-во записей в таблице $tableName
     */
    protected function getTotal()
    {
        return R::count($this->tableName);
    }

    /**
     * Получает html для построения постраничного навигатора
     */
    public function getHtml() {

        $back = null; // ссылка НАЗАД
        $forward = null; // ссылка ВПЕРЕД
        $startpage = null; // ссылка В НАЧАЛО
        $endpage = null; // ссылка В КОНЕЦ
        $page2left = null; // вторая страница слева
        $page1left = null; // первая страница слева
        $page2right = null; // вторая страница справа
        $page1right = null; // первая страница справа

        if( $this->currentPage > 1 ){
            $back = "<li class='page-item'><a class='page-link' href='{$this->uri}page=" .($this->currentPage - 1). "'>&lt;</a></li>";
        }

        if( $this->currentPage < $this->countPages ){
            $forward = "<li class='page-item'><a class='page-link' href='{$this->uri}page=" .($this->currentPage + 1). "'>&gt;</a></li>";
        }

        if( $this->currentPage > 3 ){
            $startpage = "<li class='page-item'><a class='page-link' href='{$this->uri}page=1'>&laquo;</a></li>";
        }
        if( $this->currentPage < ($this->countPages - 2) ){
            $endpage = "<li class='page-item'><a class='page-link' href='{$this->uri}page={$this->countPages}'>&raquo;</a></li>";
        }
        if( $this->currentPage - 2 > 0 ){
            $page2left = "<li class='page-item'><a class='page-link' href='{$this->uri}page=" .($this->currentPage-2). "'>" .($this->currentPage - 2). "</a></li>";
        }
        if( $this->currentPage - 1 > 0 ){
            $page1left = "<li class='page-item'><a class='page-link' href='{$this->uri}page=" .($this->currentPage-1). "'>" .($this->currentPage-1). "</a></li>";
        }
        if( $this->currentPage + 1 <= $this->countPages ){
            $page1right = "<li class='page-item'><a class='page-link' href='{$this->uri}page=" .($this->currentPage + 1). "'>" .($this->currentPage+1). "</a></li>";
        }
        if( $this->currentPage + 2 <= $this->countPages ){
            $page2right = "<li class='page-item'><a class='page-link' href='{$this->uri}page=" .($this->currentPage + 2). "'>" .($this->currentPage + 2). "</a></li>";
        }

        return '<ul class="pagination justify-content-center">' . $startpage.$back.$page2left.$page1left.'<li class="page-item active"><a class="page-link">'.$this->currentPage.'</a></li>'.$page1right.$page2right.$forward.$endpage . '</ul>';
    }

    /**
     * Получает общее кол-во страниц
     */
    protected function getCountPages(){
        return ceil($this->total / $this->perpage) ?: 1;
    }

    /**
     * Получает текущую страницу
     */
    protected function getCurrentPage($page){
        if(!$page || $page < 1) $page = 1;
        if($page > $this->countPages) $page = $this->countPages;
        return $page;
    }

    /**
     * Формирует параметр start для LIMIT
     */
    public function getStart(){
        return ($this->currentPage - 1) * $this->perpage;
    }

    /**
     * Обрабатывает в GET параметрах значение page=#
     */
    protected function getParams(){
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $uri = $url[0] . '?';
        if(isset($url[1]) && $url[1] != ''){
            $params = explode('&', $url[1]);
            foreach($params as $param){
                if(!preg_match("#page=#", $param)) $uri .= "{$param}&amp;";
            }
        }
        return $uri;
    }
}