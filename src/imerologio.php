<?php 

define('_JEXEC', 1);
define('JPATH_BASE', realpath(dirname(__FILE__) . '/'));  
require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

$mainframe = JFactory::getApplication('site');

$id = $_POST['id'];
$date_start = $_POST['date_start'];

$db = JFactory::getDbo();


$q = "select note from #__categories where id = " . $id ;

$db->setQuery($q);

$ids = $db->loadObjectList();


$Q = "select * from #__content where alias NOT LIKE '%archives%' and state = 1 and catid = " . $id . " order by ordering DESC";


$db->setQuery($Q);

$dates = $db->loadObjectList();




foreach( $dates as $d ){

	$data = json_decode( $d->images );
	$d->period = $data->image_intro_alt;

	$command = "select v.value as vl from #__fields_values as v where v.item_id = " . $d->id  . " and v.field_id = 12 ";

	$db->setQuery( $command );

	$d->artNmbr = $db->loadObjectList()[0]->vl;
}

//print_r(  $dates);

?>


<div class="resultsRequestInner">
	<div class="laws_timetable">
		<div class="progressBarWrapper">
			<h3>Progress Bar - <strong style="font-size: 30px"><?php echo $ids[0]->note; ?>%</strong></h3>
			<div id="progressbar">
			  	<div style="width:<?php echo $ids[0]->note; ?>%"></div>
			</div>
		</div>
		<div class="dateBAr">
			<h3>Date Bar - <p>ΣΗΜΑΝΤΙΚΕΣ ΗΜΕΡΟΜΗΝΙΕΣ ΤΟΥ ΝΟΜΟΣΧΕΔΙΟΥ</p></h3>			
			<div class="dateBarBar">
				<div class="dateBarBarInner">
					<ul>
						<?php foreach( $dates as $key=>$d ): ?>
							<?php switch ( $d->period ) {
								case 'D': ?>
									<li class="periodDBox" data-art="<?php echo $key+1; ?>" style="background-color: #47ff7b;"><?php echo $d->title; ?></li>
								<?php break; ?>
								<?php case 'E': ?>
									<li class="periodEBox" data-art="<?php echo $key+1; ?>" style="background-color: #47d26e;"><?php echo $d->title; ?></li>
								<?php break; ?>
								<?php case 'P': ?>
									<li class="periodPBox" data-art="<?php echo $key+1; ?>" style="background-color: #4ba264;"><?php echo $d->title; ?></li>
								<?php break; ?>
							<?php } ?>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="colorsExplanationPeriod">
					<div class="diavouleusiPeriod">
						<i class="fa fa-long-arrow-right" aria-hidden="true"></i>
						<span>Περίοδος Διαβούλευσης</span>
					</div>
					<div class="epitropiPeriod">
						<i class="fa fa-long-arrow-right" aria-hidden="true"></i>
						<span>Περίοδος Επιτροπής</span>
					</div> 
					<div class="psifoforiaPeriod">
						<i class="fa fa-long-arrow-right" aria-hidden="true"></i>
						<span>Περίοδος Ψηφοφορίας</span>
					</div>  
				</div>
				<div class="datesMainBox">
					<div class="datesMBInner">
						<?php foreach( $dates as $key=>$d ): ?>	
							<?php switch ( $d->period ) {
								case 'D': ?>
									<div data-art="<?php echo $key+1; ?>" data-id="1" data-level="<?php echo $d->artNmbr; ?>"><?php echo $d->introtext; ?></div>
								<?php break; ?>
								<?php case 'E': ?>
									<div data-art="<?php echo $key+1; ?>" data-id="2" data-level="<?php echo $d->artNmbr; ?>"><?php echo $d->introtext; ?></div>
								<?php break; ?>
								<?php case 'P': ?>
									<div data-art="<?php echo $key+1; ?>" data-id="3" data-level="<?php echo $d->artNmbr; ?>"><?php echo $d->introtext; ?></div>
								<?php break; ?>
							<?php } ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
jQuery(document).ready(function() {
	jQuery(".dateBarBarInner > ul > li").on('click',function(){
		var DataArt = jQuery( this ).attr("data-art");
		jQuery(".datesMBInner > div").css("display","none");
		jQuery(".datesMBInner > div[  data-art = " + DataArt +"]").fadeIn();                                                                                                                             
	});

	jQuery(".datesMBInner > div > p > span").on('click',function(){
		 
		var Period = jQuery( this ).parent().parent().attr("data-id");
		var ArticleNmbr = jQuery( this ).parent().parent().attr("data-level");

		jQuery( ".nomiki_ekdoxi" ).trigger( "click" );
		
		setTimeout(function(){
			jQuery( ".art_titleBox[  data-level = " + ArticleNmbr +"][  data-id = " + Period +"]" ).siblings().css('max-height','500px');
			jQuery( ".art_titleBox[  data-level = " + ArticleNmbr +"][  data-id = " + Period +"]" ).parent().parent().parent().siblings().children().children().children("div[data-level="+ ArticleNmbr +"][  data-id = " + (Period - 1) +"]").css('max-height','500px');

		},500);

	});

	jQuery(".datesMBInner > div > p > strong").on('click',function(){

		jQuery( ".law_voting" ).trigger( "click" );
		
		setTimeout(function(){
			jQuery( ".desc_tab" ).trigger( "click" );
		},200);

	}); 
});
</script>