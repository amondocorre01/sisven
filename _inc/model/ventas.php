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
class ModelVentas extends Model 
{

	public function getVentas($data){
        //var_dump($data);
        $fecha_inicial = $data['fecha_inicial'];
        $fecha_final = $data['fecha_final'];
        $cliente = $data['cliente'];
        $consulta = '';

        if($fecha_inicial && $fecha_final){
            if($fecha_inicial == $fecha_final){
                $fecha_inicial = $fecha_inicial.'00:00:00';
                $fecha_final = $fecha_final.' 23:59:59';
            }
            $consulta .= " and created_at between '$fecha_inicial' AND '$fecha_final'";
        }elseif($fecha_inicial){
            $consulta .= " and created_at LIKE '%$fecha_inicial%'";
        }elseif($fecha_final){
            $consulta .= " and created_at LIKE '%$fecha_final%'";
        }
        if($cliente){
            $consulta .= " and customer_id = '$cliente'";
        }
        $vendedor = $data['vendedor'];
        if($vendedor){
            $consulta .= " and created_by = '$vendedor'";
        }
        $estado_pago = $data['estado'];
        if($estado_pago){
            $consulta .= " and payment_status = '$estado_pago'";
        }
        $producto = $data['producto'];
        $almacen = $data['almacen'];
        if($almacen){
            $consulta .= " and store_id = '$almacen'";
        }
		//$sql = "select * from precios where estado='1';";
        $sql = "select selling_info.* FROM `selling_info` WHERE status=1 ".$consulta;
  		$result = $this->db->query($sql);	
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

    public function getVentaDetalle($invoice_id, $data){
        $producto = '';
        if(isset($data['producto'])){
            $producto = $data['producto'];
        }
        $consulta='';
        if($producto){
            $consulta .= " and item_id= '$producto'";
        }
        $sql = "select selling_item.* FROM `selling_item` WHERE invoice_id='$invoice_id' $consulta ;";
  		$result = $this->db->query($sql);	
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		return $result;
    }

    public function getPriceTotal($invoice_id){
        $sql = "select selling_price.* FROM `selling_price` WHERE invoice_id='$invoice_id';";
  		$result = $this->db->query($sql);	
		$result = $result->fetch(PDO::FETCH_ASSOC);
		return $result;
    }

	
}