<?php

require 'flight/Flight.php';

// Flight::register('db', 'PDO', array('mysql:host=localhost;port=33065;dbname=api_php_flight
// ', 'root', ''));

Flight::register('db', 'PDO', array('mysql:host=localhost:33065;dbname=api_php_flight', 'root', ''), function ($db) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
});

//Lee los datos y los muestra a cualquier interfaz que solicita dichos datos
Flight::route('GET /alumnos', function () {
    $sentencia = Flight::db()->prepare("SELECT * FROM `alumnos`");
    $sentencia->execute();
    $datos = $sentencia->fetchAll();
    Flight::json($datos);
});

//Recepciona los datos por método POST y realizar la inserción
// Flight::route('POST /alumnos', function () {
Flight::route('POST /alumnos', function () {

    $nombres = (Flight::request()->data->nombres);
    $apellidos = (Flight::request()->data->apellidos);
    $sql = "INSERT INTO alumnos (nombres,apellidos) VALUES (?,?)";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $nombres);
    $sentencia->bindParam(2, $apellidos);
    $sentencia->execute();
    Flight::jsonp(["Alumno agregado ..."]);
});

//Función para borrar registro
Flight::route('DELETE /alumnos', function () {
    $id = (Flight::request()->data->id);
    $sql = "DELETE FROM alumnos WHERE id=?";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $id);
    $sentencia->execute();
    Flight::jsonp(["Alumno borrado ..."]);

    // me quede en el min 43:40
});

Flight::start();
