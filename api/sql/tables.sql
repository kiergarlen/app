USE [siclab]
GO

SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[Cliente](
	[id_cliente] [int] IDENTITY(1,1) NOT NULL,
	[id_organismo] [int] NULL,
	[cve_edo] [int] NULL,
	[cve_mun_com] [int] NULL,
	[cve_mun_loc_com] [int] NULL,
	[valor] [float] NULL,
	[cliente] [varchar](100) NULL,
	[area] [varchar](100) NULL,
	[rfc] [varchar](50) NULL,
	[calle] [varchar](100) NULL,
	[numero] [varchar](20) NULL,
	[colonia] [varchar](100) NULL,
	[cp] [varchar](5) NULL,
	[tel] [varchar](50) NULL,
	[fax] [varchar](50) NULL,
	[contacto] [varchar](200) NULL,
	[puesto_contacto] [varchar](200) NULL,
	[email] [varchar](100) NULL,
	[interno] [int] NULL,
	[cea] [int] NULL,
	[tasa] [float] NULL,
	[fecha_actualizacion] [datetime] NULL,
	[id_usuario_actualizacion] [int] NULL,
	[activo] [int] NULL,
 CONSTRAINT [PK_Cliente] PRIMARY KEY CLUSTERED
(
	[id_cliente] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF,
IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON,
ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO


CREATE TABLE [dbo].[Parametro](
	[id_parametro] [int] NULL,
	[id_tipo_parametro] [int] NULL,
	[id_clase_parametro] [int] NULL,
	[id_area] [int] NULL,
	[id_unidad] [int] NULL,
	[id_metodo] [int] NULL,
	[id_tipo_matriz] [int] NULL,
	[id_caducidad] [int] NULL,
	[id_limite_entrega] [int] NULL,
	[id_precio] [int] NULL,
	[param] [varchar](50) NULL,
	[parametro] [varchar](200) NULL,
	[acreditado] [int] NULL,
	[fecha_actualizacion] [datetime] NULL,
	[id_usuario_actualizacion] [int] NULL,
	[activo] [int] NULL,
 CONSTRAINT [PK_Parametro] PRIMARY KEY CLUSTERED
(
	[id_parametro] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF,
IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON,
ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[Solicitud](
	[id_solicitud] [int] IDENTITY(1,1) NOT NULL,
	[id_cliente] [int] NULL,
	[id_norma] [int] NULL,
	[id_tipo_muestreo] [int] NULL,
	[folio] [int] NULL,
	[ejercicio] [int] NULL,
	[validado] [int] NULL,
	[aceptado] [int] NULL,
	[costo] [money] NULL,
	[fecha_solicitud] [datetime] NULL,
	[fecha_captura] [datetime] NULL,
	[fecha_valida] [datetime] NULL,
	[fecha_acepta] [datetime] NULL,
	[fecha_actualizacion] [datetime] NULL,
	[id_usuario_actualizacion] [int] NULL,
	[activo] [int] NULL,
 CONSTRAINT [PK_Solicitud] PRIMARY KEY CLUSTERED
(
	[id_solicitud] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF,
IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON,
ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[ParametroSolicitud](
	[id_parametro_solicitud] [int] IDENTITY(1,1) NOT NULL,
	[id_solicitud] [int] NULL,
	[id_parametro] [int] NULL,
 CONSTRAINT [PK_ParametroSolicitud] PRIMARY KEY CLUSTERED
(
	[id_parametro_solicitud] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF,
IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON,
ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO


CREATE TABLE [dbo].[OrdenMuestreo](
	[id_orden_muestreo] [int] IDENTITY(1,1) NOT NULL,
	[id_cliente] [int] NULL,
	[id_plan_muestreo] [int] NULL,
	[id_solicitud] [int] NULL,
	[id_supervisor_orden] [int] NULL,
	[id_supervisor_muestreo] [int] NULL,
	[id_origen_orden] [int] NULL,
	[id_matriz] [int] NULL,
	[id_norma] [int] NULL,
	[id_tipo_muestreo] [int] NULL,
	[id_origen_muestreo] [int] NULL,
	[origen_muestreo] [varchar](50) NULL,
	[folio] [int] NULL,
	[ejercicio] [int] NULL,
	[validado] [int] NULL,
	[aceptado] [int] NULL,
	[origen_otro] [varchar](200) NULL,
	[matriz_otra] [varchar](200) NULL,
	[fecha_orden] [datetime] NULL,
	[fecha_muestreo] [datetime] NULL,
	[hora_muestreo] [varchar](20) NULL,
	[fecha_captura] [datetime] NULL,
	[fecha_valida] [datetime] NULL,
	[fecha_acepta] [datetime] NULL,
	[fecha_actualizacion] [datetime] NULL,
	[id_usuario_actualizacion] [int] NULL,
	[activo] [int] NULL,
 CONSTRAINT [PK_OrdenMuestreo] PRIMARY KEY CLUSTERED
(
	[id_orden_muestreo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF,
IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON,
ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[ParametroOrden](
	[id_parametro_orden] [int] IDENTITY(1,1) NOT NULL,
	[id_orden] [int] NULL,
	[id_parametro] [int] NULL,
 CONSTRAINT [PK_ParametroOrden] PRIMARY KEY CLUSTERED
(
	[id_parametro_orden] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF,
IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON,
ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO




SET ANSI_PADDING OFF
GO

ALTER TABLE [dbo].[Clientes]  WITH CHECK ADD  CONSTRAINT [FK_CuerpoCalidad] FOREIGN KEY([idCuerpoCalidad])
REFERENCES [dbo].[CuerposCalidad] ([idCuerpoCalidad])
GO

ALTER TABLE [dbo].[Clientes] CHECK CONSTRAINT [FK_CuerpoCalidad]
GO
