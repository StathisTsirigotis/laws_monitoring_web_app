<?php 

define('_JEXEC', 1);
define('JPATH_BASE', realpath(dirname(__FILE__) . '/'));  
require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';

$mainframe = JFactory::getApplication('site');

$id = $_POST['id'];
$level = $_POST['level'];

$db = JFactory::getDbo();

$qq = "select id, created_time from #__categories where parent_id =" . $id;

$db->setQuery($qq);

$ids = $db->loadObjectList();

if( $level > "2" ){

	$Q = "select * from #__content where title NOT LIKE '%Άρθρο%' and state = 1 and catid = " . $ids[2]->id;
	$db->setQuery($Q);
	$voting = $db->loadObjectList();

	function _getter( $itemId , $fieldId ){

		$dbase;
				
		$dbase = JFactory::getDbo();

		$command = "select v.value as vl from #__fields_values as v where v.item_id = " . $itemId . " and v.field_id = " . $fieldId;;
		
		$dbase->setQuery( $command );
		
		return $dbase->loadObjectList()[0]->vl;
		
	}	


	foreach( $voting as $v ){

		$v->desc = strip_tags( $v->introtext );
		$v->onomastiki = _getter( $v->id , "13" );
		$v->psifisi_nd = _getter( $v->id , "14" );
		$v->thesi_nd = _getter( $v->id , "15" );
		$v->psifisi_syriza = _getter( $v->id , "16" );
		$v->thesi_syriza = _getter( $v->id , "17" );
		$v->psifisi_kinal = _getter( $v->id , "18" );
		$v->thesi_kinal = _getter( $v->id , "19" );
		$v->psifisi_kke = _getter( $v->id , "20" );
		$v->thesi_kke = _getter( $v->id , "21" );
		$v->psifisi_el = _getter( $v->id , "22" );
		$v->thesi_el = _getter( $v->id , "23" );
		$v->psifisi_mera = _getter( $v->id , "24" );
		$v->thesi_mera = _getter( $v->id , "25" );
		$v->nai = _getter( $v->id , "26" );
		$v->oxi = _getter( $v->id , "27" );
		$v->paron = _getter( $v->id , "28" );
		$v->apon = _getter( $v->id , "29" );

	}

    
	$count_yes = 0;
	$count_no = 0;
	$count_paron = 0;
}

?>


