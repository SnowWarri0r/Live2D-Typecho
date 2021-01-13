<?php
class imgdata{
    private $imgsrc;
    private $imgdata;
    private $imgform;
    private $imgRemote;
    public function getdir($source){
        $this->imgsrc  = $source;
    }
    public function redirectToURI(string $img,string $cdn){
        $this->imgRemote=$cdn .(substr($img, 0, 1)=="/"? "" : "/"). $img;
        header("Location:".$this->imgRemote);
    }
    public function img2data(){
        $this->_imgfrom($this->imgsrc);
        $this->imgdata=fread(fopen($this->imgsrc,'rb'),filesize($this->imgsrc));
    }
    public function data2img(){
        header("content-type:$this->imgform");
        echo $this->imgdata;
    }
    private function _imgfrom($imgsrc){
        $info=getimagesize($imgsrc);
        $this->imgform = $info['mime'];
    }
}
?>