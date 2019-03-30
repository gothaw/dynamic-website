<?php

class View {

    private $viewName;
    private $viewFile;
    private $viewData;
    private $footerTheme;
    private $bannerImg;

    public function __construct($viewName,$viewFile,$viewData)
    {
        $this->viewName = $viewName;
        $this->viewFile = $viewFile;
        $this->viewData = $viewData;
    }

    public function renderView(){
        require_once '../app/views/' . $this->viewFile . '.php';
    }


    public function getFooterTheme()
    {
        return $this->footerTheme;
    }


    public function setFooterTheme($footerTheme)
    {
        if($footerTheme === 'dark'){
            $this->footerTheme = $footerTheme;
        }
        else{
            $this->footerTheme = 'light';
        }
    }

    public function getBannerImg()
    {
        return $this->bannerImg;
    }


    public function setBannerImg($bannerImg)
    {
        if($bannerImg === 'light' || $bannerImg = 'dark'){
            $this->bannerImg = $bannerImg;
        }
    }

}