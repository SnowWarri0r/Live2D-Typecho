<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>
<?php
/**
 * 把可爱的 Pio 捉到博客上吧！
 *  
 * 
 * @package Live2D
 * @author SnowWarri0r
 * @version 1.0
 * @link https://www.onesnowwarrior.cn
 */

define('Live2D_Plugin_VERSION', '1.0');
class Live2D_Plugin implements Typecho_Plugin_Interface
{   
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->header = array('Live2D_Plugin', 'header');
        Typecho_Plugin::factory('Widget_Archive')->footer = array('Live2D_Plugin', 'footer');
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}
   
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){
        $homeURL = new Typecho_Widget_Helper_Form_Element_Textarea('homeURL', NULL, '', _t('主页链接'), _t('主页链接，以“/”结尾'));
        $form->addInput($homeURL);
        echo '<p>本插件需要加载jQuery，如果你的主题没有引用请选择加载。<br />关于提示语的修改，请直接编辑 message.json。</p>';
        $l2dst= new Typecho_Widget_Helper_Form_Element_Checkbox('l2dst',  array(
            'jq' => _t('配置是否加载JQuery：勾选则加载不勾选则不加载')
        ),
        array('jq'), _t('基本设置'));
        $form->addInput($l2dst);
        $cdn= new Typecho_Widget_Helper_Form_Element_Text('cdn',NULL,'',_t('CDN地址'),_t('如果为空，则代表皮肤贴图从插件目录下读取，如果有cdn则可以选择输入cdn存储皮肤贴图的地址位置(只针对皮肤贴图)'));
        $form->addInput($cdn);
    }
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    
    /**
     * 输出头部css
     * 
     * @access public
     * @return void
     */
    public static function header(){
        if(Live2D_Plugin::isMobile()){echo '<script>var dMobile=true</script>';}
        else{echo '<script>var dMobile=false</script>';}
        echo '<link rel="stylesheet" href="/usr/plugins/Live2D/css/live2d.min.css?v='.Live2D_Plugin_VERSION.'" />';
    }

    /**
     * 在底部输出所需 JS
     * 
     * @access public
     * @return void
     */
	public static function footer(){
        self::insertLive2D();
        if(Live2D_Plugin::isCDN()){
            echo '<script>let cdn="'.Helper::options()->plugin('Live2D')->cdn.'"</script>';
        }
        echo '
            <script>let cdn=""</script>
            <script type="text/javascript" src="/usr/plugins/Live2D/js/live2d.min.js?v='.Live2D_Plugin_VERSION.'"></script>
            <script type="text/javascript" src="/usr/plugins/Live2D/js/initlive2d.js?v='.Live2D_Plugin_VERSION.'"></script>
        ';
        if (!empty(Helper::options()->plugin('Live2D')->l2dst) && in_array('jq', Helper::options()->plugin('Live2D')->l2dst)){
            echo '<script src="https://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>';   }
    }


    /**
     * 在 Body 标签内插入 Live2D 块
     * @access public
     * @return void
     */
    private static function insertLive2D(){

        $html='<canvas id="live2d" class="live2d" width="280" height="250" homeurl="'.Typecho_Widget::widget('Widget_Options')->plugin('Live2D')->homeURL.'"></canvas>
        <div id="l2d-tools-panel" style="display: none">
            <a href="'.Typecho_Widget::widget('Widget_Options')->plugin('Live2D')->homeURL.'" target="_self"><div id="l2d-home" class="l2d-tools l2d-tools-r">Home</div></a>
            <div id="l2d-change" class="l2d-tools l2d-tools-r">Change</div>
            <div id="l2d-message" class="l2d-tools"></div>
            <div id="l2d-photo" class="l2d-tools l2d-tools-r">Photo</div>
            <a href="https://www.onesnowwarrior.cn/"><div id="l2d-about" class="l2d-tools l2d-tools-r">About</div></a>
            <div id="l2d-hide" class="l2d-tools l2d-tools-r">Hide</div>
        </div>';
        echo $html;
    }

    /**
     * 移动设备识别
     *
     * @return boolean
     */
    private static function isMobile(){
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $mobile_browser = Array(
            "mqqbrowser", // 手机QQ浏览器
            "opera mobi", // 手机opera
            "juc","iuc", 'ucbrowser', // uc浏览器
            "fennec","ios","applewebKit/420","applewebkit/525","applewebkit/532","ipad","iphone","ipaq","ipod",
            "iemobile", "windows ce", // windows phone
            "240x320","480x640","acer","android","anywhereyougo.com","asus","audio","blackberry",
            "blazer","coolpad" ,"dopod", "etouch", "hitachi","htc","huawei", "jbrowser", "lenovo",
            "lg","lg-","lge-","lge", "mobi","moto","nokia","phone","samsung","sony",
            "symbian","tablet","tianyu","wap","xda","xde","zte"
        );
        $is_mobile = false;
        foreach ($mobile_browser as $device) {
            if (stristr($user_agent, $device)) {
                $is_mobile = true;
                break;
            }
        }
        return $is_mobile;
    }
    /**
     *cdn配置识别
     *
     * @return boolean
     */
    private static function isCDN(){
        $is_cdn = false;
        if(!empty(Typecho_Widget::widget("Widget_Options")->plugin("Live2D")->cdn)){
            $is_cdn = true;
        }
        return $is_cdn;
    }
    
}
?>
