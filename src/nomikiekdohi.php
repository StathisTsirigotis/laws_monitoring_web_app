<?php 

define('_JEXEC', 1);
define('JPATH_BASE', realpath(dirname(__FILE__) . '/'));  
require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';

$mainframe = JFactory::getApplication('site');

$id = $_POST['id'];
$level = $_POST['level'];
$date_start = $_POST['date_start'];


$db = JFactory::getDbo();


$q = "select id, created_time from #__categories where parent_id =" . $id;

$db->setQuery($q);

$ids = $db->loadObjectList();

if( $level == 1 ){

	$q_1 = "select * from #__content where catid =" . $ids[0]->id . " and state = 1 order by ordering DESC";
	$db->setQuery($q_1);
	$arts_1 = $db->loadObjectList();

}
elseif ( $level == 2) {

	$q_1 = "select * from #__content where catid =" . $ids[0]->id . " and state = 1 order by ordering DESC";
	$db->setQuery($q_1);
	$arts_1 = $db->loadObjectList();

	$q_2 = "select * from #__content where catid =" . $ids[1]->id . " and state = 1 order by ordering DESC";
	$db->setQuery($q_2);
	$arts_2 = $db->loadObjectList();

	foreach ($arts_2 as $a2) {
		
		$data = json_decode( $a2->images );
		$a2->differ = $data->image_intro_alt;

	}

}
else{

	$q_1 = "select * from #__content where catid =" . $ids[0]->id . " and state = 1 order by ordering DESC";
	$db->setQuery($q_1);
	$arts_1 = $db->loadObjectList();

	$q_2 = "select * from #__content where catid =" . $ids[1]->id . " and state = 1 order by ordering DESC";
	$db->setQuery($q_2);
	$arts_2 = $db->loadObjectList();

	foreach ($arts_2 as $a2) {
		
		$data = json_decode( $a2->images );
		$a2->differ = $data->image_intro_alt;

	}

	$q_3 = "select * from #__content where catid =" . $ids[2]->id . " and state = 1 and title LIKE '%Άρθρο%' order by ordering DESC";
	$db->setQuery($q_3);
	$arts_3 = $db->loadObjectList();

	foreach ($arts_3 as $a3) {
		
		$dataa = json_decode( $a3->images );
		$a3->differ = $dataa->image_intro_alt;

	}

}

?>


<div class="resultsRequestInner">
	<div class="nomikiEkdoxi">
		<div class="nomikiEkdoxiTAb">
			<div class="law_start_date"><strong>Έναρξη :</strong> <?php echo $date_start; ?></div>
			<div class="diavouleusi_box">
				<p class="diavouleusi_button monitorBox">ΔΙΑΒΟΥΛΕΥΣΗ</p>
				<div>
					<?php foreach( $arts_1 as $key => $a1 ): ?>
						<div class="article_box">
							<p class="art_titleBox" data-id="1"><?php echo $a1->title; ?></p>
							<div class="art_fulltext" data-id="1" data-level="<?php echo $key+1; ?>">
								<h4><?php echo $a1->introtext; ?></h4>
								<div><?php echo $a1->fulltext; ?></div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="epitropi_box">
				<p class="epitropi_button monitorBox">ΕΠΙΤΡΟΠΗ</p>
				<div>
					<?php if( $level > 1 ) : ?>
						<?php foreach( $arts_2 as $key => $a2 ): ?>
							<div class="article_box">
								<p class="art_titleBox 
								<?php if( !empty( $a2->differ ) ){ ?> 
									differ_art_change
								 	<?php } ?>" 
								data-id="2" data-level="<?php echo $key+1; ?>"><?php echo $a2->title; ?></p>
								<div class="art_fulltext" data-id="2" data-level="<?php echo $key+1; ?>">
									<h4><?php echo $a2->introtext; ?></h4>
									<div><?php echo $a2->fulltext; ?></div>
								</div>
							</div>
						<?php endforeach; ?>
					<?php else : ?>
						<p class="notyetmsg">Δεν έχει οριστεί επιτροπή για τον παρόν νομοσχέδιο</p>
					<?php endif; ?>
				</div>
			</div>
			<div class="vote_box">
				<p class="vote_button monitorBox">ΨΗΦΟΦΟΡΙΑ</p>
				<div>
					<?php if( $level > 2 ) : ?>
						<?php foreach( $arts_3 as $key => $a3 ): ?>
							<div class="article_box">
								<p class="art_titleBox 
								<?php if( !empty( $a3->differ ) ){ ?> 
											differ_art_change_p
								<?php } ?>" 
								data-id="3" data-level="<?php echo $key+1; ?>"><?php echo $a3->title; ?></p>
								<div class="art_fulltext" data-id="3" data-level="<?php echo $key+1; ?>">
									<h4><?php echo $a3->introtext; ?></h4>
									<div><?php echo $a3->fulltext; ?></div>
								</div>
							</div>
						<?php endforeach; ?>
					<?php else : ?>
						<p class="notyetmsg">Δεν έχει οριστεί ψηφοφορία για τον παρόν νομοσχέδιο</p>
					<?php endif; ?>
				</div>
			</div>
			<div class="changesCOlorBox">
				<span class="changeClr">Τροποποίηση κειμένου</span>
				<span class="deleteClr">Διαγραφή κειμένου</span>
				<span class="addClr">Προσθήκη κειμένου</span>
			</div>
		</div>
	</div>
