<?php
class PDOAdapter
{
	/** @var array $_config Arreglo con los datos de conexión a la Base de Datos */
	protected $_config = array();
	/** @var mixed|null $_link Enlace a la Base de Datos */
	protected $_link = null;
	/** @var mixed|null $_instance Instancia única (Singleton) de la clase PDOAdapter */
	protected static $_instance = null;

	/**
	 * Obtiene la Instancia única (Singleton) de la clase PDOAdapter
	 * @param array Arreglo con los datos de conexión a la Base de Datos
	 * @return PDOAdapter Instancia única (Singleton) de la clase PDOAdapter
	 */
	public static function getInstance(array $config = array())
	{
		if (self::$_instance === null) {
			self::$_instance = new self($config);
		}
		return self::$_instance;
	}

	/**
	 * Constructor de clase
	 * @param array Arreglo con los datos de conexión a la Base de Datos
	 */
	protected function __construct(array $config)
	{
		if (count($config) !== 5) {
			throw new Exception('Invalid number of connection parameters.');
		}
		$this->_config = $config;

		if ($this->_link === null){
			list($driver, $host, $user, $password, $database) = $this->_config;
			try {
				$dsn = $driver . ":server=" . $host . ";Database=" . $database;
				$pdo = new PDO($dsn, $user, $password);
				//Enable error output, not recommended for production
				//$pdo = setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$pdo->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_SYSTEM);
				$this->_link = $pdo;
			} catch (PDOException $e) {
				echo "Error: " . $e->getMessage();
			}

			unset($host, $user, $password, $database);
		}
	}

	/**
	 * Previene el clonado de la Instancia de clase
	 */
	protected function __clone(){}

	/**
	 * Obtiene un solo renglón que resulte de la Sentencia SQL ($sql) ingresada
	 * @param string $sql Sentencia SQL a procesar
	 * @return object Resultado de la Sentencia SQL ($sql) a procesar
	 */
	public function getSingleRow($sql)
	{
		return $this->_link->query($sql)->fetch(PDO::FETCH_OBJ);
	}

	/**
	 * Obtiene los renglones que resulten de la Sentencia SQL ($sql) ingresada
	 * @param string $sql Sentencia SQL a procesar
	 * @return object Resultado de la Sentencia SQL ($sql) a procesar
	 */
	public function getAllRows($sql)
	{
		return $this->_link->query($sql)->fetchAll(PDO::FETCH_OBJ);
	}

	/**
	 * Obtiene los renglones que resulten de la Sentencia SQL ($sql) ingresada
	 * @param string $sql Sentencia SQL a procesar
	 * @return array Resultado de la Sentencia SQL ($sql) a procesar
	 */
	public function getAllRowsArray($sql)
	{
		return $this->_link->query($sql)->fetchAll(PDO::FETCH_NUM);
	}

	/**
	 * Emula el comportamiento de mysql_real_escape_string(), sin usar una conexión a MySQL
	 * @param mixed $inp Valor a procesar
	 * @return mixed $inp Valor procesada
	 */
	public function mysql_escape_mimic($inp)
	{
		if(is_array($inp))
			return array_map(__METHOD__, $inp);
		if(!empty($inp) && is_string($inp))
		{
			return str_replace(
				array('\\', "\0", "\n", "\r", "'", '"', "\x1a"),
				array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'),
				$inp
			);
		}
		return $inp;
	}

	/**
	 * Elimina las comillas, usando mysql_escape_mimic
	 * @param mixed $value Valor a procesar
	 * @return mixed $value Valor procesado
	 */
	public function noQuoteValue($value)
	{
		return mysql_escape_mimic($value);
	}

	/**
	 * Inserta un registro en la tabla $table
	 * @param mixed $value Valor a procesar
	 * @return mixed $value Valor procesado
	 */
	public function insertRecord($table, $idField, array $data)
	{
		$fields = implode(',', array_keys($data));
		$values = implode(',', array_map(array($this, 'noQuoteValue'), array_values($data)));
		$sql = 'INSERT INTO ' . $table . '(' . $fields . ')' . ' VALUES (' . $values . ')';
		$this->_link->exec($sql);
		return $this->getInsertedRowID($table, $idField);
	}

	/**
	 * Actualiza un registro en la tabla $table, con el arreglo $data, aplicando la condición $where
	 * @param string $table Nombre de la tabla
	 * @param array $data Arreglo de datos a actualizar
	 * @param string $where Condición a aplicar
	 * @return mixed Resultado de la sentencia
	 */
	public function updateTable($table, array $data, $where = '')
	{
		$set = array();
		foreach ($data as $field => $value) {
			$set[] = $field . '=' . $value;
		}

		$set = implode(',', $set);
		$sql = 'UPDATE ' . $table . ' SET ' . $set . (($where) ? ' WHERE ' . $where : '');
		return $this->_link->exec($sql);
	}

	/**
	 * Elimina un registro en la tabla $table, aplicando la condición $where
	 * @param string $table Nombre de la tabla
	 * @param string $where Condición a aplicar
	 * @return mixed Resultado de la sentencia
	 */
	public function deleteRecord($table, $where)
	{
		$sql = 'DELETE FROM ' . $table . (($where) ? ' WHERE ' . $where : '');
		return $this->_link->exec($sql);
	}

	/**
	 * Obtiene la identidad del último registro en la tabla $table
	 * @param string $table Nombre de la tabla
	 * @param string $idField Nombre del campo de identidad
	 * @return mixed Resultado de la sentencia
	 */
	public function getInsertedRowID($table, $idField = "id")
	{
		$sql = "SELECT TOP 1 $idField as id from $table ORDER BY $idField DESC";
		return $this->_link->query($sql)->fetchAll();
	}
}