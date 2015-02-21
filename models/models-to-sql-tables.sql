CREATE TABLE 'parametro' (
    'id_parametro' int NOT NULL PRIMARY KEY,
    'id_area' int,
    'id_tipo_parametro' int,
    'id_clase_parametro' int,
    'id_unidad' int,
    'id_metodo' int,
    'id_tipo_matriz' int,
    'param' varchar(50),
    'parametro' varchar(100),
    'es_param' int(1),
    'caducidad' int,
    'acreditado' int(1),
    'limite_entrega' int,
    'precio' int,
    'fecha_actualizacion' date,
    'hora_actualizacion' time,
    'activo' int(1)
);

CREATE TABLE 'recipiente_clase' (
    'id_recipiente_clase' int NOT NULL PRIMARY KEY,
    'id_preservacion' int,
    'fecha_actualizacion' date,
    'hora_actualizacion' time,
    'activo' int(1)
);

CREATE TABLE 'hielera' (
    'id_hielera' int NOT NULL PRIMARY KEY,
    'hielera' varchar(50),
    'fecha_actualizacion' date,
    'hora_actualizacion' time,
    'activo' int(1)
);

CREATE TABLE 'material' (
    'id_material' int NOT NULL PRIMARY KEY,
    'material' varchar(50),
    'fecha_actualizacion' date,
    'hora_actualizacion' time,
    'activo' int(1)
);

CREATE TABLE 'reactivo' (
    'id_reactivo' int NOT NULL PRIMARY KEY,
    'reactivo' varchar(50),
    'lote' varchar(50),
    'volumen' float(3),
    'cantidad' int,
    'fecha_actualizacion' date,
    'hora_actualizacion' time,
    'activo' int(1)
);

CREATE TABLE 'preservacion' (
    'id_preservacion' int NOT NULL PRIMARY KEY,
    'id_clase_parametro' int,
    'preservacion' varchar(50),
    'descripcion' varchar(100),
    'fecha_actualizacion' date,
    'hora_actualizacion' time,
    'activo' int(1)
);

CREATE TABLE 'area' (
    'id_area' int NOT NULL PRIMARY KEY,
    'area' varchar(50),
    'siglas' varchar(5),
    'receptora' int,
    'id_empleado' int,
    'fecha_actualizacion' date,
    'hora_actualizacion' time,
    'activo' int(1)
);
