<?php /*
Plugin Name: Colio-Press Portfolio
Plugin URI: http://jasonjalbuena.com/
Description: Custom plugin for sistercor.com to WordPress-ize the Colio jQuery portfolio plugin
Version: 1.0
Author: Jason Jalbuena
Author URI: http://jasonjalbuena.com
License: GPLv2 or later
*/

add_shortcode('coliopress', 'coliopress_f');
function coliopress_f() {
	$o=get_option('colio_press_o');//get options as saved from db

	$thfilt=(!empty($o['filters'])?$o['filters']:'');
	if($thfilt==array()||$thfilt=='') {$thfilt=array(0);}

	$thcat=(!empty($o['cats'])?$o['cats']:'');
	if($thcat==array()||$thcat=='') {$thcat=array(0);}

	$thdis=(!empty($o['items'])?$o['items']:'');
	if($thdis==array()||$thdis=='') {$thdis=array(0);}	

	echo '<link rel="stylesheet" href="'.plugins_url( 'css/base.cssX' , __FILE__ ).'">
	<link rel="stylesheet" href="'.plugins_url( 'css/skeleton.cssX' , __FILE__ ).'">
	<link rel="stylesheet" href="'.plugins_url( 'css/layout.css' , __FILE__ ).'">
	<link rel="stylesheet" href="'.plugins_url( 'css/colio.css' , __FILE__ ).'">
	<link rel="stylesheet" href="'.plugins_url( 'css/style.css' , __FILE__ ).'">
	<link rel="stylesheet" href="'.plugins_url( 'css/flexslider.css' , __FILE__ ).'">

	<script type="text/javascript" src="'.plugins_url( 'js/jquery.easing.1.3.js' , __FILE__ ).'"></script>
	<script type="text/javascript" src="'.plugins_url( 'js/jquery.scrollUp.min.js' , __FILE__ ).'"></script>
	<script type="text/javascript" src="'.plugins_url( 'js/jquery.browser.js' , __FILE__ ).'"></script>
	<script type="text/javascript" src="'.plugins_url( 'js/jquery.quicksand.js' , __FILE__ ).'"></script>
	<script type="text/javascript" src="'.plugins_url( 'js/jquery.colio.min.js' , __FILE__ ).'"></script>
	<script type="text/javascript" src="'.plugins_url( 'js/jquery.flexslider.js' , __FILE__ ).'"></script>

	<style type="text/css">
#primary .entry-content ul, #primary .entry-content ol {list-style:none;}
#primary .flexslider ul.slides {margin:0;}
#primary .flexslider ol {margin-top:20px;}
#primary .flexslider ul.flex-direction-nav {display:none;}
#secondary.widget-area, #ascrail2000 {opacity:0 !important;}
#page footer#section-sub-footer {margin:0;}
	@media only screen and (min-width: 768px) {
.colio-theme-white .main, .colio-theme-white .side {
    clear:both;
    padding:0;
    width:100%;}	
.colio-theme-white .main h3 {
    margin-top:0;
}
.colio-theme-white .colio-navigation {
    left:41px;
    margin-right:0;
    position:absolute;
    top:4px;
}
	}
	</style>
	<script type="text/javascript">
		jQuery(document).ready(function($) {

//fix for elevate theme, nicescroll breaks scrolltop
$("a.colio-link").click(function() {
	$("#main").getNiceScroll().doScrollPos(0,$("#main").position().top);
	var sh_ht = $("#section-header").height() + 10;
	$("#section-content").css("top",sh_ht).css("z-index","1");
	$("#section-header, #section-content").css("position","fixed");
});

// "colio" plugin
var colio_run = function(){';
	echo "$('#demo_1').remove();
	$('.portfolio .list').colio({
		id: 'demo_1',
		theme: 'white',
		placement: 'before',
		onContent: function(content){
			// init flexslider plugin
			$('.flexslider', content).flexslider({slideshow: false, animationSpeed: 300});
		}
	});
};

colio_run();

// quicksand plugin
var quicksand_run = function(items){
	$('.portfolio .list').quicksand(items, {
		retainExisting: false, adjustWidth:false, duration: 500
	}, colio_run);
};

$('.portfolio .list li').each(function(n){
	$(this).attr('data-id', n);
});

var copy = $('.portfolio .list li').clone();

$('.portfolio .filters a').click(function(){
	$(this).addClass('filter-active').siblings().removeClass('filter-active');
	var href = $(this).attr('href').substr(1);
	filter = href ? '.' + href : '*';
	quicksand_run(copy.filter(filter));
	return false;
});
	});
	</script>";
	$imgs=array();
	echo '<div class="portfolio clearfix">
		<div class="filters">
			<a href="#" class="filter-active">All</a>';
			foreach($thfilt as $th) {
				$title=(!empty($th['title'])?$th['title']:'');
				if(empty($title)) {
				}else{
					$tag=(!empty($th['tag'])?$th['tag']:'');
				}
				echo '<a href="#'.$tag.'">'.$title.'</a>';
			}
		echo '</div><!-- filters -->
		<ul class="list clearfix">';
			foreach($thdis as $th) {
				$title=(!empty($th['title'])?$th['title']:'');
				if(empty($title)) {
				}else{
					$subtitle=(!empty($th['subtitle'])?$th['subtitle']:'');
					$img_sm=(!empty($th['img_sm'])?$th['img_sm']:'');
					$img_bg=(!empty($th['img_bg'])?$th['img_bg']:'');
					$thfilts=(!empty($th['filters'])?$th['filters']:array());
					$thcats=(!empty($th['cats'])?$th['cats']:'');
					echo '<li class="'.implode(' ',$thfilts).'"  data-content="#'.$thcats.'">
						<div class="thumb">
							<div class="view">
								<a class="button colio-link" href="#">View Project</a>
							</div>
							<img src="'.$img_sm.'" alt="'.$title.'"/>
						</div>
						<h4><a class="colio-link" href="#">'.$title.'</a></h4>
						<p>'.$subtitle.'</p>
					</li>';
					$imgs[$thcats][]=array($img_sm, $title);
				}
			}
		echo '</ul><!-- list -->
	</div>';
	foreach($thcat as $c) {
		$title=(!empty($c['title'])?$c['title']:'');
		$tag=(!empty($c['tag'])?$c['tag']:'');
		$desc=(!empty($c['desc'])?$c['desc']:'');
		echo '<div id="'.$tag.'" class="colio-content">
			<div class="side">
				<div class="flexslider">
					<ul class="slides">';
						foreach($imgs[$tag] as $s) {
							echo '<li><img src="'.$s[0].'" alt="'.$s[1].'"/></li>';
						}
					echo '</ul>
				</div>
			</div>
		<div class="main">
			<h3>'.$title.'</h3>
			<p>'.$desc.'</p>
		</div>
	</div>';
	}
}