</div>

<script>
	jQuery(document).ready(function() {
	
	jQuery( ".art_titleBox" ).on('click',function(){ //click ston titlo tou arthrou
		jQuery( ".art_fulltext" ).css('max-height','0px'); //kleinw ola ta boxakia twn arthrwn

		var thisHeight = jQuery( this ).siblings().css('max-height'); //pairnw to max-height toy box pou thelw na anoi3ei
		var thisDATAID = jQuery( this ).attr("data-id"); //pairnw data-id tou arthrou
		var thisDATALVL = jQuery( this ).siblings().attr('data-level'); //pairnw data-level arthroy
 
		if( thisDATAID == '1' ){ //tsekarw an einai sto stadio "1" diavouleusis
			if( thisHeight == '0px' ){ //an einai kleisto to boxaki tou arthrou anoi3e to
				jQuery( this ).siblings().css('max-height','500px');
			}else{ // alliws an einai anoixto kleisto
				jQuery( ".art_fulltext" ).css('max-height','0px');
			}
		}
		else if( thisDATAID == '2' ){ //tsekarw einai sto stadio "2" epitropis
			if( thisHeight == '0px' ){ //an einai kleisto to boxaki tou arthrou anoi3e to
				if(jQuery( this ).hasClass("differ_art_change")){ //an einai kokkinismeno to arthro tote anoi3e mazi kai to idio arthro tis diavouleusis
					jQuery( ".diavouleusi_box > div > div > .art_fulltext[  data-level = " + thisDATALVL +"]").css('max-height','500px');
					jQuery( this ).siblings().css('max-height','500px');
				}else{ //alliws anoi3e mono to arthro tis epitropis
					jQuery( this ).siblings().css('max-height','500px');
				}
			}else{ //alliws an einai anoixta kleista
				jQuery( ".art_fulltext" ).css('max-height','0px');
			}
		}else{ //tsekarw an einai sto stadio "3" psifoforias
			if( thisHeight == '0px' ){ //an einai kleisto to boxaki tou arthrou anoi3e to
				if(jQuery( this ).hasClass("differ_art_change_p")){ //an einai kokkinismeno to arthro tote anoi3e mazi kai to idio arthro tis epitropis
					if( jQuery( ".epitropi_box > div > div > .art_titleBox[  data-level = " + thisDATALVL +"]").hasClass("differ_art_change") ){ //an einai kokkinismeno to athro KAI TIS EPITROPIS tote anoi3e ta ola
						jQuery( ".diavouleusi_box > div > div > .art_fulltext[  data-level = " + thisDATALVL +"]").css('max-height','500px'); //diavoulesi
						jQuery( ".epitropi_box > div > div > .art_fulltext[  data-level = " + thisDATALVL +"]").css('max-height','500px'); //epitropi
						jQuery( this ).siblings().css('max-height','500px'); //psifoforia
					}
					else{ //aliws anoi3e mono psifoforia kai epitropi
						jQuery( ".epitropi_box > div > div > .art_fulltext[  data-level = " + thisDATALVL +"]").css('max-height','500px'); //epitropi
						jQuery( this ).siblings().css('max-height','500px'); //psifoforia
					}
				}else{ //alliws anoi3e mono psifoforias
					jQuery( this ).siblings().css('max-height','500px');
				}
			}else{ //an einai naoixto kleista ola
				jQuery( ".art_fulltext" ).css('max-height','0px');
			}
		} 
	});
});
</script>