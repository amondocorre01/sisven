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
class ModelAcciones extends Model 
{
	public function savePricesUsers($datos){
		$sql = "select * from products;";
  		$result = $this->db->query($sql);	
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

    public function savePricesUser($data){
        $res = false;
		$store_id = store_id();
        $datos = $data->datos;
        $idPreciosWorking = array();
        if(count($datos) == 0){
            $clearOthersItems = $this->db->query("UPDATE precios_usuarios SET estado = 0 WHERE id_usuario = '$data->user';");
            $res = true;
        }else{
            foreach ($datos as $key => $value) {
                $idPrices = $value->idPrices;
                $prices = $value->prices;
                $name1 = $prices[0]->nameColumn;
                $precio1 = floatval($prices[0]->currentPrice);
                $name2 = $prices[1]->nameColumn;
                $precio2 = floatval($prices[1]->currentPrice); 
                if($precio1 >= $precio2){
                    $piso = $precio2;
                    $piso_name = $name2;
                    $techo = $precio1;
                    $techo_name = $name1;
                }else{
                    $piso = $precio1;
                    $piso_name = $name1;
                    $techo = $precio2;
                    $techo_name = $name2;
                }
                array_push($idPreciosWorking, $idPrices);
                $result = $this->db->query("CALL `savePricesUser`('$data->user','$idPrices','$piso','$techo','$piso_name','$techo_name')");
                $result = $result->fetchAll(PDO::FETCH_ASSOC);
                $res = true;
            }
            $idPreciosWorking = implode(',', $idPreciosWorking);
            $clearOthersItems = $this->db->query("UPDATE precios_usuarios SET estado = 0 WHERE id_usuario = '$data->user' AND id_precios NOT IN($idPreciosWorking);");   
        }
        return $res; 
	}

    public function getPricesUser($user){
        $sql = "select * from precios_usuarios where id_usuario='$user' and estado='1';";
  		$result = $this->db->query($sql);	
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		return $result;
    }

}