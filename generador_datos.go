package main

import (
	"crypto/sha512"
	"encoding/hex"
	"fmt"
	"io"
	"os"
)

func check(e error) {
	if e != nil {
		panic(e)
	}
}

func hash(s string) (result string) {
	h := sha512.New()
	io.WriteString(h, s)
	result = hex.EncodeToString(h.Sum(nil))
	return
}

func Newline(f *os.File) {
	f.Write([]byte("\n"))
}

func main() {
	var password string = hash("123456")

	f, err := os.Create("datos.sql")
	check(err)
	defer f.Close()

	f.WriteString("INSERT INTO periodo (id, anio, tipo, activo) VALUES (1, 2014, 'único', TRUE);")
	Newline(f)

	for i := 1; i <= 40; i++ {
		id := 9000 + i

		str := fmt.Sprintf("INSERT INTO usuario (id, username, password, nombre, apellido, cedula, email, cod_carne, telefono_habi, telefono_celu, tipo, direccion) VALUES (%d, '%s%d', '%s', '%s%d', '%s%d', '%d', '%dusuario@pasantias.com', '%s', '0414XXXXXX', '0414XXXXXX', 'estudiante', 'Direccion %d');",
			id, "usuario", i, password, "Nombre", i, "Apellido", i, i, i, "12345678912", i)
		Newline(f)
		f.WriteString(str)
		str = fmt.Sprintf("INSERT INTO pasantia(id, usuario_id, periodo_id, compania, email, departamento, direccion, dirigido_a, actividad, actividades, supervisor, cargo_supervisor, horario, telefono_celu, telefono_ofic, tiempo_completo, fecha_inicio, fecha_fin, m01_registrada) VALUES (%d, %d, 1, 'Compañia %d', '%dcompania@empresa.com', 'Departamento %d', 'Direccion %d', 'Presidente %d', 'Actividad %d', 'Actividades %d', 'Supervisor %d', 'Cargo %d', 'Horario %d', '0414XXXXXXX', '0414XXXXXXX', TRUE, '2014-08-01', '2014-09-01', '2014-10-01');",
			id, id, i, i, i, i, i, i, i, i, i, i)
		Newline(f)
		f.WriteString(str)
	}

	Newline(f)
	f.WriteString(fmt.Sprintf("INSERT INTO usuario (id, username, password, tipo) VALUES (98765, 'olintex', '%s', 'tutor_licom');", password))
	Newline(f)
	f.WriteString(fmt.Sprintf("INSERT INTO usuario (id, username, password, tipo) VALUES (98766, 'monica', '%s', 'dpe');", password))
}
