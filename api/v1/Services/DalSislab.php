<?php
namespace Service;
//include "../Services/PDOAdapter.php";

class DALSislab
{
	protected static $_instance;
	const DB_DRIVER = "mysql";
	//const DB_DRIVER = "sqlsrv";
	const DB_HOST = "[::1]";
	const DB_USER = "sislab";
	const DB_PASSWORD = "sislab@12#";
	const DB_DATA_BASE = "Sislab";

	public static function getInstance() {
		if (self::$_instance === null)
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	protected function __construct() {
		//PDOAdapter::getInstance(array(
		//self::DB_DRIVER, self::DB_HOST, self::DB_USER,
		//self::DB_PASSWORD, self::DB_DATA_BASE));
	}

	protected function __clone(){}

	public function getMenu($userId) {
		//$sql = "SELECT
		//		menu, submenu
		//	FROM
		//		menu
		//	WHERE
		//		id_usuario := $userId
		//	ORDER BY
		//		order";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		if ($userId == 1)
		{
			$result = '
				[
					{
						"id_menu":1,
						"orden":1,
						"url":"/#",
						"label":"Informe",
						"activo":1,
						"submenu":
						[
							{
								"id_submenu":1,
								"id_menu":1,
								"orden":1,
								"url":"/estudio/estudios",
								"label":"Informe",
								"activo":1
							}
						]
					},
					{
						"id_menu":2,
						"orden":2,
						"url":"/#",
						"label":"Muestreo",
						"activo":1,
						"submenu":
						[
							{
								"id_submenu":2,
								"id_menu":2,
								"orden":1,
								"url":"/muestreo/solicitudes",
								"label":"Solicitud",
								"activo":1
							},
							{
								"id_submenu":3,
								"id_menu":2,
								"orden":2,
								"url":"/muestreo/ordenes",
								"label":"Orden Muestreo",
								"activo":1
							},
							{
								"id_submenu":4,
								"id_menu":2,
								"orden":3,
								"url":"/muestreo/planes",
								"label":"Plan Muestreo",
								"activo":1
							}
						]
					},
					{
						"id_menu":3,
						"orden":3,
						"url":"/#",
						"label":"Recepción",
						"activo":1,
						"submenu":
						[
							{
								"id_submenu":5,
								"id_menu":3,
								"orden":1,
								"url":"/recepcion/hojas",
								"label":"Hoja Campo",
								"activo":1
							},
							{
								"id_submenu":6,
								"id_menu":3,
								"orden":1,
								"url":"/recepcion/recepciones",
								"label":"Recepción Muestras",
								"activo":1
							},
							{
								"id_submenu":7,
								"id_menu":3,
								"orden":4,
								"url":"/recepcion/custodias",
								"label":"Cadena Custodia",
								"activo":1
							}
						]
					},
					{
						"id_menu":4,
						"orden":4,
						"url":"/#",
						"label":"Inventario",
						"activo":1,
						"submenu":
						[
							{
								"id_submenu":8,
								"id_menu":4,
								"orden":1,
								"url":"/inventario/muestras",
								"label":"Inventario Muestras",
								"activo":1
							},
							{
								"id_submenu":9,
								"id_menu":4,
								"orden":2,
								"url":"/inventario/equipos",
								"label":"Equipos",
								"activo":1
							},
							{
								"id_submenu":10,
								"id_menu":4,
								"orden":3,
								"url":"/inventario/reactivos",
								"label":"Reactivos",
								"activo":1
							},
							{
								"id_submenu":11,
								"id_menu":4,
								"orden":4,
								"url":"/inventario/recipientes",
								"label":"Recipientes",
								"activo":1
							}
						]
					},
					{
						"id_menu":5,
						"orden":5,
						"url":"/#",
						"label":"Análisis",
						"activo":1,
						"submenu":
						[
							{
								"id_submenu":12,
								"id_menu":5,
								"orden":1,
								"url":"/analisis/analisis",
								"label":"Análisis",
								"activo":1
							}
						]
					},
					{
						"id_menu":6,
						"orden":6,
						"url":"/#",
						"label":"Reportes",
						"activo":1,
						"submenu":
						[
							{
								"id_submenu":13,
								"id_menu":6,
								"orden":1,
								"url":"/reporte/reportes",
								"label":"Reportes",
								"activo":1
							}
						]
					},
					{
						"id_menu":7,
						"orden":7,
						"url":"/#",
						"label":"Catálogos",
						"activo":1,
						"submenu":
						[
							{
								"id_submenu":16,
								"id_menu":7,
								"orden":1,
								"url":"/catalogo/puntos",
								"label":"Puntos Muestreo",
								"activo":1
							},
							{
								"id_submenu":17,
								"id_menu":7,
								"orden":2,
								"url":"/catalogo/clientes",
								"label":"Clientes",
								"activo":1
							},
							{
								"id_submenu":18,
								"id_menu":7,
								"orden":3,
								"url":"/catalogo/areas",
								"label":"Áreas",
								"activo":1
							},
							{
								"id_submenu":19,
								"id_menu":7,
								"orden":4,
								"url":"/catalogo/empleados",
								"label":"Empleados",
								"activo":1
							},
							{
								"id_submenu":20,
								"id_menu":7,
								"orden":5,
								"url":"/catalogo/normas",
								"label":"Normas",
								"activo":1
							},
							{
								"id_submenu":21,
								"id_menu":7,
								"orden":6,
								"url":"/catalogo/referencia",
								"label":"Valores Referencia",
								"activo":1
							},
							{
								"id_submenu":22,
								"id_menu":7,
								"orden":7,
								"url":"/catalogo/metodos",
								"label":"Métodos análisis",
								"activo":1
							},
							{
								"id_submenu":23,
								"id_menu":7,
								"orden":8,
								"url":"/catalogo/precios",
								"label":"Precio análisis",
								"activo":1
							}
						]
					},
					{
						"id_menu":8,
						"orden":8,
						"url":"/#",
						"label":"Administración",
						"activo":1,
						"submenu":
						[
							{
								"id_submenu":24,
								"id_menu":8,
								"orden":1,
								"url":"/sistema/usuarios",
								"label":"Usuarios",
								"activo":1
							},
							{
								"id_submenu":25,
								"id_menu":8,
								"orden":2,
								"url":"/sistema/perfil",
								"label":"Ver Perfil",
								"activo":1
							},
							{
								"id_submenu":26,
								"id_menu":8,
								"orden":3,
								"url":"/sistema/logout",
								"label":"Cerrar sesión",
								"activo":1
							}
						]
					}
				]
			';
		}
		else if ($userId == 20)
		{
			$result = '
				[
					{
						"id_menu":1,
						"orden":1,
						"url":"/#",
						"label":"Muestreo",
						"activo":1,
						"submenu":
						[
							{
								"id_submenu":1,
								"id_menu":1,
								"orden":1,
								"url":"/muestreo/solicitudes",
								"label":"Solicitud",
								"activo":1
							}
						]
					},
					{
						"id_menu":5,
						"orden":5,
						"url":"/#",
						"label":"Reportes",
						"activo":1,
						"submenu":
						[
							{
								"id_submenu":14,
								"id_menu":5,
								"orden":1,
								"url":"/reporte/consulta",
								"label":"Consultar",
								"activo":1
							}
						]
					},
					{
						"id_menu":6,
						"orden":6,
						"url":"/#",
						"label":"Catálogos",
						"activo":1,
						"submenu":
						[
							{
								"id_submenu":16,
								"id_menu":6,
								"orden":1,
								"url":"/catalogo/puntos",
								"label":"Puntos Muestreo",
								"activo":1
							},
							{
								"id_submenu":17,
								"id_menu":6,
								"orden":2,
								"url":"/catalogo/clientes",
								"label":"Clientes",
								"activo":1
							},
							{
								"id_submenu":18,
								"id_menu":6,
								"orden":3,
								"url":"/catalogo/areas",
								"label":"Áreas",
								"activo":1
							},
							{
								"id_submenu":19,
								"id_menu":6,
								"orden":4,
								"url":"/catalogo/empleados",
								"label":"Empleados",
								"activo":1
							},
							{
								"id_submenu":20,
								"id_menu":6,
								"orden":5,
								"url":"/catalogo/normas",
								"label":"Normas",
								"activo":1
							},
							{
								"id_submenu":21,
								"id_menu":6,
								"orden":6,
								"url":"/catalogo/referencia",
								"label":"Valores Referencia",
								"activo":1
							},
							{
								"id_submenu":22,
								"id_menu":6,
								"orden":7,
								"url":"/catalogo/metodos",
								"label":"Métodos análisis",
								"activo":1
							},
							{
								"id_submenu":23,
								"id_menu":6,
								"orden":8,
								"url":"/catalogo/precios",
								"label":"Precio análisis",
								"activo":1
							}
						]
					},
					{
						"id_menu":7,
						"orden":7,
						"url":"/#",
						"label":"Administración",
						"activo":1,
						"submenu":
						[
							{
								"id_submenu":25,
								"id_menu":7,
								"orden":2,
								"url":"/sistema/perfil",
								"label":"Ver Perfil",
								"activo":1
							},
							{
								"id_submenu":26,
								"id_menu":7,
								"orden":3,
								"url":"/sistema/logout",
								"label":"Cerrar sesión",
								"activo":1
							}
						]
					}
				]
			';
		}
		else
		{
			$result = '
				[
					{
						"id_menu":7,
						"orden":7,
						"url":"/#",
						"label":"Administración",
						"activo":1,
						"submenu":
						[
							{
								"id_submenu":26,
								"id_menu":7,
								"orden":3,
								"url":"/sistema/logout",
								"label":"Cerrar sesión",
								"activo":1
							}
						]
					}
				]
			';
		}
		return $result;
	}

	public function getTasks($userId) {
		//$sql = "SELECT
		//		id_tarea, id_usuario, id_supervisor,
		//		id_area, id_tipo_tarea
		//	FROM
		//		tarea
		//	WHERE
		//		id_usuario := $userId
		//	ORDER BY
		//		fecha DESC";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '[]';
		if ($userId == 1) {
			$result = '
				[
					{
						"id_tarea":1,
						"id_usuario":20,
						"id_area":5,
						"area":"Administrativo",
						"id_tipo_area":1,
						"tipo_tarea":"Solicitud",
						"validado":0,
						"fecha_captura":"2014-11-30",
						"usuario":
						{
							"id_usuario":20,
							"id_nivel":6,
							"id_area":5,
							"id_puesto":7,
							"usr":"mroman",
							"pwd":"mroman",
							"area":"Administrativo",
							"puesto":"Secretaria",
							"nombres":"Mirna María",
							"ap":"López",
							"am":"Román",
							"fecha_act":"2014-11-30",
							"calidad":0,
							"supervisa":0,
							"analiza":0,
							"muestrea":0,
							"cert":0,
							"activo":1
						}
					},
					{
						"id_tarea":2,
						"id_usuario":20,
						"id_area":5,
						"area":"Administrativo",
						"id_tipo_area":1,
						"tipo_tarea":"Solicitud",
						"validado":0,
						"fecha_captura":"2014-11-30",
						"usuario":
						{
							"id_usuario":20,
							"id_nivel":6,
							"id_area":5,
							"id_puesto":7,
							"usr":"mroman",
							"pwd":"mroman",
							"area":"Administrativo",
							"puesto":"Secretaria",
							"nombres":"Mirna María",
							"ap":"López",
							"am":"Román",
							"fecha_act":"2014-11-30",
							"calidad":0,
							"supervisa":0,
							"analiza":0,
							"muestrea":0,
							"cert":0,
							"activo":1
						}
					}
				]
			';
		}
		return $result;
	}

	public function getStatus($statusId) {
		if ($statusId == 1)
		{
			$result = '
				{
					"id_status":1,
					"status":"Sin validar",
					"activo":1
				}
			';
		}
		else if ($statusId == 2)
		{
			$result = '
				{
					"id_status":2,
					"status":"Validado",
					"activo":1
				}
			';
		}
		else if ($statuId == 3)
		{
			$result = '
				{
					"id_status":3,
					"status":"Rechazado",
					"activo":1
				}
			';
		}
		else
		{
			$result = '
				{
					"id_status":0,
					"status":"Sin status",
					"activo":1
				}
			';
		}
		return $result;
	}

	public function getStatusList() {
		$result = '
			[
				{
					"id_status":1,
					"status":"Sin validar",
					"activo":1
				},
				{
					"id_status":2,
					"status":"Validado",
					"activo":1
				},
				{
					"id_status":3,
					"status":"Rechazado",
					"activo":1
				}
			]
		';
	}

	public function getStudy($studyId) {
		//$sql = "SELECT
		//		*
		//	FROM
		//		estudio
		//	WHERE id_estudio := $studyId AND activo = 1";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		if ($studyId == 1)
		{
			$result = '
				{
					"id_estudio":1,
					"id_cliente":1,
					"id_origen_orden":1,
					"id_ejercicio":2015,
					"id_status":2,
					"id_usuario_captura":20,
					"id_usuario_valida":1,
					"id_usuario_actualiza":1,
					"numero_oficio":432,
					"folio":"CEA-432/2015",
					"origen_descripcion":"GP-001/2015",
					"ubicacion":"Río Santiago",
					"status":"Validado",
					"fecha":"2015-03-21",
					"fecha_captura":"2015-03-21",
					"ip_captura":"[::1]",
					"host_captura":"[::1]",
					"fecha_valida":"2015-03-21",
					"ip_valida":"[::1]",
					"host_valida":"[::1]",
					"fecha_actualiza":"2015-03-21",
					"ip_actualiza":"[::1]",
					"host_actualiza":"[::1]",
					"fecha_rechaza":"2015-03-21",
					"motivo_rechaza":"Error en datos cliente",
					"activo":1,
					"cliente":
					{
						"id_cliente":1,
						"id_organismo":1,
						"cliente":"CEA Jalisco",
						"area":"Dirección de Operación de PTARS",
						"rfc":"Registro Federal de Contribuyentes",
						"calle":"Av. Brasilia",
						"numero":"2970",
						"colonia":"Col. Colomos Providencia",
						"cp":"44680",
						"id_estado":14,
						"id_municipio":14039,
						"municipio":"Guadalajara",
						"id_localidad":140390001,
						"localidad":"Guadalajara",
						"tel":"3030-9350 ext. 8370",
						"fax":"",
						"contacto":"Biol. Luis Aceves Martínez",
						"puesto_contacto":"puesto contacto",
						"email":"laceves@ceajalisco.gob.mx",
						"fecha_act":"23/11/2014",
						"interno":1,
						"cea":1,
						"tasa":0,
						"activo":1
					},
					"solicitudes":
					[
						{
							"id_solicitud":1,
							"id_estudio":1,
							"id_matriz":1,
							"id_tipo_muestreo":2,
							"id_norma":3,
							"id_status":1,
							"cantidad_muestras":15,
							"activo":1
						},
						{
							"id_solicitud":2,
							"id_estudio":1,
							"id_matriz":6,
							"id_tipo_muestreo":1,
							"id_norma":1,
							"id_status":1,
							"cantidad_muestras":16,
							"activo":1
						}
					]
				}
			';
		}
		else if ($studyId == 2)
		{
			$result = '
				{
					"id_estudio":2,
					"id_cliente":13,
					"id_origen_orden":2,
					"id_ejercicio":2015,
					"id_status":1,
					"id_usuario_captura":20,
					"id_usuario_valida":1,
					"id_usuario_actualiza":1,
					"numero_oficio":433,
					"folio":"CEA-433/2015",
					"origen_descripcion":"",
					"ubicacion":"Río Santiago",
					"status":"Sin validar",
					"fecha":"2015-03-21",
					"fecha_captura":"2015-03-21",
					"ip_captura":"[::1]",
					"host_captura":"[::1]",
					"fecha_valida":"2015-03-21",
					"ip_valida":"[::1]",
					"host_valida":"[::1]",
					"fecha_actualiza":"2015-03-21",
					"ip_actualiza":"[::1]",
					"host_actualiza":"[::1]",
					"fecha_rechaza":"",
					"motivo_rechaza":"",
					"activo":1,
					"cliente":
					{
						"id_cliente":13,
						"id_organismo":6,
						"cliente":"Ayuntamiento de Cotija, Michoacan",
						"area":"",
						"rfc":"Registro Federal de Contribuyentes",
						"calle":"Pino Suárez Pte.",
						"numero":"100",
						"colonia":"Col. Centro",
						"cp":"59940",
						"id_estado":16,
						"estado":"Michoacán de Ocampo",
						"id_municipio":16019,
						"municipio":"Cotija",
						"id_localidad":160190001,
						"localidad":"Cotija de La Paz",
						"tel":"045-35-4100-1836",
						"fax":"",
						"contacto":"Arq. Juan Jesús Zarate Barajas",
						"puesto_contacto":"puesto contacto",
						"email":"ooapascotija@hotmail.com",
						"fecha_act":"23/11/2014",
						"interno":0,
						"cea":0,
						"tasa":1,
						"activo":1
					},
					"solicitudes":
					[
						{
							"id_solicitud":1,
							"id_estudio":1,
							"id_matriz":1,
							"id_tipo_muestreo":2,
							"id_norma":3,
							"id_status":1,
							"cantidad_muestras":15,
							"activo":1
						}
					]
				}
			';
		}
		else if ($studyId == 3)
		{
			$result = '
				{
					"id_estudio":3,
					"id_cliente":21,
					"id_origen_orden":2,
					"id_ejercicio":2015,
					"id_status":2,
					"id_usuario_captura":20,
					"id_usuario_valida":1,
					"id_usuario_actualiza":1,
					"numero_oficio":3,
					"folio":"CEA-3/2015",
					"origen_descripcion":"",
					"ubicacion":"",
					"status":"Validado",
					"fecha":"2015-03-21",
					"fecha_captura":"2015-03-21",
					"ip_captura":"[::1]",
					"host_captura":"[::1]",
					"fecha_valida":"22/03/2015",
					"ip_valida":"[::1]",
					"host_valida":"[::1]",
					"fecha_actualiza":"22/03/2015",
					"ip_actualiza":"[::1]",
					"host_actualiza":"[::1]",
					"fecha_rechaza":"",
					"motivo_rechaza":"",
					"activo":1,
					"cliente":
					{
						"id_cliente":21,
						"id_organismo":14,
						"cliente":"SECOLAM S.A. de C.V.",
						"area":"",
						"rfc":"Registro Federal de Contribuyentes",
						"calle":"De los Fiordos",
						"numero":"16",
						"colonia":"Col. Acueducto de Guadalupe",
						"cp":"07279",
						"id_estado":9,
						"estado":"Distrito Federal",
						"id_municipio":9007,
						"municipio":"Gustavo A. Madero",
						"id_localidad":90070001,
						"localidad":"Gustavo A. Madero",
						"tel":"1567-4406",
						"fax":"",
						"contacto":"Ing. Roberto Escalante Villanueva",
						"puesto_contacto":"puesto contacto",
						"email":"rescalante@secovam.com",
						"fecha_act":"23/11/2014",
						"interno":0,
						"cea":0,
						"tasa":1,
						"activo":1
					},
					"solicitudes":
					[
						{
							"id_solicitud":5,
							"id_estudio":3,
							"id_matriz":1,
							"id_tipo_muestreo":2,
							"id_norma":3,
							"id_status":1,
							"cantidad_muestras":15,
							"activo":1
						},
						{
							"id_solicitud":6,
							"id_estudio":3,
							"id_matriz":2,
							"id_tipo_muestreo":1,
							"id_norma":1,
							"id_status":1,
							"cantidad_muestras":16,
							"activo":1
						}
					]
				}
			';
		}
		else
		{
			$result = '
				{
					"id_estudio":0,
					"id_cliente":0,
					"id_origen_orden":0,
					"id_ejercicio":0,
					"id_status":1,
					"id_usuario_captura":0,
					"id_usuario_valida":0,
					"id_usuario_actualiza":0,
					"numero_oficio":0,
					"folio":"CEA-0/0",
					"origen_descripcion":"",
					"ubicacion":"",
					"status":"Sin validar",
					"fecha":"",
					"fecha_captura":"",
					"ip_captura":0,
					"host_captura":"",
					"fecha_valida":"",
					"ip_valida":"",
					"host_valida":"",
					"fecha_actualiza":"",
					"ip_actualiza":"",
					"host_actualiza":"",
					"fecha_rechaza":"",
					"motivo_rechaza":"",
					"activo":1,
					"cliente":
					{
					},
					"solicitudes":
					[
						{
							"id_solicitud":0,
							"id_estudio":0,
							"id_matriz":0,
							"id_tipo_muestreo":0,
							"id_norma":0,
							"id_status":1,
							"cantidad_muestras":0,
							"activo":1
						}
					]
				}
			';
		}
		return $result;
	}

	public function getStudies() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		estudio
		//	WHERE activo = 1";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_estudio":1,
					"id_cliente":1,
					"id_origen_orden":1,
					"id_ejercicio":2015,
					"id_status":2,
					"id_usuario_captura":20,
					"id_usuario_valida":1,
					"id_usuario_actualiza":1,
					"numero_oficio":432,
					"folio":"CEA-432/2015",
					"origen_descripcion":"GP-001/2015",
					"ubicacion":"Río Santiago",
					"status":"Validado",
					"fecha":"2015-03-21",
					"fecha_captura":"2015-03-21",
					"ip_captura":"[::1]",
					"host_captura":"[::1]",
					"fecha_valida":"2015-03-21",
					"ip_valida":"[::1]",
					"host_valida":"[::1]",
					"fecha_actualiza":"2015-03-21",
					"ip_actualiza":"[::1]",
					"host_actualiza":"[::1]",
					"fecha_rechaza":"2015-03-21",
					"motivo_rechaza":"Error en datos cliente",
					"activo":1,
					"cliente":
					{
						"id_cliente":1,
						"id_organismo":1,
						"cliente":"CEA Jalisco",
						"area":"Dirección de Operación de PTARS",
						"rfc":"Registro Federal de Contribuyentes",
						"calle":"Av. Brasilia",
						"numero":"2970",
						"colonia":"Col. Colomos Providencia",
						"cp":"44680",
						"id_estado":14,
						"id_municipio":14039,
						"municipio":"Guadalajara",
						"id_localidad":140390001,
						"localidad":"Guadalajara",
						"tel":"3030-9350 ext. 8370",
						"fax":"",
						"contacto":"Biol. Luis Aceves Martínez",
						"puesto_contacto":"puesto contacto",
						"email":"laceves@ceajalisco.gob.mx",
						"fecha_act":"23/11/2014",
						"interno":1,
						"cea":1,
						"tasa":0,
						"activo":1
					},
					"solicitudes":
					[
						{
							"id_solicitud":1,
							"id_estudio":1,
							"id_matriz":1,
							"id_tipo_muestreo":2,
							"id_norma":3,
							"id_status":1,
							"cantidad_muestras":15,
							"activo":1
						},
						{
							"id_solicitud":2,
							"id_estudio":1,
							"id_matriz":6,
							"id_tipo_muestreo":1,
							"id_norma":1,
							"id_status":1,
							"cantidad_muestras":16,
							"activo":1
						}
					]
				},
				{
					"id_estudio":2,
					"id_cliente":13,
					"id_origen_orden":2,
					"id_ejercicio":2015,
					"id_status":1,
					"id_usuario_captura":20,
					"id_usuario_valida":1,
					"id_usuario_actualiza":1,
					"numero_oficio":433,
					"folio":"CEA-433/2015",
					"origen_descripcion":"",
					"ubicacion":"Río Santiago",
					"status":"Sin validar",
					"fecha":"2015-03-21",
					"fecha_captura":"2015-03-21",
					"ip_captura":"[::1]",
					"host_captura":"[::1]",
					"fecha_valida":"2015-03-21",
					"ip_valida":"[::1]",
					"host_valida":"[::1]",
					"fecha_actualiza":"2015-03-21",
					"ip_actualiza":"[::1]",
					"host_actualiza":"[::1]",
					"fecha_rechaza":"",
					"motivo_rechaza":"",
					"activo":1,
					"cliente":
					{
						"id_cliente":13,
						"id_organismo":6,
						"cliente":"Ayuntamiento de Cotija, Michoacan",
						"area":"",
						"rfc":"Registro Federal de Contribuyentes",
						"calle":"Pino Suárez Pte.",
						"numero":"100",
						"colonia":"Col. Centro",
						"cp":"59940",
						"id_estado":16,
						"estado":"Michoacán de Ocampo",
						"id_municipio":16019,
						"municipio":"Cotija",
						"id_localidad":160190001,
						"localidad":"Cotija de La Paz",
						"tel":"045-35-4100-1836",
						"fax":"",
						"contacto":"Arq. Juan Jesús Zarate Barajas",
						"puesto_contacto":"puesto contacto",
						"email":"ooapascotija@hotmail.com",
						"fecha_act":"23/11/2014",
						"interno":0,
						"cea":0,
						"tasa":1,
						"activo":1
					},
					"solicitudes":
					[
						{
							"id_solicitud":1,
							"id_estudio":1,
							"id_matriz":1,
							"id_tipo_muestreo":2,
							"id_norma":3,
							"id_status":1,
							"cantidad_muestras":15,
							"activo":1
						}
					]
				},
				{
					"id_estudio":3,
					"id_cliente":21,
					"id_origen_orden":2,
					"id_ejercicio":2015,
					"id_status":2,
					"id_usuario_captura":20,
					"id_usuario_valida":1,
					"id_usuario_actualiza":1,
					"numero_oficio":3,
					"folio":"CEA-3/2015",
					"origen_descripcion":"",
					"ubicacion":"",
					"status":"Validado",
					"fecha":"2015-03-21",
					"fecha_captura":"2015-03-21",
					"ip_captura":"[::1]",
					"host_captura":"[::1]",
					"fecha_valida":"22/03/2015",
					"ip_valida":"[::1]",
					"host_valida":"[::1]",
					"fecha_actualiza":"22/03/2015",
					"ip_actualiza":"[::1]",
					"host_actualiza":"[::1]",
					"fecha_rechaza":"",
					"motivo_rechaza":"",
					"activo":1,
					"cliente":
					{
						"id_cliente":21,
						"id_organismo":14,
						"cliente":"SECOLAM S.A. de C.V.",
						"area":"",
						"rfc":"Registro Federal de Contribuyentes",
						"calle":"De los Fiordos",
						"numero":"16",
						"colonia":"Col. Acueducto de Guadalupe",
						"cp":"07279",
						"id_estado":9,
						"estado":"Distrito Federal",
						"id_municipio":9007,
						"municipio":"Gustavo A. Madero",
						"id_localidad":90070001,
						"localidad":"Gustavo A. Madero",
						"tel":"1567-4406",
						"fax":"",
						"contacto":"Ing. Roberto Escalante Villanueva",
						"puesto_contacto":"puesto contacto",
						"email":"rescalante@secovam.com",
						"fecha_act":"23/11/2014",
						"interno":0,
						"cea":0,
						"tasa":1,
						"activo":1
					},
					"solicitudes":
					[
						{
							"id_solicitud":5,
							"id_estudio":3,
							"id_matriz":1,
							"id_tipo_muestreo":2,
							"id_norma":3,
							"id_status":1,
							"cantidad_muestras":15,
							"activo":1
						},
						{
							"id_solicitud":6,
							"id_estudio":3,
							"id_matriz":2,
							"id_tipo_muestreo":1,
							"id_norma":1,
							"id_status":1,
							"cantidad_muestras":16,
							"activo":1
						}
					]
				}
			]
		';
		return $result;
	}

	public function getQuote($quoteId) {
		//$sql = "SELECT
		//		*
		//	FROM
		//		solicitud
		//	WHERE id_solicitud := $quoteId AND activo = 1";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		if ($quoteId == 1)
		{
			$result = '
				{
					"id_solicitud":1,
					"id_estudio":1,
					"id_cliente":13,
					"id_matriz":1,
					"id_tipo_muestreo":2,
					"id_norma":3,
					"id_cuerpo_receptor":0,
					"id_tipo_cuerpo":3,
					"id_ejercicio":2015,
					"id_status":2,
					"id_usuario_captura":20,
					"id_usuario_valida":1,
					"id_usuario_actualiza":1,
					"numero_oficio":432,
					"folio":"CEA-432/2014",
					"matriz":"Agua residual",
					"cantidad_muestras":15,
					"tipo_muestreo":"Compuesto",
					"costo_total":33520,
					"cuerpo_receptor":"Río Santiago",
					"tipo_cuerpo":"C",
					"status":"Validado",
					"fecha":"2015-03-21",
					"fecha_captura":"2015-03-21",
					"ip_captura":"[::1]",
					"host_captura":"localhost",
					"fecha_valida":"2015-03-21",
					"ip_valida":"[::1]",
					"host_valida":"localhost",
					"fecha_actualiza":"2015-03-21",
					"ip_actualiza":"[::1]",
					"host_actualiza":"localhost",
					"fecha_acepta":"2015-03-21",
					"fecha_rechaza":"2015-03-21",
					"motivo_rechaza":"Error en tipo del cuerpo receptor",
					"activo":1,
					"cliente":
					{
					},
					"matriz":
					{
					},
					"tipo_muestreo":
					{
					},
					"norma":
					{
					},
					"parametros":
					[
					]
				}
			';
		}
		else if ($quoteId == 2)
		{
			$result = '
				{
					"id_solicitud":2,
					"id_estudio":1,
					"id_cliente":13,
					"id_matriz":2,
					"id_tipo_muestreo":1,
					"id_norma":1,
					"id_cuerpo_receptor":0,
					"id_tipo_cuerpo":3,
					"id_ejercicio":2015,
					"id_status":2,
					"id_usuario_captura":20,
					"id_usuario_valida":1,
					"id_usuario_actualiza":1,
					"numero_oficio":432,
					"folio":"CEA-432/2015",
					"matriz":"Agua residual tratada",
					"cantidad_muestras":16,
					"tipo_muestreo":"Simple",
					"costo_total":33520,
					"cuerpo_receptor":"Río Santiago",
					"tipo_cuerpo":"C",
					"status":"Validado",
					"fecha":"2015-03-21",
					"fecha_captura":"2015-03-21",
					"ip_captura":"[::1]",
					"host_captura":"localhost",
					"fecha_valida":"2015-03-21",
					"ip_valida":"[::1]",
					"host_valida":"localhost",
					"fecha_actualiza":"2015-03-21",
					"ip_actualiza":"[::1]",
					"host_actualiza":"localhost",
					"fecha_acepta":"2015-03-21",
					"fecha_rechaza":"2015-03-21",
					"motivo_rechaza":"Error en nombre del cuerpo receptor",
					"activo":1,
					"cliente":
					{
					},
					"norma":
					{
					},
					"parametros":
					[
					]
				}
			';
		}
		else {
			$result = '
				{
					"id_solicitud":0,
					"id_estudio":0,
					"id_cliente":0,
					"id_matriz":1,
					"id_tipo_muestreo":1,
					"id_norma":1,
					"id_cuerpo_receptor":0,
					"id_tipo_cuerpo":0,
					"id_ejercicio":0,
					"id_status":0,
					"id_usuario_captura":0,
					"id_usuario_valida":0,
					"id_usuario_actualiza":0,
					"numero_oficio":0,
					"folio":"CEA-0/0",
					"matriz":"",
					"cantidad_muestras":0,
					"tipo_muestreo":"",
					"costo_total":0,
					"cuerpo_receptor":"",
					"tipo_cuerpo":"",
					"status":"Sin validar",
					"fecha":"",
					"fecha_captura":"",
					"ip_captura":"",
					"host_captura":"",
					"fecha_valida":"",
					"ip_valida":"",
					"host_valida":"",
					"fecha_actualiza":"",
					"ip_actualiza":"",
					"host_actualiza":"",
					"fecha_acepta":"",
					"fecha_rechaza":"",
					"motivo_rechaza":"",
					"activo":1,
					"cliente":
					{
					},
					"norma":
					{
						"id_norma":1,
						"id_tipo_matriz":2,
						"norma":""
					},
					"parametros":
					[
					]
				}
			';
		}
		return $result;
	}

	public function getQuotesByStudyId($studyId) {
		//$sql = "SELECT
		//		*
		//	FROM
		//		solicitud_cotizacion";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		if ($studyId == 1)
		{
			$result = '
				[
					{
						"id_solicitud":1,
						"id_estudio":1,
						"id_cliente":13,
						"id_matriz":1,
						"id_tipo_muestreo":2,
						"id_norma":3,
						"id_cuerpo_receptor":0,
						"id_tipo_cuerpo":3,
						"id_ejercicio":2015,
						"id_status":2,
						"id_usuario_captura":20,
						"id_usuario_valida":1,
						"id_usuario_actualiza":1,
						"numero_oficio":432,
						"folio":"CEA-432/2014",
						"matriz":"Agua residual",
						"cantidad_muestras":15,
						"tipo_muestreo":"Compuesto",
						"costo_total":33520,
						"cuerpo_receptor":"Río Santiago",
						"tipo_cuerpo":"C",
						"status":"Validado",
						"fecha":"2015-03-21",
						"fecha_captura":"2015-03-21",
						"ip_captura":"[::1]",
						"host_captura":"localhost",
						"fecha_valida":"2015-03-21",
						"ip_valida":"[::1]",
						"host_valida":"localhost",
						"fecha_actualiza":"2015-03-21",
						"ip_actualiza":"[::1]",
						"host_actualiza":"localhost",
						"fecha_acepta":"2015-03-21",
						"fecha_rechaza":"2015-03-21",
						"motivo_rechaza":"Error en tipo del cuerpo receptor",
						"activo":1,
						"cliente":
						{
						},
						"matriz":
						{
						},
						"tipo_muestreo":
						{
						},
						"norma":
						{
						},
						"parametros":
						[
						]
					},
					{
						"id_solicitud":2,
						"id_estudio":1,
						"id_cliente":13,
						"id_matriz":2,
						"id_tipo_muestreo":1,
						"id_norma":1,
						"id_cuerpo_receptor":0,
						"id_tipo_cuerpo":3,
						"id_ejercicio":2015,
						"id_status":2,
						"id_usuario_captura":20,
						"id_usuario_valida":1,
						"id_usuario_actualiza":1,
						"numero_oficio":432,
						"folio":"CEA-432/2015",
						"matriz":"Agua residual tratada",
						"cantidad_muestras":16,
						"tipo_muestreo":"Simple",
						"costo_total":33520,
						"cuerpo_receptor":"Río Santiago",
						"tipo_cuerpo":"C",
						"status":"Validado",
						"fecha":"2015-03-21",
						"fecha_captura":"2015-03-21",
						"ip_captura":"[::1]",
						"host_captura":"localhost",
						"fecha_valida":"2015-03-21",
						"ip_valida":"[::1]",
						"host_valida":"localhost",
						"fecha_actualiza":"2015-03-21",
						"ip_actualiza":"[::1]",
						"host_actualiza":"localhost",
						"fecha_acepta":"2015-03-21",
						"fecha_rechaza":"2015-03-21",
						"motivo_rechaza":"Error en nombre del cuerpo receptor",
						"activo":1,
						"cliente":
						{
						},
						"norma":
						{
						},
						"parametros":
						[
						]
					}
				]
			';
		}
		else
		{
			$result = '
				[]
			';
		}
		return $result;
	}

	public function getQuotes() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		solicitud_cotizacion";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_solicitud":1,
					"id_estudio":1,
					"id_cliente":13,
					"id_matriz":1,
					"id_tipo_muestreo":2,
					"id_norma":3,
					"id_cuerpo_receptor":0,
					"id_tipo_cuerpo":3,
					"id_ejercicio":2015,
					"id_status":2,
					"id_usuario_captura":20,
					"id_usuario_valida":1,
					"id_usuario_actualiza":1,
					"numero_oficio":432,
					"folio":"CEA-432/2014",
					"matriz":"Agua residual",
					"cantidad_muestras":15,
					"tipo_muestreo":"Compuesto",
					"costo_total":33520,
					"cuerpo_receptor":"Río Santiago",
					"tipo_cuerpo":"C",
					"status":"Validado",
					"fecha":"2015-03-21",
					"fecha_captura":"2015-03-21",
					"ip_captura":"[::1]",
					"host_captura":"localhost",
					"fecha_valida":"2015-03-21",
					"ip_valida":"[::1]",
					"host_valida":"localhost",
					"fecha_actualiza":"2015-03-21",
					"ip_actualiza":"[::1]",
					"host_actualiza":"localhost",
					"fecha_acepta":"2015-03-21",
					"fecha_rechaza":"2015-03-21",
					"motivo_rechaza":"Error en tipo del cuerpo receptor",
					"activo":1,
					"cliente":
					{
					},
					"matriz":
					{
					},
					"tipo_muestreo":
					{
					},
					"norma":
					{
					},
					"parametros":
					[
					]
				},
				{
					"id_solicitud":2,
					"id_estudio":1,
					"id_cliente":13,
					"id_matriz":2,
					"id_tipo_muestreo":1,
					"id_norma":1,
					"id_cuerpo_receptor":0,
					"id_tipo_cuerpo":3,
					"id_ejercicio":2015,
					"id_status":2,
					"id_usuario_captura":20,
					"id_usuario_valida":1,
					"id_usuario_actualiza":1,
					"numero_oficio":432,
					"folio":"CEA-432/2015",
					"matriz":"Agua residual tratada",
					"cantidad_muestras":16,
					"tipo_muestreo":"Simple",
					"costo_total":33520,
					"cuerpo_receptor":"Río Santiago",
					"tipo_cuerpo":"C",
					"status":"Validado",
					"fecha":"2015-03-21",
					"fecha_captura":"2015-03-21",
					"ip_captura":"[::1]",
					"host_captura":"localhost",
					"fecha_valida":"2015-03-21",
					"ip_valida":"[::1]",
					"host_valida":"localhost",
					"fecha_actualiza":"2015-03-21",
					"ip_actualiza":"[::1]",
					"host_actualiza":"localhost",
					"fecha_acepta":"2015-03-21",
					"fecha_rechaza":"2015-03-21",
					"motivo_rechaza":"Error en nombre del cuerpo receptor",
					"activo":1,
					"cliente":
					{
					},
					"norma":
					{
					},
					"parametros":
					[
					]
				}
			]
		';
		return $result;
	}

	public function getOrder($orderId) {
		//$sql = "SELECT
		//		*
		//	FROM
		//		orden
		//	WHERE id_orden := $orderId AND activo = 1";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		if ($orderId == 1) {
			$result = '
				{
					"id_orden":1,
					"id_cliente":1,
					"id_solicitud":1,
					"id_plan":1,
					"id_origen_orden":1,
					"id_matriz":3,
					"id_tipo_muestreo":1,
					"id_origen_muestreo":1,
					"id_supervisor_orden":1,
					"id_supervisor_muestreo":2,
					"id_supervisor_custodia":4,
					"id_norma":1,
					"numero_oficio":656,
					"id_ejercicio":2014,
					"folio":"CEA-656/2014",
					"fecha_captura":"2014-11-01",
					"fecha_valida":"2014-11-02",
					"fecha_muestreo":"2014-11-04",
					"hora_muestreo":"9:25",
					"fecha_actualiza":"2014-11-01",
					"emergencia":"",
					"origen_muestreo":"Agua",
					"validado":0,
					"aceptado":0,
					"activo":1,
					"origen_orden":
					{
						"id_origen_orden":2,
						"origen_orden":"Cotización"
					},
					"cliente":
					{
						"id_cliente":1,
						"id_organismo":1,
						"cliente":"CEA Jalisco",
						"area":"Dirección de Operación de PTARS",
						"rfc":"Registro Federal de Contribuyentes",
						"calle":"Av. Brasilia",
						"numero":"2970",
						"colonia":"Col. Colomos Providencia",
						"cp":"44680",
						"id_estado":14,
						"id_municipio":14039,
						"municipio":"Guadalajara",
						"id_localidad":140390001,
						"localidad":"Guadalajara",
						"tel":"3030-9350 ext. 8370",
						"fax":"",
						"contacto":"Biol. Luis Aceves Martínez",
						"puesto_contacto":"puesto contacto",
						"email":"laceves@ceajalisco.gob.mx",
						"fecha_act":"23/11/2014",
						"interno":1,
						"cea":1,
						"tasa":0,
						"activo":1
					},
					"supervisor_muestreo":
					{
						"id_supervisor_muestreo":2,
						"id_empleado":3,
						"id_nivel":3,
						"id_area":2,
						"area":"Metales Pesados",
						"id_puesto":4,
						"puesto":"Supervisor (MP)",
						"nombres":"Marín",
						"ap":"Gomar",
						"am":"Sosa",
						"fecha_act":"2014-11-30",
						"calidad":0,
						"supervisa":1,
						"analiza":1,
						"muestrea":1,
						"cert":1,
						"activo":1
					},
					"solicitud":
					{
						"id_solicitud":1,
						"numero_oficio":432,
						"id_ejercicio":2014,
						"folio":"CEA-432/2014",
						"fecha_solicitud":"2015-03-21",
						"fecha_captura":"2015-03-21",
						"fecha_valida":null,
						"fecha_acepta":null,
						"fecha_actualiza":"2015-03-21",
						"validado":0,
						"id_cliente":1,
						"id_usuario_captura":1,
						"id_usuario_valida":3,
						"id_norma":1,
						"id_tipo_muestreo":1,
						"total":0,
						"cliente":
						{
							"id_cliente":1,
							"id_organismo":1,
							"cliente":"CEA Jalisco",
							"area":"Dirección de Operación de PTARS",
							"rfc":"Registro Federal de Contribuyentes",
							"calle":"Av. Brasilia",
							"numero":"2970",
							"colonia":"Col. Colomos Providencia",
							"cp":"44680",
							"id_estado":14,
							"id_municipio":14039,
							"municipio":"Guadalajara",
							"id_localidad":140390001,
							"localidad":"Guadalajara",
							"tel":"3030-9350 ext. 8370",
							"fax":"",
							"contacto":"Biol. Luis Aceves Martínez",
							"puesto_contacto":"puesto contacto",
							"email":"laceves@ceajalisco.gob.mx",
							"fecha_act":"23/11/2014",
							"interno":1,
							"cea":1,
							"tasa":0,
							"activo":1
						},
						"descripcion_servicio":"Servicio de muestreo y análisis, para verificar el cumplimiento de la norma NOM-001-SEMARNAT-1996, que establece los límites máximos permisibles de contaminantes en las descargas de aguas residuales a los sistemas de alcantarillado urbano o municipal. -auto",
						"notas":"La presente cotización se realiza sin visita previa y se contempla un fácil y seguro acceso para la toma de muestras. Se requiere regresar esta cotización con la firma y sello de Aceptación del Servicio. -auto",
						"condiciones":"El informe de resultados se entregará a los 10 días hábiles de haber ingresado las muestras al laboratorio. El pago de resultados se hará en las instalaciones del Laboratorio de Calidad del Agua de la CEA, así también mediante depósito bancario a la cuenta: 884371445 de la Institución Bancaria BANORTE a nombre de la Comisión Estatal del Agua de Jalisco o por transferencia electrónica, cuenta interbancaria: 072320008843714454. -auto",
						"captura":{
							"id_usuario":1,
							"nombre":"Usuario captura",
							"puesto":"puesto Usuario captura"
						},
						"valida":{
							"id_empleado":3,
							"nombre":"Gerente que valida",
							"puesto":"puesto Usuario valida"
						},
						"norma":{
							"id_norma":1,
							"norma":"NOM-001-SEMARNAT-1996",
							"desc":"Norma Oficial Mexicana",
							"parametros":[
								{
									"id_parametro":25,
									"parametro":"Arsénico",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":27,
									"parametro":"Cadmio",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":28,
									"parametro":"Cobre",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":38,
									"parametro":"Coliformes fecales",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":29,
									"parametro":"Cromo",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":16,
									"parametro":"Demada bioquímica de oxígeno",
									"cert":0,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":19,
									"parametro":"Fósforo total",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":18,
									"parametro":"Grasas y aceites",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":6,
									"parametro":"Alcalinidad total",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":39,
									"parametro":"Materia flotante",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":32,
									"parametro":"Mercurio",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":7,
									"parametro":"Cloruros totales",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":33,
									"parametro":"Níquel",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":2,
									"parametro":"Potencial de hidrógeno",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":34,
									"parametro":"Plomo",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":22,
									"parametro":"Sólidos sedimentables",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":20,
									"parametro":"Sólidos suspendidos totales",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":1,
									"parametro":"Temperatura",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":36,
									"parametro":"Zinc",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								}
							]
						},
						"actividades":[
							{
								"id_actividad":1,
								"actividad":"Muestreo instantáneo",
								"id_metodo":87,
								"metodo":{
									"id_metodo":87,
									"metodo":"metodo para muestreo instantáneo"
								},
								"cantidad":1,
								"precio":0
							}
						],
						"tipo_muestreo":
						{
							"id_tipo_muestreo":1,
							"tipo_muestreo":"Simple"
						}
					},
					"parametros":
					[
						{
							"id_parametro":25,
							"parametro":"Arsénico",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":27,
							"parametro":"Cadmio",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":28,
							"parametro":"Cobre",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":38,
							"parametro":"Coliformes fecales",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":29,
							"parametro":"Cromo",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":16,
							"parametro":"Demada bioquímica de oxígeno",
							"cert":0,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":19,
							"parametro":"Fósforo total",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":18,
							"parametro":"Grasas y aceites",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":6,
							"parametro":"Alcalinidad total",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":39,
							"parametro":"Materia flotante",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":32,
							"parametro":"Mercurio",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":7,
							"parametro":"Cloruros totales",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":33,
							"parametro":"Níquel",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":2,
							"parametro":"Potencial de hidrógeno",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":34,
							"parametro":"Plomo",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":22,
							"parametro":"Sólidos sedimentables",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":20,
							"parametro":"Sólidos suspendidos totales",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":1,
							"parametro":"Temperatura",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":36,
							"parametro":"Zinc",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						}
					],
					"matriz":
					{
						"id_matriz":3,
						"matriz":"Agua Residual Tratada"
					},
					"tipo_muestreo":
					{
						"id_tipo_muestreo":1,
						"tipo_muestreo":"Simple"
					},
					"supervisor_orden":
					{
						"id_supervisor_orden":2,
						"id_empleado":1,
						"id_nivel":1,
						"id_area":5,
						"area":"Administrativo",
						"id_puesto":1,
						"puesto":"Gerente de Laboratorio",
						"nombres":"Reyna",
						"ap":"García",
						"am":"Meneses",
						"fecha_act":"2014-11-30",
						"calidad":0,
						"supervisa":1,
						"analiza":1,
						"muestrea":1,
						"cert":1,
						"activo":1
					},
					"supervisor_muestreo":
					{
						"id_supervisor_muestreo":2,
						"id_empleado":3,
						"id_nivel":3,
						"id_area":2,
						"area":"Metales Pesados",
						"id_puesto":4,
						"puesto":"Supervisor (MP)",
						"nombres":"Marín",
						"ap":"Gomar",
						"am":"Sosa",
						"fecha_act":"2014-11-30",
						"calidad":0,
						"supervisa":1,
						"analiza":1,
						"muestrea":1,
						"cert":1,
						"activo":1
					},
					"norma":
					{
						"id_norma":1,
						"norma":"NOM-001-SEMARNAT-1996",
						"desc":"Norma Oficial Mexicana",
						"parametros":[
							{
								"id_parametro":25,
								"parametro":"Arsénico",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":27,
								"parametro":"Cadmio",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":28,
								"parametro":"Cobre",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":38,
								"parametro":"Coliformes fecales",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":29,
								"parametro":"Cromo",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":16,
								"parametro":"Demada bioquímica de oxígeno",
								"cert":0,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":19,
								"parametro":"Fósforo total",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":18,
								"parametro":"Grasas y aceites",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":6,
								"parametro":"Alcalinidad total",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":39,
								"parametro":"Materia flotante",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":32,
								"parametro":"Mercurio",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":7,
								"parametro":"Cloruros totales",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":33,
								"parametro":"Níquel",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":2,
								"parametro":"Potencial de hidrógeno",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":34,
								"parametro":"Plomo",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":22,
								"parametro":"Sólidos sedimentables",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":20,
								"parametro":"Sólidos suspendidos totales",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":1,
								"parametro":"Temperatura",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":36,
								"parametro":"Zinc",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							}
						]
					}
				}
			';
		}
		else {
			$result = '
				{
					"id_orden":0,
					"id_cliente":0,
					"id_solicitud":0,
					"id_plan":0,
					"id_origen_orden":0,
					"id_matriz":0,
					"id_tipo_muestreo":0,
					"id_origen_muestreo":0,
					"id_supervisor_orden":0,
					"id_supervisor_muestreo":0,
					"id_supervisor_custodia":0,
					"id_norma":1,
					"numero_oficio":0,
					"id_ejercicio":0,
					"folio":"CEA-0/0",
					"fecha_captura":"",
					"fecha_valida":"",
					"fecha_muestreo":"",
					"hora_muestreo":"",
					"fecha_actualiza":"",
					"emergencia":"",
					"origen_muestreo":"",
					"validado":0,
					"aceptado":0,
					"activo":0,
					"origen_orden":
					{

					},
					"cliente":
					{

					},
					"supervisor_muestreo":
					{

					},
					"solicitud":
					{

					},
					"parametros":
					[

					],
					"matriz":
					{

					},
					"tipo_muestreo":
					{

					},
					"supervisor_orden":
					{

					},
					"supervisor_muestreo":
					{

					},
					"norma":{
					}
				}
			';
		}
		return $result;
	}

	public function getOrders() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		orden";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_orden":1,
					"id_cliente":1,
					"id_solicitud":1,
					"id_plan":0,
					"id_origen_orden":1,
					"id_matriz":3,
					"id_tipo_muestreo":1,
					"id_origen_muestreo":1,
					"id_supervisor_orden":1,
					"id_supervisor_muestreo":2,
					"id_supervisor_custodia":4,
					"id_norma":1,
					"numero_oficio":656,
					"id_ejercicio":2014,
					"folio":"CEA-656/2014",
					"fecha_captura":"2014-11-01",
					"fecha_valida":"2014-11-02",
					"fecha_muestreo":"2014-11-04",
					"hora_muestreo":"9:25",
					"fecha_actualiza":"2014-11-01",
					"emergencia":"",
					"origen_muestreo":"Agua",
					"validado":0,
					"aceptado":0,
					"activo":0,
					"origen_orden":
					{
						"id_origen_orden":2,
						"origen_orden":"Cotización"
					},
					"cliente":
					{
						"id_cliente":1,
						"id_organismo":1,
						"cliente":"CEA Jalisco",
						"area":"Dirección de Operación de PTARS",
						"rfc":"Registro Federal de Contribuyentes",
						"calle":"Av. Brasilia",
						"numero":"2970",
						"colonia":"Col. Colomos Providencia",
						"cp":"44680",
						"id_estado":14,
						"id_municipio":14039,
						"municipio":"Guadalajara",
						"id_localidad":140390001,
						"localidad":"Guadalajara",
						"tel":"3030-9350 ext. 8370",
						"fax":"",
						"contacto":"Biol. Luis Aceves Martínez",
						"puesto_contacto":"puesto contacto",
						"email":"laceves@ceajalisco.gob.mx",
						"fecha_act":"23/11/2014",
						"interno":1,
						"cea":1,
						"tasa":0,
						"activo":1
					},
					"supervisor_muestreo":
					{
						"id_supervisor_muestreo":2,
						"id_empleado":3,
						"id_nivel":3,
						"id_area":2,
						"area":"Metales Pesados",
						"id_puesto":4,
						"puesto":"Supervisor (MP)",
						"nombres":"Marín",
						"ap":"Gomar",
						"am":"Sosa",
						"fecha_act":"2014-11-30",
						"calidad":0,
						"supervisa":1,
						"analiza":1,
						"muestrea":1,
						"cert":1,
						"activo":1
					},
					"solicitud":
					{
						"id_solicitud":1,
						"numero_oficio":432,
						"id_ejercicio":2014,
						"folio":"CEA-432/2014",
						"fecha_solicitud":"2015-03-21",
						"fecha_captura":"2015-03-21",
						"fecha_valida":null,
						"fecha_acepta":null,
						"fecha_actualiza":"2015-03-21",
						"validado":0,
						"id_cliente":1,
						"id_usuario_captura":1,
						"id_usuario_valida":3,
						"id_norma":1,
						"id_tipo_muestreo":1,
						"total":0,
						"cliente":
						{
							"id_cliente":1,
							"id_organismo":1,
							"cliente":"CEA Jalisco",
							"area":"Dirección de Operación de PTARS",
							"rfc":"Registro Federal de Contribuyentes",
							"calle":"Av. Brasilia",
							"numero":"2970",
							"colonia":"Col. Colomos Providencia",
							"cp":"44680",
							"id_estado":14,
							"id_municipio":14039,
							"municipio":"Guadalajara",
							"id_localidad":140390001,
							"localidad":"Guadalajara",
							"tel":"3030-9350 ext. 8370",
							"fax":"",
							"contacto":"Biol. Luis Aceves Martínez",
							"puesto_contacto":"puesto contacto",
							"email":"laceves@ceajalisco.gob.mx",
							"fecha_act":"23/11/2014",
							"interno":1,
							"cea":1,
							"tasa":0,
							"activo":1
						},
						"descripcion_servicio":"Servicio de muestreo y análisis, para verificar el cumplimiento de la norma NOM-001-SEMARNAT-1996, que establece los límites máximos permisibles de contaminantes en las descargas de aguas residuales a los sistemas de alcantarillado urbano o municipal. -auto",
						"notas":"La presente cotización se realiza sin visita previa y se contempla un fácil y seguro acceso para la toma de muestras. Se requiere regresar esta cotización con la firma y sello de Aceptación del Servicio. -auto",
						"condiciones":"El informe de resultados se entregará a los 10 días hábiles de haber ingresado las muestras al laboratorio. El pago de resultados se hará en las instalaciones del Laboratorio de Calidad del Agua de la CEA, así también mediante depósito bancario a la cuenta: 884371445 de la Institución Bancaria BANORTE a nombre de la Comisión Estatal del Agua de Jalisco o por transferencia electrónica, cuenta interbancaria: 072320008843714454. -auto",
						"captura":{
							"id_usuario":1,
							"nombre":"Usuario captura",
							"puesto":"puesto Usuario captura"
						},
						"valida":{
							"id_empleado":3,
							"nombre":"Gerente que valida",
							"puesto":"puesto Usuario valida"
						},
						"norma":{
							"id_norma":1,
							"norma":"NOM-001-SEMARNAT-1996",
							"desc":"Norma Oficial Mexicana",
							"parametros":[
								{
									"id_parametro":25,
									"parametro":"Arsénico",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":27,
									"parametro":"Cadmio",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":28,
									"parametro":"Cobre",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":38,
									"parametro":"Coliformes fecales",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":29,
									"parametro":"Cromo",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":16,
									"parametro":"Demada bioquímica de oxígeno",
									"cert":0,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":19,
									"parametro":"Fósforo total",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":18,
									"parametro":"Grasas y aceites",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":6,
									"parametro":"Alcalinidad total",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":39,
									"parametro":"Materia flotante",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":32,
									"parametro":"Mercurio",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":7,
									"parametro":"Cloruros totales",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":33,
									"parametro":"Níquel",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":2,
									"parametro":"Potencial de hidrógeno",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":34,
									"parametro":"Plomo",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":22,
									"parametro":"Sólidos sedimentables",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":20,
									"parametro":"Sólidos suspendidos totales",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":1,
									"parametro":"Temperatura",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":36,
									"parametro":"Zinc",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								}
							]
						},
						"actividades":[
							{
								"id_actividad":1,
								"actividad":"Muestreo instantáneo",
								"id_metodo":87,
								"metodo":{
									"id_metodo":87,
									"metodo":"metodo para muestreo instantáneo"
								},
								"cantidad":1,
								"precio":0
							}
						],
						"tipo_muestreo":
						{
							"id_tipo_muestreo":1,
							"tipo_muestreo":"Simple"
						}
					},
					"parametros":
					[
						{
							"id_parametro":25,
							"parametro":"Arsénico",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":27,
							"parametro":"Cadmio",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":28,
							"parametro":"Cobre",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":38,
							"parametro":"Coliformes fecales",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":29,
							"parametro":"Cromo",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":16,
							"parametro":"Demada bioquímica de oxígeno",
							"cert":0,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":19,
							"parametro":"Fósforo total",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":18,
							"parametro":"Grasas y aceites",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":6,
							"parametro":"Alcalinidad total",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":39,
							"parametro":"Materia flotante",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":32,
							"parametro":"Mercurio",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":7,
							"parametro":"Cloruros totales",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":33,
							"parametro":"Níquel",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":2,
							"parametro":"Potencial de hidrógeno",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":34,
							"parametro":"Plomo",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":22,
							"parametro":"Sólidos sedimentables",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":20,
							"parametro":"Sólidos suspendidos totales",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":1,
							"parametro":"Temperatura",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						},
						{
							"id_parametro":36,
							"parametro":"Zinc",
							"cert":1,
							"id_metodo":1,
							"metodo_ensayo":"NMX-AA-000-0000",
							"cantidad":1,
							"precio":164.65
						}
					],
					"matriz":
					{
						"id_matriz":3,
						"matriz":"Agua Residual Tratada"
					},
					"tipo_muestreo":
					{
						"id_tipo_muestreo":1,
						"tipo_muestreo":"Simple"
					},
					"supervisor_orden":
					{
						"id_supervisor_orden":2,
						"id_empleado":1,
						"id_nivel":1,
						"id_area":5,
						"area":"Administrativo",
						"id_puesto":1,
						"puesto":"Gerente de Laboratorio",
						"nombres":"Reyna",
						"ap":"García",
						"am":"Meneses",
						"fecha_act":"2014-11-30",
						"calidad":0,
						"supervisa":1,
						"analiza":1,
						"muestrea":1,
						"cert":1,
						"activo":1
					},
					"supervisor_muestreo":
					{
						"id_supervisor_muestreo":2,
						"id_empleado":3,
						"id_nivel":3,
						"id_area":2,
						"area":"Metales Pesados",
						"id_puesto":4,
						"puesto":"Supervisor (MP)",
						"nombres":"Marín",
						"ap":"Gomar",
						"am":"Sosa",
						"fecha_act":"2014-11-30",
						"calidad":0,
						"supervisa":1,
						"analiza":1,
						"muestrea":1,
						"cert":1,
						"activo":1
					},
					"norma":
					{
						"id_norma":1,
						"norma":"NOM-001-SEMARNAT-1996",
						"desc":"Norma Oficial Mexicana",
						"parametros":[
							{
								"id_parametro":25,
								"parametro":"Arsénico",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":27,
								"parametro":"Cadmio",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":28,
								"parametro":"Cobre",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":38,
								"parametro":"Coliformes fecales",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":29,
								"parametro":"Cromo",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":16,
								"parametro":"Demada bioquímica de oxígeno",
								"cert":0,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":19,
								"parametro":"Fósforo total",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":18,
								"parametro":"Grasas y aceites",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":6,
								"parametro":"Alcalinidad total",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":39,
								"parametro":"Materia flotante",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":32,
								"parametro":"Mercurio",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":7,
								"parametro":"Cloruros totales",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":33,
								"parametro":"Níquel",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":2,
								"parametro":"Potencial de hidrógeno",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":34,
								"parametro":"Plomo",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":22,
								"parametro":"Sólidos sedimentables",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":20,
								"parametro":"Sólidos suspendidos totales",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":1,
								"parametro":"Temperatura",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":36,
								"parametro":"Zinc",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							}
						]
					}
				}
			]
		';
		return $result;
	}

	public function getPlan($planId) {
		//$sql = "SELECT
		//		*
		//	FROM
		//		plan
		//	WHERE id_plan := $planId AND activo = 1";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		if ($planId == 1) {
			$result = '
				{
					"id_plan":1,
					"id_cliente":1,
					"id_solicitud":1,
					"id_orden":1,
					"id_tipo_muestreo":2,
					"id_objetivo_plan":2,
					"id_estado":14,
					"id_municipio":14039,
					"id_localidad":140390001,
					"id_supervisor_muestreo":2,
					"id_supervisor_recoleccion":2,
					"id_supervisor_registro":2,
					"id_supervisor_calibracion":2,
					"id_supervisor_recipientes":2,
					"id_supervisor_reactivos":2,
					"numero_oficio":437,
					"id_ejercicio":2014,
					"folio":"CEA-437/2014",
					"fecha_captura":"2015-02-06",
					"fecha_plan":"2014-11-06",
					"fecha_calibracion":"2015-02-06",
					"fecha_valida":"",
					"objetivo_otro":"",
					"municipio":"Guadalajara",
					"localidad":"Guadalajara",
					"calle":"Av. Brasilia",
					"numero":"2970",
					"colonia":"Col. Colomos Providencia",
					"asistente_muestreo":"",
					"asistente_recoleccion":"",
					"asistente_registro":"",
					"tipo_muestreo":"Compuesto",
					"fecha_actualiza":"2015-02-06",
					"validado":1,
					"activo":1,
					"puntos_muestreo":
					[
						{
							"id_punto_muestreo":"1",
							"punto_muestreo":"Ocotlán",
							"descripcion":"Ocotlán",
							"id_municipio":"14063",
							"municipio":"municipio 14063",
							"id_localidad":"140630001",
							"localidad":"localidad 140630001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia":0,
							"activo":1,
							"selected":false,
							"lat":20.346928,
							"lng":-102.779392,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":1,
							"siglas":"RS",
							"clave":"RS-01",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"2",
							"punto_muestreo":"Presa Corona",
							"descripcion":"Cortina Presa Corona - Poncitlán",
							"id_municipio":"14030",
							"municipio":"municipio 14030",
							"id_localidad":"140300038",
							"localidad":"localidad 140300038",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.399667,
							"lng":-103.090619,
							"alt":0,
							"idRegHid":0,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":2,
							"siglas":"RS",
							"clave":"RS-02",
							"fecha":"2013-01-31 12:44:51.860",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"3",
							"punto_muestreo":"Ex-hacienda Zap.",
							"descripcion":"Ex-hacienda de Zapotlanejo",
							"id_municipio":"14051",
							"municipio":"municipio 14051",
							"id_localidad":"140510013",
							"localidad":"localidad 140510013",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.442003,
							"lng":-103.143814,
							"alt":0,
							"idRegHid":0,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":3,
							"siglas":"RS",
							"clave":"RS-03",
							"fecha":"2013-01-31 12:39:11.093",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"4",
							"punto_muestreo":"Salto-Juanacatlán",
							"descripcion":"Compuerta - Puente El Salto-Juanacatlán",
							"id_municipio":"14051",
							"municipio":"municipio 14051",
							"id_localidad":"140510001",
							"localidad":"localidad 140510001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.512825,
							"lng":-103.174558,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":4,
							"siglas":"RS",
							"clave":"RS-04",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"5",
							"punto_muestreo":"Puente Grande",
							"descripcion":"Puente Grande",
							"id_municipio":"14101",
							"municipio":"municipio 14101",
							"id_localidad":"141010026",
							"localidad":"localidad 141010026",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.571036,
							"lng":-103.147283,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":5,
							"siglas":"RS",
							"clave":"RS-05",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"6",
							"punto_muestreo":"Matatlán",
							"descripcion":"Vertedero Controlado Matatlán",
							"id_municipio":"14101",
							"municipio":"municipio 14101",
							"id_localidad":"141010009",
							"localidad":"localidad 141010009",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.668289,
							"lng":-103.187169,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":6,
							"siglas":"RS",
							"clave":"RS-06",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"7",
							"punto_muestreo":"Paso de Gpe.",
							"descripcion":"Paso de Guadalupe",
							"id_municipio":"14045",
							"municipio":"municipio 14045",
							"id_localidad":"140450079",
							"localidad":"localidad 140450079",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.839097,
							"lng":-103.328972,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":7,
							"siglas":"RS",
							"clave":"RS-07",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"8",
							"punto_muestreo":"Cristóbal de la B.",
							"descripcion":"San Cristóbal de la Barranca",
							"id_municipio":"14071",
							"municipio":"municipio 14071",
							"id_localidad":"140710001",
							"localidad":"localidad 140710001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":21.038356,
							"lng":-103.426036,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":8,
							"siglas":"RS",
							"clave":"RS-08",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"9",
							"punto_muestreo":"Camino Salvador",
							"descripcion":"Camino al Salvador - Tequila",
							"id_municipio":"14094",
							"municipio":"municipio 14094",
							"id_localidad":"140050001",
							"localidad":"localidad 140050001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.912106,
							"lng":-103.711964,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":9,
							"siglas":"RS",
							"clave":"RS-09",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"10",
							"punto_muestreo":"Paso La Yesca",
							"descripcion":"Paso La Yesca",
							"id_municipio":"14040",
							"municipio":"municipio 14040",
							"id_localidad":"140400053",
							"localidad":"localidad 140400053",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":21.190106,
							"lng":-104.073053,
							"alt":0,
							"idRegHid":0,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":10,
							"siglas":"RS",
							"clave":"RS-10",
							"fecha":"2013-01-31 11:56:53.347",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"11",
							"punto_muestreo":"Carr. Chapala",
							"descripcion":"Carretera a Chapala antes de Aeropuerto",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140700043",
							"localidad":"localidad 140700043",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.537825,
							"lng":-103.296703,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":1,
							"siglas":"AA",
							"clave":"AA-01",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"12",
							"punto_muestreo":"El Muelle",
							"descripcion":"Puente localidad El Muelle",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140700011",
							"localidad":"localidad 140700011",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.497869,
							"lng":-103.216722,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":2,
							"siglas":"AA",
							"clave":"AA-02",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"13",
							"punto_muestreo":"Río Zula",
							"descripcion":"Puente Carretera Guadalajara - La Barca",
							"id_municipio":"14063",
							"municipio":"municipio 14063",
							"id_localidad":"140630001",
							"localidad":"localidad 140630001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.34455,
							"lng":-102.774767,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":1,
							"siglas":"RZ",
							"clave":"RZ-01",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						}
					],
					"cliente":
					{
						"id_cliente":1,
						"id_organismo":1,
						"cliente":"CEA Jalisco",
						"area":"Dirección de Operación de PTARS",
						"rfc":"Registro Federal de Contribuyentes",
						"calle":"Av. Brasilia",
						"numero":"2970",
						"colonia":"Col. Colomos Providencia",
						"cp":"44680",
						"id_estado":14,
						"id_municipio":14039,
						"municipio":"Guadalajara",
						"id_localidad":140390001,
						"localidad":"Guadalajara",
						"tel":"3030-9350 ext. 8370",
						"fax":"",
						"contacto":"Biol. Luis Aceves Martínez",
						"puesto_contacto":"puesto contacto",
						"email":"laceves@ceajalisco.gob.mx",
						"fecha_act":"23/11/2014",
						"interno":1,
						"cea":1,
						"tasa":0,
						"activo":1
					},
					"orden":
					{
						"id_orden":1,
						"numero_oficio":656,
						"id_ejercicio":2014,
						"folio":"CEA-656/2014",
						"fecha_captura":"2014-11-01",
						"fecha_valida":"2914-11-02",
						"fecha_muestreo":"2014-11-04",
						"hora_muestreo":"9:25",
						"fecha_actualiza":"2014-11-01",
						"validado":0,
						"aceptado":0,
						"id_origen_orden":1,
						"origen_orden":
						{
							"id_origen_orden":2,
							"origen_orden":"Cotización"
						},
						"emergencia":"",
						"id_cliente":1,
						"cliente":
						{
							"id_cliente":1,
							"id_organismo":1,
							"cliente":"CEA Jalisco",
							"area":"Dirección de Operación de PTARS",
							"rfc":"Registro Federal de Contribuyentes",
							"calle":"Av. Brasilia",
							"numero":"2970",
							"colonia":"Col. Colomos Providencia",
							"cp":"44680",
							"id_estado":14,
							"id_municipio":14039,
							"municipio":"Guadalajara",
							"id_localidad":140390001,
							"localidad":"Guadalajara",
							"tel":"3030-9350 ext. 8370",
							"fax":"",
							"contacto":"Biol. Luis Aceves Martínez",
							"puesto_contacto":"puesto contacto",
							"email":"laceves@ceajalisco.gob.mx",
							"fecha_act":"23/11/2014",
							"interno":1,
							"cea":1,
							"tasa":0,
							"activo":1
						},
						"id_plan":1,
						"id_supervisor_muestreo":2,
						"supervisor_muestreo":
						{
							"id_supervisor_muestreo":2,
							"id_empleado":3,
							"id_nivel":3,
							"id_area":2,
							"area":"Metales Pesados",
							"id_puesto":4,
							"puesto":"Supervisor (MP)",
							"nombres":"Marín",
							"ap":"Gomar",
							"am":"Sosa",
							"fecha_act":"2014-11-30",
							"calidad":0,
							"supervisa":1,
							"analiza":1,
							"muestrea":1,
							"cert":1,
							"activo":1
						},
						"id_supervisor_custodia":4,
						"id_solicitud":1,
						"solicitud":
						{
							"id_solicitud":1,
							"numero_oficio":432,
							"id_ejercicio":2014,
							"folio":"CEA-432/2014",
							"fecha_solicitud":"2015-03-21",
							"fecha_captura":"2015-03-21",
							"fecha_valida":null,
							"fecha_acepta":null,
							"fecha_actualiza":"2015-03-21",
							"validado":0,
							"id_cliente":1,
							"id_usuario_captura":1,
							"id_usuario_valida":3,
							"id_norma":1,
							"id_tipo_muestreo":1,
							"total":0,
							"cliente":
							{
								"id_cliente":1,
								"id_organismo":1,
								"cliente":"CEA Jalisco",
								"area":"Dirección de Operación de PTARS",
								"rfc":"Registro Federal de Contribuyentes",
								"calle":"Av. Brasilia",
								"numero":"2970",
								"colonia":"Col. Colomos Providencia",
								"cp":"44680",
								"id_estado":14,
								"id_municipio":14039,
								"municipio":"Guadalajara",
								"id_localidad":140390001,
								"localidad":"Guadalajara",
								"tel":"3030-9350 ext. 8370",
								"fax":"",
								"contacto":"Biol. Luis Aceves Martínez",
								"puesto_contacto":"puesto contacto",
								"email":"laceves@ceajalisco.gob.mx",
								"fecha_act":"23/11/2014",
								"interno":1,
								"cea":1,
								"tasa":0,
								"activo":1
							},
							"descripcion_servicio":"Servicio de muestreo y análisis, para verificar el cumplimiento de la norma NOM-001-SEMARNAT-1996, que establece los límites máximos permisibles de contaminantes en las descargas de aguas residuales a los sistemas de alcantarillado urbano o municipal. -auto",
							"notas":"La presente cotización se realiza sin visita previa y se contempla un fácil y seguro acceso para la toma de muestras. Se requiere regresar esta cotización con la firma y sello de Aceptación del Servicio. -auto",
							"condiciones":"El informe de resultados se entregará a los 10 días hábiles de haber ingresado las muestras al laboratorio. El pago de resultados se hará en las instalaciones del Laboratorio de Calidad del Agua de la CEA, así también mediante depósito bancario a la cuenta: 884371445 de la Institución Bancaria BANORTE a nombre de la Comisión Estatal del Agua de Jalisco o por transferencia electrónica, cuenta interbancaria: 072320008843714454. -auto",
							"captura":{
								"id_usuario":1,
								"nombre":"Usuario captura",
								"puesto":"puesto Usuario captura"
							},
							"valida":{
								"id_empleado":3,
								"nombre":"Gerente que valida",
								"puesto":"puesto Usuario valida"
							},
							"norma":{
								"id_norma":1,
								"norma":"NOM-001-SEMARNAT-1996",
								"desc":"Norma Oficial Mexicana",
								"parametros":[
									{
										"id_parametro":25,
										"parametro":"Arsénico",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":27,
										"parametro":"Cadmio",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":28,
										"parametro":"Cobre",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":38,
										"parametro":"Coliformes fecales",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":29,
										"parametro":"Cromo",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":16,
										"parametro":"Demada bioquímica de oxígeno",
										"cert":0,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":19,
										"parametro":"Fósforo total",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":18,
										"parametro":"Grasas y aceites",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":6,
										"parametro":"Alcalinidad total",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":39,
										"parametro":"Materia flotante",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":32,
										"parametro":"Mercurio",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":7,
										"parametro":"Cloruros totales",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":33,
										"parametro":"Níquel",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":2,
										"parametro":"Potencial de hidrógeno",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":34,
										"parametro":"Plomo",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":22,
										"parametro":"Sólidos sedimentables",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":20,
										"parametro":"Sólidos suspendidos totales",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":1,
										"parametro":"Temperatura",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":36,
										"parametro":"Zinc",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									}
								]
							},
							"actividades":[
								{
									"id_actividad":1,
									"actividad":"Muestreo instantáneo",
									"id_metodo":87,
									"metodo":{
										"id_metodo":87,
										"metodo":"metodo para muestreo instantáneo"
									},
									"cantidad":1,
									"precio":0
								}
							],
							"tipo_muestreo":
							{
								"id_tipo_muestreo":1,
								"tipo_muestreo":"Simple"
							}
						},
						"parametros":
						[
							{
								"id_parametro":25,
								"parametro":"Arsénico",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":27,
								"parametro":"Cadmio",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":28,
								"parametro":"Cobre",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":38,
								"parametro":"Coliformes fecales",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":29,
								"parametro":"Cromo",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":16,
								"parametro":"Demada bioquímica de oxígeno",
								"cert":0,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":19,
								"parametro":"Fósforo total",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":18,
								"parametro":"Grasas y aceites",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":6,
								"parametro":"Alcalinidad total",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":39,
								"parametro":"Materia flotante",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":32,
								"parametro":"Mercurio",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":7,
								"parametro":"Cloruros totales",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":33,
								"parametro":"Níquel",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":2,
								"parametro":"Potencial de hidrógeno",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":34,
								"parametro":"Plomo",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":22,
								"parametro":"Sólidos sedimentables",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":20,
								"parametro":"Sólidos suspendidos totales",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":1,
								"parametro":"Temperatura",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":36,
								"parametro":"Zinc",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							}
						],
						"id_matriz":3,
						"matriz":
						{
							"id_matriz":3,
							"matriz":"Agua Residual Tratada"
						},
						"id_tipo_muestreo":1,
						"tipo_muestreo":
						{
							"id_tipo_muestreo":1,
							"tipo_muestreo":"Simple"
						},
						"id_origen_muestreo":1,
						"origen_muestreo":"Agua",
						"id_emite_orden":1,
						"emite_orden":"Nombre del gerente",
						"id_supervisor_muestreo":2,
						"supervisor_muestreo":
						{
							"id_supervisor_muestreo":2,
							"id_empleado":3,
							"id_nivel":3,
							"id_area":2,
							"area":"Metales Pesados",
							"id_puesto":4,
							"puesto":"Supervisor (MP)",
							"nombres":"Marín",
							"ap":"Gomar",
							"am":"Sosa",
							"fecha_act":"2014-11-30",
							"calidad":0,
							"supervisa":1,
							"analiza":1,
							"muestrea":1,
							"cert":1,
							"activo":1
						},
						"id_norma":1,
						"norma":{
							"id_norma":1,
							"norma":"NOM-001-SEMARNAT-1996",
							"desc":"Norma Oficial Mexicana",
							"parametros":[
								{
									"id_parametro":25,
									"parametro":"Arsénico",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":27,
									"parametro":"Cadmio",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":28,
									"parametro":"Cobre",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":38,
									"parametro":"Coliformes fecales",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":29,
									"parametro":"Cromo",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":16,
									"parametro":"Demada bioquímica de oxígeno",
									"cert":0,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":19,
									"parametro":"Fósforo total",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":18,
									"parametro":"Grasas y aceites",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":6,
									"parametro":"Alcalinidad total",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":39,
									"parametro":"Materia flotante",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":32,
									"parametro":"Mercurio",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":7,
									"parametro":"Cloruros totales",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":33,
									"parametro":"Níquel",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":2,
									"parametro":"Potencial de hidrógeno",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":34,
									"parametro":"Plomo",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":22,
									"parametro":"Sólidos sedimentables",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":20,
									"parametro":"Sólidos suspendidos totales",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":1,
									"parametro":"Temperatura",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":36,
									"parametro":"Zinc",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								}
							]
						}
					},
					"equipos":
					[
						{
							"id_equipo":1,
							"descripcion":"Descripcion equipo",
							"inventario":"IE-MU-001",
							"bitacora":"BU-AA-001",
							"numero_oficio":1,
							"id_ejercicio":2015,
							"folio":"CEA-1/2015",
							"activo":1
						},
						{
							"id_equipo":2,
							"descripcion":"Descripcion equipo",
							"inventario":"IE-MU-002",
							"bitacora":"BU-AA-002",
							"numero_oficio":2,
							"id_ejercicio":2015,
							"folio":"CEA-2/2015",
							"activo":1
						},
						{
							"id_equipo":3,
							"descripcion":"Descripcion equipo",
							"inventario":"IE-MU-003",
							"bitacora":"BU-AA-003",
							"numero_oficio":3,
							"id_ejercicio":2015,
							"folio":"CEA-3/2015",
							"activo":1
						},
						{
							"id_equipo":4,
							"descripcion":"Descripcion equipo",
							"inventario":"IE-MU-004",
							"bitacora":"BU-AA-004",
							"numero_oficio":4,
							"id_ejercicio":2015,
							"folio":"CEA-4/2015",
							"activo":1
						}
					],
					"recipientes":
					[
						{
							"id_recipiente":1,
							"id_preservacion":1,
							"cantidad":0,
							"numero_oficio":1,
							"id_ejercicio":2015,
							"folio":"CEA-1/2015",
							"activo":1
						},
						{
							"id_recipiente":2,
							"id_preservacion":2,
							"cantidad":0,
							"numero_oficio":2,
							"id_ejercicio":2015,
							"folio":"CEA-2/2015",
							"activo":1
						},
						{
							"id_recipiente":3,
							"id_preservacion":3,
							"cantidad":0,
							"numero_oficio":3,
							"id_ejercicio":2015,
							"folio":"CEA-3/2015",
							"activo":1
						},
						{
							"id_recipiente":4,
							"id_preservacion":4,
							"cantidad":0,
							"numero_oficio":4,
							"id_ejercicio":2015,
							"folio":"CEA-4/2015",
							"activo":1
						}
					],
					"reactivos":
					[
						{
							"id_reactivo":1,
							"reactivo":"Reactivo 1",
							"cantidad":0,
							"lote":"Lote reactivo 1",
							"selected":false
						}
					],
					"materiales":
					[
					],
					"hieleras":
					[
					]
				}
			';
		}
		else {
			$result = '
				{
					"id_plan":0,
					"id_cliente":0,
					"id_solicitud":0,
					"id_orden":0,
					"id_tipo_muestreo":0,
					"id_objetivo_plan":0,
					"id_estado":14,
					"id_municipio":14039,
					"id_localidad":140390001,
					"id_supervisor_muestreo":0,
					"id_supervisor_recoleccion":0,
					"id_supervisor_registro":0,
					"id_supervisor_calibracion":0,
					"id_supervisor_recipientes":0,
					"id_supervisor_reactivos":0,
					"numero_oficio":0,
					"id_ejercicio":0,
					"folio":"CEA-0/0",
					"fecha_captura":"",
					"fecha_plan":"",
					"fecha_calibracion":"",
					"fecha_valida":"",
					"objetivo_otro":"",
					"municipio":"",
					"localidad":"",
					"calle":"",
					"numero":"",
					"colonia":"",
					"asistente_muestreo":"",
					"asistente_recoleccion":"",
					"asistente_registro":"",
					"tipo_muestreo":"",
					"fecha_actualiza":"",
					"validado":0,
					"activo":0,
					"puntos_muestreo":
					[
					],
					"cliente":
					{

					},
					"orden":
					{

					},
					"equipos":
					[

					],
					"recipientes":
					[

					],
					"reactivos":
					[

					],
					"materiales":
					[

					],
					"hieleras":
					[

					]
				}
			';
		}
		return $result;
	}

	public function getPlans() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		plan";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_plan":1,
					"id_cliente":1,
					"id_solicitud":1,
					"id_orden":1,
					"id_tipo_muestreo":2,
					"id_objetivo_plan":2,
					"id_estado":14,
					"id_municipio":14039,
					"id_localidad":140390001,
					"id_supervisor_muestreo":2,
					"id_supervisor_recoleccion":2,
					"id_supervisor_registro":2,
					"id_supervisor_calibracion":2,
					"id_supervisor_recipientes":2,
					"id_supervisor_reactivos":2,
					"numero_oficio":437,
					"id_ejercicio":2014,
					"folio":"CEA-437/2014",
					"fecha_captura":"2015-02-06",
					"fecha_plan":"2014-11-06",
					"fecha_calibracion":"2015-02-06",
					"fecha_valida":"",
					"objetivo_otro":"",
					"municipio":"Guadalajara",
					"localidad":"Guadalajara",
					"calle":"Av. Brasilia",
					"numero":"2970",
					"colonia":"Col. Colomos Providencia",
					"asistente_muestreo":"",
					"asistente_recoleccion":"",
					"asistente_registro":"",
					"tipo_muestreo":"Compuesto",
					"fecha_actualiza":"2015-02-06",
					"validado":1,
					"activo":1,
					"puntos_muestreo":
					[
						{
							"id_punto_muestreo":"1",
							"punto_muestreo":"Ocotlán",
							"descripcion":"Ocotlán",
							"id_municipio":"14063",
							"municipio":"municipio 14063",
							"id_localidad":"140630001",
							"localidad":"localidad 140630001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia":0,
							"activo":1,
							"selected":false,
							"lat":20.346928,
							"lng":-102.779392,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":1,
							"siglas":"RS",
							"clave":"RS-01",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"2",
							"punto_muestreo":"Presa Corona",
							"descripcion":"Cortina Presa Corona - Poncitlán",
							"id_municipio":"14030",
							"municipio":"municipio 14030",
							"id_localidad":"140300038",
							"localidad":"localidad 140300038",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.399667,
							"lng":-103.090619,
							"alt":0,
							"idRegHid":0,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":2,
							"siglas":"RS",
							"clave":"RS-02",
							"fecha":"2013-01-31 12:44:51.860",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"3",
							"punto_muestreo":"Ex-hacienda Zap.",
							"descripcion":"Ex-hacienda de Zapotlanejo",
							"id_municipio":"14051",
							"municipio":"municipio 14051",
							"id_localidad":"140510013",
							"localidad":"localidad 140510013",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.442003,
							"lng":-103.143814,
							"alt":0,
							"idRegHid":0,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":3,
							"siglas":"RS",
							"clave":"RS-03",
							"fecha":"2013-01-31 12:39:11.093",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"4",
							"punto_muestreo":"Salto-Juanacatlán",
							"descripcion":"Compuerta - Puente El Salto-Juanacatlán",
							"id_municipio":"14051",
							"municipio":"municipio 14051",
							"id_localidad":"140510001",
							"localidad":"localidad 140510001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.512825,
							"lng":-103.174558,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":4,
							"siglas":"RS",
							"clave":"RS-04",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"5",
							"punto_muestreo":"Puente Grande",
							"descripcion":"Puente Grande",
							"id_municipio":"14101",
							"municipio":"municipio 14101",
							"id_localidad":"141010026",
							"localidad":"localidad 141010026",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.571036,
							"lng":-103.147283,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":5,
							"siglas":"RS",
							"clave":"RS-05",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"6",
							"punto_muestreo":"Matatlán",
							"descripcion":"Vertedero Controlado Matatlán",
							"id_municipio":"14101",
							"municipio":"municipio 14101",
							"id_localidad":"141010009",
							"localidad":"localidad 141010009",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.668289,
							"lng":-103.187169,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":6,
							"siglas":"RS",
							"clave":"RS-06",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"7",
							"punto_muestreo":"Paso de Gpe.",
							"descripcion":"Paso de Guadalupe",
							"id_municipio":"14045",
							"municipio":"municipio 14045",
							"id_localidad":"140450079",
							"localidad":"localidad 140450079",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.839097,
							"lng":-103.328972,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":7,
							"siglas":"RS",
							"clave":"RS-07",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"8",
							"punto_muestreo":"Cristóbal de la B.",
							"descripcion":"San Cristóbal de la Barranca",
							"id_municipio":"14071",
							"municipio":"municipio 14071",
							"id_localidad":"140710001",
							"localidad":"localidad 140710001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":21.038356,
							"lng":-103.426036,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":8,
							"siglas":"RS",
							"clave":"RS-08",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"9",
							"punto_muestreo":"Camino Salvador",
							"descripcion":"Camino al Salvador - Tequila",
							"id_municipio":"14094",
							"municipio":"municipio 14094",
							"id_localidad":"140050001",
							"localidad":"localidad 140050001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.912106,
							"lng":-103.711964,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":9,
							"siglas":"RS",
							"clave":"RS-09",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"10",
							"punto_muestreo":"Paso La Yesca",
							"descripcion":"Paso La Yesca",
							"id_municipio":"14040",
							"municipio":"municipio 14040",
							"id_localidad":"140400053",
							"localidad":"localidad 140400053",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":21.190106,
							"lng":-104.073053,
							"alt":0,
							"idRegHid":0,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":10,
							"siglas":"RS",
							"clave":"RS-10",
							"fecha":"2013-01-31 11:56:53.347",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"11",
							"punto_muestreo":"Carr. Chapala",
							"descripcion":"Carretera a Chapala antes de Aeropuerto",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140700043",
							"localidad":"localidad 140700043",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.537825,
							"lng":-103.296703,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":1,
							"siglas":"AA",
							"clave":"AA-01",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"12",
							"punto_muestreo":"El Muelle",
							"descripcion":"Puente localidad El Muelle",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140700011",
							"localidad":"localidad 140700011",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.497869,
							"lng":-103.216722,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":2,
							"siglas":"AA",
							"clave":"AA-02",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						},
						{
							"id_punto_muestreo":"13",
							"punto_muestreo":"Río Zula",
							"descripcion":"Puente Carretera Guadalajara - La Barca",
							"id_municipio":"14063",
							"municipio":"municipio 14063",
							"id_localidad":"140630001",
							"localidad":"localidad 140630001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.34455,
							"lng":-102.774767,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":1,
							"siglas":"RZ",
							"clave":"RZ-01",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
						}
					],
					"cliente":
					{
						"id_cliente":1,
						"id_organismo":1,
						"cliente":"CEA Jalisco",
						"area":"Dirección de Operación de PTARS",
						"rfc":"Registro Federal de Contribuyentes",
						"calle":"Av. Brasilia",
						"numero":"2970",
						"colonia":"Col. Colomos Providencia",
						"cp":"44680",
						"id_estado":14,
						"id_municipio":14039,
						"municipio":"Guadalajara",
						"id_localidad":140390001,
						"localidad":"Guadalajara",
						"tel":"3030-9350 ext. 8370",
						"fax":"",
						"contacto":"Biol. Luis Aceves Martínez",
						"puesto_contacto":"puesto contacto",
						"email":"laceves@ceajalisco.gob.mx",
						"fecha_act":"23/11/2014",
						"interno":1,
						"cea":1,
						"tasa":0,
						"activo":1
					},
					"orden":
					{
						"id_orden":1,
						"numero_oficio":656,
						"id_ejercicio":2014,
						"folio":"CEA-656/2014",
						"fecha_captura":"2014-11-01",
						"fecha_valida":"2914-11-02",
						"fecha_muestreo":"2014-11-04",
						"hora_muestreo":"9:25",
						"fecha_actualiza":"2014-11-01",
						"validado":0,
						"aceptado":0,
						"id_origen_orden":1,
						"origen_orden":
						{
							"id_origen_orden":2,
							"origen_orden":"Cotización"
						},
						"emergencia":"",
						"id_cliente":1,
						"cliente":
						{
							"id_cliente":1,
							"id_organismo":1,
							"cliente":"CEA Jalisco",
							"area":"Dirección de Operación de PTARS",
							"rfc":"Registro Federal de Contribuyentes",
							"calle":"Av. Brasilia",
							"numero":"2970",
							"colonia":"Col. Colomos Providencia",
							"cp":"44680",
							"id_estado":14,
							"id_municipio":14039,
							"municipio":"Guadalajara",
							"id_localidad":140390001,
							"localidad":"Guadalajara",
							"tel":"3030-9350 ext. 8370",
							"fax":"",
							"contacto":"Biol. Luis Aceves Martínez",
							"puesto_contacto":"puesto contacto",
							"email":"laceves@ceajalisco.gob.mx",
							"fecha_act":"23/11/2014",
							"interno":1,
							"cea":1,
							"tasa":0,
							"activo":1
						},
						"id_plan":1,
						"id_supervisor_muestreo":2,
						"supervisor_muestreo":
						{
							"id_supervisor_muestreo":2,
							"id_empleado":3,
							"id_nivel":3,
							"id_area":2,
							"area":"Metales Pesados",
							"id_puesto":4,
							"puesto":"Supervisor (MP)",
							"nombres":"Marín",
							"ap":"Gomar",
							"am":"Sosa",
							"fecha_act":"2014-11-30",
							"calidad":0,
							"supervisa":1,
							"analiza":1,
							"muestrea":1,
							"cert":1,
							"activo":1
						},
						"id_supervisor_custodia":4,
						"id_solicitud":1,
						"solicitud":
						{
							"id_solicitud":1,
							"numero_oficio":432,
							"id_ejercicio":2014,
							"folio":"CEA-432/2014",
							"fecha_solicitud":"2015-03-21",
							"fecha_captura":"2015-03-21",
							"fecha_valida":null,
							"fecha_acepta":null,
							"fecha_actualiza":"2015-03-21",
							"validado":0,
							"id_cliente":1,
							"id_usuario_captura":1,
							"id_usuario_valida":3,
							"id_norma":1,
							"id_tipo_muestreo":1,
							"total":0,
							"cliente":
							{
								"id_cliente":1,
								"id_organismo":1,
								"cliente":"CEA Jalisco",
								"area":"Dirección de Operación de PTARS",
								"rfc":"Registro Federal de Contribuyentes",
								"calle":"Av. Brasilia",
								"numero":"2970",
								"colonia":"Col. Colomos Providencia",
								"cp":"44680",
								"id_estado":14,
								"id_municipio":14039,
								"municipio":"Guadalajara",
								"id_localidad":140390001,
								"localidad":"Guadalajara",
								"tel":"3030-9350 ext. 8370",
								"fax":"",
								"contacto":"Biol. Luis Aceves Martínez",
								"puesto_contacto":"puesto contacto",
								"email":"laceves@ceajalisco.gob.mx",
								"fecha_act":"23/11/2014",
								"interno":1,
								"cea":1,
								"tasa":0,
								"activo":1
							},
							"descripcion_servicio":"Servicio de muestreo y análisis, para verificar el cumplimiento de la norma NOM-001-SEMARNAT-1996, que establece los límites máximos permisibles de contaminantes en las descargas de aguas residuales a los sistemas de alcantarillado urbano o municipal. -auto",
							"notas":"La presente cotización se realiza sin visita previa y se contempla un fácil y seguro acceso para la toma de muestras. Se requiere regresar esta cotización con la firma y sello de Aceptación del Servicio. -auto",
							"condiciones":"El informe de resultados se entregará a los 10 días hábiles de haber ingresado las muestras al laboratorio. El pago de resultados se hará en las instalaciones del Laboratorio de Calidad del Agua de la CEA, así también mediante depósito bancario a la cuenta: 884371445 de la Institución Bancaria BANORTE a nombre de la Comisión Estatal del Agua de Jalisco o por transferencia electrónica, cuenta interbancaria: 072320008843714454. -auto",
							"captura":{
								"id_usuario":1,
								"nombre":"Usuario captura",
								"puesto":"puesto Usuario captura"
							},
							"valida":{
								"id_empleado":3,
								"nombre":"Gerente que valida",
								"puesto":"puesto Usuario valida"
							},
							"norma":{
								"id_norma":1,
								"norma":"NOM-001-SEMARNAT-1996",
								"desc":"Norma Oficial Mexicana",
								"parametros":[
									{
										"id_parametro":25,
										"parametro":"Arsénico",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":27,
										"parametro":"Cadmio",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":28,
										"parametro":"Cobre",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":38,
										"parametro":"Coliformes fecales",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":29,
										"parametro":"Cromo",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":16,
										"parametro":"Demada bioquímica de oxígeno",
										"cert":0,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":19,
										"parametro":"Fósforo total",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":18,
										"parametro":"Grasas y aceites",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":6,
										"parametro":"Alcalinidad total",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":39,
										"parametro":"Materia flotante",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":32,
										"parametro":"Mercurio",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":7,
										"parametro":"Cloruros totales",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":33,
										"parametro":"Níquel",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":2,
										"parametro":"Potencial de hidrógeno",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":34,
										"parametro":"Plomo",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":22,
										"parametro":"Sólidos sedimentables",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":20,
										"parametro":"Sólidos suspendidos totales",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":1,
										"parametro":"Temperatura",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":36,
										"parametro":"Zinc",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									}
								]
							},
							"actividades":[
								{
									"id_actividad":1,
									"actividad":"Muestreo instantáneo",
									"id_metodo":87,
									"metodo":{
										"id_metodo":87,
										"metodo":"metodo para muestreo instantáneo"
									},
									"cantidad":1,
									"precio":0
								}
							],
							"tipo_muestreo":
							{
								"id_tipo_muestreo":1,
								"tipo_muestreo":"Simple"
							}
						},
						"parametros":
						[
							{
								"id_parametro":25,
								"parametro":"Arsénico",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":27,
								"parametro":"Cadmio",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":28,
								"parametro":"Cobre",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":38,
								"parametro":"Coliformes fecales",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":29,
								"parametro":"Cromo",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":16,
								"parametro":"Demada bioquímica de oxígeno",
								"cert":0,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":19,
								"parametro":"Fósforo total",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":18,
								"parametro":"Grasas y aceites",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":6,
								"parametro":"Alcalinidad total",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":39,
								"parametro":"Materia flotante",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":32,
								"parametro":"Mercurio",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":7,
								"parametro":"Cloruros totales",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":33,
								"parametro":"Níquel",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":2,
								"parametro":"Potencial de hidrógeno",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":34,
								"parametro":"Plomo",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":22,
								"parametro":"Sólidos sedimentables",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":20,
								"parametro":"Sólidos suspendidos totales",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":1,
								"parametro":"Temperatura",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":36,
								"parametro":"Zinc",
								"cert":1,
								"id_metodo":1,
								"metodo_ensayo":"NMX-AA-000-0000",
								"cantidad":1,
								"precio":164.65
							}
						],
						"id_matriz":3,
						"matriz":
						{
							"id_matriz":3,
							"matriz":"Agua Residual Tratada"
						},
						"id_tipo_muestreo":1,
						"tipo_muestreo":
						{
							"id_tipo_muestreo":1,
							"tipo_muestreo":"Simple"
						},
						"id_origen_muestreo":1,
						"origen_muestreo":"Agua",
						"id_emite_orden":1,
						"emite_orden":"Nombre del gerente",
						"id_supervisor_muestreo":2,
						"supervisor_muestreo":
						{
							"id_supervisor_muestreo":2,
							"id_empleado":3,
							"id_nivel":3,
							"id_area":2,
							"area":"Metales Pesados",
							"id_puesto":4,
							"puesto":"Supervisor (MP)",
							"nombres":"Marín",
							"ap":"Gomar",
							"am":"Sosa",
							"fecha_act":"2014-11-30",
							"calidad":0,
							"supervisa":1,
							"analiza":1,
							"muestrea":1,
							"cert":1,
							"activo":1
						},
						"id_norma":1,
						"norma":{
							"id_norma":1,
							"norma":"NOM-001-SEMARNAT-1996",
							"desc":"Norma Oficial Mexicana",
							"parametros":[
								{
									"id_parametro":25,
									"parametro":"Arsénico",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":27,
									"parametro":"Cadmio",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":28,
									"parametro":"Cobre",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":38,
									"parametro":"Coliformes fecales",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":29,
									"parametro":"Cromo",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":16,
									"parametro":"Demada bioquímica de oxígeno",
									"cert":0,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":19,
									"parametro":"Fósforo total",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":18,
									"parametro":"Grasas y aceites",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":6,
									"parametro":"Alcalinidad total",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":39,
									"parametro":"Materia flotante",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":32,
									"parametro":"Mercurio",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":7,
									"parametro":"Cloruros totales",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":33,
									"parametro":"Níquel",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":2,
									"parametro":"Potencial de hidrógeno",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":34,
									"parametro":"Plomo",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":22,
									"parametro":"Sólidos sedimentables",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":20,
									"parametro":"Sólidos suspendidos totales",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":1,
									"parametro":"Temperatura",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":36,
									"parametro":"Zinc",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								}
							]
						}
					},
					"equipos":
					[
						{
							"id_equipo":1,
							"descripcion":"Descripcion equipo",
							"inventario":"IE-MU-001",
							"bitacora":"BU-AA-001",
							"numero_oficio":1,
							"id_ejercicio":2015,
							"folio":"CEA-1/2015",
							"activo":1
						},
						{
							"id_equipo":2,
							"descripcion":"Descripcion equipo",
							"inventario":"IE-MU-002",
							"bitacora":"BU-AA-002",
							"numero_oficio":2,
							"id_ejercicio":2015,
							"folio":"CEA-2/2015",
							"activo":1
						},
						{
							"id_equipo":3,
							"descripcion":"Descripcion equipo",
							"inventario":"IE-MU-003",
							"bitacora":"BU-AA-003",
							"numero_oficio":3,
							"id_ejercicio":2015,
							"folio":"CEA-3/2015",
							"activo":1
						},
						{
							"id_equipo":4,
							"descripcion":"Descripcion equipo",
							"inventario":"IE-MU-004",
							"bitacora":"BU-AA-004",
							"numero_oficio":4,
							"id_ejercicio":2015,
							"folio":"CEA-4/2015",
							"activo":1
						}
					],
					"recipientes":
					[
						{
							"id_recipiente":1,
							"id_preservacion":1,
							"cantidad":0,
							"numero_oficio":1,
							"id_ejercicio":2015,
							"folio":"CEA-1/2015",
							"activo":1
						},
						{
							"id_recipiente":2,
							"id_preservacion":2,
							"cantidad":0,
							"numero_oficio":2,
							"id_ejercicio":2015,
							"folio":"CEA-2/2015",
							"activo":1
						},
						{
							"id_recipiente":3,
							"id_preservacion":3,
							"cantidad":0,
							"numero_oficio":3,
							"id_ejercicio":2015,
							"folio":"CEA-3/2015",
							"activo":1
						},
						{
							"id_recipiente":4,
							"id_preservacion":4,
							"cantidad":0,
							"numero_oficio":4,
							"id_ejercicio":2015,
							"folio":"CEA-4/2015",
							"activo":1
						}
					],
					"reactivos":
					[
						{
							"id_reactivo":1,
							"reactivo":"Reactivo 1",
							"cantidad":0,
							"lote":"Lote reactivo 1",
							"selected":false
						}
					],
					"materiales":
					[
					],
					"hieleras":
					[
					]
				}
			]
		';
		return $result;
	}

	public function getFieldSheets() {
		$result = '
			[
				{
				  "id_hoja_campo":1,
				  "id_cliente":1,
				  "id_solicitud":1,
				  "id_cotizacion":1,
				  "id_orden_muestreo":1,
				  "id_plan_muestreo":1,
				  "id_punto_muestreo":1,
				  "id_metodo_muestreo":2,
				  "id_responsable_muestreo":1,
				  "id_tipo_muestreo":1,
				  "id_matriz":1,
				  "id_metodo":156,
				  "id_cobertura_nubes":1,
				  "id_direccion_viento":1,
				  "id_oleaje":1,
				  "id_calibracion":1,
				  "id_verificacion":1,
				  "id_informe":1,
				  "id_estado":14,
				  "id_municipio":14124,
				  "id_localidad":1411240001,
				  "fecha_captura":"",
				  "fecha_acepta":"",
				  "fecha_actualiza":"",
				  "fecha_valida":"",
				  "fecha_firmado":"",
				  "fecha_inicio":"",
				  "fecha_fin":"",
				  "hora_inicio":"",
				  "hora_fin":"",
				  "numero_oficio":1,
				  "id_ejercicio":2014,
				  "folio":"CEA-1/2014",
				  "aceptado":0,
				  "validado":0,
				  "firmado":0,
				  "comentarios":"",
				  "cobertura_nubes_otra":"",
				  "colonia":"Col. Colomos Providencia",
				  "calle":"Av. Brasilia",
				  "numero":"2970",
				  "estado":"Jalisco",
				  "municipio":"Zapotlanejo",
				  "localidad":"Zapotlanejo",
				  "cliente":
				  {
				    "id_cliente":1,
				    "id_organismo":1,
				    "cliente":"CEA Jalisco",
				    "area":"Dirección de Operación de PTARS",
				    "contacto":"Biol. Luis Aceves Martínez"
				  },
				  "orden_muestreo":
				  {
				    "id_orden_muestreo":1,
				    "numero_oficio":656,
				    "id_ejercicio":2014,
				    "folio":"CEA-656/2014",
				    "fecha_orden":"2014-11-01",
				    "id_responsable_muestreo":2,
				    "responsable_muestreo":
				    {
				      "id_responsable_muestreo":2,
				      "id_empleado":3,
				      "id_nivel":3,
				      "id_area":2,
				      "area":"Metales Pesados",
				      "id_puesto":4,
				      "puesto":"Supervisor (MP)",
				      "nombres":"Marín",
				      "ap":"Gomar",
				      "am":"Sosa",
				      "fecha_act":"2014-11-30",
				      "calidad":0,
				      "supervisa":1,
				      "analiza":1,
				      "muestrea":1,
				      "cert":1,
				      "activo":1
				    }
				  },
				  "muestra":
				  {
				    "id_muestra":1,
				    "numero_oficio":1,
				    "id_ejercicio":2014,
				    "folio":"CEA-1/2014",
				    "muestra":"",
				    "fecha_muestra":"2014-12-10",
				    "hora_muestra":"12:45",
				    "parametros_campo":
				    [
				      {
				        "id_parametro":1,
				        "param":"color",
				        "parametro":"Color",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"olor",
				        "parametro":"Olor",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"gasto",
				        "parametro":"Gasto",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"profundidad",
				        "parametro":"Profundidad",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"olor",
				        "parametro":"Olor",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"temp_ambiente",
				        "parametro":"Temperatura ambiente",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"temperatura",
				        "parametro":"Temperatura",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"ph",
				        "parametro":"Ph",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"conductividad",
				        "parametro":"Conductividad",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"oxigeno_disuelto",
				        "parametro":"Oxigeno_disuelto",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"transparencia",
				        "parametro":"Transparencia",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"cloro_residual",
				        "parametro":"Cloro_residual",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"materia_flotante",
				        "parametro":"Materia_flotante",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      }
				    ]
				  },
				  "punto_muestreo":
				  {
				    "id_punto_muestreo":1,
				    "punto_muestreo":"Punto muestreo Prueba",
				    "descripcion":"Descripción detallada del Punto de muestreo de Prueba",
				    "id_municipio":14124,
				    "municipio":"Zapotlanejo",
				    "id_localidad":141240001,
				    "localidad":"Zapotlanejo",
				    "lat":23.123456,
				    "lng":-103.654321
				  },
				  "parametros_campo":
				  [

				  ],
				  "componentes":
				  {
				    "temp_1":0,
				    "temp_2":0,
				    "temp_3":0,
				    "temp":0,
				    "ph_1":0,
				    "ph_2":0,
				    "ph_3":0,
				    "ph":0,
				    "cond_1":0,
				    "cond_2":0,
				    "cond_3":0,
				    "cond":0,
				    "od_1":0,
				    "od_2":0,
				    "od_3":0,
				    "od":0
				  },
				  "preservaciones":
				  [
				  ],
				  "validaciones":
				  [
				    {

				    }
				  ],
				  "cobertura_nubes":
				  {
				      "id_cobertura_nubes":1,
				      "cobertura_nubes":"Despejado"
				  },
				  "direccion_viento":
				  {
				    "id_direccion_viento":1,
				    "direccion_viento":"Norte"
				  },
				  "oleaje":
				  {
				    "id_oleaje":1,
				    "oleaje":"Nulo"
				  },
				  "calibracion":
				  {
				    "id_calibracion":1,
				    "bitacora":"BT-00-AAA-2134",
				    "numero_oficio":1,
				    "id_ejercicio":"2014",
				    "folio":"CEA-1/2014"
				  },
				  "verificacion":
				  {
				    "id_verificacion":1,
				    "bitacora":"BT-00-AAA-2134",
				    "numero_oficio":1,
				    "id_ejercicio":"2014",
				    "folio":"CEA-1/2014"
				  },
				  "informe":
				  {
				  }
				}
			]';
		return $result;
	}

	public function getFieldSheet($sheetId) {
		if ($sheetId == 1) {
			$result = '
				{
				  "id_hoja_campo":1,
				  "id_cliente":1,
				  "id_solicitud":1,
				  "id_cotizacion":1,
				  "id_orden_muestreo":1,
				  "id_plan_muestreo":1,
				  "id_punto_muestreo":1,
				  "id_metodo_muestreo":2,
				  "id_responsable_muestreo":1,
				  "id_tipo_muestreo":1,
				  "id_matriz":1,
				  "id_metodo":156,
				  "id_cobertura_nubes":1,
				  "id_direccion_viento":1,
				  "id_oleaje":1,
				  "id_calibracion":1,
				  "id_verificacion":1,
				  "id_informe":1,
				  "id_estado":14,
				  "id_municipio":14124,
				  "id_localidad":1411240001,
				  "fecha_captura":"",
				  "fecha_acepta":"",
				  "fecha_actualiza":"",
				  "fecha_valida":"",
				  "fecha_firmado":"",
				  "fecha_inicio":"",
				  "fecha_fin":"",
				  "hora_inicio":"",
				  "hora_fin":"",
				  "numero_oficio":1,
				  "id_ejercicio":2014,
				  "folio":"CEA-1/2014",
				  "aceptado":0,
				  "validado":0,
				  "firmado":0,
				  "comentarios":"",
				  "cobertura_nubes_otra":"",
				  "colonia":"Col. Colomos Providencia",
				  "calle":"Av. Brasilia",
				  "numero":"2970",
				  "estado":"Jalisco",
				  "municipio":"Zapotlanejo",
				  "localidad":"Zapotlanejo",
				  "cliente":
				  {
				    "id_cliente":1,
				    "id_organismo":1,
				    "cliente":"CEA Jalisco",
				    "area":"Dirección de Operación de PTARS",
				    "contacto":"Biol. Luis Aceves Martínez",
				  },
				  "orden_muestreo":
				  {
				    "id_orden_muestreo":1,
				    "numero_oficio":656,
				    "id_ejercicio":2014,
				    "folio":"CEA-656/2014",
				    "fecha_orden":"2014-11-01",
				    "id_responsable_muestreo":2,
				    "responsable_muestreo":
				    {
				      "id_responsable_muestreo":2,
				      "id_empleado":3,
				      "id_nivel":3,
				      "id_area":2,
				      "area":"Metales Pesados",
				      "id_puesto":4,
				      "puesto":"Supervisor (MP)",
				      "nombres":"Marín",
				      "ap":"Gomar",
				      "am":"Sosa",
				      "fecha_act":"2014-11-30",
				      "calidad":0,
				      "supervisa":1,
				      "analiza":1,
				      "muestrea":1,
				      "cert":1,
				      "activo":1
				    }
				  },
				  "muestra":
				  {
				    "id_muestra":1,
				    "numero_oficio":1,
				    "id_ejercicio":2014,
				    "folio":"CEA-1/2014",
				    "muestra":"",
				    "fecha_muestra":"2014-12-10",
				    "hora_muestra":"12:45",
				    "parametros_campo":
				    [
				      {
				        "id_parametro":1,
				        "param":"color",
				        "parametro":"Color",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"olor",
				        "parametro":"Olor",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"gasto",
				        "parametro":"Gasto",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"profundidad",
				        "parametro":"Profundidad",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"olor",
				        "parametro":"Olor",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"temp_ambiente",
				        "parametro":"Temperatura ambiente",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"temperatura",
				        "parametro":"Temperatura",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"ph",
				        "parametro":"Ph",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"conductividad",
				        "parametro":"Conductividad",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"oxigeno_disuelto",
				        "parametro":"Oxigeno_disuelto",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"transparencia",
				        "parametro":"Transparencia",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"cloro_residual",
				        "parametro":"Cloro_residual",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      },
				      {
				        "id_parametro":1,
				        "param":"materia_flotante",
				        "parametro":"Materia_flotante",
				        "id_tipo_parametro":1,
				        "id_clase_parametro":1,
				        "id_preservacion":1,
				        "id_unidad":1,
				        "id_metodo":1,
				        "tipo_parametro":"Físicoquímico",
				        "clase_parametro":"Campo",
				        "activo":1,
				        "valor":null,
				        "selected":false
				      }
				    ]
				  },
				  "punto_muestreo":
				  {
				    "id_punto_muestreo":1,
				    "punto_muestreo":"Punto muestreo Prueba",
				    "descripcion":"Descripción detallada del Punto de muestreo de Prueba",
				    "id_municipio":14124,
				    "municipio":"Zapotlanejo",
				    "id_localidad":141240001,
				    "localidad":"Zapotlanejo",
				    "lat":23.123456,
				    "lng":-103.654321
				  },
				  "parametros_campo":
				  [

				  ],
				  "componentes":
				  {
				    "temp_1":0,
				    "temp_2":0,
				    "temp_3":0,
				    "temp":0,
				    "ph_1":0,
				    "ph_2":0,
				    "ph_3":0,
				    "ph":0,
				    "cond_1":0,
				    "cond_2":0,
				    "cond_3":0,
				    "cond":0,
				    "od_1":0,
				    "od_2":0,
				    "od_3":0,
				    "od":0
				  },
				  "preservaciones":
				  [
				  ],
				  "validaciones":
				  [
				    {

				    }
				  ],
				  "cobertura_nubes":
				  {
				      "id_cobertura_nubes":1,
				      "cobertura_nubes":"Despejado"
				  },
				  "direccion_viento":
				  {
				    "id_direccion_viento":1,
				    "direccion_viento":"Norte"
				  },
				  "oleaje":
				  {
				    "id_oleaje":1,
				    "oleaje":"Nulo"
				  },
				  "calibracion":
				  {
				    "id_calibracion":1,
				    "bitacora":"BT-00-AAA-2134",
				    "numero_oficio":1,
				    "id_ejercicio":"2014",
				    "folio":"CEA-1/2014"
				  },
				  "verificacion":
				  {
				    "id_verificacion":1,
				    "bitacora":"BT-00-AAA-2134",
				    "numero_oficio":1,
				    "id_ejercicio":"2014",
				    "folio":"CEA-1/2014"
				  },
				  "informe":
				  {
				  }
				}
			';
		}
		else {
			$result = '
				{
				  "id_hoja_campo":0,
				  "id_cliente":0,
				  "id_solicitud":0,
				  "id_cotizacion":0,
				  "id_orden_muestreo":0,
				  "id_plan_muestreo":0,
				  "id_punto_muestreo":0,
				  "id_metodo_muestreo":0,
				  "id_responsable_muestreo":0,
				  "id_tipo_muestreo":0,
				  "id_matriz":0,
				  "id_metodo":0,
				  "id_cobertura_nubes":0,
				  "id_direccion_viento":0,
				  "id_oleaje":0,
				  "id_calibracion":0,
				  "id_verificacion":0,
				  "id_informe":0,
				  "id_estado":0,
				  "id_municipio":0,
				  "id_localidad":0,
				  "fecha_captura":"",
				  "fecha_acepta":"",
				  "fecha_actualiza":"",
				  "fecha_valida":"",
				  "fecha_firmado":"",
				  "fecha_inicio":"",
				  "fecha_fin":"",
				  "hora_inicio":"",
				  "hora_fin":"",
				  "numero_oficio":0,
				  "id_ejercicio":0,
				  "folio":"CEA-0/0",
				  "aceptado":0,
				  "validado":0,
				  "firmado":0,
				  "comentarios":"",
				  "cobertura_nubes_otra":"",
				  "colonia":"",
				  "calle":"",
				  "numero":"",
				  "estado":"",
				  "municipio":"",
				  "localidad":""
				}
			';
		}
		return $result;
	}

	public function getReceptionists() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		recepcionista";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_empleado":12,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"José Adalberto",
					"ap":"Olivarez",
					"am":"Cornejo",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":13,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"Luis Fabián",
					"ap":"Mercado",
					"am":"del Ángel",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":14,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"Octavio",
					"ap":"Elizalde",
					"am":"Ulloa",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":15,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"Mitzi Acahualxóchitl",
					"ap":"Rodríguez",
					"am":"García",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":18,
					"id_nivel":5,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"Juan Pablo",
					"ap":"Basulto",
					"am":"Rivera",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":0,
					"muestrea":0,
					"cert":0,
					"activo":1
				},
				{
					"id_empleado":19,
					"id_nivel":5,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"Miriam",
					"ap":"Yerena",
					"am":"Pelayo",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":0,
					"muestrea":0,
					"cert":0,
					"activo":1
				}
			]
		';
		return $result;
	}

	public function getReceptions() {
		return '[]';
	}

	public function getReception($receptionId) {
		return '{}';
	}

	public function getExpirations() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		expiracion";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_expiracion":1,
					"id_clase_parametro":1,
					"clase_parametro":"Físicoquimico",
					"horas_vigencia":24,
					"vigente":0,
					"selected":false,
					"activo":1
				},
				{
					"id_expiracion":2,
					"id_clase_parametro":2,
					"clase_parametro":"Oxígeno disuelto",
					"horas_vigencia":24,
					"vigente":0,
					"selected":false,
					"activo":1
				},
				{
					"id_expiracion":3,
					"id_clase_parametro":3,
					"clase_parametro":"Sustancias activas al azul de metileno",
					"horas_vigencia":24,
					"vigente":0,
					"selected":false,
					"activo":1
				},
				{
					"id_expiracion":4,
					"id_clase_parametro":4,
					"clase_parametro":"Fenoles",
					"horas_vigencia":24,
					"vigente":0,
					"selected":false,
					"activo":1
				},
				{
					"id_expiracion":5,
					"id_clase_parametro":5,
					"clase_parametro":"Dureza",
					"horas_vigencia":24,
					"vigente":0,
					"selected":false,
					"activo":1
				},
				{
					"id_expiracion":6,
					"id_clase_parametro":6,
					"clase_parametro":"Sulfuros",
					"horas_vigencia":24,
					"vigente":0,
					"selected":false,
					"activo":1
				},
				{
					"id_expiracion":7,
					"id_clase_parametro":7,
					"clase_parametro":"Físicoquimico 2",
					"horas_vigencia":24,
					"vigente":0,
					"selected":false,
					"activo":1
				},
				{
					"id_expiracion":8,
					"id_clase_parametro":8,
					"clase_parametro":"Grasas y aceites",
					"horas_vigencia":24,
					"vigente":0,
					"selected":false,
					"activo":1
				},
				{
					"id_expiracion":9,
					"id_clase_parametro":9,
					"clase_parametro":"Metales pesados",
					"horas_vigencia":24,
					"vigente":0,
					"selected":false,
					"activo":1
				},
				{
					"id_expiracion":10,
					"id_clase_parametro":10,
					"clase_parametro":"Fenoles",
					"horas_vigencia":24,
					"vigente":0,
					"selected":false,
					"activo":1
				}
			]
		';
		return $result;
	}

	public function getVolumes() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		volumen";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_volumen":1,
					"id_preservacion":1,
					"id_clase_parametro":1,
					"clase_parametro":"Físicoquimico",
					"clase_param":"FQ",
					"volumen":100,
					"id_unidad":1,
					"unidad":"ml",
					"requerido":0,
					"selected":false,
					"activo":1
				},
				{
					"id_volumen":2,
					"id_preservacion":2,
					"id_clase_parametro":2,
					"clase_parametro":"Oxígeno disuelto",
					"clase_param":"OD",
					"volumen":100,
					"id_unidad":1,
					"unidad":"ml",
					"requerido":0,
					"selected":false,
					"activo":1
				},
				{
					"id_volumen":3,
					"id_preservacion":3,
					"id_clase_parametro":3,
					"clase_parametro":"Sustancias activas al azul de metileno",
					"clase_param":"SAAM",
					"volumen":100,
					"id_unidad":1,
					"unidad":"ml",
					"requerido":0,
					"selected":false,
					"activo":1
				},
				{
					"id_volumen":4,
					"id_preservacion":4,
					"id_clase_parametro":4,
					"clase_parametro":"Fenoles",
					"clase_param":"FEN",
					"volumen":100,
					"id_unidad":1,
					"unidad":"ml",
					"requerido":0,
					"selected":false,
					"activo":1
				},
				{
					"id_volumen":5,
					"id_preservacion":5,
					"id_clase_parametro":5,
					"clase_parametro":"Dureza",
					"clase_param":"DZA",
					"volumen":100,
					"id_unidad":1,
					"unidad":"ml",
					"requerido":0,
					"selected":false,
					"activo":1
				},
				{
					"id_volumen":6,
					"id_preservacion":6,
					"id_clase_parametro":6,
					"clase_parametro":"Sulfuros",
					"clase_param":"Sulfuros",
					"volumen":100,
					"id_unidad":1,
					"unidad":"ml",
					"requerido":0,
					"selected":false,
					"activo":1
				},
				{
					"id_volumen":7,
					"id_preservacion":7,
					"id_clase_parametro":7,
					"clase_parametro":"Físicoquimico 2",
					"clase_param":"FQ-2",
					"volumen":100,
					"id_unidad":1,
					"unidad":"ml",
					"requerido":0,
					"selected":false,
					"activo":1
				},
				{
					"id_volumen":8,
					"id_preservacion":8,
					"id_clase_parametro":8,
					"clase_parametro":"Grasas y aceites",
					"clase_param":"GyA",
					"volumen":100,
					"id_unidad":1,
					"unidad":"ml",
					"requerido":0,
					"selected":false,
					"activo":1
				},
				{
					"id_volumen":9,
					"id_preservacion":9,
					"id_clase_parametro":9,
					"clase_parametro":"Metales pesados",
					"clase_param":"MP",
					"volumen":100,
					"id_unidad":1,
					"unidad":"ml",
					"requerido":0,
					"selected":false,
					"activo":1
				},
				{
					"id_volumen":10,
					"id_preservacion":10,
					"id_clase_parametro":10,
					"clase_parametro":"Fenoles",
					"clase_param":"Fenoles",
					"volumen":100,
					"id_unidad":1,
					"unidad":"ml",
					"requerido":0,
					"selected":false,
					"activo":1
				}
			]
		';
		return $result;
	}

	public function getCheckers() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		responsable_verificacion";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_empleado":12,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"José Adalberto",
					"ap":"Olivarez",
					"am":"Cornejo",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":13,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"Luis Fabián",
					"ap":"Mercado",
					"am":"del Ángel",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":14,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"Octavio",
					"ap":"Elizalde",
					"am":"Ulloa",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":15,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"Mitzi Acahualxóchitl",
					"ap":"Rodríguez",
					"am":"García",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":18,
					"id_nivel":5,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"Juan Pablo",
					"ap":"Basulto",
					"am":"Rivera",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":0,
					"muestrea":0,
					"cert":0,
					"activo":1
				},
				{
					"id_empleado":19,
					"id_nivel":5,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"Miriam",
					"ap":"Yerena",
					"am":"Pelayo",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":0,
					"muestrea":0,
					"cert":0,
					"activo":1
				}
			]
		';
		return $result;
	}

	public function getCustodies() {
		return '[]';
	}

	public function getCustody($custodyId) {
		return '{}';
	}

	public function getReports() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		reporte";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
			]
		';
		return $result;
	}

	public function getReport($reportId) {
		return '{}';
	}

	public function getEmployees() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		empleado";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_empleado":1,
					"id_nivel":1,
					"id_area":5,
					"area":"Administrativo",
					"id_puesto":1,
					"usr":"rgarcia",
					"pwd":"rgarcia",
					"puesto":"Gerente",
					"nombres":"Reyna",
					"ap":"García",
					"am":"Meneses",
					"fecha_act":"2014-11-30",
					"calidad":1,
					"supervisa":1,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":2,
					"id_nivel":3,
					"id_area":1,
					"area":"Fisicoquímico",
					"id_puesto":3,
					"usr":"mdelatorre",
					"pwd":"mdelatorre",
					"puesto":"Supervisor (FQ)",
					"nombres":"María",
					"ap":"de la Torre",
					"am":"Castañeda",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":1,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":3,
					"id_nivel":3,
					"id_area":2,
					"area":"Metales Pesados",
					"id_puesto":4,
					"usr":"mgomar",
					"pwd":"mgomar",
					"puesto":"Supervisor (MP)",
					"nombres":"Marín",
					"ap":"Gomar",
					"am":"Sosa",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":1,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":4,
					"id_nivel":3,
					"id_area":3,
					"area":"Microbiología",
					"id_puesto":5,
					"usr":"nguzman",
					"pwd":"nguzman",
					"puesto":"Supervisor (MB)",
					"nombres":"Nayeli del Rosario",
					"ap":"Guzmán",
					"am":"Rosales",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":1,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":5,
					"id_nivel":4,
					"id_area":1,
					"area":"Fisicoquímico",
					"id_puesto":6,
					"usr":"aperez",
					"pwd":"aperez",
					"puesto":"Analista",
					"nombres":"Alondra Elizabeth",
					"ap":"Pérez",
					"am":"Pérez",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":6,
					"id_nivel":4,
					"id_area":1,
					"area":"Fisicoquímico",
					"id_puesto":6,
					"usr":"aramirez",
					"pwd":"aramirez",
					"puesto":"Analista",
					"nombres":"Anderson Alberto",
					"ap":"Ramírez",
					"am":"Ramírez",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":7,
					"id_nivel":4,
					"id_area":1,
					"area":"Fisicoquímico",
					"id_puesto":6,
					"usr":"lgarcia",
					"pwd":"lgarcia",
					"puesto":"Analista",
					"nombres":"Lidia",
					"ap":"García",
					"am":"Ochoa",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":8,
					"id_nivel":4,
					"id_area":1,
					"area":"Fisicoquímico",
					"id_puesto":6,
					"usr":"mbojado",
					"pwd":"mbojado",
					"puesto":"Analista",
					"nombres":"María Gabriela",
					"ap":"Bojado",
					"am":"Pérez",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":9,
					"id_nivel":4,
					"id_area":1,
					"area":"Fisicoquímico",
					"id_puesto":6,
					"usr":"mortiz",
					"pwd":"mortiz",
					"puesto":"Analista",
					"nombres":"Moisés",
					"ap":"Ortíz",
					"am":"Flores",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":10,
					"id_nivel":4,
					"id_area":1,
					"area":"Fisicoquímico",
					"id_puesto":6,
					"usr":"nolide",
					"pwd":"nolide",
					"puesto":"Analista",
					"nombres":"Norma Angélica",
					"ap":"Olide",
					"am":"Chávez",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":11,
					"id_nivel":4,
					"id_area":1,
					"area":"Fisicoquímico",
					"id_puesto":6,
					"usr":"scampos",
					"pwd":"scampos",
					"puesto":"Analista",
					"nombres":"Saúl",
					"ap":"Campos",
					"am":"Trujillo",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":12,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"usr":"jolivarez",
					"pwd":"jolivarez",
					"puesto":"Analista",
					"nombres":"José Adalberto",
					"ap":"Olivarez",
					"am":"Cornejo",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":13,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"usr":"lmercado",
					"pwd":"lmercado",
					"puesto":"Analista",
					"nombres":"Luis Fabián",
					"ap":"Mercado",
					"am":"del Ángel",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":15,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"usr":"mrodriguez",
					"pwd":"mrodriguez",
					"puesto":"Analista",
					"nombres":"Mitzi Acahualxóchitl",
					"ap":"Rodríguez",
					"am":"García",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":16,
					"id_nivel":4,
					"id_area":2,
					"area":"Metales Pesados",
					"id_puesto":6,
					"puesto":"Analista",
					"usr":"rvazquez",
					"pwd":"rvazquez",
					"nombres":"Ruth María",
					"ap":"Vázquez",
					"am":"Ortíz",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":17,
					"id_nivel":4,
					"id_area":3,
					"area":"Microbiología",
					"id_puesto":6,
					"usr":"rreyes",
					"pwd":"rreyes",
					"puesto":"Analista",
					"nombres":"Rocío Estefanía",
					"ap":"Reyes",
					"am":"Argonza",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":18,
					"id_nivel":5,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"usr":"jbasulto",
					"pwd":"jbasulto",
					"puesto":"Analista",
					"nombres":"Juan Pablo",
					"ap":"Basulto",
					"am":"Rivera",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":0,
					"muestrea":0,
					"cert":0,
					"activo":1
				},
				{
					"id_empleado":19,
					"id_nivel":5,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"usr":"myerena",
					"pwd":"myerena",
					"puesto":"Analista",
					"nombres":"Miriam",
					"ap":"Yerena",
					"am":"Pelayo",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":0,
					"muestrea":0,
					"cert":0,
					"activo":1
				},
				{
					"id_usuario":20,
					"id_nivel":6,
					"id_area":5,
					"id_puesto":7,
					"usr":"mroman",
					"pwd":"mroman",
					"area":"Administrativo",
					"puesto":"Secretaria",
					"nombres":"Mirna María",
					"ap":"López",
					"am":"Román",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":0,
					"muestrea":0,
					"cert":0,
					"activo":1
				}
			]
		';
		return $result;
	}

	public function getReferences() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		referencia";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
			]
		';
		return $result;
	}

	public function getMethods() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		metodo";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_metodo":1,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-003-1980",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":2,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-004-SCFI-2000",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":3,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-005-SCFI-2000",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":4,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-006-SCFI-2010",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":5,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-007-SCFI-2000",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":6,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-008-SCFI-2011",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":7,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-012-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":8,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-026-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":8,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-026-SCFI-2010",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":9,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-026-SCFI-2010 NMX-AA-079-SCFI-2001 NMX-AA-099-SCFI-2006",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":10,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-028-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":11,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-029-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":12,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-030-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":13,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-034-SCFI-2000",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":14,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-034-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":15,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-036-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":16,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-036-SCFI-2002",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":17,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-038-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":18,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-039-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":19,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-042-1987",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":20,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-044-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":21,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-045-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":22,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-050-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":23,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-051-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":24,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-072-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":25,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-073-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":26,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-073-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":27,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-074-1981",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":28,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-074-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":29,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-075-1982",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":10,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-077-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":31,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-079-SCFI-2001",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":32,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-079-SCFI-2001 NMX-AA-026-SCFI-2010",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":33,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-084-1982",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":34,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-093-SCFI-2000",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":35,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-099-SCFI-2006",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":36,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-102-1987",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":37,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-102-SCFI-2006",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":38,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-113-SCFI-1999",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":39,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NMX-AA-42-1987",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":30,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NOM-092-SSA1-1994",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":41,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"NOM-230-SSA1-2002",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":42,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"SM-10200 H",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":44,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"SM-3500 Ca D",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":45,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"SM-3500 Mg E",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":46,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"SM-4500 Cl G",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":47,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"SM-4500 PA",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":48,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"SM-6210 B",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":49,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"SM-6210 B",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":50,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"SM-6630",
					"norma":"",
					"precio":0
				},
				{
					"id_metodo":51,
					"id_norma":0,
					"catalogado":1,
					"certificado":1,
					"metodo":"SM-6640 B",
					"norma":"",
					"precio":0
				}
			]
		';
		return $result;
	}

	public function getPrices() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		precio";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_precio":1,
					"precio":0,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":2,
					"precio":30,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":3,
					"precio":50,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":4,
					"precio":60,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":5,
					"precio":110,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":6,
					"precio":120,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":7,
					"precio":130,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":8,
					"precio":150,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":9,
					"precio":160,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":10,
					"precio":170,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":11,
					"precio":175,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":12,
					"precio":180,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":13,
					"precio":200,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":14,
					"precio":220,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":15,
					"precio":300,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":16,
					"precio":1000,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":17,
					"precio":1200,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":18,
					"precio":1300,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":19,
					"precio":1500,
					"fecha":"2014-01-01",
					"activo":1
				},
				{
					"id_precio":20,
					"precio":5000,
					"fecha":"2014-01-01",
					"activo":1
				}
			]
		';
		return $result;
	}

	public function getUsers() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		usuario";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_empleado":1,
					"id_nivel":1,
					"id_area":5,
					"area":"Administrativo",
					"id_puesto":1,
					"usr":"rgarcia",
					"pwd":"rgarcia",
					"puesto":"Gerente",
					"nombres":"Reyna",
					"ap":"García",
					"am":"Meneses",
					"fecha_act":"2014-11-30",
					"calidad":1,
					"supervisa":1,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":2,
					"id_nivel":3,
					"id_area":1,
					"area":"Fisicoquímico",
					"id_puesto":3,
					"usr":"mdelatorre",
					"pwd":"mdelatorre",
					"puesto":"Supervisor (FQ)",
					"nombres":"María",
					"ap":"de la Torre",
					"am":"Castañeda",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":1,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":3,
					"id_nivel":3,
					"id_area":2,
					"area":"Metales Pesados",
					"id_puesto":4,
					"usr":"mgomar",
					"pwd":"mgomar",
					"puesto":"Supervisor (MP)",
					"nombres":"Marín",
					"ap":"Gomar",
					"am":"Sosa",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":1,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":4,
					"id_nivel":3,
					"id_area":3,
					"area":"Microbiología",
					"id_puesto":5,
					"usr":"nguzman",
					"pwd":"nguzman",
					"puesto":"Supervisor (MB)",
					"nombres":"Nayeli del Rosario",
					"ap":"Guzmán",
					"am":"Rosales",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":1,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":5,
					"id_nivel":4,
					"id_area":1,
					"area":"Fisicoquímico",
					"id_puesto":6,
					"usr":"aperez",
					"pwd":"aperez",
					"puesto":"Analista",
					"nombres":"Alondra Elizabeth",
					"ap":"Pérez",
					"am":"Pérez",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":6,
					"id_nivel":4,
					"id_area":1,
					"area":"Fisicoquímico",
					"id_puesto":6,
					"usr":"aramirez",
					"pwd":"aramirez",
					"puesto":"Analista",
					"nombres":"Anderson Alberto",
					"ap":"Ramírez",
					"am":"Ramírez",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":7,
					"id_nivel":4,
					"id_area":1,
					"area":"Fisicoquímico",
					"id_puesto":6,
					"usr":"lgarcia",
					"pwd":"lgarcia",
					"puesto":"Analista",
					"nombres":"Lidia",
					"ap":"García",
					"am":"Ochoa",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":8,
					"id_nivel":4,
					"id_area":1,
					"area":"Fisicoquímico",
					"id_puesto":6,
					"usr":"mbojado",
					"pwd":"mbojado",
					"puesto":"Analista",
					"nombres":"María Gabriela",
					"ap":"Bojado",
					"am":"Pérez",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":9,
					"id_nivel":4,
					"id_area":1,
					"area":"Fisicoquímico",
					"id_puesto":6,
					"usr":"mortiz",
					"pwd":"mortiz",
					"puesto":"Analista",
					"nombres":"Moisés",
					"ap":"Ortíz",
					"am":"Flores",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":10,
					"id_nivel":4,
					"id_area":1,
					"area":"Fisicoquímico",
					"id_puesto":6,
					"usr":"nolide",
					"pwd":"nolide",
					"puesto":"Analista",
					"nombres":"Norma Angélica",
					"ap":"Olide",
					"am":"Chávez",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":11,
					"id_nivel":4,
					"id_area":1,
					"area":"Fisicoquímico",
					"id_puesto":6,
					"usr":"scampos",
					"pwd":"scampos",
					"puesto":"Analista",
					"nombres":"Saúl",
					"ap":"Campos",
					"am":"Trujillo",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":12,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"usr":"jolivarez",
					"pwd":"jolivarez",
					"puesto":"Analista",
					"nombres":"José Adalberto",
					"ap":"Olivarez",
					"am":"Cornejo",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":13,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"usr":"lmercado",
					"pwd":"lmercado",
					"puesto":"Analista",
					"nombres":"Luis Fabián",
					"ap":"Mercado",
					"am":"del Ángel",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":15,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"usr":"mrodriguez",
					"pwd":"mrodriguez",
					"puesto":"Analista",
					"nombres":"Mitzi Acahualxóchitl",
					"ap":"Rodríguez",
					"am":"García",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":16,
					"id_nivel":4,
					"id_area":2,
					"area":"Metales Pesados",
					"id_puesto":6,
					"puesto":"Analista",
					"usr":"rvazquez",
					"pwd":"rvazquez",
					"nombres":"Ruth María",
					"ap":"Vázquez",
					"am":"Ortíz",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":17,
					"id_nivel":4,
					"id_area":3,
					"area":"Microbiología",
					"id_puesto":6,
					"usr":"rreyes",
					"pwd":"rreyes",
					"puesto":"Analista",
					"nombres":"Rocío Estefanía",
					"ap":"Reyes",
					"am":"Argonza",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":18,
					"id_nivel":5,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"usr":"jbasulto",
					"pwd":"jbasulto",
					"puesto":"Analista",
					"nombres":"Juan Pablo",
					"ap":"Basulto",
					"am":"Rivera",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":0,
					"muestrea":0,
					"cert":0,
					"activo":1
				},
				{
					"id_empleado":19,
					"id_nivel":5,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"usr":"myerena",
					"pwd":"myerena",
					"puesto":"Analista",
					"nombres":"Miriam",
					"ap":"Yerena",
					"am":"Pelayo",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":0,
					"muestrea":0,
					"cert":0,
					"activo":1
				},
				{
					"id_usuario":20,
					"id_nivel":6,
					"id_area":5,
					"id_puesto":7,
					"usr":"mroman",
					"pwd":"mroman",
					"area":"Administrativo",
					"puesto":"Secretaria",
					"nombres":"Mirna María",
					"ap":"López",
					"am":"Román",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":0,
					"muestrea":0,
					"cert":0,
					"activo":1
				}
			]
		';
		return $result;
	}

	public function getUser($userId) {
		//$sql = "SELECT
		//		*
		//	FROM
		//		usuario";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			{
				"id_usuario":0,
				"id_nivel":0,
				"id_area":0,
				"id_puesto":0,
				"usr":"",
				"pwd":"",
				"area":"Ninguna",
				"puesto":"Ninguno",
				"nombres":"Usuario",
				"ap":"",
				"am":"",
				"fecha_act":"2014-11-30",
				"calidad":0,
				"supervisa":0,
				"analiza":0,
				"muestrea":0,
				"cert":0,
				"activo":0
			}
		';
		if ($userId == 1) {
			$result = '
				{
					"id_usuario":1,
					"id_nivel":2,
					"id_area":5,
					"id_puesto":1,
					"usr":"rgarcia",
					"pwd":"rgarcia",
					"area":"Administrativo",
					"puesto":"Gerente",
					"nombres":"Reyna",
					"ap":"García",
					"am":"Meneses",
					"fecha_act":"2014-11-30",
					"calidad":1,
					"supervisa":1,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				}
			';
		}
		if ($userID == 20) {
			$result = '
				{
					"id_usuario":20,
					"id_nivel":6,
					"id_area":5,
					"id_puesto":7,
					"usr":"mroman",
					"pwd":"mroman",
					"area":"Administrativo",
					"puesto":"Secretaria",
					"nombres":"Mirna María",
					"ap":"López",
					"am":"Román",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":0,
					"muestrea":0,
					"cert":0,
					"activo":1
				}
			';
		}
		return $result;
	}

	public function getUserByCredentials($usr, $pwd) {
		//$sql = "SELECT
		//		*
		//	FROM
		//		usuario";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		if ($usr == "rgarcia" && $pwd == "rgarcia") {
			$result = '
				{
					"id_usuario":1,
					"id_nivel":2,
					"id_area":5,
					"id_puesto":1,
					"usr":"rgarcia",
					"pwd":"rgarcia",
					"area":"Administrativo",
					"puesto":"Gerente",
					"nombres":"Reyna",
					"ap":"García",
					"am":"Meneses",
					"fecha_act":"2014-11-30",
					"calidad":1,
					"supervisa":1,
					"analiza":1,
					"muestrea":0,
					"cert":1,
					"activo":1
				}
			';
		}
		else if ($usr == "mroman" && $pwd == "mroman") {
			$result = '
				{
					"id_usuario":20,
					"id_nivel":6,
					"id_area":5,
					"id_puesto":7,
					"usr":"mroman",
					"pwd":"mroman",
					"area":"Administrativo",
					"puesto":"Secretaria",
					"nombres":"Mirna María",
					"ap":"López",
					"am":"Román",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":0,
					"muestrea":0,
					"cert":0,
					"activo":1
				}
			';
		}
		else {
			$result = '
				{
					"id_usuario":0,
					"id_nivel":0,
					"id_area":0,
					"id_puesto":0,
					"usr":"",
					"pwd":"",
					"area":"Ninguna",
					"puesto":"Ninguno",
					"nombres":"Usuario",
					"ap":"",
					"am":"",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":0,
					"muestrea":0,
					"cert":0,
					"activo":0
				}
			';
		}
		return $result;
	}


	public function getClients() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		cliente";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_cliente":1,
					"id_organismo":1,
					"cliente":"CEA Jalisco",
					"area":"Dirección de Operación de PTARS",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Av. Brasilia",
					"numero":"2970",
					"colonia":"Col. Colomos Providencia",
					"cp":"44680",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14039,
					"municipio":"Guadalajara",
					"id_localidad":140390001,
					"localidad":"Guadalajara",
					"tel":"3030-9350 ext. 8370",
					"fax":"",
					"contacto":"Biol. Luis Aceves Martínez",
					"puesto_contacto":"puesto contacto",
					"email":"laceves@ceajalisco.gob.mx",
					"fecha_act":"23/11/2014",
					"interno":1,
					"cea":1,
					"tasa":0,
					"activo":1
				},
				{
					"id_cliente":2,
					"id_organismo":1,
					"cliente":"CEA Jalisco",
					"area":"Gerencia Técnica Cosultiva",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Av. Brasilia",
					"numero":"2970",
					"colonia":"Col. Colomos Providencia",
					"cp":"44680",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14039,
					"municipio":"Guadalajara",
					"id_localidad":140390001,
					"localidad":"Guadalajara",
					"tel":"3030-9350 ext. 8384",
					"fax":"",
					"contacto":"Martha Olga Peña Lie",
					"puesto_contacto":"puesto contacto",
					"email":"mpena@ceajalisco.gob.mx",
					"fecha_act":"23/11/2014",
					"interno":1,
					"cea":1,
					"tasa":0,
					"activo":1
				},
				{
					"id_cliente":3,
					"id_organismo":1,
					"cliente":"CEA Jalisco",
					"area":"Gerencia de PTARS",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Av. Brasilia",
					"numero":"2970",
					"colonia":"Col. Colomos Providencia",
					"cp":"44680",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14039,
					"municipio":"Guadalajara",
					"id_localidad":140390001,
					"localidad":"Guadalajara",
					"tel":"3030-9350 ext. 8382",
					"fax":"",
					"contacto":"Ing. Víctor Ignacio Méndez Gómez",
					"puesto_contacto":"puesto contacto",
					"email":"vmendez@ceajalisco.gob.mx",
					"fecha_act":"23/11/2014",
					"interno":1,
					"cea":1,
					"tasa":0,
					"activo":1
				},
				{
					"id_cliente":4,
					"id_organismo":1,
					"cliente":"CEA Jalisco",
					"area":"Unidad Ejecutora de Abastecimiento y Saneamiento",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Av. Francia",
					"numero":"1726",
					"colonia":"Col. Moderna",
					"cp":"44190",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14039,
					"municipio":"Guadalajara",
					"id_localidad":140390001,
					"localidad":"Guadalajara",
					"tel":"3030-9200 ext. 8288",
					"fax":"",
					"contacto":"Salvador Delgado Sánchez",
					"puesto_contacto":"puesto contacto",
					"email":"sdelgado@ceajalisco.gob.mx",
					"fecha_act":"23/11/2014",
					"interno":1,
					"cea":1,
					"tasa":0,
					"activo":1
				},
				{
					"id_cliente":5,
					"id_organismo":1,
					"cliente":"CEA Jalisco",
					"area":"Dirección de Cuencas y Sustentabilidad",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Av. Brasilia",
					"numero":"2970",
					"colonia":"Col. Colomos Providencia",
					"cp":"44680",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14039,
					"municipio":"Guadalajara",
					"id_localidad":140390001,
					"localidad":"Guadalajara",
					"tel":"3030-9350 ext. 8313",
					"fax":"",
					"contacto":"Ing. Armando Brígido Muñoz Juárez",
					"puesto_contacto":"puesto contacto",
					"email":"amunoz@ceajalisco.gob.mx",
					"fecha_act":"23/11/2014",
					"interno":1,
					"cea":1,
					"tasa":0,
					"activo":1
				},
				{
					"id_cliente":6,
					"id_organismo":1,
					"cliente":"CEA Jalisco",
					"area":"Dirección de Apoyo a Municipios",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Av. Francia",
					"numero":"1726",
					"colonia":"Col. Moderna",
					"cp":"44190",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14039,
					"municipio":"Guadalajara",
					"id_localidad":140390001,
					"localidad":"Guadalajara",
					"tel":"3030-9200 ext. 8224",
					"fax":"",
					"contacto":"Ing. Ernesto Marroquín Álvarez",
					"puesto_contacto":"puesto contacto",
					"email":"emarroquin@ceajalisco.gob.mx",
					"fecha_act":"23/11/2014",
					"interno":1,
					"cea":1,
					"tasa":0,
					"activo":1
				},
				{
					"id_cliente":7,
					"id_organismo":1,
					"cliente":"CEA Jalisco",
					"area":"Gerencia de Servicio a Municipios",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Av. Francia",
					"numero":"1726",
					"colonia":"Col. Moderna",
					"cp":"44190",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14039,
					"municipio":"Guadalajara",
					"id_localidad":140390001,
					"localidad":"Guadalajara",
					"tel":"3030-9200 ext. 8221",
					"fax":"",
					"contacto":"Arq. José Manuel Gómez Padilla",
					"puesto_contacto":"puesto contacto",
					"email":"jgomez@ceajalisco.gob.mx",
					"fecha_act":"23/11/2014",
					"interno":1,
					"cea":1,
					"tasa":0,
					"activo":1
				},
				{
					"id_cliente":8,
					"id_organismo":1,
					"cliente":"CEA Jalisco",
					"area":"Gerencia de Formulación de Proyectos",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Av. Francia",
					"numero":"1726",
					"colonia":"Col. Moderna",
					"cp":"44190",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14039,
					"municipio":"Guadalajara",
					"id_localidad":140390001,
					"localidad":"Guadalajara",
					"tel":"3030-9200 ext. 8108",
					"fax":"",
					"contacto":"Gustavo Luna González",
					"puesto_contacto":"puesto contacto",
					"email":"gluna@ceajalisco.gob.mx",
					"fecha_act":"23/11/2014",
					"interno":1,
					"cea":1,
					"tasa":0,
					"activo":1
				},
				{
					"id_cliente":9,
					"id_organismo":2,
					"cliente":"Comisión Nacional del Agua",
					"area":"",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Av. Federalismo Norte",
					"numero":"275",
					"colonia":"Col. Centro",
					"cp":"44100",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14039,
					"municipio":"Guadalajara",
					"id_localidad":140390001,
					"localidad":"Guadalajara",
					"tel":"3268-0200 ext.1530",
					"fax":"",
					"contacto":"Ing. J. Jesús Amezcua Cerda",
					"puesto_contacto":"puesto contacto",
					"email":"jamezcua@conagua.gob.mx",
					"fecha_act":"23/11/2014",
					"interno":1,
					"cea":0,
					"tasa":0,
					"activo":1
				},
				{
					"id_cliente":10,
					"id_organismo":3,
					"cliente":"Procuraduria Estatal de Protección al Ambiente (PROEPA)",
					"area":"",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Circ. Agustín Yáñez esq. Av. Niños Héroes",
					"numero":"2343",
					"colonia":"Col. Arcos",
					"cp":"44130",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14039,
					"municipio":"Guadalajara",
					"id_localidad":140390001,
					"localidad":"Guadalajara",
					"tel":"1199-7550 ext. 56212",
					"fax":"",
					"contacto":"Lic. Sergio Enrique Arias García",
					"puesto_contacto":"puesto contacto",
					"email":"sergio.arias@jalisco.gob.mx",
					"fecha_act":"23/11/2014",
					"interno":1,
					"cea":0,
					"tasa":0,
					"activo":1
				},
				{
					"id_cliente":11,
					"id_organismo":4,
					"cliente":"Ministerio Público de la Federación",
					"area":"Agencia II Investigadora",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Av. 16 de septiembre",
					"numero":"591",
					"colonia":"Col. Mexicaltzingo",
					"cp":"44180",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14039,
					"municipio":"Guadalajara",
					"id_localidad":140390001,
					"localidad":"Guadalajara",
					"tel":"3942-3349",
					"fax":"",
					"contacto":"Lic. César Melendez Ibarra",
					"puesto_contacto":"puesto contacto",
					"email":"",
					"fecha_act":"23/11/2014",
					"interno":1,
					"cea":0,
					"tasa":0,
					"activo":1
				},
				{
					"id_cliente":12,
					"id_organismo":5,
					"cliente":"Secretaria de Salud Jalisco",
					"area":"Región Sanitaria XII centro - Tlaquepaque",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Los Ángeles esq. Analco",
					"numero":"S/N",
					"colonia":"Col. Las Conchas",
					"cp":"44600",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14039,
					"municipio":"Guadalajara",
					"id_localidad":140390001,
					"localidad":"Guadalajara",
					"tel":"3030-5600",
					"fax":"",
					"contacto":"Dr. Juan Jóse González Chávez",
					"puesto_contacto":"puesto contacto",
					"email":"",
					"fecha_act":"23/11/2014",
					"interno":1,
					"cea":0,
					"tasa":0,
					"activo":1
				},
				{
					"id_cliente":13,
					"id_organismo":6,
					"cliente":"Ayuntamiento de Cotija, Michoacan",
					"area":"",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Pino Suárez Pte.",
					"numero":"100",
					"colonia":"Col. Centro",
					"cp":"59940",
					"id_estado":16,
					"estado":"Michoacán de Ocampo",
					"id_municipio":16019,
					"municipio":"Cotija",
					"id_localidad":160190001,
					"localidad":"Cotija de La Paz",
					"tel":"045-35-4100-1836",
					"fax":"",
					"contacto":"Arq. Juan Jesús Zarate Barajas",
					"puesto_contacto":"puesto contacto",
					"email":"ooapascotija@hotmail.com",
					"fecha_act":"23/11/2014",
					"interno":0,
					"cea":0,
					"tasa":1,
					"activo":1
				},
				{
					"id_cliente":14,
					"id_organismo":7,
					"cliente":"Biosoluciones Integrales S.A. de C.V.",
					"area":"",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Río Orinoco",
					"numero":"213B Int. 203",
					"colonia":"Col. Del Valle",
					"cp":"66220",
					"id_estado":19,
					"estado":"Nuevo León",
					"id_municipio":19019,
					"municipio":"San Pedro Garza García",
					"id_localidad":190190001,
					"localidad":"San Pedro Garza García",
					"tel":"3168-4358",
					"fax":"",
					"contacto":"Ing. Jorge de la Cruz",
					"puesto_contacto":"puesto contacto",
					"email":"jorge-eduardo@bio-si.com.mx",
					"fecha_act":"23/11/2014",
					"interno":0,
					"cea":0,
					"tasa":1,
					"activo":1
				},
				{
					"id_cliente":15,
					"id_organismo":8,
					"cliente":"Consultoria Obras y Supervisión S.A. de C.V.",
					"area":"",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Tratado de Tlatelolco",
					"numero":"4201",
					"colonia":"Col. Jardines del Provenir",
					"cp":"45186",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14120,
					"municipio":"Zapopan",
					"id_localidad":141200001,
					"localidad":"Zapopan",
					"tel":"3861-8339",
					"fax":"",
					"contacto":"Cecilio Santos Villanueva",
					"puesto_contacto":"puesto contacto",
					"email":"cossa_02@yahoo.es",
					"fecha_act":"23/11/2014",
					"interno":0,
					"cea":0,
					"tasa":1,
					"activo":1
				},
				{
					"id_cliente":16,
					"id_organismo":9,
					"cliente":"Estudios Técnicos Ambientales y de Higiene Laboral S.A. de C.V.",
					"area":"",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Av. Sierra de Tapalpa",
					"numero":"2880",
					"colonia":"Col. Colinas de Las Águilas",
					"cp":"45080",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14120,
					"municipio":"Zapopan",
					"id_localidad":141200001,
					"localidad":"Zapopan",
					"tel":"3135-2158",
					"fax":"",
					"contacto":"Biol. María de Jesús",
					"puesto_contacto":"puesto contacto",
					"email":"esteam@prodigy.net.mx",
					"fecha_act":"23/11/2014",
					"interno":0,
					"cea":0,
					"tasa":1,
					"activo":1
				},
				{
					"id_cliente":17,
					"id_organismo":10,
					"cliente":"Instituto Tecnológico Superior de Arandas, Jalisco",
					"area":"",
					"rfc":"Registro Federal de Contribuyentes",
					"domicilio":"Libramiento Sur, km 2.7, Arandas, Jalisco",
					"calle":"Libramiento Sur",
					"numero":"Km 2.7",
					"colonia":"Arandas Centro",
					"cp":"47180",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14008,
					"municipio":"Arandas",
					"id_localidad":140080001,
					"localidad":"Arandas",
					"tel":"01-348-783-2010",
					"fax":"",
					"contacto":"Francisco López López",
					"puesto_contacto":"puesto contacto",
					"email":"francisco.lopez@tecarandas.edu.mx",
					"fecha_act":"23/11/2014",
					"interno":0,
					"cea":0,
					"tasa":1,
					"activo":1
				},
				{
					"id_cliente":18,
					"id_organismo":11,
					"cliente":"Instituto Tecnológico Superior de la Huerta",
					"area":"",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Rafael Palomera",
					"numero":"161",
					"colonia":"Col. El Maguey",
					"cp":"48850",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14043,
					"municipio":"La Huerta",
					"id_localidad":140430001,
					"localidad":"La Huerta",
					"tel":"01-357-384-0440",
					"fax":"",
					"contacto":"Ing. Ramón de Niz García",
					"puesto_contacto":"puesto contacto",
					"email":"compras@itslahuerta.edu.mx",
					"fecha_act":"23/11/2014",
					"interno":0,
					"cea":0,
					"tasa":1,
					"activo":1
				},
				{
					"id_cliente":19,
					"id_organismo":12,
					"cliente":"Instituto Tecnológico Superior de Zapotlanejo",
					"area":"",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Av. Tecnológico",
					"numero":"300",
					"colonia":"predio Huejotitlán",
					"cp":"45430",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14124,
					"municipio":"Zapotlanejo",
					"id_localidad":141240001,
					"localidad":"Zapotlanejo",
					"tel":"01-373-735-6060",
					"fax":"",
					"contacto":"Ing. Raúl Arambula",
					"puesto_contacto":"puesto contacto",
					"email":"jrulas2011@gmail.com",
					"fecha_act":"23/11/2014",
					"interno":0,
					"cea":0,
					"tasa":1,
					"activo":1
				},
				{
					"id_cliente":20,
					"id_organismo":13,
					"cliente":"OMEX Alimentaria S.A. de C.V.",
					"area":"",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Carr. Fed. Ayotlán-La Piedad",
					"numero":"Km 3.5",
					"colonia":"Col. El Bajío",
					"cp":"47930",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14016,
					"municipio":"Ayotlán",
					"id_localidad":140160001,
					"localidad":"Ayotlán",
					"tel":"044-33-3114-9580",
					"fax":"",
					"contacto":"Bernardo Pulido Valdés",
					"puesto_contacto":"puesto contacto",
					"email":"bernardo.pulido@gmail.com",
					"fecha_act":"23/11/2014",
					"interno":0,
					"cea":0,
					"tasa":1,
					"activo":1
				},
				{
					"id_cliente":21,
					"id_organismo":14,
					"cliente":"SECOLAM S.A. de C.V.",
					"area":"",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"De los Fiordos",
					"numero":"16",
					"colonia":"Col. Acueducto de Guadalupe",
					"cp":"07279",
					"id_estado":9,
					"estado":"Distrito Federal",
					"id_municipio":9007,
					"municipio":"Gustavo A. Madero",
					"id_localidad":90070001,
					"localidad":"Gustavo A. Madero",
					"tel":"1567-4406",
					"fax":"",
					"contacto":"Ing. Roberto Escalante Villanueva",
					"puesto_contacto":"puesto contacto",
					"email":"rescalante@secovam.com",
					"fecha_act":"23/11/2014",
					"interno":0,
					"cea":0,
					"tasa":1,
					"activo":1
				}
			]
		';
		return $result;
	}

	public function getClient($clientId) {
		if ($clientId == 1)
		{
			$result = '
				{
					"id_cliente":1,
					"id_organismo":1,
					"cliente":"CEA Jalisco",
					"area":"Dirección de Operación de PTARS",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Av. Brasilia",
					"numero":"2970",
					"colonia":"Col. Colomos Providencia",
					"cp":"44680",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14039,
					"municipio":"Guadalajara",
					"id_localidad":140390001,
					"localidad":"Guadalajara",
					"tel":"3030-9350 ext. 8370",
					"fax":"",
					"contacto":"Biol. Luis Aceves Martínez",
					"puesto_contacto":"puesto contacto",
					"email":"laceves@ceajalisco.gob.mx",
					"fecha_act":"23/11/2014",
					"interno":1,
					"cea":1,
					"tasa":0,
					"activo":1
				}
			';
		}
		else
		{
			$result = '
				{
					"id_cliente":0,
					"id_organismo":0,
					"cliente":"",
					"area":"",
					"rfc":"",
					"calle":"",
					"numero":"",
					"colonia":"",
					"cp":"",
					"id_estado":14,
					"estado":"Jalisco",
					"id_municipio":14001,
					"municipio":"Acatic",
					"id_localidad":140010001,
					"localidad":"Acatic",
					"tel":"",
					"fax":"",
					"contacto":"",
					"puesto_contacto":"",
					"email":"",
					"fecha_act":"",
					"interno":0,
					"cea":0,
					"tasa":0,
					"activo":1
				}
			';
		}
		return $result;
	}

	public function getParameters() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		parametro";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_parametro":1,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":6,
					"id_metodo":1,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Acidez Total",
					"parametro":"Acidez Total",
					"metodo":"NMX-AA-036-SCFI-2001",
					"caducidad":24,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg CaCO₃\/l",
					"descripcion_unidad":"mg CaCO₃\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":2,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":6,
					"id_metodo":1,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Alc. Fenolftaleína",
					"parametro":"Alcalinidad a la Fenolftaleína",
					"metodo":"NMX-AA-036-SCFI-2001",
					"caducidad":24,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg CaCO₃\/l",
					"descripcion_unidad":"mg CaCO₃\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":3,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":6,
					"id_metodo":1,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Alc. Total",
					"parametro":"Alcalinidad Total",
					"metodo":"NMX-AA-036-SCFI-2001",
					"caducidad":24,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg CaCO₃\/l",
					"descripcion_unidad":"mg CaCO₃\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":4,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":13,
					"id_metodo":2,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Cloruros Totales",
					"parametro":"Cloruros Totales",
					"metodo":"NMX-AA-073-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"Cl⁻ mg\/l",
					"descripcion_unidad":"Cl⁻ mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":120,
					"selected":false
				},
				{
					"id_parametro":5,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":6,
					"id_metodo":3,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Dureza Calcio",
					"parametro":"Dureza de Calcio",
					"metodo":"SM-3500-Ca D",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg CaCO₃\/l",
					"descripcion_unidad":"mg CaCO₃\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":6,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":6,
					"id_metodo":4,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Dureza Magnesio",
					"parametro":"Dureza de Magnesio",
					"metodo":"SM-3500-Mg E",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg CaCO₃\/l",
					"descripcion_unidad":"mg CaCO₃\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":7,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":6,
					"id_metodo":5,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Dureza Total",
					"parametro":"Dureza Total",
					"metodo":"NMX-AA-072-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg CaCO₃\/l",
					"descripcion_unidad":"mg CaCO₃\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":120,
					"selected":false
				},
				{
					"id_parametro":8,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":6,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Fósforo Total",
					"parametro":"Fósforo Total",
					"metodo":"NMX-AA-029-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":10,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":8,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Fósforo Ortofosfatos",
					"parametro":"Fósforo de Ortofosfatos",
					"metodo":"SM-4500-P A",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":0,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":11,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":12,
					"id_metodo":9,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Color Aparente",
					"parametro":"Color Aparente",
					"metodo":"NMX-AA-045-SCFI-1993",
					"caducidad":48,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"U (Pt-Co)",
					"descripcion_unidad":"U (Pt-Co)",
					"acreditado":1,
					"limite_entrega":144,
					"precio":0,
					"selected":false
				},
				{
					"id_parametro":12,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":12,
					"id_metodo":10,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Color Verdadero",
					"parametro":"Color Verdadero",
					"metodo":"NMX-AA-045-SCFI-2001",
					"caducidad":48,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"U (Pt-Co)",
					"descripcion_unidad":"U (Pt-Co)",
					"acreditado":1,
					"limite_entrega":144,
					"precio":60,
					"selected":false
				},
				{
					"id_parametro":13,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":11,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Fenoles",
					"parametro":"Fenoles",
					"metodo":"NMX-AA-050-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":200,
					"selected":false
				},
				{
					"id_parametro":14,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":12,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Grasas y Aceites",
					"parametro":"Grasas y Aceites",
					"metodo":"NMX-AA-005-SCFI-2013",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":15,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":13,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"SAAM",
					"parametro":"Sustancias Activas al Azul de Metileno",
					"metodo":"NMX-AA-039-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":180,
					"selected":false
				},
				{
					"id_parametro":16,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":5,
					"id_metodo":14,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Turbiedad",
					"parametro":"Turbiedad",
					"metodo":"NMX-AA-038-SCFI-2001",
					"caducidad":24,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"UNT",
					"descripcion_unidad":"UNT",
					"acreditado":1,
					"limite_entrega":144,
					"precio":50,
					"selected":false
				},
				{
					"id_parametro":17,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":15,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"DBO",
					"parametro":"Demanda Bioquímica de Oxígeno",
					"metodo":"NMX-AA-028-SCFI-2001",
					"caducidad":24,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":18,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":15,
					"id_metodo":16,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"DBO Soluble",
					"parametro":"Demanda Bioquímica de Oxígeno Soluble",
					"metodo":"NMX-AA-030\/2-SCFI-2012",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg O2\/l",
					"descripcion_unidad":"mg O2\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":175,
					"selected":false
				},
				{
					"id_parametro":19,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":17,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Fluoruros",
					"parametro":"Fluoruros",
					"metodo":"NMX-AA-077-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":20,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":18,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Sulfatos",
					"parametro":"Sulfatos",
					"metodo":"NMX-AA-074-1981",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":21,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":19,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Nitrógeno Orgánico",
					"parametro":"Nitrógeno Orgánico",
					"metodo":"NMX-AA-026-SCFI-2010",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":22,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":19,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Nitrógeno Amoniacal",
					"parametro":"Nitrógeno Amoniacal",
					"metodo":"NMX-AA-026-SCFI-2010",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":23,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":20,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Nitrógeno Nitratos",
					"parametro":"Nitrógeno de Nitratos",
					"metodo":"NMX-AA-079-SCFI-2001",
					"caducidad":48,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":24,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":21,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Nitrógeno Nitritos",
					"parametro":"Nitrógeno de Nitritos",
					"metodo":"NMX-AA-099-SCFI-2006",
					"caducidad":24,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":25,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":22,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Nitrógeno Total",
					"parametro":"Nitrógeno Total",
					"metodo":"NMX-AA-[026, 079, 099]-SCFI-[2010, 2001, 2006]",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":220,
					"selected":false
				},
				{
					"id_parametro":27,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":19,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Nitrógeno Kjeldahl",
					"parametro":"Nitrógeno Total Kjeldahl",
					"metodo":"NMX-AA-026-SCFI-2010",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":160,
					"selected":false
				},
				{
					"id_parametro":28,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":24,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Cromo Hexavalente",
					"parametro":"Cromo Hexavalente",
					"metodo":"NMX-AA-044-SCFI-2001",
					"caducidad":24,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":120,
					"selected":false
				},
				{
					"id_parametro":30,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":26,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Sílice",
					"parametro":"Sílice Reactiva",
					"metodo":"NMX-AA-075-1982",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":31,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":27,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"SD Fijos",
					"parametro":"Sólidos Disueltos Fijos",
					"metodo":"NMX-AA-034-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":32,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":27,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"SD Totales",
					"parametro":"Sólidos Disueltos Totales",
					"metodo":"NMX-AA-034-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":33,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":27,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"SD Volátiles",
					"parametro":"Sólidos Disueltos Volátiles",
					"metodo":"NMX-AA-034-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":34,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":28,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"S Sedimentables",
					"parametro":"Sólidos Sedimentables",
					"metodo":"NMX-AA-004-SCFI-2013",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"ml\/l",
					"descripcion_unidad":"ml\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":50,
					"selected":false
				},
				{
					"id_parametro":35,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":27,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"SS Fijos",
					"parametro":"Sólidos Suspendidos Fijos",
					"metodo":"NMX-AA-034-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":36,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":27,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"SS Totales",
					"parametro":"Sólidos Suspendidos Totales",
					"metodo":"NMX-AA-034-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":37,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":27,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"SS Volátiles",
					"parametro":"Sólidos Suspendidos Volátiles",
					"metodo":"NMX-AA-034-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":38,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":27,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"S Totales",
					"parametro":"Sólidos Totales",
					"metodo":"NMX-AA-034-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":40,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":27,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"ST Fijos",
					"parametro":"Sólidos Totales Fijos",
					"metodo":"NMX-AA-034-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":41,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":27,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"ST Volátiles",
					"parametro":"Sólidos Totales Volátiles",
					"metodo":"NMX-AA-034-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":43,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":30,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Sulfuros",
					"parametro":"Sulfuros",
					"metodo":"NMX-AA-084-1982",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":0,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":44,
					"id_tipo_parametro":4,
					"id_area":4,
					"id_unidad":2,
					"id_metodo":31,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Temp.",
					"parametro":"Temperatura",
					"metodo":"NMX-AA-007-SCFI-2013",
					"caducidad":0,
					"area":"Muestreo",
					"unidad":"°C",
					"descripcion_unidad":"°C",
					"acreditado":1,
					"limite_entrega":120,
					"precio":30,
					"selected":false
				},
				{
					"id_parametro":45,
					"id_tipo_parametro":4,
					"id_area":4,
					"id_unidad":3,
					"id_metodo":32,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"pH",
					"parametro":"Potencial de Hidrógeno",
					"metodo":"NMX-AA-008-SCFI-2011",
					"caducidad":6,
					"area":"Muestreo",
					"unidad":"U de pH ",
					"descripcion_unidad":"U de pH ",
					"acreditado":1,
					"limite_entrega":120,
					"precio":50,
					"selected":false
				},
				{
					"id_parametro":46,
					"id_tipo_parametro":4,
					"id_area":4,
					"id_unidad":17,
					"id_metodo":33,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Cond.",
					"parametro":"Conductividad",
					"metodo":"NMX-AA-093-SCFI-2000",
					"caducidad":24,
					"area":"Muestreo",
					"unidad":"mS\/m",
					"descripcion_unidad":"mS\/m",
					"acreditado":1,
					"limite_entrega":120,
					"precio":50,
					"selected":false
				},
				{
					"id_parametro":47,
					"id_tipo_parametro":4,
					"id_area":4,
					"id_unidad":1,
					"id_metodo":34,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"O2 Disuelto",
					"parametro":"Oxígeno Disuelto",
					"metodo":"NMX-AA-012-SCFI-2001",
					"caducidad":6,
					"area":"Muestreo",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":120,
					"precio":50,
					"selected":false
				},
				{
					"id_parametro":48,
					"id_tipo_parametro":4,
					"id_area":4,
					"id_unidad":18,
					"id_metodo":35,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Materia Flotante",
					"parametro":"Materia Flotante",
					"metodo":"NMX-AA-006-SCFI-2010",
					"caducidad":0,
					"area":"Muestreo",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":1,
					"limite_entrega":120,
					"precio":30,
					"selected":false
				},
				{
					"id_parametro":52,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Aluminio",
					"parametro":"Aluminio",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":53,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Arsénico",
					"parametro":"Arsénico",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":54,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Bario",
					"parametro":"Bario",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":55,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Cadmio",
					"parametro":"Cadmio",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":56,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Cobre",
					"parametro":"Cobre",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":57,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Cromo",
					"parametro":"Cromo",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":58,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Fierro",
					"parametro":"Fierro",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":59,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Manganeso",
					"parametro":"Manganeso",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":60,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Mercurio",
					"parametro":"Mercurio",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":61,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Niquel",
					"parametro":"Níquel",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":62,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Plomo",
					"parametro":"Plomo",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":63,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Sodio",
					"parametro":"Sodio",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":64,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Calcio",
					"parametro":"Calcio",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":65,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Magnesio",
					"parametro":"Magnesio",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":200,
					"selected":false
				},
				{
					"id_parametro":66,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Potasio",
					"parametro":"Potasio",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":67,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Zinc",
					"parametro":"Zinc",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":77,
					"id_tipo_parametro":3,
					"id_area":3,
					"id_unidad":8,
					"id_metodo":41,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Coliformes Tot.",
					"parametro":"Coliformes Totales",
					"metodo":"NMX-AA-042-1987",
					"caducidad":6,
					"area":"Microbiología",
					"unidad":"NMP\/100 ml",
					"descripcion_unidad":"NMP\/100 ml",
					"acreditado":1,
					"limite_entrega":120,
					"precio":160,
					"selected":false
				},
				{
					"id_parametro":78,
					"id_tipo_parametro":3,
					"id_area":3,
					"id_unidad":8,
					"id_metodo":41,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Coliformes Fecales",
					"parametro":"Coliformes Fecales",
					"metodo":"NMX-AA-042-1987",
					"caducidad":6,
					"area":"Microbiología",
					"unidad":"NMP\/100 ml",
					"descripcion_unidad":"NMP\/100 ml",
					"acreditado":1,
					"limite_entrega":120,
					"precio":160,
					"selected":false
				},
				{
					"id_parametro":79,
					"id_tipo_parametro":3,
					"id_area":3,
					"id_unidad":20,
					"id_metodo":42,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Coliformes Tot. (UFC)",
					"parametro":"Coliformes Totales (UFC)",
					"metodo":"NMX-AA-102-SCFI-2006",
					"caducidad":24,
					"area":"Microbiología",
					"unidad":"UFC\/100 ml",
					"descripcion_unidad":"UFC\/100 ml",
					"acreditado":1,
					"limite_entrega":120,
					"precio":160,
					"selected":false
				},
				{
					"id_parametro":80,
					"id_tipo_parametro":3,
					"id_area":3,
					"id_unidad":20,
					"id_metodo":42,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Coliformes Fecales (UFC)",
					"parametro":"Coliformes Fecales (UFC)",
					"metodo":"NMX-AA-102-SCFI-2006",
					"caducidad":24,
					"area":"Microbiología",
					"unidad":"UFC\/100 ml",
					"descripcion_unidad":"UFC\/100 ml",
					"acreditado":1,
					"limite_entrega":120,
					"precio":160,
					"selected":false
				},
				{
					"id_parametro":81,
					"id_tipo_parametro":3,
					"id_area":3,
					"id_unidad":21,
					"id_metodo":43,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Huevos Helminto",
					"parametro":"Huevos de Helminto",
					"metodo":"NMX-AA-113-SCFI-2012",
					"caducidad":-1,
					"area":"Microbiología",
					"unidad":"H\/l",
					"descripcion_unidad":"H\/l",
					"acreditado":1,
					"limite_entrega":120,
					"precio":200,
					"selected":false
				},
				{
					"id_parametro":82,
					"id_tipo_parametro":3,
					"id_area":3,
					"id_unidad":22,
					"id_metodo":44,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Clorofilas - a",
					"parametro":"Clorofilas - a",
					"metodo":"SM-10200-H",
					"caducidad":-1,
					"area":"Microbiología",
					"unidad":"mg\/m³",
					"descripcion_unidad":"mg\/m³",
					"acreditado":1,
					"limite_entrega":120,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":83,
					"id_tipo_parametro":3,
					"id_area":3,
					"id_unidad":22,
					"id_metodo":45,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Clorofilas - b",
					"parametro":"Clorofilas - b",
					"metodo":"SM-10200-H",
					"caducidad":-1,
					"area":"Microbiología",
					"unidad":"mg\/m³",
					"descripcion_unidad":"mg\/m³",
					"acreditado":1,
					"limite_entrega":120,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":84,
					"id_tipo_parametro":3,
					"id_area":3,
					"id_unidad":22,
					"id_metodo":45,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Clorofilas - c",
					"parametro":"Clorofilas - c",
					"metodo":"SM-10200-H",
					"caducidad":-1,
					"area":"Microbiología",
					"unidad":"mg\/m³",
					"descripcion_unidad":"mg\/m³",
					"acreditado":1,
					"limite_entrega":120,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":93,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Cianuros",
					"parametro":"Cianuros",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":300,
					"selected":false
				},
				{
					"id_parametro":94,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Cl Libre Residual",
					"parametro":"Cloro Libre Residual",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":60,
					"selected":false
				},
				{
					"id_parametro":95,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"DQO Soluble",
					"parametro":"Demanda Química de Oxigeno Soluble",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":160,
					"selected":false
				},
				{
					"id_parametro":96,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"DQO",
					"parametro":"Demanda Química de Oxigeno",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":130,
					"selected":false
				},
				{
					"id_parametro":97,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Herbicidas Clorados",
					"parametro":"Herbicidas Clorados (2,4 D)",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":1300,
					"selected":false
				},
				{
					"id_parametro":98,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Hidrocarburos BTEX",
					"parametro":"Hidrocarburos Aromáticos BTEX",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":1200,
					"selected":false
				},
				{
					"id_parametro":99,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Mesófilos Aerobios",
					"parametro":"Mesófilos Aerobios",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":100,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Nitrógeno (NO2+NO3)",
					"parametro":"Nitrógeno (NO2 + NO3)",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":101,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Plaguicidas Clorados",
					"parametro":"Plaguicidas Clorados",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":1500,
					"selected":false
				},
				{
					"id_parametro":102,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Prueba Jarras",
					"parametro":"Prueba de Jarras",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":5000,
					"selected":false
				},
				{
					"id_parametro":103,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Thrihalometanos",
					"parametro":"Trihalometanos",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":1000,
					"selected":false
				},
				{
					"id_parametro":104,
					"id_tipo_parametro":4,
					"id_area":4,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Gasto",
					"parametro":"Gasto",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"",
					"descripcion_unidad":"",
					"acreditado":0,
					"limite_entrega":null,
					"precio":0,
					"selected":false
				},
				{
					"id_parametro":105,
					"id_tipo_parametro":4,
					"id_area":4,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Olor",
					"parametro":"Olor",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"",
					"descripcion_unidad":"",
					"acreditado":0,
					"limite_entrega":null,
					"precio":0,
					"selected":false
				},
				{
					"id_parametro":106,
					"id_tipo_parametro":4,
					"id_area":4,
					"id_unidad":11,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Profundidad",
					"parametro":"Profundidad",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"m",
					"descripcion_unidad":"m",
					"acreditado":0,
					"limite_entrega":null,
					"precio":0,
					"selected":false
				}
			]
		';
		return $result;
	}

	public function getAllParameters() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		parametro";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_parametro":1,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":6,
					"id_metodo":1,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Acidez Total",
					"parametro":"Acidez Total",
					"metodo":"NMX-AA-036-SCFI-2001",
					"caducidad":24,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg CaCO₃\/l",
					"descripcion_unidad":"mg CaCO₃\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":2,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":6,
					"id_metodo":1,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Alc. Fenolftaleína",
					"parametro":"Alcalinidad a la Fenolftaleína",
					"metodo":"NMX-AA-036-SCFI-2001",
					"caducidad":24,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg CaCO₃\/l",
					"descripcion_unidad":"mg CaCO₃\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":3,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":6,
					"id_metodo":1,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Alc. Total",
					"parametro":"Alcalinidad Total",
					"metodo":"NMX-AA-036-SCFI-2001",
					"caducidad":24,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg CaCO₃\/l",
					"descripcion_unidad":"mg CaCO₃\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":4,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":13,
					"id_metodo":2,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Cloruros Totales",
					"parametro":"Cloruros Totales",
					"metodo":"NMX-AA-073-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"Cl⁻ mg\/l",
					"descripcion_unidad":"Cl⁻ mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":120,
					"selected":false
				},
				{
					"id_parametro":5,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":6,
					"id_metodo":3,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Dureza Calcio",
					"parametro":"Dureza de Calcio",
					"metodo":"SM-3500-Ca D",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg CaCO₃\/l",
					"descripcion_unidad":"mg CaCO₃\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":6,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":6,
					"id_metodo":4,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Dureza Magnesio",
					"parametro":"Dureza de Magnesio",
					"metodo":"SM-3500-Mg E",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg CaCO₃\/l",
					"descripcion_unidad":"mg CaCO₃\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":7,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":6,
					"id_metodo":5,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Dureza Total",
					"parametro":"Dureza Total",
					"metodo":"NMX-AA-072-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg CaCO₃\/l",
					"descripcion_unidad":"mg CaCO₃\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":120,
					"selected":false
				},
				{
					"id_parametro":8,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":6,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Fósforo Total",
					"parametro":"Fósforo Total",
					"metodo":"NMX-AA-029-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":9,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":14,
					"id_metodo":7,
					"id_tipo_matriz":2,
					"tipo_matriz":"Lodos",
					"param":"Fósforo Total",
					"parametro":"Fósforo Total (Lodos)",
					"metodo":"NMX-AA-94-1985",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"g\/Kg",
					"descripcion_unidad":"g\/Kg",
					"acreditado":0,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":10,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":8,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Fósforo Ortofosfatos",
					"parametro":"Fósforo de Ortofosfatos",
					"metodo":"SM-4500-P A",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":0,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":11,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":12,
					"id_metodo":9,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Color Aparente",
					"parametro":"Color Aparente",
					"metodo":"NMX-AA-045-SCFI-1993",
					"caducidad":48,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"U (Pt-Co)",
					"descripcion_unidad":"U (Pt-Co)",
					"acreditado":1,
					"limite_entrega":144,
					"precio":0,
					"selected":false
				},
				{
					"id_parametro":12,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":12,
					"id_metodo":10,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Color Verdadero",
					"parametro":"Color Verdadero",
					"metodo":"NMX-AA-045-SCFI-2001",
					"caducidad":48,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"U (Pt-Co)",
					"descripcion_unidad":"U (Pt-Co)",
					"acreditado":1,
					"limite_entrega":144,
					"precio":60,
					"selected":false
				},
				{
					"id_parametro":13,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":11,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Fenoles",
					"parametro":"Fenoles",
					"metodo":"NMX-AA-050-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":200,
					"selected":false
				},
				{
					"id_parametro":14,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":12,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Grasas y Aceites",
					"parametro":"Grasas y Aceites",
					"metodo":"NMX-AA-005-SCFI-2013",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":15,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":13,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"SAAM",
					"parametro":"Sustancias Activas al Azul de Metileno",
					"metodo":"NMX-AA-039-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":180,
					"selected":false
				},
				{
					"id_parametro":16,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":5,
					"id_metodo":14,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Turbiedad",
					"parametro":"Turbiedad",
					"metodo":"NMX-AA-038-SCFI-2001",
					"caducidad":24,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"UNT",
					"descripcion_unidad":"UNT",
					"acreditado":1,
					"limite_entrega":144,
					"precio":50,
					"selected":false
				},
				{
					"id_parametro":17,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":15,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"DBO",
					"parametro":"Demanda Bioquímica de Oxígeno",
					"metodo":"NMX-AA-028-SCFI-2001",
					"caducidad":24,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":18,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":15,
					"id_metodo":16,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"DBO Soluble",
					"parametro":"Demanda Bioquímica de Oxígeno Soluble",
					"metodo":"NMX-AA-030\/2-SCFI-2012",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg O2\/l",
					"descripcion_unidad":"mg O2\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":175,
					"selected":false
				},
				{
					"id_parametro":19,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":17,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Fluoruros",
					"parametro":"Fluoruros",
					"metodo":"NMX-AA-077-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":20,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":18,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Sulfatos",
					"parametro":"Sulfatos",
					"metodo":"NMX-AA-074-1981",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":21,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":19,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Nitrógeno Orgánico",
					"parametro":"Nitrógeno Orgánico",
					"metodo":"NMX-AA-026-SCFI-2010",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":22,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":19,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Nitrógeno Amoniacal",
					"parametro":"Nitrógeno Amoniacal",
					"metodo":"NMX-AA-026-SCFI-2010",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":23,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":20,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Nitrógeno Nitratos",
					"parametro":"Nitrógeno de Nitratos",
					"metodo":"NMX-AA-079-SCFI-2001",
					"caducidad":48,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":24,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":21,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Nitrógeno Nitritos",
					"parametro":"Nitrógeno de Nitritos",
					"metodo":"NMX-AA-099-SCFI-2006",
					"caducidad":24,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":25,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":22,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Nitrógeno Total",
					"parametro":"Nitrógeno Total",
					"metodo":"NMX-AA-[026, 079, 099]-SCFI-[2010, 2001, 2006]",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":220,
					"selected":false
				},
				{
					"id_parametro":26,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":14,
					"id_metodo":23,
					"id_tipo_matriz":2,
					"tipo_matriz":"Lodos",
					"param":"Nitrógeno Total (Lodos)",
					"parametro":"Nitrógeno Total (Lodos)",
					"metodo":"NMX-AA-024-1984",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"g\/Kg",
					"descripcion_unidad":"g\/Kg",
					"acreditado":0,
					"limite_entrega":144,
					"precio":220,
					"selected":false
				},
				{
					"id_parametro":27,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":19,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Nitrógeno Kjeldahl",
					"parametro":"Nitrógeno Total Kjeldahl",
					"metodo":"NMX-AA-026-SCFI-2010",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":160,
					"selected":false
				},
				{
					"id_parametro":28,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":24,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Cromo Hexavalente",
					"parametro":"Cromo Hexavalente",
					"metodo":"NMX-AA-044-SCFI-2001",
					"caducidad":24,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":120,
					"selected":false
				},
				{
					"id_parametro":29,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":16,
					"id_metodo":25,
					"id_tipo_matriz":2,
					"tipo_matriz":"Lodos",
					"param":"Sequedad",
					"parametro":"Sequedad",
					"metodo":"NOM-004-SEMARNAT-2002",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"%",
					"descripcion_unidad":"%",
					"acreditado":0,
					"limite_entrega":144,
					"precio":0,
					"selected":false
				},
				{
					"id_parametro":30,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":26,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Sílice",
					"parametro":"Sílice Reactiva",
					"metodo":"NMX-AA-075-1982",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":31,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":27,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"SD Fijos",
					"parametro":"Sólidos Disueltos Fijos",
					"metodo":"NMX-AA-034-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":32,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":27,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"SD Totales",
					"parametro":"Sólidos Disueltos Totales",
					"metodo":"NMX-AA-034-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":33,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":27,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"SD Volátiles",
					"parametro":"Sólidos Disueltos Volátiles",
					"metodo":"NMX-AA-034-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":34,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":28,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"S Sedimentables",
					"parametro":"Sólidos Sedimentables",
					"metodo":"NMX-AA-004-SCFI-2013",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"ml\/l",
					"descripcion_unidad":"ml\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":50,
					"selected":false
				},
				{
					"id_parametro":35,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":27,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"SS Fijos",
					"parametro":"Sólidos Suspendidos Fijos",
					"metodo":"NMX-AA-034-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":36,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":27,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"SS Totales",
					"parametro":"Sólidos Suspendidos Totales",
					"metodo":"NMX-AA-034-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":37,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":27,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"SS Volátiles",
					"parametro":"Sólidos Suspendidos Volátiles",
					"metodo":"NMX-AA-034-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":38,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":27,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"S Totales",
					"parametro":"Sólidos Totales",
					"metodo":"NMX-AA-034-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":39,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":16,
					"id_metodo":25,
					"id_tipo_matriz":2,
					"tipo_matriz":"Lodos",
					"param":"S Totales",
					"parametro":"Sólidos Totales (Lodos)",
					"metodo":"NOM-004-SEMARNAT-2002",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"%",
					"descripcion_unidad":"%",
					"acreditado":0,
					"limite_entrega":144,
					"precio":0,
					"selected":false
				},
				{
					"id_parametro":40,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":27,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"ST Fijos",
					"parametro":"Sólidos Totales Fijos",
					"metodo":"NMX-AA-034-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":41,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":27,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"ST Volátiles",
					"parametro":"Sólidos Totales Volátiles",
					"metodo":"NMX-AA-034-SCFI-2001",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":42,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":16,
					"id_metodo":25,
					"id_tipo_matriz":2,
					"tipo_matriz":"Lodos",
					"param":"ST Volátiles (Lodos)",
					"parametro":"Sólidos Totales Volátiles (Lodos)",
					"metodo":"NOM-004-SEMARNAT-2002",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"%",
					"descripcion_unidad":"%",
					"acreditado":0,
					"limite_entrega":144,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":43,
					"id_tipo_parametro":1,
					"id_area":1,
					"id_unidad":1,
					"id_metodo":30,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Sulfuros",
					"parametro":"Sulfuros",
					"metodo":"NMX-AA-084-1982",
					"caducidad":-1,
					"area":"Gravimetría y Fisicoquímicos",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":0,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":44,
					"id_tipo_parametro":4,
					"id_area":4,
					"id_unidad":2,
					"id_metodo":31,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Temp.",
					"parametro":"Temperatura",
					"metodo":"NMX-AA-007-SCFI-2013",
					"caducidad":0,
					"area":"Muestreo",
					"unidad":"°C",
					"descripcion_unidad":"°C",
					"acreditado":1,
					"limite_entrega":120,
					"precio":30,
					"selected":false
				},
				{
					"id_parametro":45,
					"id_tipo_parametro":4,
					"id_area":4,
					"id_unidad":3,
					"id_metodo":32,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"pH",
					"parametro":"Potencial de Hidrógeno",
					"metodo":"NMX-AA-008-SCFI-2011",
					"caducidad":6,
					"area":"Muestreo",
					"unidad":"U de pH ",
					"descripcion_unidad":"U de pH ",
					"acreditado":1,
					"limite_entrega":120,
					"precio":50,
					"selected":false
				},
				{
					"id_parametro":46,
					"id_tipo_parametro":4,
					"id_area":4,
					"id_unidad":17,
					"id_metodo":33,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Cond.",
					"parametro":"Conductividad",
					"metodo":"NMX-AA-093-SCFI-2000",
					"caducidad":24,
					"area":"Muestreo",
					"unidad":"mS\/m",
					"descripcion_unidad":"mS\/m",
					"acreditado":1,
					"limite_entrega":120,
					"precio":50,
					"selected":false
				},
				{
					"id_parametro":47,
					"id_tipo_parametro":4,
					"id_area":4,
					"id_unidad":1,
					"id_metodo":34,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"O2 Disuelto",
					"parametro":"Oxígeno Disuelto",
					"metodo":"NMX-AA-012-SCFI-2001",
					"caducidad":6,
					"area":"Muestreo",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":120,
					"precio":50,
					"selected":false
				},
				{
					"id_parametro":48,
					"id_tipo_parametro":4,
					"id_area":4,
					"id_unidad":18,
					"id_metodo":35,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Materia Flotante",
					"parametro":"Materia Flotante",
					"metodo":"NMX-AA-006-SCFI-2010",
					"caducidad":0,
					"area":"Muestreo",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":1,
					"limite_entrega":120,
					"precio":30,
					"selected":false
				},
				{
					"id_parametro":52,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Aluminio",
					"parametro":"Aluminio",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":53,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Arsénico",
					"parametro":"Arsénico",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":54,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Bario",
					"parametro":"Bario",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":55,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Cadmio",
					"parametro":"Cadmio",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":56,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Cobre",
					"parametro":"Cobre",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":57,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Cromo",
					"parametro":"Cromo",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":58,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Fierro",
					"parametro":"Fierro",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":59,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Manganeso",
					"parametro":"Manganeso",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":60,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Mercurio",
					"parametro":"Mercurio",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":61,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Niquel",
					"parametro":"Níquel",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":62,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Plomo",
					"parametro":"Plomo",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":63,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Sodio",
					"parametro":"Sodio",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":64,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Calcio",
					"parametro":"Calcio",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":65,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Magnesio",
					"parametro":"Magnesio",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":200,
					"selected":false
				},
				{
					"id_parametro":66,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Potasio",
					"parametro":"Potasio",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":67,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":1,
					"id_metodo":39,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Zinc",
					"parametro":"Zinc",
					"metodo":"NMX-AA-051-SCFI-2001",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/l",
					"descripcion_unidad":"mg\/l",
					"acreditado":1,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":68,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":19,
					"id_metodo":25,
					"id_tipo_matriz":2,
					"tipo_matriz":"Lodos",
					"param":"Arsénico (Lodos)",
					"parametro":"Arsénico (Lodos)",
					"metodo":"NOM-004-SEMARNAT-2002",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/kg en base seca",
					"descripcion_unidad":"mg\/kg en base seca",
					"acreditado":0,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":69,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":19,
					"id_metodo":25,
					"id_tipo_matriz":2,
					"tipo_matriz":"Lodos",
					"param":"Cadmio (Lodos)",
					"parametro":"Cadmio (Lodos)",
					"metodo":"NOM-004-SEMARNAT-2002",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/kg en base seca",
					"descripcion_unidad":"mg\/kg en base seca",
					"acreditado":0,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":70,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":19,
					"id_metodo":25,
					"id_tipo_matriz":2,
					"tipo_matriz":"Lodos",
					"param":"Cobre (Lodos)",
					"parametro":"Cobre (Lodos)",
					"metodo":"NOM-004-SEMARNAT-2002",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/kg en base seca",
					"descripcion_unidad":"mg\/kg en base seca",
					"acreditado":0,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":71,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":19,
					"id_metodo":25,
					"id_tipo_matriz":2,
					"tipo_matriz":"Lodos",
					"param":"Cromo (Lodos)",
					"parametro":"Cromo (Lodos)",
					"metodo":"NOM-004-SEMARNAT-2002",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/kg en base seca",
					"descripcion_unidad":"mg\/kg en base seca",
					"acreditado":0,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":72,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":19,
					"id_metodo":25,
					"id_tipo_matriz":2,
					"tipo_matriz":"Lodos",
					"param":"Mercurio (Lodos)",
					"parametro":"Mercurio (Lodos)",
					"metodo":"NOM-004-SEMARNAT-2002",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/kg en base seca",
					"descripcion_unidad":"mg\/kg en base seca",
					"acreditado":0,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":73,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":19,
					"id_metodo":25,
					"id_tipo_matriz":2,
					"tipo_matriz":"Lodos",
					"param":"Níquel (Lodos)",
					"parametro":"Níquel (Lodos)",
					"metodo":"NOM-004-SEMARNAT-2002",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/kg en base seca",
					"descripcion_unidad":"mg\/kg en base seca",
					"acreditado":0,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":74,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":19,
					"id_metodo":25,
					"id_tipo_matriz":2,
					"tipo_matriz":"Lodos",
					"param":"Plomo (Lodos)",
					"parametro":"Plomo (Lodos)",
					"metodo":"NOM-004-SEMARNAT-2002",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/kg en base seca",
					"descripcion_unidad":"mg\/kg en base seca",
					"acreditado":0,
					"limite_entrega":144,
					"precio":170,
					"selected":false
				},
				{
					"id_parametro":75,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":19,
					"id_metodo":25,
					"id_tipo_matriz":2,
					"tipo_matriz":"Lodos",
					"param":"Zinc (Lodos)",
					"parametro":"Zinc (Lodos)",
					"metodo":"NOM-004-SEMARNAT-2002",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"mg\/kg en base seca",
					"descripcion_unidad":"mg\/kg en base seca",
					"acreditado":0,
					"limite_entrega":144,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":77,
					"id_tipo_parametro":3,
					"id_area":3,
					"id_unidad":8,
					"id_metodo":41,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Coliformes Tot.",
					"parametro":"Coliformes Totales",
					"metodo":"NMX-AA-042-1987",
					"caducidad":6,
					"area":"Microbiología",
					"unidad":"NMP\/100 ml",
					"descripcion_unidad":"NMP\/100 ml",
					"acreditado":1,
					"limite_entrega":120,
					"precio":160,
					"selected":false
				},
				{
					"id_parametro":78,
					"id_tipo_parametro":3,
					"id_area":3,
					"id_unidad":8,
					"id_metodo":41,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Coliformes Fecales",
					"parametro":"Coliformes Fecales",
					"metodo":"NMX-AA-042-1987",
					"caducidad":6,
					"area":"Microbiología",
					"unidad":"NMP\/100 ml",
					"descripcion_unidad":"NMP\/100 ml",
					"acreditado":1,
					"limite_entrega":120,
					"precio":160,
					"selected":false
				},
				{
					"id_parametro":79,
					"id_tipo_parametro":3,
					"id_area":3,
					"id_unidad":20,
					"id_metodo":42,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Coliformes Tot. (UFC)",
					"parametro":"Coliformes Totales (UFC)",
					"metodo":"NMX-AA-102-SCFI-2006",
					"caducidad":24,
					"area":"Microbiología",
					"unidad":"UFC\/100 ml",
					"descripcion_unidad":"UFC\/100 ml",
					"acreditado":1,
					"limite_entrega":120,
					"precio":160,
					"selected":false
				},
				{
					"id_parametro":80,
					"id_tipo_parametro":3,
					"id_area":3,
					"id_unidad":20,
					"id_metodo":42,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Coliformes Fecales (UFC)",
					"parametro":"Coliformes Fecales (UFC)",
					"metodo":"NMX-AA-102-SCFI-2006",
					"caducidad":24,
					"area":"Microbiología",
					"unidad":"UFC\/100 ml",
					"descripcion_unidad":"UFC\/100 ml",
					"acreditado":1,
					"limite_entrega":120,
					"precio":160,
					"selected":false
				},
				{
					"id_parametro":81,
					"id_tipo_parametro":3,
					"id_area":3,
					"id_unidad":21,
					"id_metodo":43,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Huevos Helminto",
					"parametro":"Huevos de Helminto",
					"metodo":"NMX-AA-113-SCFI-2012",
					"caducidad":-1,
					"area":"Microbiología",
					"unidad":"H\/l",
					"descripcion_unidad":"H\/l",
					"acreditado":1,
					"limite_entrega":120,
					"precio":200,
					"selected":false
				},
				{
					"id_parametro":82,
					"id_tipo_parametro":3,
					"id_area":3,
					"id_unidad":22,
					"id_metodo":44,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Clorofilas - a",
					"parametro":"Clorofilas - a",
					"metodo":"SM-10200-H",
					"caducidad":-1,
					"area":"Microbiología",
					"unidad":"mg\/m³",
					"descripcion_unidad":"mg\/m³",
					"acreditado":1,
					"limite_entrega":120,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":83,
					"id_tipo_parametro":3,
					"id_area":3,
					"id_unidad":22,
					"id_metodo":45,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Clorofilas - b",
					"parametro":"Clorofilas - b",
					"metodo":"SM-10200-H",
					"caducidad":-1,
					"area":"Microbiología",
					"unidad":"mg\/m³",
					"descripcion_unidad":"mg\/m³",
					"acreditado":1,
					"limite_entrega":120,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":84,
					"id_tipo_parametro":3,
					"id_area":3,
					"id_unidad":22,
					"id_metodo":45,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Clorofilas - c",
					"parametro":"Clorofilas - c",
					"metodo":"SM-10200-H",
					"caducidad":-1,
					"area":"Microbiología",
					"unidad":"mg\/m³",
					"descripcion_unidad":"mg\/m³",
					"acreditado":1,
					"limite_entrega":120,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":85,
					"id_tipo_parametro":3,
					"id_area":3,
					"id_unidad":23,
					"id_metodo":25,
					"id_tipo_matriz":2,
					"tipo_matriz":"Lodos",
					"param":"Coliformes Fecales (Lodos)",
					"parametro":"Coliformes Fecales (Lodos)",
					"metodo":"NOM-004-SEMARNAT-2002",
					"caducidad":-1,
					"area":"Microbiología",
					"unidad":"NMP\/g en base seca",
					"descripcion_unidad":"NMP\/g en base seca",
					"acreditado":0,
					"limite_entrega":120,
					"precio":160,
					"selected":false
				},
				{
					"id_parametro":86,
					"id_tipo_parametro":3,
					"id_area":3,
					"id_unidad":24,
					"id_metodo":25,
					"id_tipo_matriz":2,
					"tipo_matriz":"Lodos",
					"param":"Huevos Helminto (Lodos)",
					"parametro":"Huevos de Helminto (Lodos)",
					"metodo":"NOM-004-SEMARNAT-2002",
					"caducidad":-1,
					"area":"Microbiología",
					"unidad":"H.H.\/g en base seca",
					"descripcion_unidad":"H.H.\/g en base seca",
					"acreditado":0,
					"limite_entrega":120,
					"precio":200,
					"selected":false
				},
				{
					"id_parametro":93,
					"id_tipo_parametro":2,
					"id_area":2,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Cianuros",
					"parametro":"Cianuros",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"Metales pesados",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":300,
					"selected":false
				},
				{
					"id_parametro":94,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Cl Libre Residual",
					"parametro":"Cloro Libre Residual",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":60,
					"selected":false
				},
				{
					"id_parametro":95,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"DQO Soluble",
					"parametro":"Demanda Química de Oxigeno Soluble",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":160,
					"selected":false
				},
				{
					"id_parametro":96,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"DQO",
					"parametro":"Demanda Química de Oxigeno",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":130,
					"selected":false
				},
				{
					"id_parametro":97,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Herbicidas Clorados",
					"parametro":"Herbicidas Clorados (2,4 D)",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":1300,
					"selected":false
				},
				{
					"id_parametro":98,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Hidrocarburos BTEX",
					"parametro":"Hidrocarburos Aromáticos BTEX",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":1200,
					"selected":false
				},
				{
					"id_parametro":99,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Mesófilos Aerobios",
					"parametro":"Mesófilos Aerobios",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":150,
					"selected":false
				},
				{
					"id_parametro":100,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Nitrógeno (NO2+NO3)",
					"parametro":"Nitrógeno (NO2 + NO3)",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":110,
					"selected":false
				},
				{
					"id_parametro":101,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Plaguicidas Clorados",
					"parametro":"Plaguicidas Clorados",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":1500,
					"selected":false
				},
				{
					"id_parametro":102,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Prueba Jarras",
					"parametro":"Prueba de Jarras",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":5000,
					"selected":false
				},
				{
					"id_parametro":103,
					"id_tipo_parametro":6,
					"id_area":6,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Thrihalometanos",
					"parametro":"Trihalometanos",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"Falta Unidad",
					"descripcion_unidad":"Falta Unidad",
					"acreditado":0,
					"limite_entrega":null,
					"precio":1000,
					"selected":false
				},
				{
					"id_parametro":104,
					"id_tipo_parametro":4,
					"id_area":4,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Gasto",
					"parametro":"Gasto",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"",
					"descripcion_unidad":"",
					"acreditado":0,
					"limite_entrega":null,
					"precio":0,
					"selected":false
				},
				{
					"id_parametro":105,
					"id_tipo_parametro":4,
					"id_area":4,
					"id_unidad":18,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Olor",
					"parametro":"Olor",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"",
					"descripcion_unidad":"",
					"acreditado":0,
					"limite_entrega":null,
					"precio":0,
					"selected":false
				},
				{
					"id_parametro":106,
					"id_tipo_parametro":4,
					"id_area":4,
					"id_unidad":11,
					"id_metodo":38,
					"id_tipo_matriz":1,
					"tipo_matriz":"Agua",
					"param":"Profundidad",
					"parametro":"Profundidad",
					"metodo":"Falta Método",
					"caducidad":-1,
					"area":"",
					"unidad":"m",
					"descripcion_unidad":"m",
					"acreditado":0,
					"limite_entrega":null,
					"precio":0,
					"selected":false
				}
			]
		';
		return $result;
	}

	public function getNorms() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		norma";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_norma":1,
					"id_tipo_matriz":1,
					"norma":"NOM-001-SEMARNAT-1996",
					"desc":"Norma Oficial Mexicana",
					"parametros":[
						{"id_parametro":25,"parametro":"Arsénico"},
						{"id_parametro":27,"parametro":"Cadmio"},
						{"id_parametro":28,"parametro":"Cobre"},
						{"id_parametro":38,"parametro":"Coliformes fecales"},
						{"id_parametro":29,"parametro":"Cromo"},
						{"id_parametro":16,"parametro":"Demada bioquímica de oxígeno*"},
						{"id_parametro":19,"parametro":"Fósforo total"},
						{"id_parametro":18,"parametro":"Grasas y aceites"},
						{"id_parametro":6,"parametro":"Alcalinidad total"},
						{"id_parametro":39,"parametro":"Materia flotante"},
						{"id_parametro":32,"parametro":"Mercurio"},
						{"id_parametro":7,"parametro":"Cloruros totales"},
						{"id_parametro":33,"parametro":"Níquel"},
						{"id_parametro":2,"parametro":"Potencial de hidrógeno"},
						{"id_parametro":34,"parametro":"Plomo"},
						{"id_parametro":22,"parametro":"Sólidos sedimentables"},
						{"id_parametro":20,"parametro":"Sólidos suspendidos totales"},
						{"id_parametro":1,"parametro":"Temperatura"},
						{"id_parametro":36,"parametro":"Zinc"}
					]
				},
				{
					"id_norma":2,
					"id_tipo_matriz":1,
					"norma":"NOM-002-SEMARNAT-1996",
					"desc":"Norma Oficial Mexicana",
					"parametros":[
						{"id_parametro":25,"parametro":"Arsénico"},
						{"id_parametro":27,"parametro":"Cadmio"},
						{"id_parametro":28,"parametro":"Cobre"},
						{"id_parametro":51,"parametro":"Cromo hexavalente"},
						{"id_parametro":16,"parametro":"Demada bioquímica de oxígeno*"},
						{"id_parametro":18,"parametro":"Grasas y aceites"},
						{"id_parametro":39,"parametro":"Materia flotante"},
						{"id_parametro":32,"parametro":"Mercurio"},
						{"id_parametro":33,"parametro":"Níquel"},
						{"id_parametro":2,"parametro":"Potencial de hidrógeno"},
						{"id_parametro":34,"parametro":"Plomo"},
						{"id_parametro":22,"parametro":"Sólidos sedimentables"},
						{"id_parametro":20,"parametro":"Sólidos suspendidos totales"},
						{"id_parametro":1,"parametro":"Temperatura"},
						{"id_parametro":36,"parametro":"Zinc"}
					]
				},
				{
					"id_norma":3,
					"id_tipo_matriz":1,
					"norma":"NOM-003-SEMARNAT-1997",
					"desc":"Norma Oficial Mexicana",
					"parametros":[
						{"id_parametro":25,"parametro":"Arsénico"},
						{"id_parametro":27,"parametro":"Cadmio"},
						{"id_parametro":28,"parametro":"Cobre"},
						{"id_parametro":38,"parametro":"Coliformes fecales"},
						{"id_parametro":29,"parametro":"Cromo"},
						{"id_parametro":16,"parametro":"Demada bioquímica de oxígeno*"},
						{"id_parametro":6,"parametro":"Alcalinidad total"},
						{"id_parametro":18,"parametro":"Grasas y aceites"},
						{"id_parametro":32,"parametro":"Mercurio"},
						{"id_parametro":33,"parametro":"Níquel"},
						{"id_parametro":34,"parametro":"Plomo"},
						{"id_parametro":20,"parametro":"Sólidos suspendidos totales"},
						{"id_parametro":36,"parametro":"Zinc"}
					]
				},
				{
					"id_norma":5,
					"id_tipo_matriz":1,
					"norma":"NOM-127-SSA1-1994",
					"desc":"Norma Oficial Mexicana",
					"parametros":[
						{"id_parametro":24,"parametro":"Aluminio"},
						{"id_parametro":25,"parametro":"Arsénico"},
						{"id_parametro":26,"parametro":"Bario"},
						{"id_parametro":27,"parametro":"Cadmio"},
						{"id_parametro":40,"parametro":"Cloro libre residual"},
						{"id_parametro":7,"parametro":"Cloruros totales"},
						{"id_parametro":28,"parametro":"Cobre"},
						{"id_parametro":38,"parametro":"Coliformes fecales"},
						{"id_parametro":37,"parametro":"Coliformes totales"},
						{"id_parametro":29,"parametro":"Cromo"},
						{"id_parametro":50,"parametro":"Color verdadero"},
						{"id_parametro":8,"parametro":"Dureza total"},
						{"id_parametro":54,"parametro":"Fenoles"},
						{"id_parametro":30,"parametro":"Fierro"},
						{"id_parametro":9,"parametro":"Fluoruros"},
						{"id_parametro":31,"parametro":"Manganeso*"},
						{"id_parametro":32,"parametro":"Mercurio"},
						{"id_parametro":10,"parametro":"Nitrógeno de nitratos"},
						{"id_parametro":11,"parametro":"Nitrógeno de nitritos"},
						{"id_parametro":12,"parametro":"Nitrógeno amoniacal"},
						{"id_parametro":2,"parametro":"Potencial de hidrógeno"},
						{"id_parametro":34,"parametro":"Plomo"},
						{"id_parametro":35,"parametro":"Sodio"},
						{"id_parametro":21,"parametro":"Sólidos disueltos totales"},
						{"id_parametro":14,"parametro":"Sulfatos"},
						{"id_parametro":15,"parametro":"Sustancias activas al azul de metileno"},
						{"id_parametro":36,"parametro":"Zinc"},
						{"id_parametro":5,"parametro":"Turbiedad"}
					]
				},
				{
					"id_norma":7,
					"id_tipo_matriz":1,
					"norma":"LFD Uso 3",
					"desc":"Ley Federal de Derechos",
					"parametros":[
						{"id_parametro":1,"parametro":"Temperatura"},
						{"id_parametro":2,"parametro":"pH"},
						{"id_parametro":39,"parametro":"Materia flotante"},
						{"id_parametro":4,"parametro":"Conductividad*"},
						{"id_parametro":44,"parametro":"Oxígeno disuelto"},
						{"id_parametro":6,"parametro":"Alcalinidad total"},
						{"id_parametro":7,"parametro":"Cloruros totales"},
						{"id_parametro":16,"parametro":"Demada bioquímica de oxígeno*"},
						{"id_parametro":17,"parametro":"Demanda química de oxígeno*"},
						{"id_parametro":9,"parametro":"Fluoruros"},
						{"id_parametro":19,"parametro":"Fósforo total"},
						{"id_parametro":18,"parametro":"Grasas y aceites"},
						{"id_parametro":12,"parametro":"Nitrógeno amoniacal"},
						{"id_parametro":20,"parametro":"Sólidos suspendidos totales"},
						{"id_parametro":23,"parametro":"Sulfuros"},
						{"id_parametro":54,"parametro":"Fenoles"},
						{"id_parametro":50,"parametro":"Color verdadero"},
						{"id_parametro":24,"parametro":"Aluminio"},
						{"id_parametro":25,"parametro":"Arsénico"},
						{"id_parametro":26,"parametro":"Bario"},
						{"id_parametro":27,"parametro":"Cadmio"},
						{"id_parametro":28,"parametro":"Cobre"},
						{"id_parametro":29,"parametro":"Cromo"},
						{"id_parametro":30,"parametro":"Fierro"},
						{"id_parametro":31,"parametro":"Manganeso*"},
						{"id_parametro":32,"parametro":"Mercurio"},
						{"id_parametro":33,"parametro":"Níquel"},
						{"id_parametro":34,"parametro":"Plomo"},
						{"id_parametro":36,"parametro":"Zinc"},
						{"id_parametro":7,"parametro":"Cloruros totales"}
					]
				}
			]
		';
		return $result;
	}

	public function getNormsByMatrixType($matrixTypeId) {
		//$sql = "SELECT
		//		*
		//	FROM
		//		norma";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		if ($matrixTypeId == 1)
		{
			$result = '
				[
					{
						"id_norma":1,
						"id_tipo_matriz":1,
						"norma":"NOM-001-SEMARNAT-1996",
						"desc":"Norma Oficial Mexicana",
						"parametros":[
							{"id_parametro":25,"parametro":"Arsénico"},
							{"id_parametro":27,"parametro":"Cadmio"},
							{"id_parametro":28,"parametro":"Cobre"},
							{"id_parametro":38,"parametro":"Coliformes fecales"},
							{"id_parametro":29,"parametro":"Cromo"},
							{"id_parametro":16,"parametro":"Demada bioquímica de oxígeno*"},
							{"id_parametro":19,"parametro":"Fósforo total"},
							{"id_parametro":18,"parametro":"Grasas y aceites"},
							{"id_parametro":6,"parametro":"Alcalinidad total"},
							{"id_parametro":39,"parametro":"Materia flotante"},
							{"id_parametro":32,"parametro":"Mercurio"},
							{"id_parametro":7,"parametro":"Cloruros totales"},
							{"id_parametro":33,"parametro":"Níquel"},
							{"id_parametro":2,"parametro":"Potencial de hidrógeno"},
							{"id_parametro":34,"parametro":"Plomo"},
							{"id_parametro":22,"parametro":"Sólidos sedimentables"},
							{"id_parametro":20,"parametro":"Sólidos suspendidos totales"},
							{"id_parametro":1,"parametro":"Temperatura"},
							{"id_parametro":36,"parametro":"Zinc"}
						]
					},
					{
						"id_norma":2,
						"id_tipo_matriz":1,
						"norma":"NOM-002-SEMARNAT-1996",
						"desc":"Norma Oficial Mexicana",
						"parametros":[
							{"id_parametro":25,"parametro":"Arsénico"},
							{"id_parametro":27,"parametro":"Cadmio"},
							{"id_parametro":28,"parametro":"Cobre"},
							{"id_parametro":51,"parametro":"Cromo hexavalente"},
							{"id_parametro":16,"parametro":"Demada bioquímica de oxígeno*"},
							{"id_parametro":18,"parametro":"Grasas y aceites"},
							{"id_parametro":39,"parametro":"Materia flotante"},
							{"id_parametro":32,"parametro":"Mercurio"},
							{"id_parametro":33,"parametro":"Níquel"},
							{"id_parametro":2,"parametro":"Potencial de hidrógeno"},
							{"id_parametro":34,"parametro":"Plomo"},
							{"id_parametro":22,"parametro":"Sólidos sedimentables"},
							{"id_parametro":20,"parametro":"Sólidos suspendidos totales"},
							{"id_parametro":1,"parametro":"Temperatura"},
							{"id_parametro":36,"parametro":"Zinc"}
						]
					},
					{
						"id_norma":3,
						"id_tipo_matriz":1,
						"norma":"NOM-003-SEMARNAT-1997",
						"desc":"Norma Oficial Mexicana",
						"parametros":[
							{"id_parametro":25,"parametro":"Arsénico"},
							{"id_parametro":27,"parametro":"Cadmio"},
							{"id_parametro":28,"parametro":"Cobre"},
							{"id_parametro":38,"parametro":"Coliformes fecales"},
							{"id_parametro":29,"parametro":"Cromo"},
							{"id_parametro":16,"parametro":"Demada bioquímica de oxígeno*"},
							{"id_parametro":6,"parametro":"Alcalinidad total"},
							{"id_parametro":18,"parametro":"Grasas y aceites"},
							{"id_parametro":32,"parametro":"Mercurio"},
							{"id_parametro":33,"parametro":"Níquel"},
							{"id_parametro":34,"parametro":"Plomo"},
							{"id_parametro":20,"parametro":"Sólidos suspendidos totales"},
							{"id_parametro":36,"parametro":"Zinc"}
						]
					},
					{
						"id_norma":5,
						"id_tipo_matriz":1,
						"norma":"NOM-127-SSA1-1994",
						"desc":"Norma Oficial Mexicana",
						"parametros":[
							{"id_parametro":24,"parametro":"Aluminio"},
							{"id_parametro":25,"parametro":"Arsénico"},
							{"id_parametro":26,"parametro":"Bario"},
							{"id_parametro":27,"parametro":"Cadmio"},
							{"id_parametro":40,"parametro":"Cloro libre residual"},
							{"id_parametro":7,"parametro":"Cloruros totales"},
							{"id_parametro":28,"parametro":"Cobre"},
							{"id_parametro":38,"parametro":"Coliformes fecales"},
							{"id_parametro":37,"parametro":"Coliformes totales"},
							{"id_parametro":29,"parametro":"Cromo"},
							{"id_parametro":50,"parametro":"Color verdadero"},
							{"id_parametro":8,"parametro":"Dureza total"},
							{"id_parametro":54,"parametro":"Fenoles"},
							{"id_parametro":30,"parametro":"Fierro"},
							{"id_parametro":9,"parametro":"Fluoruros"},
							{"id_parametro":31,"parametro":"Manganeso*"},
							{"id_parametro":32,"parametro":"Mercurio"},
							{"id_parametro":10,"parametro":"Nitrógeno de nitratos"},
							{"id_parametro":11,"parametro":"Nitrógeno de nitritos"},
							{"id_parametro":12,"parametro":"Nitrógeno amoniacal"},
							{"id_parametro":2,"parametro":"Potencial de hidrógeno"},
							{"id_parametro":34,"parametro":"Plomo"},
							{"id_parametro":35,"parametro":"Sodio"},
							{"id_parametro":21,"parametro":"Sólidos disueltos totales"},
							{"id_parametro":14,"parametro":"Sulfatos"},
							{"id_parametro":15,"parametro":"Sustancias activas al azul de metileno"},
							{"id_parametro":36,"parametro":"Zinc"},
							{"id_parametro":5,"parametro":"Turbiedad"}
						]
					},
					{
						"id_norma":7,
						"id_tipo_matriz":1,
						"norma":"LFD Uso 3",
						"desc":"Ley Federal de Derechos",
						"parametros":[
							{"id_parametro":1,"parametro":"Temperatura"},
							{"id_parametro":2,"parametro":"pH"},
							{"id_parametro":39,"parametro":"Materia flotante"},
							{"id_parametro":4,"parametro":"Conductividad*"},
							{"id_parametro":44,"parametro":"Oxígeno disuelto"},
							{"id_parametro":6,"parametro":"Alcalinidad total"},
							{"id_parametro":7,"parametro":"Cloruros totales"},
							{"id_parametro":16,"parametro":"Demada bioquímica de oxígeno*"},
							{"id_parametro":17,"parametro":"Demanda química de oxígeno*"},
							{"id_parametro":9,"parametro":"Fluoruros"},
							{"id_parametro":19,"parametro":"Fósforo total"},
							{"id_parametro":18,"parametro":"Grasas y aceites"},
							{"id_parametro":12,"parametro":"Nitrógeno amoniacal"},
							{"id_parametro":20,"parametro":"Sólidos suspendidos totales"},
							{"id_parametro":23,"parametro":"Sulfuros"},
							{"id_parametro":54,"parametro":"Fenoles"},
							{"id_parametro":50,"parametro":"Color verdadero"},
							{"id_parametro":24,"parametro":"Aluminio"},
							{"id_parametro":25,"parametro":"Arsénico"},
							{"id_parametro":26,"parametro":"Bario"},
							{"id_parametro":27,"parametro":"Cadmio"},
							{"id_parametro":28,"parametro":"Cobre"},
							{"id_parametro":29,"parametro":"Cromo"},
							{"id_parametro":30,"parametro":"Fierro"},
							{"id_parametro":31,"parametro":"Manganeso*"},
							{"id_parametro":32,"parametro":"Mercurio"},
							{"id_parametro":33,"parametro":"Níquel"},
							{"id_parametro":34,"parametro":"Plomo"},
							{"id_parametro":36,"parametro":"Zinc"},
							{"id_parametro":7,"parametro":"Cloruros totales"}
						]
					}
				]
			';
		}
		else
		{
			$result = '
				[
					{
						"id_norma":1,
						"id_tipo_matriz":1,
						"norma":"NOM-001-SEMARNAT-1996",
						"desc":"Norma Oficial Mexicana",
						"parametros":[
							{"id_parametro":25,"parametro":"Arsénico"},
							{"id_parametro":27,"parametro":"Cadmio"},
							{"id_parametro":28,"parametro":"Cobre"},
							{"id_parametro":38,"parametro":"Coliformes fecales"},
							{"id_parametro":29,"parametro":"Cromo"},
							{"id_parametro":16,"parametro":"Demada bioquímica de oxígeno*"},
							{"id_parametro":19,"parametro":"Fósforo total"},
							{"id_parametro":18,"parametro":"Grasas y aceites"},
							{"id_parametro":6,"parametro":"Alcalinidad total"},
							{"id_parametro":39,"parametro":"Materia flotante"},
							{"id_parametro":32,"parametro":"Mercurio"},
							{"id_parametro":7,"parametro":"Cloruros totales"},
							{"id_parametro":33,"parametro":"Níquel"},
							{"id_parametro":2,"parametro":"Potencial de hidrógeno"},
							{"id_parametro":34,"parametro":"Plomo"},
							{"id_parametro":22,"parametro":"Sólidos sedimentables"},
							{"id_parametro":20,"parametro":"Sólidos suspendidos totales"},
							{"id_parametro":1,"parametro":"Temperatura"},
							{"id_parametro":36,"parametro":"Zinc"}
						]
					}
				]
			';
		}

		return $result;
	}

	public function getSamplingTypes() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		tipo_muestreo";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_tipo_muestreo":1,
					"tipo_muestreo":"Simple",
					"selected":false
				},
				{
					"id_tipo_muestreo":2,
					"tipo_muestreo":"Compuesto",
					"selected":false
				}
			]
		';
		return $result;
	}

	public function getOrderSources() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		tipo_muestreo";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_origen_orden":1,
					"origen_orden":"Oficio"
				},
				{
					"id_origen_orden":2,
					"origen_orden":"Cotización"
				},
				{
					"id_origen_orden":3,
					"origen_orden":"Programa"
				},
				{
					"id_origen_orden":4,
					"origen_orden":"Emergencia"
				}
			]
		';
		return $result;
	}

	public function getMatrices() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		matriz";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_matriz":1,
					"id_tipo_matriz":1,
					"matriz":"Agua Residual",
					"clave":"AR"
				},
				{
					"id_matriz":2,
					"id_tipo_matriz":1,
					"matriz":"Agua Residual Tratada",
					"clave":"ART"
				},
				{
					"id_matriz":3,
					"id_tipo_matriz":1,
					"matriz":"Agua Potable",
					"clave":"AP"
				},
				{
					"id_matriz":4,
					"id_tipo_matriz":1,
					"matriz":"Agua Superficial",
					"clave":"AS"
				},
				{
					"id_matriz":5,
					"id_tipo_matriz":1,
					"matriz":"Agua Subterránea",
					"clave":"ASb"
				},
				{
					"id_matriz":6,
					"id_tipo_matriz":2,
					"matriz":"Lodos",
					"clave":"LD"
				},
				{
					"id_matriz":7,
					"id_tipo_matriz":1,
					"matriz":"Planta Potabilizadora",
					"clave":"PPt"
				},
				{
					"id_matriz":8,
					"id_tipo_matriz":1,
					"matriz":"Otra",
					"clave":"OTR"
				}
			]
		';
		return $result;
	}

	public function getSamplingSupervisors() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		responsable_muestreo";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_responsable_muestreo":2,
					"id_empleado":3,
					"id_nivel":3,
					"id_area":2,
					"area":"Metales Pesados",
					"id_puesto":4,
					"puesto":"Supervisor (MP)",
					"nombres":"Marín",
					"ap":"Gomar",
					"am":"Sosa",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":1,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_responsable_muestreo":3,
					"id_empleado":12,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"José Adalberto",
					"ap":"Olivarez",
					"am":"Cornejo",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_responsable_muestreo":4,
					"id_empleado":13,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"Luis Fabián",
					"ap":"Mercado",
					"am":"del Ángel",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_responsable_muestreo":6,
					"id_empleado":15,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"Mitzi Acahualxóchitl",
					"ap":"Rodríguez",
					"am":"García",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				}
			]
		';
		return $result;
	}

	public function getPlanObjectives() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		objetivo_plan";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_objetivo_plan":1,
					"objetivo_plan":"Programa",
					"activo":1
				},
				{
					"id_objetivo_plan":2,
					"objetivo_plan":"Puntos concertados con el cliente",
					"activo":1
				},
				{
					"id_objetivo_plan":3,
					"objetivo_plan":"Atención a una emergencia",
					"activo":1
				},
				{
					"id_objetivo_plan":4,
					"objetivo_plan":"Obtención de Control, blanco de campo, etc",
					"activo":1
				},
				{
					"id_objetivo_plan":5,
					"objetivo_plan":"Otro",
					"activo":1
				}
			]
		';
		return $result;
	}

	public function getPointKinds() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		clase_punto";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_clase_punto":1,
					"clase_punto":"Fijos",
					"activo":1
				},
				{
					"id_clase_punto":2,
					"clase_punto":"Provisionales",
					"activo":1
				},
				{
					"id_clase_punto":3,
					"clase_punto":"De Interés General",
					"activo":1
				},
				{
					"id_clase_punto":4,
					"clase_punto":"De Interés Particular",
					"activo":1
				}
			]
		';
		return $result;
	}

	public function getDistricts() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		municipio";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_municipio":14001,
					"municipio":"Acatic"
				},
				{
					"id_municipio":14030,
					"municipio":"Chapala"
				},
				{
					"id_municipio":14039,
					"municipio":"Guadalajara"
				},
				{
					"id_municipio":14120,
					"municipio":"Zapopan"
				},
				{
					"id_municipio":14123,
					"municipio":"Zapotlan El Grande"
				},
				{
					"id_municipio":14124,
					"municipio":"Zapotlanejo"
				}
			]
		';
		return $result;
	}

	public function getDistrict($districtId) {
		//$sql = "SELECT
		//		*
		//	FROM
		//		municipio
		// WHERE
		//		id_municipio := $districtId";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		if ($districtId == 14001)
		{
			$result = '
				{
					"id_municipio":14001,
					"municipio":"Acatic"
				}
			';
		}
		else if ($districtId == 14039)
		{
			$result = '
				{
					"id_municipio":14039,
					"municipio":"Guadalajara"
				},
			';
		}
		else
		{
			$result = '
					{
						"id_municipio":0,
						"municipio":"0"
					}
			';
		}
		return $result;
	}


	public function getCitiesByDistrictId($districtId) {
		//$sql = "SELECT
		//		*
		//	FROM
		//		municipio
		// WHERE
		//		id_municipio := $districtId";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		if ($districtId == 14001)
		{
			$result = '
				[
					{
						"id_municipio":14001,
						"id_localidad":14001001,
						"localidad":"Acatic"
					}
				]
			';
		}
		else if ($districtId == 14030)
		{
			$result = '
				[
					{
						"id_municipio":14030,
						"id_localidad":14030001,
						"localidad":"Chapala"
					}
				]
			';
		}
		else if ($districtId == 14039)
		{
			$result = '
				[
					{
						"id_municipio":14039,
						"id_localidad":14039001,
						"localidad":"Guadalajara"
					}
				]
			';
		}
		else
		{
			$result = '
					{
						"id_municipio":0,
						"id_localidad":0,
						"localidad":"0"
					}
			';
		}
		return $result;
	}

	public function getSamplingEmployees() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		empleado_muestreo";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_empleado":12,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"José Adalberto",
					"ap":"Olivarez",
					"am":"Cornejo",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":13,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"Luis Fabián",
					"ap":"Mercado",
					"am":"del Ángel",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":15,
					"id_nivel":4,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"Mitzi Acahualxóchitl",
					"ap":"Rodríguez",
					"am":"García",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				},
				{
					"id_empleado":18,
					"id_nivel":5,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"Juan Pablo",
					"ap":"Basulto",
					"am":"Rivera",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":0,
					"muestrea":0,
					"cert":0,
					"activo":1
				},
				{
					"id_empleado":19,
					"id_nivel":5,
					"id_area":4,
					"area":"Muestreo",
					"id_puesto":6,
					"puesto":"Analista",
					"nombres":"Miriam",
					"ap":"Yerena",
					"am":"Pelayo",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":0,
					"analiza":0,
					"muestrea":0,
					"cert":0,
					"activo":1
				}
			]
		';
		return $result;
	}

	public function getPreservations() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		preservacion";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_preservacion":1,
					"id_clase_parametro":1,
					"clase_parametro":"Fisicoquímico",
					"clase_param":"FQ",
					"preservacion":"Hielo, 4°C",
					"tipo_preservacion":"Fisicoquímico",
					"descripcion":"Hielo, 4°C",
					"preservado":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_preservacion":2,
					"id_clase_parametro":2,
					"clase_parametro":"Oxígeno disuelto",
					"clase_param":"OD",
					"preservacion":"2 ml MnSo4 + 2 ml Álcali Ioduro + 2 ml H2So4",
					"tipo_preservacion":"Oxígeno disuelto",
					"descripcion":"2 ml MnSo4 + 2 ml Álcali Ioduro + 2 ml H2So4",
					"preservado":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_preservacion":3,
					"id_clase_parametro":3,
					"clase_parametro":"Sustancias activas al azul de metileno",
					"clase_param":"SAAM",
					"preservacion":"H2SO4, 4°C, pH<2",
					"tipo_preservacion":"Sustancias activas al azul de metileno",
					"descripcion":"H2SO4, 4°C, pH<2",
					"preservado":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_preservacion":4,
					"id_clase_parametro":4,
					"clase_parametro":"Fenoles",
					"clase_param":"FEN",
					"preservacion":"5ml H2SO4 + CuSO4, 4°C, pH<2",
					"tipo_preservacion":"Fenoles",
					"descripcion":"5ml H2SO4 + CuSO4, 4°C, pH<2",
					"preservado":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_preservacion":5,
					"id_clase_parametro":5,
					"clase_parametro":"Dureza",
					"clase_param":"DZA",
					"preservacion":"HNO3, pH<2",
					"tipo_preservacion":"Dureza",
					"descripcion":"HNO3, pH<2",
					"preservado":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_preservacion":6,
					"id_clase_parametro":6,
					"clase_parametro":"Sulfuros",
					"clase_param":"Sulfuros",
					"preservacion":"6.5 ml de Acetato de Zn 2N, NaOH 6N pH≥9, 4°C",
					"tipo_preservacion":"Sulfuros",
					"descripcion":"6.5 ml de Acetato de Zn 2N, NaOH 6N pH≥9, 4°C",
					"preservado":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_preservacion":7,
					"id_clase_parametro":7,
					"clase_parametro":"Fisicoquímico 2",
					"clase_param":"FQ-2",
					"preservacion":"H2SO4, 4°C, pH<2",
					"tipo_preservacion":"Fisicoquímico 2",
					"descripcion":"H2SO4, 4°C, pH<2",
					"preservado":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_preservacion":8,
					"id_clase_parametro":8,
					"clase_parametro":"Grasas y aceites",
					"clase_param":"GyA",
					"preservacion":"HCL1:1, 4°C, pH<2",
					"tipo_preservacion":"Grasas y aceites",
					"descripcion":"HCL1:1, 4°C, pH<2",
					"preservado":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_preservacion":9,
					"id_clase_parametro":9,
					"clase_parametro":"Metales pesados",
					"clase_param":"MP",
					"preservacion":"HNO3, pH<2",
					"tipo_preservacion":"Metales pesados",
					"descripcion":"HNO3, pH<2",
					"preservado":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				}
			]
		';
		return $result;
	}

	public function getContainerKinds() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		clase_recipiente";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_clase_recipiente":1,
					"id_preservacion":1,
					"id_clase_parametro":1,
					"clase_parametro":"Fisicoquímico",
					"clase_param":"FQ",
					"preservacion":"Hielo, 4°C",
					"tipo_preservacion":"Fisicoquímico",
					"descripcion":"Hielo, 4°C",
					"cantidad":0,
					"adecuado":0,
					"preservado":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_clase_recipiente":2,
					"id_preservacion":2,
					"id_clase_parametro":2,
					"clase_parametro":"Oxígeno disuelto",
					"clase_param":"OD",
					"preservacion":"2 ml MnSo4 + 2 ml Álcali Ioduro + 2 ml H2So4",
					"tipo_preservacion":"Oxígeno disuelto",
					"descripcion":"2 ml MnSo4 + 2 ml Álcali Ioduro + 2 ml H2So4",
					"cantidad":0,
					"adecuado":0,
					"preservado":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_clase_recipiente":3,
					"id_preservacion":3,
					"id_clase_parametro":3,
					"clase_parametro":"Sustancias activas al azul de metileno",
					"clase_param":"SAAM",
					"preservacion":"H2SO4, 4°C, pH<2",
					"tipo_preservacion":"Sustancias activas al azul de metileno",
					"descripcion":"H2SO4, 4°C, pH<2",
					"cantidad":0,
					"adecuado":0,
					"preservado":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_clase_recipiente":4,
					"id_preservacion":4,
					"id_clase_parametro":4,
					"clase_parametro":"Fenoles",
					"clase_param":"FEN",
					"preservacion":"5ml H2SO4 + CuSO4, 4°C, pH<2",
					"tipo_preservacion":"Fenoles",
					"descripcion":"5ml H2SO4 + CuSO4, 4°C, pH<2",
					"cantidad":0,
					"adecuado":0,
					"preservado":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_clase_recipiente":5,
					"id_preservacion":5,
					"id_clase_parametro":5,
					"clase_parametro":"Dureza",
					"clase_param":"DZA",
					"preservacion":"HNO3, pH<2",
					"tipo_preservacion":"Dureza",
					"descripcion":"HNO3, pH<2",
					"cantidad":0,
					"adecuado":0,
					"preservado":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_clase_recipiente":6,
					"id_preservacion":6,
					"id_clase_parametro":6,
					"clase_parametro":"Sulfuros",
					"clase_param":"Sulfuros",
					"preservacion":"6.5 ml de Acetato de Zn 2N, NaOH 6N pH≥9, 4°C",
					"tipo_preservacion":"Sulfuros",
					"descripcion":"6.5 ml de Acetato de Zn 2N, NaOH 6N pH≥9, 4°C",
					"cantidad":0,
					"adecuado":0,
					"preservado":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_clase_recipiente":7,
					"id_preservacion":7,
					"id_clase_parametro":7,
					"clase_parametro":"Fisicoquímico 2",
					"clase_param":"FQ-2",
					"preservacion":"H2SO4, 4°C, pH<2",
					"tipo_preservacion":"Fisicoquímico 2",
					"descripcion":"H2SO4, 4°C, pH<2",
					"cantidad":0,
					"adecuado":0,
					"preservado":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_clase_recipiente":8,
					"id_preservacion":8,
					"id_clase_parametro":8,
					"clase_parametro":"Grasas y aceites",
					"clase_param":"GyA",
					"preservacion":"HCL1:1, 4°C, pH<2",
					"tipo_preservacion":"Grasas y aceites",
					"descripcion":"HCL1:1, 4°C, pH<2",
					"cantidad":0,
					"adecuado":0,
					"preservado":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_clase_recipiente":9,
					"id_preservacion":9,
					"id_clase_parametro":9,
					"clase_parametro":"Metales pesados",
					"clase_param":"MP",
					"preservacion":"HNO3, pH<2",
					"tipo_preservacion":"Metales pesados",
					"descripcion":"HNO3, pH<2",
					"cantidad":0,
					"adecuado":0,
					"preservado":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				}
			]
		';
		return $result;
	}

	public function getReactives() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		reactivo";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_reactivo":1,
					"reactivo":"Solución de pH 4",
					"lote":"",
					"volumen":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_reactivo":2,
					"reactivo":"Solución de pH 7",
					"lote":"",
					"volumen":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_reactivo":3,
					"reactivo":"Solución de pH 10",
					"lote":"",
					"volumen":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_reactivo":4,
					"reactivo":"Solución de pH (otro)",
					"lote":"",
					"volumen":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_reactivo":5,
					"reactivo":"Ácido clorhídrico",
					"lote":"",
					"volumen":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_reactivo":6,
					"reactivo":"Ácido sulfúrico",
					"lote":"",
					"volumen":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_reactivo":7,
					"reactivo":"Agua desionizada",
					"lote":"",
					"volumen":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_reactivo":8,
					"reactivo":"Ácido nítrico",
					"lote":"",
					"volumen":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_reactivo":9,
					"reactivo":"Ácido nítrico instra",
					"reactivo":"Metales pesados",
					"lote":"",
					"volumen":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_reactivo":10,
					"reactivo":"Conductividad 1000",
					"lote":"",
					"volumen":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_reactivo":11,
					"reactivo":"Conductividad 1200",
					"lote":"",
					"volumen":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_reactivo":12,
					"reactivo":"Conductividad 1400",
					"lote":"",
					"volumen":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_reactivo":13,
					"reactivo":"Conductividad 1600",
					"lote":"",
					"volumen":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_reactivo":14,
					"reactivo":"Conductividad (otro)",
					"lote":"",
					"volumen":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_reactivo":15,
					"reactivo":"Acetato de zinc",
					"lote":"",
					"volumen":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_reactivo":16,
					"reactivo":"Sulfato de cobre 10%",
					"lote":"",
					"volumen":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				},
				{
					"id_reactivo":17,
					"reactivo":"Hielo",
					"lote":"",
					"volumen":0,
					"selected":false,
					"cantidad":0,
					"activo":1
				}
			]
		';
		return $result;
	}

	public function getMaterials() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		material";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_material":1,
					"material":"Manual de Procedimientos",
					"selected":false,
					"activo":1
				},
				{
					"id_material":2,
					"material":"Hoja de campo",
					"selected":false,
					"activo":1
				},
				{
					"id_material":3,
					"material":"Bitácora",
					"selected":false,
					"activo":1
				},
				{
					"id_material":4,
					"material":"Disco Sechi",
					"selected":false,
					"activo":1
				},
				{
					"id_material":5,
					"material":"Draga",
					"selected":false,
					"activo":1
				},
				{
					"id_material":6,
					"material":"Tamiz",
					"selected":false,
					"activo":1
				},
				{
					"id_material":7,
					"material":"Termómetro",
					"selected":false,
					"activo":1
				},
				{
					"id_material":8,
					"material":"Geoposicionador",
					"selected":false,
					"activo":1
				},
				{
					"id_material":9,
					"material":"Tiras reactivas pH",
					"selected":false,
					"activo":1
				},
				{
					"id_material":1,
					"material":"Pipetas Pasteur",
					"selected":false,
					"activo":1
				},
				{
					"id_material":1,
					"material":"Termo",
					"selected":false,
					"activo":1
				},
				{
					"id_material":1,
					"material":"Cubeta",
					"selected":false,
					"activo":1
				},
				{
					"id_material":1,
					"material":"Marcadores",
					"selected":false,
					"activo":1
				},
				{
					"id_material":1,
					"material":"Papel secante",
					"selected":false,
					"activo":1
				},
				{
					"id_material":1,
					"material":"Pisetas",
					"selected":false,
					"activo":1
				},
				{
					"id_material":1,
					"material":"Camara",
					"selected":false,
					"activo":1
				},
				{
					"id_material":1,
					"material":"Guantes",
					"selected":false,
					"activo":1
				},
				{
					"id_material":1,
					"material":"Lentes de Protección",
					"selected":false,
					"activo":1
				},
				{
					"id_material":1,
					"material":"Chaleco salvavidas",
					"selected":false,
					"activo":1
				},
				{
					"id_material":2,
					"material":"Arnés",
					"selected":false,
					"activo":1
				},
				{
					"id_material":2,
					"material":"Cuerdas",
					"selected":false,
					"activo":1
				},
				{
					"id_material":2,
					"material":"Cubre bocas",
					"selected":false,
					"activo":1
				},
				{
					"id_material":2,
					"material":"Casco",
					"selected":false,
					"activo":1
				}
			]
		';
		return $result;
	}

	public function getCoolers() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		hielera";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_hielera":1,
					"hielera":"Hielera 1",
					"selected":false
				},
				{
					"id_hielera":2,
					"hielera":"Hielera 2",
					"selected":false
				},
				{
					"id_hielera":3,
					"hielera":"Hielera 3",
					"selected":false
				},
				{
					"id_hielera":4,
					"hielera":"Hielera 4",
					"selected":false
				},
				{
					"id_hielera":5,
					"hielera":"Hielera 5",
					"selected":false
				},
				{
					"id_hielera":6,
					"hielera":"Hielera 6",
					"selected":false
				},
				{
					"id_hielera":7,
					"hielera":"Hielera 7",
					"selected":false
				},
				{
					"id_hielera":8,
					"hielera":"Hielera 8",
					"selected":false
				},
				{
					"id_hielera":9,
					"hielera":"Hielera 9",
					"selected":false
				},
				{
					"id_hielera":10,
					"hielera":"Hielera 10",
					"selected":false
				},
				{
					"id_hielera":11,
					"hielera":"Hielera 11",
					"selected":false
				},
				{
					"id_hielera":12,
					"hielera":"Hielera 12",
					"selected":false
				},
				{
					"id_hielera":13,
					"hielera":"Hielera 13",
					"selected":false
				},
				{
					"id_hielera":14,
					"hielera":"Hielera 14",
					"selected":false
				},
				{
					"id_hielera":15,
					"hielera":"Hielera 15",
					"selected":false
				},
				{
					"id_hielera":16,
					"hielera":"Hielera 16",
					"selected":false
				},
				{
					"id_hielera":17,
					"hielera":"Hielera 17",
					"selected":false
				},
				{
					"id_hielera":18,
					"hielera":"Hielera 18",
					"selected":false
				},
				{
					"id_hielera":19,
					"hielera":"Hielera 19",
					"selected":false
				},
				{
					"id_hielera":20,
					"hielera":"Hielera 20",
					"selected":false
				}
			]
		';
		return $result;
	}

	public function getClouds() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		cobertura_nubes";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_cobertura_nubes":1,
					"cobertura_nubes":"Despejado"
				},
				{
					"id_cobertura_nubes":2,
					"cobertura_nubes":"Nublado"
				},
				{
					"id_cobertura_nubes":3,
					"cobertura_nubes":"Lluvia"
				},
				{
					"id_cobertura_nubes":4,
					"cobertura_nubes":"Otro"
				}
			]
		';
		return $result;
	}

	public function getWinds() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		direccion_viento";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_direccion_viento":1,
					"direccion_viento":"Norte"
				},
				{
					"id_direccion_viento":2,
					"direccion_viento":"Noreste"
				},
				{
					"id_direccion_viento":3,
					"direccion_viento":"Este"
				},
				{
					"id_direccion_viento":4,
					"direccion_viento":"Sureste"
				},
				{
					"id_direccion_viento":5,
					"direccion_viento":"Sur"
				},
				{
					"id_direccion_viento":6,
					"direccion_viento":"Suroeste"
				},
				{
					"id_direccion_viento":7,
					"direccion_viento":"Oeste"
				},
				{
					"id_direccion_viento":8,
					"direccion_viento":"Noroeste"
				}
			]
		';
		return $result;
	}

	public function getWaves() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		oleaje";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_oleaje":1,
					"oleaje":"Nulo"
				},
				{
					"id_oleaje":2,
					"oleaje":"Lento"
				},
				{
					"id_oleaje":3,
					"oleaje":"Medio"
				},
				{
					"id_oleaje":4,
					"oleaje":"Fuerte"
				}
			]
		';
		return $result;
	}

	public function getSamplingNorms() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		metodo_muestreo";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_metodo_muestreo":234,
					"metodo_muestreo":"NMX-AA-003-1980"
				},
				{
					"id_metodo_muestreo":234,
					"metodo_muestreo":"NMX-AA-014-1980"
				},
				{
					"id_metodo_muestreo":235,
					"metodo_muestreo":"NOM-230-SSA1-2001"
				}
			]
		';
		return $result;
	}

	public function getPoints() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		punto_muestreo";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
					{
							"id_punto_muestreo":"1",
							"punto_muestreo":"Ocotlán",
							"descripcion":"Ocotlán",
							"id_municipio":"14063",
							"municipio":"municipio 14063",
							"id_localidad":"140630001",
							"localidad":"localidad 140630001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.346928,
							"lng":-102.779392,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":1,
							"siglas":"RS",
							"clave":"RS-01",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
					},
					{
							"id_punto_muestreo":"2",
							"punto_muestreo":"Presa Corona",
							"descripcion":"Cortina Presa Corona - Poncitlán",
							"id_municipio":"14030",
							"municipio":"municipio 14030",
							"id_localidad":"140300038",
							"localidad":"localidad 140300038",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.399667,
							"lng":-103.090619,
							"alt":0,
							"idRegHid":0,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":2,
							"siglas":"RS",
							"clave":"RS-02",
							"fecha":"2013-01-31 12:44:51.860",
							"usr_update":1,
							"comentarios":""
					},
					{
							"id_punto_muestreo":"3",
							"punto_muestreo":"Ex-hacienda Zap.",
							"descripcion":"Ex-hacienda de Zapotlanejo",
							"id_municipio":"14051",
							"municipio":"municipio 14051",
							"id_localidad":"140510013",
							"localidad":"localidad 140510013",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.442003,
							"lng":-103.143814,
							"alt":0,
							"idRegHid":0,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":3,
							"siglas":"RS",
							"clave":"RS-03",
							"fecha":"2013-01-31 12:39:11.093",
							"usr_update":1,
							"comentarios":""
					},
					{
							"id_punto_muestreo":"4",
							"punto_muestreo":"Salto-Juanacatlán",
							"descripcion":"Compuerta - Puente El Salto-Juanacatlán",
							"id_municipio":"14051",
							"municipio":"municipio 14051",
							"id_localidad":"140510001",
							"localidad":"localidad 140510001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.512825,
							"lng":-103.174558,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":4,
							"siglas":"RS",
							"clave":"RS-04",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
					},
					{
							"id_punto_muestreo":"5",
							"punto_muestreo":"Puente Grande",
							"descripcion":"Puente Grande",
							"id_municipio":"14101",
							"municipio":"municipio 14101",
							"id_localidad":"141010026",
							"localidad":"localidad 141010026",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.571036,
							"lng":-103.147283,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":5,
							"siglas":"RS",
							"clave":"RS-05",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
					},
					{
							"id_punto_muestreo":"6",
							"punto_muestreo":"Matatlán",
							"descripcion":"Vertedero Controlado Matatlán",
							"id_municipio":"14101",
							"municipio":"municipio 14101",
							"id_localidad":"141010009",
							"localidad":"localidad 141010009",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.668289,
							"lng":-103.187169,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":6,
							"siglas":"RS",
							"clave":"RS-06",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
					},
					{
							"id_punto_muestreo":"7",
							"punto_muestreo":"Paso de Gpe.",
							"descripcion":"Paso de Guadalupe",
							"id_municipio":"14045",
							"municipio":"municipio 14045",
							"id_localidad":"140450079",
							"localidad":"localidad 140450079",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.839097,
							"lng":-103.328972,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":7,
							"siglas":"RS",
							"clave":"RS-07",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
					},
					{
							"id_punto_muestreo":"8",
							"punto_muestreo":"Cristóbal de la B.",
							"descripcion":"San Cristóbal de la Barranca",
							"id_municipio":"14071",
							"municipio":"municipio 14071",
							"id_localidad":"140710001",
							"localidad":"localidad 140710001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":21.038356,
							"lng":-103.426036,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":8,
							"siglas":"RS",
							"clave":"RS-08",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
					},
					{
							"id_punto_muestreo":"9",
							"punto_muestreo":"Camino Salvador",
							"descripcion":"Camino al Salvador - Tequila",
							"id_municipio":"14094",
							"municipio":"municipio 14094",
							"id_localidad":"140050001",
							"localidad":"localidad 140050001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.912106,
							"lng":-103.711964,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":9,
							"siglas":"RS",
							"clave":"RS-09",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
					},
					{
							"id_punto_muestreo":"10",
							"punto_muestreo":"Paso La Yesca",
							"descripcion":"Paso La Yesca",
							"id_municipio":"14040",
							"municipio":"municipio 14040",
							"id_localidad":"140400053",
							"localidad":"localidad 140400053",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":21.190106,
							"lng":-104.073053,
							"alt":0,
							"idRegHid":0,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":10,
							"siglas":"RS",
							"clave":"RS-10",
							"fecha":"2013-01-31 11:56:53.347",
							"usr_update":1,
							"comentarios":""
					},
					{
							"id_punto_muestreo":"11",
							"punto_muestreo":"Carr. Chapala",
							"descripcion":"Carretera a Chapala antes de Aeropuerto",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140700043",
							"localidad":"localidad 140700043",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.537825,
							"lng":-103.296703,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":1,
							"siglas":"AA",
							"clave":"AA-01",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
					},
					{
							"id_punto_muestreo":"12",
							"punto_muestreo":"El Muelle",
							"descripcion":"Puente localidad El Muelle",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140700011",
							"localidad":"localidad 140700011",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.497869,
							"lng":-103.216722,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":2,
							"siglas":"AA",
							"clave":"AA-02",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
					},
					{
							"id_punto_muestreo":"13",
							"punto_muestreo":"Río Zula",
							"descripcion":"Puente Carretera Guadalajara - La Barca",
							"id_municipio":"14063",
							"municipio":"municipio 14063",
							"id_localidad":"140630001",
							"localidad":"localidad 140630001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.34455,
							"lng":-102.774767,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":1,
							"idCuerpoCalidad":1,
							"consecutivo":1,
							"siglas":"RZ",
							"clave":"RZ-01",
							"fecha":"2012-07-11 00:00:00.000",
							"usr_update":1,
							"comentarios":""
					},
					{
							"id_punto_muestreo":"14",
							"punto_muestreo":"Cajititlán II",
							"descripcion":"Cajititlán II",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140970005",
							"localidad":"localidad 140970005",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.428539,
							"lng":-103.31169,
							"alt":0,
							"idRegHid":12,
							"idCuenca":16,
							"idSubCuenca":28,
							"idCuerpoCalidad":2,
							"consecutivo":6,
							"siglas":"LC",
							"clave":"LC-06",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"ID14"
					},
					{
							"id_punto_muestreo":"15",
							"punto_muestreo":"Cajititlán III",
							"descripcion":"Cajititlán III",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140970005",
							"localidad":"localidad 140970005",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.430558,
							"lng":-103.3164,
							"alt":0,
							"idRegHid":12,
							"idCuenca":16,
							"idSubCuenca":28,
							"idCuerpoCalidad":2,
							"consecutivo":0,
							"siglas":"LC",
							"clave":"LC-00",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"Modificado 2014-09-02 coords(20.43149,-103.4149) ID15"
					},
					{
							"id_punto_muestreo":"16",
							"punto_muestreo":"San Lucas II",
							"descripcion":"San Lucas Evangelista 16",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140970502",
							"localidad":"localidad 140970502",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.413152,
							"lng":-103.3325,
							"alt":0,
							"idRegHid":12,
							"idCuenca":16,
							"idSubCuenca":28,
							"idCuerpoCalidad":2,
							"consecutivo":0,
							"siglas":"LC",
							"clave":"LC-00",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"Modificado 2014-09-02 coords(20.42528,-103.33965) ID16"
					},
					{
							"id_punto_muestreo":"17",
							"punto_muestreo":"Coexcomatitlán",
							"descripcion":"Coexcomatitlán",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140970014",
							"localidad":"localidad 140970014",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.42725,
							"lng":-103.35365,
							"alt":0,
							"idRegHid":12,
							"idCuenca":16,
							"idSubCuenca":28,
							"idCuerpoCalidad":2,
							"consecutivo":7,
							"siglas":"LC",
							"clave":"LC-07",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"ID17"
					},
					{
							"id_punto_muestreo":"18",
							"punto_muestreo":"Desc. Tlajomulco",
							"descripcion":"Descarga de Tlajomulco",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140970014",
							"localidad":"localidad 140970014",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.42109,
							"lng":-103.36456,
							"alt":0,
							"idRegHid":12,
							"idCuenca":16,
							"idSubCuenca":28,
							"idCuerpoCalidad":2,
							"consecutivo":8,
							"siglas":"LC",
							"clave":"LC-08",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"ID18"
					},
					{
							"id_punto_muestreo":"19",
							"punto_muestreo":"San Miguel 19",
							"descripcion":"San Miguel Cuyutlán 19",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140970014",
							"localidad":"localidad 140970014",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.423691,
							"lng":-103.3604,
							"alt":0,
							"idRegHid":12,
							"idCuenca":16,
							"idSubCuenca":28,
							"idCuerpoCalidad":2,
							"consecutivo":1,
							"siglas":"LC",
							"clave":"LC-01",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"Modificado 2014-09-02 coords(20.42202,-103.35871)"
					},
					{
							"id_punto_muestreo":"20",
							"punto_muestreo":"Centro de Laguna 20",
							"descripcion":"Centro de laguna 20",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140970005",
							"localidad":"localidad 140970005",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.418944,
							"lng":-103.319778,
							"alt":0,
							"idRegHid":12,
							"idCuenca":16,
							"idSubCuenca":28,
							"idCuerpoCalidad":2,
							"consecutivo":3,
							"siglas":"LC",
							"clave":"LC-03",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"Modificado 2014-09-02 coords(20.41803,-103.32665)"
					},
					{
							"id_punto_muestreo":"21",
							"punto_muestreo":"San Juan",
							"descripcion":"San Juan Evangelista",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140970004",
							"localidad":"localidad 140970004",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.40818,
							"lng":-103.3121,
							"alt":0,
							"idRegHid":12,
							"idCuenca":16,
							"idSubCuenca":28,
							"idCuerpoCalidad":2,
							"consecutivo":9,
							"siglas":"LC",
							"clave":"LC-09",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"ID21"
					},
					{
							"id_punto_muestreo":"22",
							"punto_muestreo":"San Juan II",
							"descripcion":"San Juan Evangelista II",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140970004",
							"localidad":"localidad 140970004",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.409697,
							"lng":-103.299456,
							"alt":0,
							"idRegHid":12,
							"idCuenca":16,
							"idSubCuenca":28,
							"idCuerpoCalidad":2,
							"consecutivo":0,
							"siglas":"LC",
							"clave":"LC-00",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"Modificado 2014-09-02 coords(20.403361,-103.296667) ID22"
					},
					{
							"id_punto_muestreo":"23",
							"punto_muestreo":"Desc. Cajititlán II",
							"descripcion":"Descarga de Cajititlán II",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140970005",
							"localidad":"localidad 140970005",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.42023,
							"lng":-103.30417,
							"alt":0,
							"idRegHid":12,
							"idCuenca":16,
							"idSubCuenca":28,
							"idCuerpoCalidad":2,
							"consecutivo":0,
							"siglas":"LC",
							"clave":"LC-00",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"ID23"
					},
					{
							"id_punto_muestreo":"24",
							"punto_muestreo":"Embarcadero G.F.",
							"descripcion":"Frente embarcadero Gómez Farías ",
							"id_municipio":"14023",
							"municipio":"municipio 14023",
							"id_localidad":"140230156",
							"localidad":"localidad 140230156",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":19.762567,
							"lng":-103.470883,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":53,
							"idCuerpoCalidad":3,
							"consecutivo":1,
							"siglas":"LZ",
							"clave":"LZ-05",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"ID24 N1"
					},
					{
							"id_punto_muestreo":"25",
							"punto_muestreo":"Cooperativa 2 G.F.",
							"descripcion":"Frente a la cooperativa 2 de G. F. ",
							"id_municipio":"14023",
							"municipio":"municipio 14023",
							"id_localidad":"140230156",
							"localidad":"localidad 140230156",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":19.76745,
							"lng":-103.472533,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":53,
							"idCuerpoCalidad":3,
							"consecutivo":2,
							"siglas":"LZ",
							"clave":"LZ-06",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"ID25 N2"
					},
					{
							"id_punto_muestreo":"26",
							"punto_muestreo":"Cerritos",
							"descripcion":"Frente a los Cerritos ",
							"id_municipio":"14023",
							"municipio":"municipio 14023",
							"id_localidad":"140230156",
							"localidad":"localidad 140230156",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":19.7698,
							"lng":-103.477733,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":53,
							"idCuerpoCalidad":3,
							"consecutivo":3,
							"siglas":"LZ",
							"clave":"LZ-07",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"ID26 N3"
					},
					{
							"id_punto_muestreo":"27",
							"punto_muestreo":"Desc. Río Grande",
							"descripcion":"Frente a la descarga del Río Grande ",
							"id_municipio":"14023",
							"municipio":"municipio 14023",
							"id_localidad":"140790063",
							"localidad":"localidad 140790063",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":19.769483,
							"lng":-103.484,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":53,
							"idCuerpoCalidad":3,
							"consecutivo":4,
							"siglas":"LZ",
							"clave":"LZ-08",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"ID27 N4"
					},
					{
							"id_punto_muestreo":"28",
							"punto_muestreo":"Aguaje",
							"descripcion":"Frente al Aguaje",
							"id_municipio":"14023",
							"municipio":"municipio 14023",
							"id_localidad":"140790063",
							"localidad":"localidad 140790063",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":19.76045,
							"lng":-103.489133,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":53,
							"idCuerpoCalidad":3,
							"consecutivo":5,
							"siglas":"LZ",
							"clave":"LZ-09",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"ID28 N5"
					},
					{
							"id_punto_muestreo":"29",
							"punto_muestreo":"Derramadero",
							"descripcion":"Frente al Derramadero",
							"id_municipio":"14023",
							"municipio":"municipio 14023",
							"id_localidad":"140230208",
							"localidad":"localidad 140230208",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":19.744667,
							"lng":-103.485033,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":53,
							"idCuerpoCalidad":3,
							"consecutivo":6,
							"siglas":"LZ",
							"clave":"LZ-10",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"ID29 N6"
					},
					{
							"id_punto_muestreo":"30",
							"punto_muestreo":"Desc. Cd. Guzmán",
							"descripcion":"Frente a descarga de agua de Cd. Guzmán ",
							"id_municipio":"14023",
							"municipio":"municipio 14023",
							"id_localidad":"140230124",
							"localidad":"localidad 140230124",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":19.7396,
							"lng":-103.480783,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":53,
							"idCuerpoCalidad":3,
							"consecutivo":7,
							"siglas":"LZ",
							"clave":"LZ-11",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"ID30 N7"
					},
					{
							"id_punto_muestreo":"31",
							"punto_muestreo":"Centro laguna",
							"descripcion":"Centro de la Laguna ",
							"id_municipio":"14023",
							"municipio":"municipio 14023",
							"id_localidad":"140230208",
							"localidad":"localidad 140230208",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":19.75525,
							"lng":-103.475467,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":53,
							"idCuerpoCalidad":3,
							"consecutivo":8,
							"siglas":"LZ",
							"clave":"LZ-12",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"ID31 N8"
					},
					{
							"id_punto_muestreo":"32",
							"punto_muestreo":"Club canotaje",
							"descripcion":"Frente al Club de Canotaje ",
							"id_municipio":"14023",
							"municipio":"municipio 14023",
							"id_localidad":"140230208",
							"localidad":"localidad 140230208",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":19.756967,
							"lng":-103.467767,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":53,
							"idCuerpoCalidad":3,
							"consecutivo":9,
							"siglas":"LZ",
							"clave":"LZ-13",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"ID32 N9"
					},
					{
							"id_punto_muestreo":"33",
							"punto_muestreo":"Vaso regulador",
							"descripcion":"Vaso Regulador de la Laguna ",
							"id_municipio":"14023",
							"municipio":"municipio 14023",
							"id_localidad":"140230156",
							"localidad":"localidad 140230156",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":19.761683,
							"lng":-103.4671,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":53,
							"idCuerpoCalidad":3,
							"consecutivo":10,
							"siglas":"LZ",
							"clave":"LZ-14",
							"fecha":"2012-09-19 00:00:00.000",
							"usr_update":1,
							"comentarios":"ID33 N10"
					},
					{
							"id_punto_muestreo":"41",
							"punto_muestreo":"San Miguel Cuyutlán 41",
							"descripcion":"San Miguel Cuyutlán 41",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140970005",
							"localidad":"localidad 140970005",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.423691,
							"lng":-103.3604,
							"alt":0,
							"idRegHid":12,
							"idCuenca":16,
							"idSubCuenca":28,
							"idCuerpoCalidad":2,
							"consecutivo":1,
							"siglas":"LC",
							"clave":"LC-01",
							"fecha":"2013-03-10 00:00:00.000",
							"usr_update":1,
							"comentarios":"Nueva distribución, finales de 2013"
					},
					{
							"id_punto_muestreo":"42",
							"punto_muestreo":"Cajititlán 42",
							"descripcion":"Cajititlán 42",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140970005",
							"localidad":"localidad 140970005",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.430558,
							"lng":-103.3164,
							"alt":0,
							"idRegHid":12,
							"idCuenca":16,
							"idSubCuenca":28,
							"idCuerpoCalidad":2,
							"consecutivo":2,
							"siglas":"LC",
							"clave":"LC-02",
							"fecha":"2013-03-10 00:00:00.000",
							"usr_update":1,
							"comentarios":"Nueva distribución, finales de 2013"
					},
					{
							"id_punto_muestreo":"43",
							"punto_muestreo":"Centro de Laguna 43",
							"descripcion":"Centro de Laguna 43",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140970005",
							"localidad":"localidad 140970005",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.418944,
							"lng":-103.319778,
							"alt":0,
							"idRegHid":12,
							"idCuenca":16,
							"idSubCuenca":28,
							"idCuerpoCalidad":2,
							"consecutivo":3,
							"siglas":"LC",
							"clave":"LC-03",
							"fecha":"2013-03-10 00:00:00.000",
							"usr_update":1,
							"comentarios":"Nueva distribución, finales de 2013"
					},
					{
							"id_punto_muestreo":"44",
							"punto_muestreo":"San Lucas 44",
							"descripcion":"San Lucas Evangelista",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140970014",
							"localidad":"localidad 140970014",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.413152,
							"lng":-103.3325,
							"alt":0,
							"idRegHid":12,
							"idCuenca":16,
							"idSubCuenca":28,
							"idCuerpoCalidad":2,
							"consecutivo":4,
							"siglas":"LC",
							"clave":"LC-04",
							"fecha":"2013-03-10 00:00:00.000",
							"usr_update":1,
							"comentarios":"Nueva distribución, finales de 2013"
					},
					{
							"id_punto_muestreo":"45",
							"punto_muestreo":"San Juan 45",
							"descripcion":"San Juan Evangelista 45",
							"id_municipio":"14097",
							"municipio":"municipio 14097",
							"id_localidad":"140970004",
							"localidad":"localidad 140970004",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.409697,
							"lng":-103.299456,
							"alt":0,
							"idRegHid":12,
							"idCuenca":16,
							"idSubCuenca":28,
							"idCuerpoCalidad":2,
							"consecutivo":5,
							"siglas":"LC",
							"clave":"LC-05",
							"fecha":"2013-03-10 00:00:00.000",
							"usr_update":1,
							"comentarios":"Nueva distribución, finales de 2013"
					},
					{
							"id_punto_muestreo":"46",
							"punto_muestreo":"Cd. Guzmán",
							"descripcion":"Descarga Ciudad Guzmán",
							"id_municipio":"14023",
							"municipio":"municipio 14023",
							"id_localidad":"140230001",
							"localidad":"localidad 140230001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":19.747575,
							"lng":-103.4830472,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":53,
							"idCuerpoCalidad":3,
							"consecutivo":1,
							"siglas":"LZ",
							"clave":"LZ-01",
							"fecha":"2014-04-11 15:19:45.517",
							"usr_update":1,
							"comentarios":"Nuevo punto"
					},
					{
							"id_punto_muestreo":"47",
							"punto_muestreo":"Pista de Canotaje",
							"descripcion":"Pista de Canotaje",
							"id_municipio":"14023",
							"municipio":"municipio 14023",
							"id_localidad":"140230001",
							"localidad":"localidad 140230001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":19.75476389,
							"lng":-103.4706861,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":53,
							"idCuerpoCalidad":3,
							"consecutivo":2,
							"siglas":"LZ",
							"clave":"LZ-02",
							"fecha":"2014-04-11 15:21:51.460",
							"usr_update":1,
							"comentarios":"Nuevo punto de muestreo"
					},
					{
							"id_punto_muestreo":"48",
							"punto_muestreo":"Centro de Laguna",
							"descripcion":"Centro de Laguna",
							"id_municipio":"14023",
							"municipio":"municipio 14023",
							"id_localidad":"140230001",
							"localidad":"localidad 140230001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":19.75649167,
							"lng":-103.4800278,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":53,
							"idCuerpoCalidad":3,
							"consecutivo":3,
							"siglas":"LZ",
							"clave":"LZ-03",
							"fecha":"2014-04-11 15:22:36.760",
							"usr_update":1,
							"comentarios":""
					},
					{
							"id_punto_muestreo":"49",
							"punto_muestreo":"Gómez Farías",
							"descripcion":"Gómez Farías",
							"id_municipio":"14079",
							"municipio":"municipio 14079",
							"id_localidad":"140790001",
							"localidad":"localidad 140790001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":19.76572222,
							"lng":-103.4854167,
							"alt":0,
							"idRegHid":12,
							"idCuenca":1,
							"idSubCuenca":53,
							"idCuerpoCalidad":3,
							"consecutivo":4,
							"siglas":"LZ",
							"clave":"LZ-04",
							"fecha":"2014-04-11 15:23:28.760",
							"usr_update":1,
							"comentarios":""
					},
					{
							"id_punto_muestreo":"50",
							"punto_muestreo":"Los Gavilanes",
							"descripcion":"Los Gavilanes de Abajo",
							"id_municipio":"14091",
							"municipio":"municipio 14091",
							"id_localidad":"140910052",
							"localidad":"localidad 140910052",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":21.611438,
							"lng":-102.444273,
							"alt":1618,
							"idRegHid":12,
							"idCuenca":19,
							"idSubCuenca":31,
							"idCuerpoCalidad":4,
							"consecutivo":1,
							"siglas":"RV",
							"clave":"RV-01",
							"fecha":"2014-12-01 10:26:19.650",
							"usr_update":1,
							"comentarios":"Nuevo Punto, Río Verde"
					},
					{
							"id_punto_muestreo":"51",
							"punto_muestreo":"San Nicolás",
							"descripcion":"San Nicolás de las Flores",
							"id_municipio":"14046",
							"municipio":"municipio 14046",
							"id_localidad":"140460068",
							"localidad":"localidad 140460068",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":21.29348,
							"lng":-102.552867,
							"alt":1559,
							"idRegHid":12,
							"idCuenca":19,
							"idSubCuenca":46,
							"idCuerpoCalidad":4,
							"consecutivo":2,
							"siglas":"RV",
							"clave":"RV-02",
							"fecha":"2014-12-01 10:35:08.930",
							"usr_update":1,
							"comentarios":"Nuevo Punto, Río Verde"
					},
					{
							"id_punto_muestreo":"52",
							"punto_muestreo":"Puente Temaca",
							"descripcion":"Puente Temaca-Cañadas",
							"id_municipio":"14117",
							"municipio":"municipio 14117",
							"id_localidad":"141170065",
							"localidad":"localidad 141170065",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":21.192111,
							"lng":-102.691125,
							"alt":1618,
							"idRegHid":12,
							"idCuenca":19,
							"idSubCuenca":46,
							"idCuerpoCalidad":4,
							"consecutivo":3,
							"siglas":"RV",
							"clave":"RV-03",
							"fecha":"2014-12-01 10:37:28.610",
							"usr_update":1,
							"comentarios":"Nuevo Punto, Río Verde"
					},
					{
							"id_punto_muestreo":"53",
							"punto_muestreo":"Puente Yahualica",
							"descripcion":"Puente Yahualica",
							"id_municipio":"14118",
							"municipio":"municipio 14118",
							"id_localidad":"141180010",
							"localidad":"localidad 141180010",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":21.006219,
							"lng":-102.821295,
							"alt":1466,
							"idRegHid":12,
							"idCuenca":19,
							"idSubCuenca":46,
							"idCuerpoCalidad":4,
							"consecutivo":4,
							"siglas":"RV",
							"clave":"RV-04",
							"fecha":"2014-12-01 10:40:26.940",
							"usr_update":1,
							"comentarios":"Nuevo Punto, Río Verde"
					},
					{
							"id_punto_muestreo":"54",
							"punto_muestreo":"Los Venados",
							"descripcion":"Balneario Los Venados",
							"id_municipio":"14001",
							"municipio":"municipio 14001",
							"id_localidad":"140010001",
							"localidad":"localidad 140010001",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.828838,
							"lng":-102.962601,
							"alt":1254,
							"idRegHid":12,
							"idCuenca":19,
							"idSubCuenca":52,
							"idCuerpoCalidad":4,
							"consecutivo":5,
							"siglas":"RV",
							"clave":"RV-05",
							"fecha":"2014-12-01 10:42:48.167",
							"usr_update":1,
							"comentarios":"Nuevo Punto, Río Verde"
					},
					{
							"id_punto_muestreo":"55",
							"punto_muestreo":"El Purgatorio",
							"descripcion":"El Purgatorio",
							"id_municipio":"14124",
							"municipio":"municipio 14124",
							"id_localidad":"141240016",
							"localidad":"localidad 141240016",
							"id_clase_punto":1,
							"id_tipo_muestreo":1,
							"frecuencia_muestreo":0,
							"activo":1,
							"selected":false,
							"lat":20.71575,
							"lng":-103.230437,
							"alt":1057,
							"idRegHid":12,
							"idCuenca":19,
							"idSubCuenca":46,
							"idCuerpoCalidad":4,
							"consecutivo":6,
							"siglas":"RV",
							"clave":"RV-06",
							"fecha":"2014-12-01 10:45:57.233",
							"usr_update":1,
							"comentarios":"Nuevo Punto, Río Verde"
					}
			]
		';
		return $result;
	}

	public function getParametersField() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		parametros_campo";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_parametro":1,
					"param":"color",
					"parametro":"Color",
					"id_tipo_parametro":1,
					"id_clase_parametro":1,
					"id_preservacion":1,
					"id_unidad":1,
					"id_metodo":1,
					"tipo_parametro":"Fisicoquímico",
					"clase_parametro":"Campo",
					"activo":1,
					"valor":null,
					"selected":false
				},
				{
					"id_parametro":1,
					"param":"olor",
					"parametro":"Olor",
					"id_tipo_parametro":1,
					"id_clase_parametro":1,
					"id_preservacion":1,
					"id_unidad":1,
					"id_metodo":1,
					"tipo_parametro":"Fisicoquímico",
					"clase_parametro":"Campo",
					"activo":1,
					"valor":null,
					"selected":false
				},
				{
					"id_parametro":1,
					"param":"gasto",
					"parametro":"Gasto",
					"id_tipo_parametro":1,
					"id_clase_parametro":1,
					"id_preservacion":1,
					"id_unidad":1,
					"id_metodo":1,
					"tipo_parametro":"Fisicoquímico",
					"clase_parametro":"Campo",
					"activo":1,
					"valor":null,
					"selected":false
				},
				{
					"id_parametro":1,
					"param":"profundidad",
					"parametro":"Profundidad",
					"id_tipo_parametro":1,
					"id_clase_parametro":1,
					"id_preservacion":1,
					"id_unidad":1,
					"id_metodo":1,
					"tipo_parametro":"Fisicoquímico",
					"clase_parametro":"Campo",
					"activo":1,
					"valor":null,
					"selected":false
				},
				{
					"id_parametro":1,
					"param":"transparencia",
					"parametro":"Transparencia",
					"id_tipo_parametro":1,
					"id_clase_parametro":1,
					"id_preservacion":1,
					"id_unidad":1,
					"id_metodo":1,
					"tipo_parametro":"Fisicoquímico",
					"clase_parametro":"Campo",
					"activo":1,
					"valor":null,
					"selected":false
				},
				{
					"id_parametro":1,
					"param":"materia_flotante",
					"parametro":"Materia_flotante",
					"id_tipo_parametro":1,
					"id_clase_parametro":1,
					"id_preservacion":1,
					"id_unidad":1,
					"id_metodo":1,
					"tipo_parametro":"Fisicoquímico",
					"clase_parametro":"Campo",
					"activo":1,
					"valor":null,
					"selected":false
				}
			]
		';
		return $result;
	}


	public function getSamples() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		muestras";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_muestra":1,
					"numero_oficio":687,
					"id_ejercicio":2014,
					"folio":"CEA-687/2014",
					"id_reporte":1,
					"id_cliente":1,
					"id_orden":1,
					"id_matriz":3,
					"id_punto_muestreo":1,
					"id_recepcionista":15,
					"id_supervisor":1,
					"fecha_muestreo":"2014-12-19",
					"hora_muestreo":"9:08",
					"fecha_recepcion":"2014-12-19",
					"hora_recepcion":"14:08",
					"fecha_captura":"2014-11-01",
					"fecha_valida":"",
					"fecha_actualiza":"2014-11-02",
					"validado":0,
					"recibe_fisicoquimico":1,
					"recibe_metales":1,
					"recibe_biologico":1,
					"descripcion":"texto de la Descripción de la muestra",
					"comentarios":"Sin Comentarios...",
					"punto_muestreo":
					{
						"id_punto_muestreo":1,
						"id_cuerpo_receptor":1,
						"cve_mun_com":14001,
						"municipio":"Zapotlanejo",
						"cve_mun_loc_com":140010001,
						"localidad":"Zapotlanejo",
						"numero":1,
						"siglas":"RYT",
						"punto_muestreo":"Punto muestreo prueba",
						"descripcion":"Descripción del entorno del punto de muestreo",
						"lat":20.123456,
						"lng":-102.654321,
						"alt":0,
						"fecha_actualiza":"2014-11-30",
						"activo":1
					},
					"areas_seleccionadas":
					[
						{
							"id_area":1,
							"area":"Fisicoquímico",
							"siglas":"FQ",
							"fecha_act":"2014-11-30",
							"receptora":1,
							"selected":true,
							"activo":1
						},
						{
							"id_area":2,
							"area":"Metales Pesados",
							"siglas":"MP",
							"fecha_act":"2014-11-30",
							"receptora":1,
							"selected":true,
							"activo":1
						},
						{
							"id_area":3,
							"area":"Microbiología",
							"siglas":"MB",
							"fecha_act":"2014-11-30",
							"receptora":1,
							"selected":true,
							"activo":1
						}
					],
					"recipientes":
					[
						{
							"id_recipiente":1,
							"id_muestra":1,
							"id_tipo_recipiente":1,
							"id_tipo_preservacion":1,
							"id_tipo_parametro":1,
							"id_camara":2,
							"preservado":true,
							"camara":
							{
								"id_camara":2,
								"camara":"Cámara 2"
							},
							"id_anaquel":4,
							"anaquel":
							{
								"id_anaquel":4,
								"anaquel":"D"
							},
							"volumen_inicial":240,
							"volumen_actual":240,
							"fecha_consumo":"2014-12-20",
							"fecha_muestreo":"2014-12-19",
							"hora_muestreo":"9:08",
							"fecha_expiracion":"2014-12-20",
							"hora_expiracion":"9:08",
							"tipo_recipiente":
							{
								"id_tipo_recipiente":1,
								"tipo_recipiente":"Vidrio"
							}
						}
					],
					"reporte":
					{
						"id_reporte":1
					},
					"cliente":
					{
						"id_cliente":1,
						"id_organismo":1,
						"cliente":"CEA Jalisco",
						"area":"Dirección de Operación de PTARS",
						"rfc":"Registro Federal de Contribuyentes",
						"calle":"Av. Brasilia",
						"numero":"2970",
						"colonia":"Col. Colomos Providencia",
						"cp":"44680",
						"id_estado":14,
						"id_municipio":14039,
						"municipio":"Guadalajara",
						"id_localidad":140390001,
						"localidad":"Guadalajara",
						"tel":"3030-9350 ext. 8370",
						"fax":"",
						"contacto":"Biol. Luis Aceves Martínez",
						"puesto_contacto":"puesto contacto",
						"email":"laceves@ceajalisco.gob.mx",
						"fecha_act":"23/11/2014",
						"interno":1,
						"cea":1,
						"tasa":0,
						"activo":1
					},
					"matriz":
					{
						"id_matriz":3,
						"matriz":"Agua Residual Tratada"
					},
					"recepcionista":
					{
						"id_empleado":15,
						"id_nivel":4,
						"id_area":4,
						"area":"Muestreo",
						"id_puesto":6,
						"puesto":"Analista",
						"nombres":"Mitzi Acahualxóchitl",
						"ap":"Rodríguez",
						"am":"García",
						"fecha_act":"2014-11-30",
						"calidad":0,
						"supervisa":0,
						"analiza":1,
						"muestrea":1,
						"cert":1,
						"activo":1
					},
					"supervisor":
					{
						"id_empleado":1,
						"id_nivel":1,
						"id_area":5,
						"area":"Administrativo",
						"id_puesto":1,
						"puesto":"Gerente",
						"nombres":"Reyna",
						"ap":"García",
						"am":"Meneses",
						"fecha_act":"2014-11-30",
						"calidad":1,
						"supervisa":1,
						"analiza":1,
						"muestrea":0,
						"cert":1,
						"activo":1
					},
					"orden":
					{
						"id_orden":1,
						"numero_oficio":656,
						"id_ejercicio":2014,
						"folio":"CEA-656/2014",
						"fecha_orden":"2014-11-01",
						"fecha_captura":"2014-11-01",
						"fecha_valida":"2914-07-02",
						"fecha_acepta":"2014-11-03",
						"fecha_actualiza":"2014-11-01",
						"validado":0,
						"aceptado":0,
						"id_origen_orden":2,
						"origen_orden":
						{
							"id_origen_orden":2,
							"origen_orden":"Cotización"
						},
						"emergencia":"",
						"id_cliente":1,
						"cliente":
						{
							"id_cliente":1,
							"id_organismo":1,
							"cliente":"CEA Jalisco",
							"area":"Dirección de Operación de PTARS",
							"rfc":"Registro Federal de Contribuyentes",
							"calle":"Av. Brasilia",
							"numero":"2970",
							"colonia":"Col. Colomos Providencia",
							"cp":"44680",
							"id_estado":14,
							"id_municipio":14039,
							"municipio":"Guadalajara",
							"id_localidad":140390001,
							"localidad":"Guadalajara",
							"tel":"3030-9350 ext. 8370",
							"fax":"",
							"contacto":"Biol. Luis Aceves Martínez",
							"puesto_contacto":"puesto contacto",
							"email":"laceves@ceajalisco.gob.mx",
							"fecha_act":"23/11/2014",
							"interno":1,
							"cea":1,
							"tasa":0,
							"activo":1
						},
						"id_plan":1,
						"id_responsable_muestreo":2,
						"responsable_muestreo":
						{
							"id_responsable_muestreo":2,
							"id_empleado":3,
							"id_nivel":3,
							"id_area":2,
							"area":"Metales Pesados",
							"id_puesto":4,
							"puesto":"Supervisor (MP)",
							"nombres":"Marín",
							"ap":"Gomar",
							"am":"Sosa",
							"fecha_act":"2014-11-30",
							"calidad":0,
							"supervisa":1,
							"analiza":1,
							"muestrea":1,
							"cert":1,
							"activo":1
						},
						"id_responsable_custodia":4,
						"id_solicitud":1,
						"solicitud":
						{
							"id_solicitud":1,
							"numero_oficio":432,
							"id_ejercicio":2014,
							"folio":"CEA-432/2014",
							"fecha_solicitud":"2015-03-21",
							"fecha_captura":"2015-03-21",
							"fecha_valida":null,
							"fecha_acepta":null,
							"fecha_actualiza":"2015-03-21",
							"validado":0,
							"id_cliente":1,
							"id_usuario_captura":1,
							"id_usuario_valida":3,
							"id_norma":1,
							"id_tipo_muestreo":1,
							"total":0,
							"cliente":
							{
								"id_cliente":1,
								"id_organismo":1,
								"cliente":"CEA Jalisco",
								"area":"Dirección de Operación de PTARS",
								"rfc":"Registro Federal de Contribuyentes",
								"calle":"Av. Brasilia",
								"numero":"2970",
								"colonia":"Col. Colomos Providencia",
								"cp":"44680",
								"id_estado":14,
								"id_municipio":14039,
								"municipio":"Guadalajara",
								"id_localidad":140390001,
								"localidad":"Guadalajara",
								"tel":"3030-9350 ext. 8370",
								"fax":"",
								"contacto":"Biol. Luis Aceves Martínez",
								"puesto_contacto":"puesto contacto",
								"email":"laceves@ceajalisco.gob.mx",
								"fecha_act":"23/11/2014",
								"interno":1,
								"cea":1,
								"tasa":0,
								"activo":1
							},
							"descripcion_servicio":"Servicio de muestreo y análisis, para verificar el cumplimiento de la norma NOM-001-SEMARNAT-1996, que establece los límites máximos permisibles de contaminantes en las descargas de aguas residuales a los sistemas de alcantarillado urbano o municipal. -auto",
							"notas":"La presente cotización se realiza sin visita previa y se contempla un fácil y seguro acceso para la toma de muestras. Se requiere regresar esta cotización con la firma y sello de Aceptación del Servicio. -auto",
							"condiciones":"El informe de resultados se entregará a los 10 días hábiles de haber ingresado las muestras al laboratorio. El pago de resultados se hará en las instalaciones del Laboratorio de Calidad del Agua de la CEA, así también mediante depósito bancario a la cuenta: 884371445 de la Institución Bancaria BANORTE a nombre de la Comisión Estatal del Agua de Jalisco o por transferencia electrónica, cuenta interbancaria: 072320008843714454. -auto",
							"captura":{
								"id_usuario":1,
								"nombre":"Usuario captura",
								"puesto":"puesto Usuario captura"
							},
							"usr":"rgarcia",
							"pwd":"rgarcia",
							"valida":{
								"id_empleado":3,
								"nombre":"Gerente que valida",
								"puesto":"puesto Usuario valida"
							},
							"norma":{
								"id_norma":1,
								"norma":"NOM-001-SEMARNAT-1996",
								"desc":"Norma Oficial Mexicana",
								"parametros":[
									{
										"id_parametro":25,
										"parametro":"Arsénico",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":27,
										"parametro":"Cadmio",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":28,
										"parametro":"Cobre",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":38,
										"parametro":"Coliformes fecales",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":29,
										"parametro":"Cromo",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":16,
										"parametro":"Demada bioquímica de oxígeno",
										"cert":0,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":19,
										"parametro":"Fósforo total",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":18,
										"parametro":"Grasas y aceites",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":6,
										"parametro":"Alcalinidad total",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":39,
										"parametro":"Materia flotante",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":32,
										"parametro":"Mercurio",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":7,
										"parametro":"Cloruros totales",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":33,
										"parametro":"Níquel",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":2,
										"parametro":"Potencial de hidrógeno",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":34,
										"parametro":"Plomo",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":22,
										"parametro":"Sólidos sedimentables",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":20,
										"parametro":"Sólidos suspendidos totales",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":1,
										"parametro":"Temperatura",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									},
									{
										"id_parametro":36,
										"parametro":"Zinc",
										"cert":1,
										"id_metodo":1,
										"metodo": {
											"id_metodo":1,
											"metodo":"NMX-AA-000-0000"
										},
										"cantidad":1,
										"precio":164.65
									}
								]
							},
							"actividades":[
								{
									"id_actividad":1,
									"actividad":"Muestreo instantáneo",
									"id_metodo":87,
									"metodo":{
										"id_metodo":87,
										"metodo":"metodo para muestreo instantáneo"
									},
									"cantidad":1,
									"precio":0
								}
							],
							"tipo_muestreo":
							{
								"id_tipo_muestreo":1,
								"tipo_muestreo":"Simple"
							}
						},
						"parametros":
						[
							{
								"id_parametro":25,
								"parametro":"Arsénico",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":27,
								"parametro":"Cadmio",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":28,
								"parametro":"Cobre",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":38,
								"parametro":"Coliformes fecales",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":29,
								"parametro":"Cromo",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":16,
								"parametro":"Demada bioquímica de oxígeno",
								"cert":0,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":19,
								"parametro":"Fósforo total",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":18,
								"parametro":"Grasas y aceites",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":6,
								"parametro":"Alcalinidad total",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":39,
								"parametro":"Materia flotante",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":32,
								"parametro":"Mercurio",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":7,
								"parametro":"Cloruros totales",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":33,
								"parametro":"Níquel",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":2,
								"parametro":"Potencial de hidrógeno",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":34,
								"parametro":"Plomo",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":22,
								"parametro":"Sólidos sedimentables",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":20,
								"parametro":"Sólidos suspendidos totales",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":1,
								"parametro":"Temperatura",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							},
							{
								"id_parametro":36,
								"parametro":"Zinc",
								"cert":1,
								"id_metodo":1,
								"metodo": {
									"id_metodo":1,
									"metodo":"NMX-AA-000-0000"
								},
								"cantidad":1,
								"precio":164.65
							}
						],
						"id_matriz":3,
						"matriz":
						{
							"id_matriz":3,
							"matriz":"Agua Residual Tratada"
						},
						"id_tipo_muestreo":1,
						"tipo_muestreo":
						{
							"id_tipo_muestreo":1,
							"tipo_muestreo":"Simple"
						},
						"id_origen_muestreo":1,
						"origen_muestreo":"Agua",
						"id_emite_orden":1,
						"emite_orden":"Nombre del gerente",
						"id_responsable_muestreo":2,
						"responsable_muestreo":
						{
							"id_responsable_muestreo":2,
							"id_empleado":3,
							"id_nivel":3,
							"id_area":2,
							"area":"Metales Pesados",
							"id_puesto":4,
							"puesto":"Supervisor (MP)",
							"nombres":"Marín",
							"ap":"Gomar",
							"am":"Sosa",
							"fecha_act":"2014-11-30",
							"calidad":0,
							"supervisa":1,
							"analiza":1,
							"muestrea":1,
							"cert":1,
							"activo":1
						},
						"id_norma":1,
						"norma":{
							"id_norma":1,
							"norma":"NOM-001-SEMARNAT-1996",
							"desc":"Norma Oficial Mexicana",
							"parametros":[
								{
									"id_parametro":25,
									"parametro":"Arsénico",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":27,
									"parametro":"Cadmio",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":28,
									"parametro":"Cobre",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":38,
									"parametro":"Coliformes fecales",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":29,
									"parametro":"Cromo",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":16,
									"parametro":"Demada bioquímica de oxígeno",
									"cert":0,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":19,
									"parametro":"Fósforo total",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":18,
									"parametro":"Grasas y aceites",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":6,
									"parametro":"Alcalinidad total",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":39,
									"parametro":"Materia flotante",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":32,
									"parametro":"Mercurio",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":7,
									"parametro":"Cloruros totales",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":33,
									"parametro":"Níquel",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":2,
									"parametro":"Potencial de hidrógeno",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":34,
									"parametro":"Plomo",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":22,
									"parametro":"Sólidos sedimentables",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":20,
									"parametro":"Sólidos suspendidos totales",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":1,
									"parametro":"Temperatura",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								},
								{
									"id_parametro":36,
									"parametro":"Zinc",
									"cert":1,
									"id_metodo":1,
									"metodo": {
										"id_metodo":1,
										"metodo":"NMX-AA-000-0000"
									},
									"cantidad":1,
									"precio":164.65
								}
							]
						}
					}
				}
			]
		';
		return $result;
	}

	public function getInstruments() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		instrumentos";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
			]
		';
		return $result;
	}

	public function getContainers() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		recipientes";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
			]
		';
		return $result;
	}

	public function getAnalysis() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		analisis";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_analisis":1,
					"id_muestra":1,
					"id_norma":1,
					"id_cliente":1,
					"muestra":
					{
						"id_muestra":1,
						"muestra":"",
						"numero_oficio":1,
						"id_ejercicio":2014,
						"folio":"CEA-1/2014"
					},
					"norma":
					{
						"id_norma":1,
						"norma":"NMX-AA-BBCC-00-0000"
					},
					"cliente":
					{
						"id_cliente":1,
						"cliente":"",
						"area":""
					}
				}
			]
		';
		return $result;
	}

	public function getAreas() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		areas";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_area":1,
					"area":"Fisicoquímico",
					"siglas":"FQ",
					"fecha_act":"2014-11-30",
					"receptora":1,
					"responsable":"Responsable Fisicoquímico",
					"selected":false,
					"activo":1
				},
				{
					"id_area":2,
					"area":"Metales Pesados",
					"siglas":"MP",
					"fecha_act":"2014-11-30",
					"receptora":1,
					"responsable":"Responsable Metales Pesados",
					"selected":false,
					"activo":1
				},
				{
					"id_area":3,
					"area":"Microbiología",
					"siglas":"MB",
					"fecha_act":"2014-11-30",
					"receptora":1,
					"responsable":"Responsable Microbiología",
					"selected":false,
					"activo":1
				},
				{
					"id_area":4,
					"area":"Muestreo",
					"siglas":"MU",
					"fecha_act":"2014-11-30",
					"receptora":0,
					"responsable":"Responsable Muestreo",
					"selected":false,
					"activo":1
				},
				{
					"id_area":5,
					"area":"Administrativo",
					"siglas":"AD",
					"fecha_act":"2014-11-30",
					"receptora":0,
					"responsable":"Responsable Administrativo",
					"selected":false,
					"activo":1
				}
			]
		';
		return $result;
	}

	public function getAnalysisSelections() {
		//$sql = "SELECT
		//		*
		//	FROM
		//		analisis_seleccion";
		//return \Service\Adapter\PDOAdapter::getInstance()->getAllRows($sql);
		$result = '
			[
				{
					"id_analisis_seleccion":1,
					"id_area":1,
					"id_muestra":1,
					"area":"Físicoquimico",
					"id_parameter":1,
					"parametro":"Parametro"
				}
			]
		';
		return $result;
	}
}
