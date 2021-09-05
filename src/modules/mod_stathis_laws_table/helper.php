<?php

ini_set('display_errors', 0);

class Laws_table
{ 

	private $db;

	public function __construct (){

		$this->db = JFactory::getDbo();

	}

	public function _getItems(){

		$Q = "select * from aaqwu_categories where parent_id = 8";

		$this->db->setQuery($Q);

		$items = $this->db->loadObjectList();

		foreach( $items as $i ){

			$params = json_decode( $i->params );
			$i->finished = $params->image_alt;

			$data = json_decode( $i->metadata );
			$i->author = $data->author;

			$date = new JDate( $i->created_time );
			$i->date = $date->format('d/m/Y');

			$i->levelc = self::_getChilds( $i->id );

			$arts = self::_getArts( $i->id );

			foreach( $arts as $a ){

				$i->sxedio = $a->sxedio;
				$i->aitiologiki = $a->aitiologiki;
				$i->diavouleusiekthesi = $a->ekthesid;
				$i->teliko = $a->teliko;

			}

		}
		return $items;

	}

	public function _getArts($id){

		$q = "select * from #__content where alias LIKE '%archives%' and catid = " . $id;

		$this->db->setQuery($q);

		$items = $this->db->loadObjectList();

		foreach( $items as $i ){

			$i->sxedio = self::_getter( $i->id , "7" );
			$i->aitiologiki = self::_getter( $i->id , "8" );
			$i->ekthesid = self::_getter( $i->id , "9" );
			$i->teliko = self::_getter( $i->id , "30" );

		}

		return $items;



	}

	public function _getChilds($id){

		$Q = "select count(*) as c from aaqwu_categories where parent_id = " . $id;

		$this->db->setQuery($Q);

		return $this->db->loadObjectList()[0]->c;

	}

	public function _getter( $itemId , $fieldId ){
			
		$command = "select v.value as vl from #__fields_values as v where v.item_id = " . $itemId . " and v.field_id = " . $fieldId;;
		
		$this->db->setQuery( $command );
		
		return $this->db->loadObjectList()[0]->vl;
		
	}	


}