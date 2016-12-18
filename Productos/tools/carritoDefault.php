<?php
session_start("InternetFriends");
class Carrito
{

	//aquí guardamos el contenido del carrito
	private $carrito = array();

	//seteamos el carrito exista o no exista en el constructor
	public function __construct()
	{

		if(!isset($_SESSION["carrito"]))
		{
			$_SESSION["carrito"] = null;
			$this->carrito["precio_total"] = 0;
			$this->carrito["articulos_total"] = 0;
		}
		$this->carrito = $_SESSION['carrito'];
	}

	public function cambiarCantidad($articulo = array(), $cantidadArticulos)
	{
		if (!is_numeric($cantidadArticulos))
		{
			throw new Exception("Error, el articulo no es un array!", 1);
		}
		if (empty($cantidadArticulos)) {
			$cantidadArticulos=1;
		}
		if(!is_array($articulo) || empty($articulo))
		{
			throw new Exception("Error, el articulo no es un array!", 1);
		}
		if(!$articulo["idProducto"] || !$articulo["cantidad"] || !$articulo["precio"])
		{
			throw new Exception("Error, el articulo debe tener un id, cantidad y precio!", 1);
		}
		if(!is_numeric($articulo["idProducto"]) || !is_numeric($articulo["cantidad"]))
		{
			throw new Exception("Error, el id, cantidad y precio deben ser números!", 1);
		}
		$unique_id = md5($articulo["idProducto"]);
		$articulo["unique_id"] = $unique_id;
		$articulo['cantidad'] = $cantidadArticulos;
		if(!empty($this->carrito))
		{
			foreach ($this->carrito as $row)
			{
				if($row["unique_id"] === $unique_id)
				{
					$articulo["cantidad"] = $cantidadArticulos;
				}
			}
		}
		$articulo["cantidad"] = trim(preg_replace('/([^0-9\.])/i', '', $articulo["cantidad"]));
	  $articulo["precio"] = trim(preg_replace('/([^0-9\.])/i', '', $articulo["precio"]));
    $articulo["total"] = $articulo["cantidad"] * $articulo["precio"];
    $this->unset_producto($unique_id);
    $_SESSION["carrito"][$unique_id] = $articulo;
    $this->update_carrito();
    $this->update_precio_cantidad();
	}
	//añadimos un producto al carrito
	public function add($articulo = array(), $cantidadArticulos)
	{
		if (!is_numeric($cantidadArticulos))
		{
			throw new Exception("Error, el articulo no es un array!", 1);
		}
		if (empty($cantidadArticulos)) {
			$cantidadArticulos=1;
		}
		//primero comprobamos el articulo a añadir, si está vacío o no es un
		//array lanzamos una excepción y cortamos la ejecución
		if(!is_array($articulo) || empty($articulo))
		{
			throw new Exception("Error, el articulo no es un array!", 1);
		}

		//nuestro carro necesita siempre un id producto, cantidad y precio articulo
		if(!$articulo["idProducto"] || !$articulo["cantidad"] || !$articulo["precio"])
		{
			throw new Exception("Error, el articulo debe tener un id, cantidad y precio!", 1);
		}

		//nuestro carro necesita siempre un id producto, cantidad y precio articulo
		if(!is_numeric($articulo["idProducto"]) || !is_numeric($articulo["cantidad"]))
		{
			throw new Exception("Error, el id, cantidad y precio deben ser números!", 1);
		}

		//debemos crear un identificador único para cada producto
		$unique_id = md5($articulo["idProducto"]);

		//creamos la id única para el producto
		$articulo["unique_id"] = $unique_id;
		$articulo['cantidad'] = $cantidadArticulos;

		//si no está vacío el carrito lo recorremos
		if(!empty($this->carrito))
		{
			foreach ($this->carrito as $row)
			{
				//comprobamos si este producto ya estaba en el
				//carrito para actualizar el producto o insertar
				//un nuevo producto
				if($row["unique_id"] === $unique_id)
				{
					//si ya estaba sumamos la cantidad
					$articulo["cantidad"] = $row["cantidad"] += $cantidadArticulos;
				}
			}
		}

		//evitamos que nos pongan números negativos y que sólo sean números para cantidad y precio
		$articulo["cantidad"] = trim(preg_replace('/([^0-9\.])/i', '', $articulo["cantidad"]));
	  $articulo["precio"] = trim(preg_replace('/([^0-9\.])/i', '', $articulo["precio"]));

	    //añadimos un elemento total al array carrito para
	    //saber el precio total de la suma de este artículo
	    $articulo["total"] = $articulo["cantidad"] * $articulo["precio"];

	    //primero debemos eliminar el producto si es que estaba en el carrito
	    $this->unset_producto($unique_id);

	    ///ahora añadimos el producto al carrito
	    $_SESSION["carrito"][$unique_id] = $articulo;

	    //actualizamos el carrito
	    $this->update_carrito();

	    //actualizamos el precio total y el número de artículos del carrito
	    //una vez hemos añadido el producto
	    $this->update_precio_cantidad();

	}

