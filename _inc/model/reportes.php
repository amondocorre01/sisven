<?php
/*
| -----------------------------------------------------
| PRODUCT NAME: 	Modern POS
| -----------------------------------------------------
| AUTHOR:			 Guido Alcón
| -----------------------------------------------------
| EMAIL:			info@ 
| -----------------------------------------------------
| COPYRIGHT:		RESERVED BY  
| -----------------------------------------------------
| WEBSITE:			http:// 
| -----------------------------------------------------
*/
class ModelReportes extends Model 
{
	public function getReportProducts(){
		$sql = "select * from products;";
  		$result = $this->db->query($sql);	
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

    public function getSuppliers(){
		$sql = "select * from suppliers;";
  		$result = $this->db->query($sql);	
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

    public function getCategories(){
		$sql = "select * from categorys;";
  		$result = $this->db->query($sql);	
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

    public function getStores(){
		$sql = "select * from stores;";
  		$result = $this->db->query($sql);	
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

    public function getUsers(){
		$sql = "select * from users;";
  		$result = $this->db->query($sql);	
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

    public function getPrices(){
		$sql = "select * from precios;";
  		$result = $this->db->query($sql);	
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
	
	public function getNroColumnasPrices(){
		$sql = "SELECT COLUMN_NAME FROM information_schema.columns WHERE table_name = 'precios'";
  		$result = $this->db->query($sql);	
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

}