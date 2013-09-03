<?php 
 class DB_mysql{
 	#variables de coneccion
 	var $basedatos;
 	var $servidor;
 	var $usuario;
 	var $clave;
 	#indentificador de conexion y de consulta
 	var $conexion_id=0;
 	var $consulta_id=0;
 	#numero de error
 	var $errno=0;
 	var $error="";
 	#contructor
 	function DB_mysql($db="",$host="",$user="",$pass=""){
 
 	}
 	#connecion a la base de datos
 	function conectar($db,$host,$user,$pass){
 		if($db!="") $this->basedatos=$db;
 		if($host!="") $this->servidor=$host;
		if($user!="") $this->usuario=$user;
 		if($pass!="") $this->clave=$pass;
 		#conectando a la base
 		$this->conexion_id=mysql_connect($this->servidor,$this->usuario,$this->clave);
 		if (!$this->conexion_id) {
 			$this->error="Ha Fallado la Conexión";
 			return 0;
 		}
 		#seleccionamos la base de datos
 		if (!@mysql_select_db($this->basedatos,$this->conexion_id)) {
 			$this->error="Imposible de abrir".$this->basedatos;
 			return 0;
 		}
 		/* si hemos tenido exito conectandonos devuelve el identificador de la conexion, sino devuelve 0*/
		return $this->conexion_id;
 	}
 	
 	#ejecuta una consulta
 	function consulta($sql=""){
 		if ($sql=="") {
 			$this->error="no ha identficado una consulta Sql";
 			return 0;
 		}
 		#ejecutamos la consulta
 		$this->consulta_id=@mysql_query($sql,$this->conexion_id);
 		if (!$this->consulta_id) {
 			$this->errno=mysql_errno();
 			$this->error=mysql_error();
 		}
 		/*si hemos tendo exito n la consulta devuelv el identificador de la coneccion, sino devuelve 0*/
 		return $this->consulta_id;
 	}
 	#devuelve el numero de campos de una consulta
 	function numcampos(){
 		return mysql_num_fields($this->consulta_id);
 	}
 	#devuelve el nro de registrados dey una consulta
 	function numregistros(){
 		return mysql_num_rows($this->consulta_id);
 	}
 	/*devuelve el nombre de un campo de la consulta*/
 	function nombrecampo($numcampos){
 		return mysql_field_name($this->consulta_id, $numcampos);
 	}
 	#muestra los datos de una consulta
 	function verconsulta(){
 		echo "<table border=1>\n";
 		#mostramos los nombres de los campos
 		for ($i=0; $i <$this->numcampos() ; $i++) { 
 			echo "<td><b>".$this->nombrecampo($i)."</b></td>\n";
 		}
 		echo "</tr>\n";
 		//mostramos los registros
 		while ($row=mysql_fetch_row($this->consulta_id)) {
 			echo "<tr>\n";
 			for ($i=0; $i <$this->numcampos() ; $i++) { 
 				echo "<td>".$row[$i]."</td> \n";
 			}

			echo "<tr>\n" ;

 		}
 	}
 }

 ?>