//set options
function colio_press_admin_init_stuff(){
	register_setting('colio_press_gr','colio_press_o');//theme settings
}
add_action('admin_init','colio_press_admin_init_stuff');

// add additional Admin menus
function colio_press_admin_menu_new_items() {
	add_menu_page('Portfolio Settings', 'Portfolio Settings', 'manage_options', 'colio_press_settings', 'colio_press_settings_settings_page');
}
add_action('admin_menu', 'colio_press_admin_menu_new_items');

//add admin scripts
function load_custom_wp_admin_style() {
	wp_enqueue_script('jquery');
	if (is_admin() ) {
		if(function_exists( 'wp_enqueue_media' )){
			wp_enqueue_media();
		}else{
		wp_enqueue_style('thickbox');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		}
	}
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

//start colio press settings page
function colio_press_settings_settings_page() {
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
	?>
	<div class="wrap">
		<?php screen_icon('themes'); echo "<h2>Work Portfolio Settings Options</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] || (isset($_GET['updated']) && $_GET['updated']=='true')) : ?>
			<div class="updated fade"><p><strong>Options saved.</strong></p></div>
		<?php endif; 
		$o=get_option('colio_press_o'); ?>
		<form method="post" action="options.php">
			<?php settings_fields( 'colio_press_gr' ); ?>			
<h3>Filters</h3>
<div id="filtersdiv">
	<?php $thfilt=(!empty($o['filters'])?$o['filters']:'');
	if($thfilt==array()||$thfilt=='') {$thfilt=array(0);}
    echo '<table id="filters" class="th_all ui-sortable"><tbody>';
	$i=1;$filter_opts=array();
		foreach($thfilt as $th) {
			$title=(!empty($th['title'])?esc_html($th['title']):'');
			if(empty($title)) {
			}else{
				$tag=(!empty($th['tag'])?esc_html($th['tag']):'');
				echo '<tr>
					<td class="sort">+</td>
					<td class="inputter">
						<input class="" type="text" name="colio_press_o[filters]['.$i.'][title]" value="'.$title.'" placeholder="Title"/>
						<input class="tag" type="text" name="colio_press_o[filters]['.$i.'][tag]" value="'.$tag.'" placeholder="Slug.Letters only,no spaces/characters"/>
					</td>
					<td class="remd deleteme"><div class="remcat">delete</div></td>
				</tr>';
				$filter_opts[]=array($tag,$title);
				$i++;
			}
		}
	echo '</tbody></table>
	<span id="addfilter" class="addnew">+ add new filter</span>'; ?>
	<p class="submit"><input type="submit" class="button-primary" value="Save" /></p>
</div>

<h3>Projects</h3>
<div id="catsdiv">
	<?php $thcat=(!empty($o['cats'])?$o['cats']:'');
	if($thcat==array()||$thcat=='') {$thcat=array(0);}
    echo '<table id="cats" class="th_all ui-sortable"><tbody>';
	$i=1;$cat_opts=array();
		foreach($thcat as $th) {
			$title=(!empty($th['title'])?esc_html($th['title']):'');
			if(empty($title)) {
			}else{
				$tag=(!empty($th['tag'])?$th['tag']:'');
				$desc=(!empty($th['desc'])?esc_html($th['desc']):'');
				echo '<tr>
					<td class="sort">+</td>
					<td class="inputter">
						<input class="" type="text" name="colio_press_o[cats]['.$i.'][title]" value="'.$title.'" placeholder="Title"/>
						<input class="tag" type="text" name="colio_press_o[cats]['.$i.'][tag]" value="'.$tag.'" placeholder="Slug.Letters only,no spaces/characters"/>
					</td>
					<td><textarea class="cat_texta" name="colio_press_o[cats]['.$i.'][desc]" placeholder="Description">'.$desc.'</textarea></td>
					<td class="remd deleteme"><div class="remcat">delete</div></td>
				</tr>';
				$cat_opts[]=array($tag,$title);
				$i++;
			}
		}
	echo '</tbody></table>
	<span id="addcat" class="addnew">+ add new project</span>'; ?>
	<p class="submit"><input type="submit" class="button-primary" value="Save" /></p>
</div>

<h3>Individual Items</h3>
<div id="items">
	<?php $thdis=(!empty($o['items'])?$o['items']:'');
	if($thdis==array()||$thdis=='') {$thdis=array(0);}
    echo '<ul id="th_display" class="th_all ui-sortable">';
	$i=1;
		foreach($thdis as $th) {
			$img_sm=(!empty($th['img_sm'])?$th['img_sm']:'');
			if(empty($img_sm)) {
			}else{
				$title=(!empty($th['title'])?esc_html($th['title']):'');
				$subtitle=(!empty($th['subtitle'])?esc_html($th['subtitle']):'');
				$img_bg=(!empty($th['img_bg'])?$th['img_bg']:'');
				$thfilts=(!empty($th['filters'])?$th['filters']:array());
				$thcats=(!empty($th['cats'])?$th['cats']:array());
				echo '<li class="small">
					<div><img class="img_sm" src="'.$img_sm.'"/></div><br/>
					<span class="addimg">CHANGE SMALL IMAGE</span><span class="deleteme">&#8709; delete</span>
					<input class="img_url" type="text" name="colio_press_o[items]['.$i.'][img_sm]" value="'.$img_sm.'"/><br/><br/>
					<span class="add_bg_img">CHANGE BIG IMAGE</span><a href="'.$img_bg.'" class="bgimg_pre" target="blank">view big image</a>
					<input type="text" name="colio_press_o[items]['.$i.'][img_bg]" value="'.$img_bg.'"/>
					<br/><br/>
					<input class="title" type="text" name="colio_press_o[items]['.$i.'][title]" value="'.$title.'" placeholder="Title"/>
					<input class="subtitle" type="text" name="colio_press_o[items]['.$i.'][subtitle]" value="'.$subtitle.'" placeholder="Subtitle"/>
					<div class="cat_cbs">
						Filters:<br/>';
						foreach($filter_opts as $c) {
							echo '<label><input '.(in_array($c[0], $thfilts)?'checked ':'').'type="checkbox" name="colio_press_o[items]['.$i.'][filters][]" value="'.$c[0].'"> '.$c[1].'</label>';
						}
					echo '</div>
					<div class="cat_cbs">
						Categories:<br/>';
						foreach($cat_opts as $c) {
							echo '<label><input '.($c[0]==$thcats?'checked ':'').'type="radio" name="colio_press_o[items]['.$i.'][cats]" value="'.$c[0].'"> '.$c[1].'</label>';
						}
					echo '</div>
					<span class="close">&#x25BC; close</span>
				</li>';
				$i++;
			}
		}
	echo '</ul>
	<span id="slideadd" class="addnew">+ add new slide</span>'; ?>
	<p class="submit"><input type="submit" class="button-primary" value="Save" /></p>
</div>
			<script type="text/javascript">jQuery(document).ready(function($){
var _custom_media = true,newi,numberone,numeroone,
			_orig_send_attachment = wp.media.editor.send.attachment,
			newi=1;
$(function() {
	$("#filters tbody, #cats tbody, #th_display").sortable({
		placeholder: "drag-placeholder"
	});
	var ta_width = $('#cats tr').find('textarea').width(   );
	$('#cats tr').find('textarea').css('width', ta_width + 'px');	
	$("#cats tbody").sortable({
		placeholder: "drag-placeholder"
	});
	
});
$("body").on("click", ".addimg", function() {
	var send_attachment_bkp = wp.media.editor.send.attachment;
	var button = $(this);

	_custom_media = true;
	wp.media.editor.send.attachment = function(props, attachment){
		if (_custom_media) {
			button.parent().find('img').attr('src',attachment.url);
			button.parent().find('.img_url').attr('value',attachment.url);
		} else {
			return _orig_send_attachment.apply(this, [props, attachment]);
		};
	}
	wp.media.editor.open(button);
	return false;
});
$("body").on("click", ".add_bg_img", function() {
	var send_attachment_bkp = wp.media.editor.send.attachment;
	var button = $(this);
	_custom_media = true;
	wp.media.editor.send.attachment = function(props, attachment){
		if (_custom_media) {
			button.next().attr('value',attachment.url);
			button.next().next().attr('href',attachment.url);
		} else {
			return _orig_send_attachment.apply(this, [props, attachment]);
		};
	}
	wp.media.editor.open(button);
	return false;
});
$(document).on('mouseover', '.img_sm', function() {
	$(this).before('<div class="overlay"><br/><br/>edit</div>');
}).on('mouseleave', '.overlay', function() {
	$('.overlay').remove();
});
$(document).on('click', '.overlay', function() {
	$(this).animate({width:'500px',height:'300px'},500);
	$(this).next().animate({width:'500px',height:'300px'},500);
	$(this).parent().parent().attr('style','').animate({width:'500px'},500).css('background','#636363');
	$(this).next().removeClass().addClass('editimg');
	$(this).parent().addClass('editdiv');
	$(this).parent().parent().removeClass();
	$('.overlay').remove();
});
$(document).on('click', '.close', function() {
	$(this).parent().animate({width:'121px',height:'69px'},500).attr('style','');
	$(this).parent().find('div').removeClass('editdiv');
	$(this).parent().addClass('small');
	$(this).parent().attr('style','');
	$(this).parent().find('img').removeClass().animate({width:'121px',height:'69px'},500,function(){$(this).addClass('img_sm').attr('style','');});
});
$('#addfilter').click(function() {
	if($('#filters tr').length) {
		newi = $('#filters tr').length;
		newi = newi + 1;
	} else {
		newi = 1;
	}	
	$('#filters').append('<tr><td class="sort">+</td><td class="inputter"><input class="" type="text" name="colio_press_o[filters][' + newi + '][title]" value="" placeholder="Title"/><input class="tag" type="text" name="colio_press_o[filters][' + newi + '][tag]" value="" placeholder="Slug.Letters only,no spaces/characters"/></td><td class="remd deleteme"><div class="remcat">delete</div></td></tr>');
});
$('#addcat').click(function() {
	if($('#cats tr').length) {
		newi = $('#cats tr').length;
		newi = newi + 1;
	} else {
		newi = 1;
	}
	$('#cats').append('<tr><td class="sort">+</td><td class="inputter"><input class="" type="text" name="colio_press_o[cats][' + newi + '][title]" value="" placeholder="Title"/><input class="tag" type="text" name="colio_press_o[cats][' + newi + '][tag]" value="" placeholder="Slug.Letters only,no spaces/characters"/></td><td><textarea name="colio_press_o[cats][' + newi + '][desc]" placeholder="Description"></textarea></td><td class="remd deleteme">delete</td></tr>');
});
<?php $f_opts='';	
	foreach($filter_opts as $c) {
		$f_opts.='<label><input type="checkbox" name="colio_press_o[items][qqqwww][filters][]" value="'.$c[0].'"> '.$c[1].'</label>';
	}
	$var_opts='';	
	foreach($cat_opts as $c) {
		$var_opts.='<label><input type="checkbox" name="colio_press_o[items][qqqwww][cats]" value="'.$c[0].'"> '.$c[1].'</label>';
	} ?>
var f_opts='<?php echo $f_opts; ?>';
var var_opts='<?php echo $var_opts; ?>';
$('#slideadd').click(function() {
	if($('#th_display li').length) {
		newi = $('#th_display li').length;
		newi = newi + 1;
	} else {
		newi = 1;
	}
	f_opts = f_opts.replace('qqqwww', newi ).replace('qqqwww', newi ).replace('qqqwww', newi ).replace('qqqwww', newi ).replace('qqqwww', newi ).replace('qqqwww', newi ).replace('qqqwww', newi ).replace('qqqwww', newi );
	var_opts = var_opts.replace('qqqwww', newi ).replace('qqqwww', newi ).replace('qqqwww', newi ).replace('qqqwww', newi ).replace('qqqwww', newi ).replace('qqqwww', newi ).replace('qqqwww', newi ).replace('qqqwww', newi );
	$('#th_display').append('<li><div><img class="img_sm" src=""/></div><br/><span class="addimg">CHANGE SMALL IMAGE</span><span class="deleteme">&#8709; delete</span><input class="img_url" type="text" name="colio_press_o[items][' + newi + '][img_sm]" value=""/><br/><br/><span class="add_bg_img">CHANGE BIG IMAGE</span><a href="" target="blank">view big image</a><input type="text" name="colio_press_o[items][' + newi + '][img_bg]" value=""/><br/><br/><input class="title" type="text" name="colio_press_o[items][' + newi + '][title]" value="" placeholder="Title"/><input class="subtitle" type="text" name="colio_press_o[items][' + newi + '][subtitle]" value="" placeholder="Subtitle"/><div class="cat_cbs">Filters:<br/>' + f_opts + '</div><div class="cat_cbs">Categories:<br/>' + var_opts + '</div><span class="close">&#x25BC; close</span></li>');
});
$(document).on('click', '.deleteme', function() {
	var r=confirm("Really delete this?");
	if (r==true) {
		$(this).parent().fadeOut(800, function() {
			$(this).remove(); 
		});
		$(this).parent().find('img').animate({width:'0',height:'0'},1800);
	}
});
				});
			</script>
			<style type="text/css">
.th_all {background:#3A3A3A;border:1px solid #C0C0C0;padding:20px 10px;}

#cats, #cats .ui-sortable-helper {width: 100%;}

table .sort {width:10px;color:#fff;}
#cats .inputter {width:268px;}
#cats input {width:265px;display: block;}
#cats textarea, #cats .ui-sortable-helper textarea {width:100%;}
table .remd {width:35px;color:#fff;}

#filters input {width:130px;float:left;}
#filters .inputter .tag {width:265px;}

.th_all li {display:inline-block;width:121px;height:auto;overflow:visible;color:#fff;}
.th_all li.small {overflow:hidden;height:69px;}
.th_all li img {width:100%;background:#808080;height:69px;display:inline-block;}
.th_all .editdiv {opacity:0.4;position:absolute;}
.th_all .editimg {height:300px;width:500px;}
.deleteme {left:297px;}
.th_all input, .th_all select, .th_all span, .th_all a {position:relative;width:490px;z-index:1;}
.th_all .overlay {position:absolute;height:69px;width:121px;color:#fff; background:#000;text-align:center;font-size:30px; vertical-align:middle; opacity:0.7;}
li.drag-placeholder {background:#C0C0C0;width:3px;height:70px;margin:0 5px;}

.cat_cbs {margin:8px 0;}
.cat_cbs label {margin-right:15px;}
.cat_cbs input {width:10px;}

.sort, .remcat {cursor:pointer;}
.addnew {color:#21759B;cursor:pointer;}
.addnew:hover {color:#D54E21;}
#wpfooter {bottom:40px;position:relative;}
			</style>
		</form>
	</div>
<?php }
//end colio press settings page
?>