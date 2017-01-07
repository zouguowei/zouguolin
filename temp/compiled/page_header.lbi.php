<?php echo $this->smarty_insert_scripts(array('files'=>'jquery-1.11.3.min.js,jquery.json.js')); ?> 
<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
</script> 
<script type="text/javascript">
//设为首页 www.ecmoban.com
function SetHome(obj,url){
    try{
        obj.style.behavior='url(#default#homepage)';
       obj.setHomePage(url);
   }catch(e){
       if(window.netscape){
          try{
              netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
         }catch(e){
              alert("抱歉，此操作被浏览器拒绝！\n\n请在浏览器地址栏输入“about:config”并回车然后将[signed.applets.codebase_principal_support]设置为'true'");
          }
       }else{
        alert("抱歉，您所使用的浏览器无法完成此操作。\n\n您需要手动将【"+url+"】设置为首页。");
       }
  }
}
 
//收藏本站 bbs.ecmoban.com
function AddFavorite(title, url) {
  try {
      window.external.addFavorite(url, title);
  }
catch (e) {
     try {
       window.sidebar.addPanel(title, url, "");
    }
     catch (e) {
         alert("抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请使用Ctrl+D进行添加");
     }
  }
}
</script> 


<div class="indexw_header">
  <div class=" block header_bg" style="margin-bottom: 0px;">
    <div class="clear_f"></div>
    <div class="header_top logo_wrap">
      <div class="indexw_header_middleL"> <a class="logo_new" href="index.php"><img src="themes/ecmoban_zsxn/images/logo.png"  width="320" height="100"/></a> </div>
      <div class="indexw_slogan"></div>
      <div class="indexw_header_middleR">
        <div class="indexw_header_input_border">
          <div class="ser_n">
            <form id="searchForm" class="searchBox" name="searchForm" method="get" action="search.php" onSubmit="return checkSearchForm()">
              <input name="keywords" type="text" id="keyword" value="墙绘"  onclick="javascript:if(this.value=='墙绘')this.value=''"  class="indexw_header_input_text" />
              <input type="submit"  name="imageField" class="fm_hd_btm_shbx_bttn" value="搜 索">
            </form>
            <ul class="searchType none_f">
            </ul>
          </div>
          </div>
      </div>
    </div>
  </div>
</div>
<div class="menu_box clearfix">
  <div class="block">
    <div class="menu"> 
    	<div class="menu_new_div"><a style="border-left:none;" href="index.php"<?php if ($this->_var['navigator_list']['config']['index'] == 1): ?> class="cur"<?php endif; ?>><?php echo $this->_var['lang']['home']; ?></a></div>
      <?php $_from = $this->_var['navigator_list']['middle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_middle_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_middle_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_middle_list']['iteration']++;
?> 
      <div class="menu_new_div"><a href="<?php echo $this->_var['nav']['url']; ?>" <?php if ($this->_var['nav']['opennew'] == 1): ?>target="_blank" <?php endif; ?> <?php if ($this->_var['nav']['active'] == 1): ?> class="cur"<?php endif; ?>><?php echo $this->_var['nav']['name']; ?></a></div>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
    </div>
  </div>
</div>
