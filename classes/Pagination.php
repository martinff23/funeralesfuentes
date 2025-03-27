<?php

namespace Classes;

class Pagination{
    public $currentPage;
    public $recordsPerPage;
    public $totalRecords;

    public function __construct($currentPage=1,$recordsPerPage=10,$totalRecords=0){
        $this->currentPage = (int) $currentPage;
        $this->recordsPerPage = (int) $recordsPerPage;
        $this->totalRecords = (int) $totalRecords;
    }

    public function calculateOffset(){
        return $this->recordsPerPage * ($this->currentPage - 1);
    }

    public function totalPages(){
        return ceil($this->totalRecords/$this->recordsPerPage);
    }

    public function previousPage(){
        return (($this->currentPage - 1) > 0) ? $this->currentPage - 1 : false;
    }

    public function nextPage(){
        return (($this->currentPage + 1) <= $this->totalPages() ) ? $this->currentPage + 1 : false;
    }

    public function link_previous(){
        $html='';
        if($this->previousPage()){
            $html.= '<a class="pagination__link pagination__link--text" href="?page='.$this->previousPage().'">&laquo; Anterior</a>';
        }
        return $html;
    }

    public function link_next(){
        $html='';
        if($this->nextPage()){
            $html.= '<a class="pagination__link pagination__link--text" href="?page='.$this->nextPage().'">Siguiente &raquo;</a>';
        }
        return $html;
    }

    public function steps(){
        $html='';
        for($i=1;$i<=$this->totalPages();$i++){
            if($i===$this->currentPage){
                $html.='<span class="pagination__link pagination__link--current">'.$i.'</span>';
            } else{
                $html.='<a class="pagination__link pagination__link--number" href="?page='.$i.'">'.$i.'</a>';
            }
        }
        return $html;
    }

    public function pagination(){
        $html='';
        if($this->totalRecords > 0){
            $html.='<div class="pagination">';
            $html.=$this->link_previous();
            $html.=$this->steps();
            $html.=$this->link_next();
            $html.='</div>';
        }
        return $html;
    }
}