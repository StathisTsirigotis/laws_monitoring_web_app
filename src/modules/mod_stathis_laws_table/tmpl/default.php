<?php 
// No direct access
defined('_JEXEC') or die; 

$builder = new Laws_table();
$items = $builder->_getItems();

?>

<div class="mostrecentlawstablewrapper">
	<div class="mostrecentlawsInner">
		<div class="mostreventlawstable">
			<table id="lawsTenTable" style="width:100%">
			  	<tr>
				    <th style="width: 400px;">ΤΙΤΛΟΣ</th>
				    <th>ΠΟΡΕΙΑ ΝΟΜΟΣΧΕΔΙΟΥ</th> 
				    <th>ΣΧΕΤΙΚΑ ΑΡΧΕΙΑ</th>
			  	</tr>
			  	<?php foreach ( $items as $r => $i ): ?>
				  	<tr>
					    <td class="lawTitleBox" data-id="<?php echo $i->id; ?>" data-title="<?php echo $i->title; ?>" data-level="<?php echo $i->levelc; ?>" data-date-start="<?php echo $i->date; ?>">
					    	<span><?php echo $r+1; ?> ) </span><p class="lawTitle"><?php echo $i->title; ?></p>
					    	<div class="lawPresentation">
					    		<?php echo $i->archives; ?> 
					    		<h3><?php echo $i->title; ?></h3>
					    		<div class="lawPinner">
					    			<div class="dateMinistry">
					    				<p>ΗΜΕΡΟΜΗΝΙΑ : <?php echo $i->date; ?></p>
					    				<p>ΥΠΟΥΡΓΕΙΟ : <?php echo $i->author; ?></p>
					    			</div>
					    			<div class="lawDesc"><?php echo $i->description; ?></div>
					    		</div>
					    	</div>
						</td>
					    <td>
					    	<?php switch ( $i->levelc ) {
					    		case '1': ?>
					    			<span class="monitorBox diavouleusi">Δ</span>
					    			<?php break; 
					    		
					    		case '2' : ?>
					    			<span class="monitorBox diavouleusi">Δ</span>
					    			<span class="monitorBox epitropi">Ε</span>
					    			<?php break;

				    			case '3' : ?>
					    			<span class="monitorBox diavouleusi">Δ</span>
						    		<span class="monitorBox epitropi">Ε</span>
						    		<span class="monitorBox psifoforia">Ψ</span>
				    			<?php break;
					    	} ?>
					    		
				    		<?php if( !empty( $i->finished ) ) { ?>
				    			<?php if ( $i->finished == "ΝΑΙ" ) : ?>
				    				<span class="votesYES"></span>
			    				<?php else : ?>
			    					<span class="votesNO"></span>
			    				<?php endif ; ?>
				    		<?php } ?>
				    	</td>
				    	<td>
				    		<?php if(!empty($i->sxedio)) { ?>
				    			<a href="http://localhost/nomosxedia/images/pdfs/<?php echo $i->sxedio; ?>" target="_blank"><img src="/nomosxedia/images/pdf.png"><span>σχέδιο νόμου</span></a>
				    		<?php } ?>
				    		<?php if(!empty($i->aitiologiki)) {?>
				    			<a href="http://localhost/nomosxedia/images/pdfs/<?php echo $i->aitiologiki; ?>" target="_blank"><img src="/nomosxedia/images/pdf.png"><span>αιτιολογική έκθεση</span></a>
			    			<?php } ?>
				    		<?php if(!empty($i->diavouleusiekthesi)) { ?>
				    			<a href="http://localhost/nomosxedia/images/pdfs/<?php echo $i->diavouleusiekthesi; ?>" target="_blank"><img src="/nomosxedia/images/pdf.png"><span>έκθεση διαβούλευσης</span></a>
			    			<?php } ?>
			    			<?php if(!empty($i->teliko)) { ?>
				    			<a href="http://localhost/nomosxedia/images/pdfs/<?php echo $i->teliko; ?>" target="_blank"><img src="/nomosxedia/images/pdf.png"><span>τελικό νομοσχέδιο</span></a>
			    			<?php } ?>
				    	</td>
				  	</tr>
			  	<?php endforeach; ?>
			</table>
		</div>
		<div class="lawTableNotes">
			<div class="lTNleft">
				<p>Κάντε <strong>mouse over</strong> σε κάθε τίτλο για σύντομη περιγραφή</p>
				<p>Κάντε <strong>click</strong> σε κάθε τίτλο για να δείς την πορεία του νομοσχεδίου</p>
			</div>
			<div class="lTNCenter">
				<span class="downpageYes"> : Υπερψήφιση</span>
				<span class="downpageNo"> : Καταψήφιση </span>
			</div>
			<div class="lTNRight">
				<p><strong>Δ</strong> : Διαβούλευση</p>
				<p><strong>Ε</strong> : Επιτροπή</p>
				<p><strong>Ψ</strong> : Ψηφοφορία</p>
			</div>
		</div>
	</div>
	<div class="lawTabOnCLick">
		<div class="mainTabLAw">	
		<span class="backtoLAws">πίσω στους νόμους</span>	
			<ul>
				<li class="nomiki_ekdoxi" data-law="" data-lawlevel="" data-datestart="">ΝΟΜΙΚΗ ΕΚΔΟΧΗ</li>
				<li class="law_timetable" data-law="" data-datestart="">ΗΜΕΡΟΛΟΓΙΟ</li>
				<li class="law_voting" data-law="" data-lawlevel="" data-datestart="">ΚΟΙΝ/ΚΗ ΨΗΦΟΦΟΡΙΑ</li>
			</ul>
			<h3></h3>
			<div class="resultsRequest"></div>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function(){
	jQuery(".lawTitleBox").click(function(){
		jQuery(".mostrecentlawsInner").fadeOut();
		jQuery(".mainTabLAw").fadeIn(1000);
		var dataLaw = jQuery( this ).data("id");
		var dataTitle = jQuery( this ).data("title");
		var dataLevel = jQuery( this ).data("level");
		var dateStart = jQuery( this ).data("date-start");
		jQuery(".mainTabLAw > ul > li").attr("data-law",dataLaw);
		jQuery(".nomiki_ekdoxi").attr("data-lawlevel",dataLevel);
		jQuery(".law_voting").attr("data-lawlevel",dataLevel);
		jQuery(".mainTabLAw > ul > li").attr("data-datestart",dateStart);
		jQuery(".mainTabLAw > h3").html(dataTitle);
	});

	jQuery(".backtoLAws").click(function(){
		jQuery(".mainTabLAw").fadeOut();
		jQuery(".mostrecentlawsInner").fadeIn(1000);
		jQuery(".resultsRequest").html('');
		jQuery(".mainTabLAw > ul > li").removeClass("clickableTAb");
	});

	jQuery(".nomiki_ekdoxi").on("click",function(){

		jQuery.post("nomikiekdohi.php",
	  	{
		    id: jQuery( ".nomiki_ekdoxi" ).attr("data-law"),
		    level: jQuery( ".nomiki_ekdoxi" ).attr("data-lawlevel"),
		    date_start: jQuery( ".nomiki_ekdoxi" ).attr("data-datestart")
	  	},
	  	function(data){
		    jQuery(".resultsRequest").html(data);
	  	});
	});

	jQuery(".law_timetable").on("click",function(){

		jQuery.post("imerologio.php",
	  	{
		    id: jQuery( ".law_timetable" ).attr("data-law"),
		    date_start: jQuery( ".law_timetable" ).attr("data-datestart")
	  	},
	  	function(data){
		    jQuery(".resultsRequest").html(data);
	  	});
	});

	jQuery(".law_voting").on("click",function(){

		jQuery.post("vote.php",
	  	{
		    id: jQuery( ".law_voting" ).attr("data-law"),
		    level: jQuery( ".law_voting" ).attr("data-lawlevel")
	  	},
	  	function(data){
		    jQuery(".resultsRequest").html(data);
	  	});
	});

	jQuery( ".mainTabLAw > ul > li" ).click( function() {
		jQuery( ".mainTabLAw > ul > li" ).removeClass( "clickableTAb" );
		jQuery( this ).addClass( "clickableTAb" );
	} );

});
</script>