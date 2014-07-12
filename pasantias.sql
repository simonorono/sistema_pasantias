
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

COMMENT ON COLUMN periodo.id IS 'El identificador único de un periodo';
COMMENT ON COLUMN periodo.anio IS 'El año';
COMMENT ON COLUMN periodo.tipo IS 'El tipo de periodo';
COMMENT ON COLUMN periodo.activo IS '¿Activo?';

CREATE TABLE usuario
(
    id serial NOT NULL,
    username varchar(20) NOT NULL,
    password char(128) NOT NULL,
    nombre varchar(30),
    apellido varchar(30),
    cedula varchar(30),
    email varchar(254),
    direccion text,
    tipo tipo_cuenta NOT NULL,
    cod_carne char(11),
    telefono_celu char(14),
    telefono_habi char(14),
    PRIMARY KEY (id),
    UNIQUE (username),
    UNIQUE (email)
);

COMMENT ON COLUMN usuario.id IS 'El identificador único de un usuario';
COMMENT ON COLUMN usuario.username IS 'El nombre de usuario';
COMMENT ON COLUMN usuario.password IS 'La contraseña';
COMMENT ON COLUMN usuario.nombre IS 'El primer nombre del usuario';
COMMENT ON COLUMN usuario.apellido IS 'El apellido del usuario';
COMMENT ON COLUMN usuario.cedula IS 'La cédula del usuario';
COMMENT ON COLUMN usuario.email IS 'El correo del usuario';
COMMENT ON COLUMN usuario.direccion IS 'La dirección del usuario';
COMMENT ON COLUMN usuario.tipo IS 'El tipo de cuenta';
COMMENT ON COLUMN usuario.cod_carne IS 'El código de carné (si aplica)';
COMMENT ON COLUMN usuario.telefono_celu IS 'El teléfono celular';
COMMENT ON COLUMN usuario.telefono_habi IS 'El teléfono de habitación';

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
    m03_numero_asignado timestamp without time zone,
    m04_sellada timestamp without time zone,
    m05_entrego_copia timestamp without time zone,
    m06_entrego_borrador timestamp without time zone,
    m07_retiro_borrador timestamp without time zone,
    m08_entrega_final timestamp without time zone,
    m09_carga_nota timestamp without time zone,

    numero_carta char(3),
    aprobada boolean,
    valida boolean,

    PRIMARY KEY (id),
    UNIQUE (usuario_id, periodo_id)
);

COMMENT ON COLUMN pasantia.id IS 'El identificador único de la pasantia';
COMMENT ON COLUMN pasantia.usuario_id IS 'El identificador del usuario';
COMMENT ON COLUMN pasantia.periodo_id IS 'El identificador del periodo';
COMMENT ON COLUMN pasantia.compania IS 'El nombre de la compañia';
COMMENT ON COLUMN pasantia.email IS 'El correo electrónico de la compañia';
COMMENT ON COLUMN pasantia.departamento IS 'El departamento dónde se realizará la pasantia';
COMMENT ON COLUMN pasantia.direccion IS 'La dirección de la compañia';
COMMENT ON COLUMN pasantia.dirigido_a IS 'La persona a quien va dirigida la carta de postulación';
COMMENT ON COLUMN pasantia.actividad IS 'La actividad de la compañia';
COMMENT ON COLUMN pasantia.actividades IS 'Las actividades que serán realizadas por el pasante';
COMMENT ON COLUMN pasantia.supervisor IS 'El supervisor de la pasantia';
COMMENT ON COLUMN pasantia.cargo_supervisor IS 'El cargo del supervisor';
COMMENT ON COLUMN pasantia.horario IS 'El horario de trabajo del pasante';
COMMENT ON COLUMN pasantia.telefono_celu IS 'El teléfono celular de la compañia';
COMMENT ON COLUMN pasantia.telefono_ofic IS 'El teléfono de oficina de la compañia';
COMMENT ON COLUMN pasantia.tiempo_completo IS '¿Tiempo completo?';
COMMENT ON COLUMN pasantia.fecha_inicio IS 'Fecha de inicio de la pasantia';
COMMENT ON COLUMN pasantia.fecha_fin IS 'Fecha de fin de la pasantia';
COMMENT ON COLUMN pasantia.m01_registrada IS 'Fecha de registro';
COMMENT ON COLUMN pasantia.m02_aceptada IS 'Fecha de aceptación';
COMMENT ON COLUMN pasantia.m03_numero_asignado IS 'Fecha de cuando el némero de carta fue asignado';
COMMENT ON COLUMN pasantia.m04_sellada IS 'Fecha de cuando la carta fue sellada';
COMMENT ON COLUMN pasantia.m05_entrego_copia IS 'Fecha de entrega de la copia de la carta firmada';
COMMENT ON COLUMN pasantia.m06_entrego_borrador IS 'Fecha de entrega del borrador';
COMMENT ON COLUMN pasantia.m07_retiro_borrador IS 'Fecha de retiro del borrador';
COMMENT ON COLUMN pasantia.m08_entrega_final IS 'Fecha de entrega final';
COMMENT ON COLUMN pasantia.m09_carga_nota IS 'Fecha de la carga de la nota';
COMMENT ON COLUMN pasantia.numero_carta IS 'El número de carta';
COMMENT ON COLUMN pasantia.aprobada IS 'Resultado final de la pasantía';
COMMENT ON COLUMN pasantia.valida IS '¿Es valida la pasantía?';