<div class="resultsRequestInner">
	<div class="law_vote">
		<?php if( $level < "3" ): ?>
			<div class="law_vote_message">
				<img src="/nomosxedia/images/no.png" alt="Oχι Ψηφοφορία">
				<p>ΔΕΝ ΕΧΕΙ ΓΙΝΕΙ ΑΚΟΜΑ ΨΗΦΟΦΟΡΙΑ</p>
			</div>
		<?php else: ?>
			<div class="law_vote_inner">
				<div class="law_vote_tab">
					<ul>
						<li class="desc_tab">ΠΕΡΙΓΡΑΦΗ</li>
						<li class="thesis_tab">ΕΡΜΗΝΕΙΑ ΘΕΣΕΩΝ</li>
						<li class="charts_tab">ΨΗΦΟΦΟΡΙΑ</li>
					</ul>
				</div>
				<div class="voting_infos_box">
					<div class="voting_infos_box_inner">
						<div class="voting_infos_desc">
							<img src="/nomosxedia/images/policy.png" alt="Περιγραφή">
							<p><?php echo $voting[0]->desc; ?></p>
						</div>
						<div class="voting_infos_thesis">
							<div class="vit_box">
								<div class="komma_logo"><img src="/nomosxedia/templates/laws/media/images/nd.png" alt="Νέα Δημοκρατία"></div>
								<div class="komma_thesis"><?php echo $voting[0]->thesi_nd; ?></div>
							</div>
							<div class="vit_box">
								<div class="komma_logo"><img src="/nomosxedia/templates/laws/media/images/syriza.jpg" alt="Σύριζα"></div>
								<div class="komma_thesis"><?php echo $voting[0]->thesi_syriza; ?></div>
							</div>
							<div class="vit_box">
								<div class="komma_logo"><img src="/nomosxedia/templates/laws/media/images/kinal.png" alt="ΚΙΝΑΛ"></div>
								<div class="komma_thesis"><?php echo $voting[0]->thesi_kinal; ?></div>
							</div>
							<div class="vit_box">
								<div class="komma_logo"><img src="/nomosxedia/templates/laws/media/images/kke.png" alt="KKE"></div>
								<div class="komma_thesis"><?php echo $voting[0]->thesi_kke; ?></div>
							</div>
							<div class="vit_box">
								<div class="komma_logo"><img src="/nomosxedia/templates/laws/media/images/el.jpg" alt="Ελληνική Λύση"></div>
								<div class="komma_thesis"><?php echo $voting[0]->thesi_el; ?></div>
							</div>
							<div class="vit_box">
								<div class="komma_logo"><img src="/nomosxedia/templates/laws/media/images/mera25.png" alt="Μέρα 25"></div>
								<div class="komma_thesis"><?php echo $voting[0]->thesi_mera; ?></div>
							</div>
						</div>
						<div class="voting_infos_charts">
							<div class="named_vote">
								<div class="vote_img">
									<img src="/nomosxedia/images/vote.png" alt="Ψοφοφορία">
								</div>
								<?php if( $voting[0]->onomastiki == 'yes' ): ?>
									<div class="named_vote_inner">
										<p>ΟΝΟΜΑΣΤΙΚΗ ΨΗΦΟΦΟΡΙΑ : <strong>NAI</strong></p>
										<div>
											<p>ΝΑΙ : <span class="nmbr_yes"><?php echo $voting[0]->nai; ?></span></p>
											<p>OΧΙ : <span class="nmbr_no"><?php echo $voting[0]->oxi; ?></span></p>
											<p>ΠΑΡΩΝ : <span class="nmbr_paron"><?php echo $voting[0]->paron; ?></span></p>
											<p>ΑΠΩΝ : <span class="nmbr_apon"><?php echo $voting[0]->apon; ?></span></p>
										</div>
									</div>
								<?php else: ?>
									<div class="named_vote_inner">
										<p>ΟΝΟΜΑΣΤΙΚΗ ΨΗΦΟΦΟΡΙΑ : <strong>OXI</strong></p>
										<div>
											<p>ΝΑΙ : <span class="nmbr_yes"><?php echo $voting[0]->nai; ?></span></p>
											<p>OΧΙ : <span class="nmbr_no"><?php echo $voting[0]->oxi; ?></span></p>
											<p>ΠΑΡΩΝ : <span class="nmbr_paron"><?php echo $voting[0]->paron; ?></span></p>
											<p>ΑΠΩΝ : <span class="nmbr_apon"><?php echo $voting[0]->apon; ?></span></p>
										</div>
									</div>
								<?php endif; ?>
							</div>
							<div class="vic_komma">
								<div class="vic_komma_logo">
									<img src="/nomosxedia/templates/laws/media/images/nd.png" alt="Νέα Δημοκρατία">
									<?php if($voting[0]->psifisi_nd == 'yes'): ?>
										<?php $count_yes++; ?>
										<i class="fa fa-check vote-yes" aria-hidden="true"></i>
									<?php elseif($voting[0]->psifisi_nd == 'no'): ?>
										<?php $count_no++; ?>
										<i class="fa fa-ban vote-no" aria-hidden="true"></i>
									<?php else: ?>
										<?php $count_paron++; ?>
										<span>ΠΑΡΩΝ</span>
								    <?php endif; ?>
								</div>
								<div class="vic_komma_logo">
									<img src="/nomosxedia/templates/laws/media/images/syriza.jpg" alt="Σύριζα">
									<?php if($voting[0]->psifisi_syriza == 'yes'): ?>
										<?php $count_yes++; ?>
										<i class="fa fa-check vote-yes" aria-hidden="true"></i>
									<?php elseif($voting[0]->psifisi_syriza == 'no'): ?>
										<?php $count_no++; ?>
										<i class="fa fa-ban vote-no" aria-hidden="true"></i>
									<?php else: ?>
										<?php $count_paron++; ?>
										<span>ΠΑΡΩΝ</span>
								    <?php endif; ?>
								</div>
								<div class="vic_komma_logo">
									<img src="/nomosxedia/templates/laws/media/images/kinal.png" alt="ΚΙΝΑΛ">
									<?php if($voting[0]->psifisi_kinal == 'yes'): ?>
										<?php $count_yes++; ?>
										<i class="fa fa-check vote-yes" aria-hidden="true"></i>
									<?php elseif($voting[0]->psifisi_kinal == 'no'): ?>
										<?php $count_no++; ?>
										<i class="fa fa-ban vote-no" aria-hidden="true"></i>
									<?php else: ?>
										<?php $count_paron++; ?>
										<span>ΠΑΡΩΝ</span>
								    <?php endif; ?>
								</div>
								<div class="vic_komma_logo">
									<img src="/nomosxedia/templates/laws/media/images/kke.png" alt="KKE">
									<?php if($voting[0]->psifisi_kke == 'yes'): ?>
										<?php $count_yes++; ?>
										<i class="fa fa-check vote-yes" aria-hidden="true"></i>
									<?php elseif($voting[0]->psifisi_kke == 'no'): ?>
										<?php $count_no++; ?>
										<i class="fa fa-ban vote-no" aria-hidden="true"></i>
									<?php else: ?>
										<?php $count_paron++; ?>
										<span>ΠΑΡΩΝ</span>
								    <?php endif; ?>
								</div>
								<div class="vic_komma_logo">
									<img src="/nomosxedia/templates/laws/media/images/el.jpg" alt="Ελληνική">
									<?php if($voting[0]->psifisi_el == 'yes'): ?>
										<?php $count_yes++; ?>
										<i class="fa fa-check vote-yes" aria-hidden="true"></i>
									<?php elseif($voting[0]->psifisi_el == 'no'): ?>
										<?php $count_no++; ?>
										<i class="fa fa-ban vote-no" aria-hidden="true"></i>
									<?php else: ?>
										<?php $count_paron++; ?>
										<span>ΠΑΡΩΝ</span>
								    <?php endif; ?>
								</div>
								<div class="vic_komma_logo">
									<img src="/nomosxedia/templates/laws/media/images/mera25.png" alt="Μέρα 25">
									<?php if($voting[0]->psifisi_mera == 'yes'): ?>
										<?php $count_yes++; ?>
										<i class="fa fa-check vote-yes" aria-hidden="true"></i>
									<?php elseif($voting[0]->psifisi_mera == 'no'): ?>
										<?php $count_no++; ?>
										<i class="fa fa-ban vote-no" aria-hidden="true"></i>
									<?php else: ?>
										<?php $count_paron++; ?>
										<span>ΠΑΡΩΝ</span>
								    <?php endif; ?>
								</div>
							</div>
							<div class="vic_pie_chart">
									<div id="piechart2"></div>
							</div>
							<div class="vic_column_chart">
									<div id="columnchart2"></div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>


