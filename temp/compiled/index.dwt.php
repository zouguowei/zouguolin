<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v3.0.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
<link rel="alternate" type="application/rss+xml" title="RSS|<?php echo $this->_var['page_title']; ?>" href="<?php echo $this->_var['feed_url']; ?>" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,index.js')); ?>
</head>
<body class="index_page" style="min-width:1200px;">
<?php echo $this->fetch('library/page_header.lbi'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.SuperSlide.js')); ?>
<?php echo $this->fetch('library/index_ad.lbi'); ?>
<div class="indexw_content">
<div class="block clearfix" >
<div class="AreaL">
<div id="mallNews" class="box_1">
    <h3><span>最新资讯</span></h3>
    <div class="NewsList tc" style="border-top:none">
        <ul>
        <?php $_from = $this->_var['new_articles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
        <li>
      <a href="<?php echo $this->_var['article']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['article']['title']); ?>"><?php echo sub_str($this->_var['article']['short_title'],20); ?></a>
        </li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
    </div>
</div>

<?php $this->assign('ads_id','159'); ?><?php $this->assign('ads_num','1'); ?><?php echo $this->fetch('library/ad_position.lbi'); ?>

</div>
<div class="Arear">
<div class="sale_box_new clearfix">
<h3><span>服务流程</span></h3>
  <div class="indexw_content_4_top clearfix">
     <ul class="clearfix">
       <?php $_from = $this->_var['new_articles_13']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['article']):
?>
       <li>
       		<p><a href="<?php echo $this->_var['article']['url']; ?>"><img src="themes/ecmoban_zsxn/images/fwlc<?php echo $this->_var['key']; ?>.jpg" border="0" class="B_blue"/></a></p>
       		<p class="indexw_content_pright"><a href="<?php echo $this->_var['article']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['article']['title']); ?>" style="font-weight:bold;"><?php echo $this->_var['article']['title']; ?></a><br /><br /><?php echo $this->_var['article']['description']; ?></p>
       	</li>
       <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
       </ul>
   </div>
 </div>
<div class="sale_box_new clearfix" style="width:486px;">
<h3><span>选择我们的三大理由</span></h3>
  <div class="indexw_content_4_top clearfix">
     <ul class="clearfix">
        <li>
       		<p><a><img src="themes/ecmoban_zsxn/images/ln1.jpg" border="0" class="B_blue"/></a></p>
       		<p class="indexw_content_pright" style="width: 300px;"><a style="font-weight:bold;">一棵树-理念性</a><br /><br />个性时尚+自然本真+深度创作+绿色环保+完美品质+引领时尚艺术手绘的最新潮流</p>
       	</li>
       	<li>
       		<p><a><img src="themes/ecmoban_zsxn/images/ln2.jpg" border="0" class="B_blue"/></a></p>
       		<p class="indexw_content_pright"><a style="font-weight:bold;">一棵树-专业性</a><br /><br />专业名牌高校艺术创作团队+丰富的行业经验</p>
       	</li>
       	<li>
       		<p><a><img src="themes/ecmoban_zsxn/images/ln3.jpg" border="0" class="B_blue"/></a></p>
       		<p class="indexw_content_pright" style="width: 300px;"><a style="font-weight:bold;">一棵树-服务性</a><br />为您提供最实惠最优质的艺术创作服务、艺术品质量把关、节约成本预算、良好的职业道德操守、兢兢业业的工作态度</p>
       	</li>
       </ul>
   </div>
 </div>
<div class="blank" style="height:1px;"></div>
</div> 
  <div class="goodsBox_1">
  

  
<?php if ($this->_var['new_goods']): ?>
<?php if ($this->_var['cat_rec_sign'] != 1): ?>
<div class="xm-box">
  <h4 class="title"><span>最新案例</span> <a class="more" href="search.php?intro=new">更多</a></h4>
  <div class="indexw_content_4_top"></div>
  <div id="show_new_area" class="clearfix"> 
    
    <?php $_from = $this->_var['new_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
    <div class="goodsItem <?php if ($this->_var['key'] == 0): ?>no-margin-left<?php endif; ?>"> <a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['original_img']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>" class="goodsimg" /></a><br />
      <p class="f1"><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>"><?php echo $this->_var['goods']['short_style_name']; ?></a></p>
      <p>
     <font class="market"> 价格：<?php echo $this->_var['goods']['market_price']; ?></font> <br/>
      </p>
      </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  </div>
</div>
<div class="blank"></div>
<?php endif; ?> 
<?php endif; ?> 
<?php if ($this->_var['hot_goods']): ?>
<?php if ($this->_var['cat_rec_sign'] != 1): ?>
<div class="xm-box">
  <h4 class="title"><span>热门推荐</span> <a class="more" href="search.php?intro=new">更多</a></h4>
  <div class="indexw_content_4_top"></div>
  <div id="show_hot_area" class="clearfix"> 

    <?php $_from = $this->_var['hot_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
    <div class="goodsItem <?php if ($this->_var['key'] == 0): ?>no-margin-left<?php endif; ?>"> <a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['original_img']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>" class="goodsimg" /></a><br />
      <p class="f1"><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>"><?php echo $this->_var['goods']['short_style_name']; ?></a></p>
      <p>
      <font class="market">价格：<?php echo $this->_var['goods']['market_price']; ?></font> <br/>
      </p>
      </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  </div>
</div>
<div class="blank"></div>
<?php endif; ?> 
<?php endif; ?> 
<?php if ($this->_var['best_goods']): ?>
<?php if ($this->_var['cat_rec_sign'] != 1): ?>
<div class="xm-box">
  <h4 class="title"><span>精品推荐</span> <a class="more" href="search.php?intro=new">更多</a></h4>
  <div class="indexw_content_4_top"></div>
  <div id="show_best_area" class="clearfix"> 
    <?php $_from = $this->_var['best_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
    <div class="goodsItem <?php if ($this->_var['key'] == 0): ?>no-margin-left<?php endif; ?>"> <a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['original_img']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>" class="goodsimg" /></a><br />
      <p class="f1"><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>"><?php echo $this->_var['goods']['short_style_name']; ?></a></p>
       <p>
      <font class="market">价格：<?php echo $this->_var['goods']['market_price']; ?></font> <br/>
    </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  </div>
</div>
<div class="blank"></div>
<?php endif; ?> 
<?php endif; ?> 
</div> 
</div>
  

 </div>
<div class="bottom_ad">
            
<?php $this->assign('ads_id','160'); ?><?php $this->assign('ads_num','1'); ?><?php echo $this->fetch('library/ad_position.lbi'); ?>


</div>
<div class="resetClear"></div>

    <?php echo $this->fetch('library/help.lbi'); ?>
 

<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