	//método que actualiza el precio total y la cantidad
	//de productos total del carrito
	private function update_precio_cantidad()
	{
		//seteamos las variables precio y artículos a 0
		$precio = 0;
		$articulos = 0;

		//recorrecmos el contenido del carrito para actualizar
		//el precio total y el número de artículos
		foreach ($this->carrito as $row)
		{
			$precio += ($row['precio'] * $row['cantidad']);
			$articulos += $row['cantidad'];
		}

		//asignamos a articulos_total el número de artículos actual
		//y al precio el precio actual
		$_SESSION['carrito']["articulos_total"] = $articulos;
		$_SESSION['carrito']["precio_total"] = $precio;

		//refrescamos él contenido del carrito para que quedé actualizado
		$this->update_carrito();
	}

	//método que retorna el precio total del carrito
	public function precio_total()
	{
		//si no está definido el elemento precio_total o no existe el carrito
		//el precio total será 0
		if(!isset($this->carrito["precio_total"]) || $this->carrito === null)
		{
			return 0;
		}
		//si no es númerico lanzamos una excepción porque no es correcto
		if(!is_numeric($this->carrito["precio_total"]))
		{
			throw new Exception("El precio total del carrito debe ser un número", 1);
		}
		//en otro caso devolvemos el precio total del carrito
		return $this->carrito["precio_total"] ? $this->carrito["precio_total"] : 0;
	}

	//método que retorna el número de artículos del carrito
	public function articulos_total()
	{
		//si no está definido el elemento articulos_total o no existe el carrito
		//el número de artículos será de 0
		if(!isset($this->carrito["articulos_total"]) || $this->carrito === null)
		{
			return 0;
		}
		//si no es númerico lanzamos una excepción porque no es correcto
		if(!is_numeric($this->carrito["articulos_total"]))
		{
			throw new Exception("El número de artículos del carrito debe ser un número", 1);
		}
		//en otro caso devolvemos el número de artículos del carrito
		return $this->carrito["articulos_total"] ? $this->carrito["articulos_total"] : 0;
	}

	//este método retorna el contenido del carrito
	public function get_content()
	{
		//asignamos el carrito a una variable
		$_SESSION['carrito'] = $this->carrito;
		//debemos eliminar del carrito el número de artículos
		//y el precio total para poder mostrar bien los artículos
		//ya que estos datos los devuelven los métodos
		//articulos_total y precio_total
		unset($_SESSION['carrito']["articulos_total"]);
		unset($_SESSION['carrito']["precio_total"]);
		return $_SESSION['carrito'] == null ? null : $_SESSION['carrito'];
	}

	//método que llamamos al insertar un nuevo producto al
	//carrito para eliminarlo si existia, así podemos insertarlo
	//de nuevo pero actualizado
	private function unset_producto($unique_id)
	{
		unset($_SESSION["carrito"][$unique_id]);
	}

	//para eliminar un producto debemos pasar la clave única
	//que contiene cada uno de ellos
	public function remove_producto($unique_id)
	{
		//si no existe el carrito
		if($this->carrito === null)
		{
			throw new Exception("El carrito no existe!", 1);
		}

		//si no existe la id única del producto en el carrito
		if(!isset($this->carrito[$unique_id]))
		{
			throw new Exception("La unique_id $unique_id no existe!", 1);
		}

		//en otro caso, eliminamos el producto, actualizamos el carrito y
		//el precio y cantidad totales del carrito
		unset($_SESSION["carrito"][$unique_id]);
		$this->update_carrito();
		$this->update_precio_cantidad();
		return true;
	}

	//eliminamos el contenido del carrito por completo
	public function destroy()
	{
		unset($_SESSION["carrito"]);
		$this->carrito = null;
		return true;
	}

	//actualizamos el contenido del carrito
	public function update_carrito()
	{
		self::__construct();
	}
}
?>