<script>
   jQuery(document).ready(function() {
	jQuery(".desc_tab").click(function(){
		jQuery(".voting_infos_thesis").hide();
		jQuery(".voting_infos_charts").hide();
		jQuery(".voting_infos_desc").fadeIn(500);
	});

	jQuery(".thesis_tab").click(function(){
		jQuery(".voting_infos_desc").hide();
		jQuery(".voting_infos_charts").hide();
		jQuery(".voting_infos_thesis").fadeIn(500);
	});

	jQuery(".charts_tab").click(function(){
		jQuery(".voting_infos_desc").hide();
		jQuery(".voting_infos_thesis").hide()
		jQuery(".voting_infos_charts").fadeIn(500);
	});

	jQuery(".law_vote_tab > ul > li").click(function(){
		jQuery(".law_vote_tab > ul > li").removeClass("law_vote_tab_clicked");
		jQuery(this).addClass("law_vote_tab_clicked");
	});

	google.charts.load('current', {'packages':['corechart']});
	google.charts.load('current', { 'packages': ['table'] });
	google.charts.load('current', { 'packages': ['bar'] });
	google.charts.setOnLoadCallback(drawChart2);
	google.charts.setOnLoadCallback(drawSort2);

	function drawChart2() {

		var data = google.visualization.arrayToDataTable([
		['Voting', 'Percentage'],
          ['ΝΑΙ', <?php echo $voting[0]->nai; ?>],
          ['ΟΧΙ', <?php echo $voting[0]->oxi; ?>],
          ['ΠΑΡΩΝ',<?php echo $voting[0]->paron; ?>],
          ['ΑΠΩΝ',<?php echo $voting[0]->apon; ?>]
		]);

		var options = {
			width: 820,
		  	height: 600,
		  	title: 'Ποσοστιαίο αποτέλεσμα ψηφοφορίας',
		  	colors: ['#32d676', '#ff0000', '#b7b7b7', '#000000']
		};

		var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

		chart.draw(data, options);
	}

  	function drawSort2() {
	      var data = google.visualization.arrayToDataTable([
	        ["Element", "Αριθμός ψήφων από τους 300 συνολικά", { role: "style" } ],
	        ["NAI", <?php echo $voting[0]->nai; ?>, "#32d676"],
	        ["ΠΑΡΩΝ", <?php echo $voting[0]->paron; ?>, "#b7b7b7"],
	        ["ΟΧΙ", <?php echo $voting[0]->oxi; ?>, "#ff0000"],
	        ["ΑΠΩΝ", <?php echo $voting[0]->apon; ?>, "#000000"]
	      ]);

	      var view = new google.visualization.DataView(data);
	      view.setColumns([0, 1,
	                       { calc: "stringify",
	                         sourceColumn: 1,
	                         type: "string",
	                         role: "annotation" },
	                       2]);

	      var options = {
	        title: "Αριθμός ΝΑΙ/ΠΑΡΩΝ/ΟΧΙ/ΑΠΩΝ",
	        width: 820,
	        height: 600,
	        bar: {groupWidth: "95%"},
	        legend: { position: "none" },
	      };
	      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart2"));
	      chart.draw(view, options);
  	}
});
</script>