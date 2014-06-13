
-- CREATE DATABASE pasantias;

CREATE TYPE tipo_periodo AS ENUM
(
    'primero',
    'segundo',
    'unico'
);

CREATE TYPE tipo_cuenta AS ENUM
(
    'estudiante',
    'tutor_licom',
    'dpe'
);

CREATE TABLE periodo
(
    id serial NOT NULL,
    anio numeric (4,0) NOT NULL,
    tipo tipo_periodo NOT NULL,
    activo boolean NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (anio,tipo)
);

CREATE TABLE usuario
(
    id serial NOT NULL,
    username varchar(20) NOT NULL,
    password char(128) NOT NULL,
    nombre varchar(30),
    apellido varchar(30),
    cedula varchar(30),
    email varchar(254),
    tipo tipo_cuenta NOT NULL,
    cod_carne char(11),
    telefono_celu char(14),
    telefono_habi char(14),
    PRIMARY KEY (id),
    UNIQUE (username),
    UNIQUE (email),
    UNIQUE (cod_carne)
);

CREATE INDEX ON usuario USING btree (username);
CREATE INDEX ON usuario USING btree (cedula);
CREATE INDEX ON usuario USING btree (email);

CREATE TABLE pasantia
(
    id serial NOT NULL,
    usuario_id int REFERENCES usuario (id) ON UPDATE CASCADE ON DELETE CASCADE,
    periodo_id int REFERENCES periodo (id) ON UPDATE CASCADE ON DELETE CASCADE,
    compania text NOT NULL,
    email varchar(254) NOT NULL,
    departamento text NOT NULL,
    direccion text NOT NULL,
    dirigido_a text NOT NULL,
    actividad text NOT NULL,
    actividades text NOT NULL,
    supervisor text NOT NULL,
    cargo_supervisor text NOT NULL,
    horario text NOT NULL,
    telefono_celu char(14) NOT NULL,
    telefono_ofic char(14) NOT NULL,
    tiempo_completo boolean NOT NULL,
    fecha_inicio timestamp without time zone NOT NULL,
    fecha_fin timestamp without time zone NOT NULL,

    m01_registrada timestamp without time zone,
    m02_aceptada timestamp without time zone,
    m04_numero_asignado timestamp without time zone,
    m05_sellada timestamp without time zone,
    m06_entrego_copia timestamp without time zone,
    m07_entrego_borrador timestamp without time zone,
    m08_retiro_borrador timestamp without time zone,
    m09_entrega_final timestamp without time zone,
    m10_carga_nota timestamp without time zone,

    PRIMARY KEY (id),
    UNIQUE (usuario_id, periodo_id)
);
