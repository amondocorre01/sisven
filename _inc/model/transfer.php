<?php
/*
| -----------------------------------------------------
| PRODUCT NAME: 	Modern POS
| -----------------------------------------------------
| AUTHOR:			 
| -----------------------------------------------------
| EMAIL:			info@ 
| -----------------------------------------------------
| COPYRIGHT:		RESERVED BY  
| -----------------------------------------------------
| WEBSITE:			http:// 
| -----------------------------------------------------
*/
class ModelTransfer extends Model 
{
	public function getTransfers($store_id = null, $limit = 100000) 
	{
		$store_id = $store_id ? $store_id : store_id();
		$statement = $this->db->prepare("SELECT * FROM `transfers` 
			WHERE (`transfers`.`from_store_id` = ? OR `transfers`.`to_store_id` = ?) ORDER BY `transfers`.`created_at` DESC LIMIT $limit");
		$statement->execute(array($store_id, $store_id));
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getTransferInfo($id, $store_id = null)
    {
        $store_id = $store_id ? $store_id : store_id();
        $statement = $this->db->prepare("SELECT `transfers`.* FROM `transfers` WHERE `transfers`.`id` = ?");
        $statement->execute(array($id));
        $invoice = $statement->fetch(PDO::FETCH_ASSOC);
        $invoice['created_by'] = get_the_user($invoice['created_by'], 'username');
        return $invoice;
    }

	public function getTransferItems($transfer_id)
    {
        $statement = $this->db->prepare("SELECT * FROM `transfer_items` WHERE `transfer_id` = ?");
        $statement->execute(array($transfer_id));
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $array = array();
        $i = 0;
        foreach ($rows as $row) {
            $array[$i] = $row;
            $array[$i]['unit_name'] = get_the_unit(get_the_product($row['product_id'], 'unit_id'), 'unit_name');
            $i++;
        }
        return $array;
    }

    public function getTransferenciasSalida($fecha_inicial,$fecha_final,$store_id,$product_id){
        $sql ="select *,
        (SELECT pit.item_purchase_price FROM purchase_item pit WHERE t.invoice_id=pit.invoice_id AND pit.item_id='$product_id') AS precio
        , (DATE_FORMAT(t.created_at, '%Y-%m-%d')) as fecha FROM transfers t, transfer_items ti WHERE t.id=ti.transfer_id AND t.from_store_id='$store_id' AND ti.product_id='$product_id' AND t.created_at >='$fecha_inicial'  AND t.created_at<='$fecha_final' ORDER BY t.created_at asc";
        $statement = $this->db->prepare($sql);
		$statement->execute();
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
		return $products;
	}

    public function getTransferenciasEntrada($fecha_inicial,$fecha_final,$store_id,$product_id){
        $sql ="select *,
        (SELECT pit.item_purchase_price FROM purchase_item pit WHERE t.invoice_id=pit.invoice_id AND pit.item_id='$product_id') AS precio
        , (DATE_FORMAT(t.created_at, '%Y-%m-%d')) as fecha FROM transfers t, transfer_items ti WHERE t.id=ti.transfer_id AND t.to_store_id='$store_id' AND ti.product_id='$product_id' AND t.created_at >='$fecha_inicial'  AND t.created_at<='$fecha_final' ORDER BY t.created_at asc";
        $statement = $this->db->prepare($sql);
		$statement->execute();
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
		return $products;
	}
    public function agregarKardex($iden,$fecha,$detalle,$ingreso,$salida,$pCosto,$ingVal,$salVal){
        $sql ="insert into kardex(sesion,fecha,detalle,ingreso,salida,pCosto,ingVal,salVal)values('$iden','$fecha','$detalle','$ingreso','$salida','$pCosto','$ingVal','$salVal');";
        $statement = $this->db->prepare($sql);
		$statement->execute();
    }

    public function limpiarKardex($iden){
        $sql ="delete from kardex where sesion='$iden';";
        $statement = $this->db->prepare($sql);
		$statement->execute();
    }

    public function obtenerKardex($iden){
        $sql ="select * from kardex where sesion='$iden' order by fecha asc;";
        $statement = $this->db->prepare($sql);
		$statement->execute();
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
		return $products;
    }
}